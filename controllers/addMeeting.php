<?php
/**
 * @package App.Site
 * @sub_packacge com_users
 *
 * @author Andre Dias
 */

defined('__APP__8B1H9MU5QI') or die();

/**
 * Default controller class
 *
 * @since 1.0.0
 */
class TutoradosControllerAddMeeting extends AppController {

	/**
	 * Execute the controller
	 *
	 * return boolean True if the controller finished execution, false otherwise
	 * A controller might return false is some precondition for the controller
	 * to run has not been satisfied
	 *
	 * @since 1.0.0
	 */
	public function execute(){
	    if(isset($_POST["new_meeting_meio"])){
	        $place = $_POST["new_meeting_place"];
	        $meio = $_POST["new_meeting_meio"];
	        $meeting_general_comment = $_POST["new_meeting_comment"];
            $date = $_POST["new_meeting_date"];
            $meeting_date  = DateTime::createFromFormat("d-m-Y G:i", $date)->format('Y-m-d H:i:s');
            $tutor_id = FenixEdu::getSingleton()->getIstId();
            $this->add_meeting($tutor_id,$place,$meio,$meeting_general_comment,$meeting_date);

            $meeting_id = $this->get_meeting_id($place,$meio,$meeting_general_comment,$meeting_date,$tutor_id);

	        if(isset($_POST["new_meeting_students"])){
	            foreach ($_POST["new_meeting_students"] as $student_id) {
                    $student_comment = $_POST['new_meeting_comment'.$student_id];
                    $student_present  = 0;
                    if(isset($_POST['new_meeting_present'.$student_id])){
                        $student_present = 1;
                    }
	                $this->add_student_to_meeting($meeting_id,$student_id,$student_comment,$student_present);
                }
	        }
            App::instance()->messages->addSuccess("Meeting added with success");
        }
    }

    public function add_meeting($tutor_id,$place,$meio,$comment,$meeting_date){
        App::instance()->db->
        insert("tuturado_reunion")->
        fields(
            array(
                "responsible_tutor",
                "local",
                "meio",
                "extra_info",
                "date"))->
        values(array(
                 ":tutor_id",
                 ":local",
                 ":meio",
                 ":extra_info",
                 ":date"))->
        dispatch(array(
            ":tutor_id"    => $tutor_id    ,
            ":local"       => $place     ,
            ":meio"        => $meio     ,
            ":extra_info"  => $comment,
            ":date"        => $meeting_date,
        ),false);

    }

    public function get_meeting_id($place,$meio,$meeting_general_comment,$meeting_date,$tutor_id){
        $reunion_id = App::instance()->db->select(array("reunion_id"))->from("tuturado_reunion")->where(
            "responsible_tutor=:tutor_id
            AND date=:date AND local=:local AND meio=:meio AND extra_info=:extra_info")
            ->dispatch(array("tutor_id" => $tutor_id,
                "local" => $place,
                "meio" => $meio,
                "date" => $meeting_date,
                "extra_info" => $meeting_general_comment,
            ));

        return $reunion_id[0]["reunion_id"];
    }

    public function add_student_to_meeting($meeting_id,$student_id,$student_comment,$student_present){
        App::instance()->db->
        insert("tuturado_reunion_atendence")->
        fields(
            array(
                "reunion_id",
                "student_id",
                "present",
                "extra_info",))->
        values(array(
            ":meeting_id",
            ":student_id",
            ":present",
            ":extra_info",))->
        dispatch(array(
            ":meeting_id"    => $meeting_id    ,
            ":student_id"       => $student_id     ,
            ":present"        => $student_present ,
            ":extra_info"  => $student_comment,
        ),false);
    }



	/**
	 * Get the Application Object
	 *
	 * @return The Application object
	 *
	 * @since 1.0.0
	 */
	public function getApplication(){
		//TODO
	}

	/**
	 * Get the input object
	 *
	 * @return The input object
	 *
	 * @since 1.0.0
	 */
	public function getInput(){
		//TODO
	}
}
