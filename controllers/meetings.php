<?php
/**
 * @package App.Site
 * @sub_packacge com_users
 *
 * @author Andre Dias
 */

defined('__APP__8B1H9MU5QI') or die();

include('addMeeting.php');


/**
 * Default controller class
 *
 * @since 1.0.0
 */
class TutoradosControllerMeetings extends AppController {

	/**
	 * Execute the controller
	 *
	 * return boolean True if the controller finished execution, false otherwise
	 * A controller might return false is some precondition for the controller
	 * to run has not been satisfied
	 *
	 * @since 1.0.0
	 */
	public function execute()
    {
        //var_dump($_POST);
        if (isset($_POST["meetings"])) {
//            ["meetings"]
//            ["students_in_2"]
//            ["ist123451_present_in_meeting_2"] "on"
//            ["ist123451_comment_in_meeting_2"] "holy great student!"  }

            foreach ($_POST["meetings"] as $meeting_id) {

                if(isset($_POST["students_in_".$meeting_id])){
                    foreach ($_POST["students_in_".$meeting_id] as $student_id) {
                        $present = 0;
                        if(isset($_POST[$student_id."_present_in_meeting_".$meeting_id])) {
                            $present = 1;
                        }

                        $student_individual_comment = $_POST[$student_id."_comment_in_meeting_".$meeting_id];

                        echo ("Aluno " . $present . " em " . $meeting_id . " with " . $student_individual_comment . " <br><br>");

                        $this->update_student_in_meeting($meeting_id,$student_id,$present,$student_individual_comment);
                    }
                }
                $this->update_meeting_general_info($meeting_id,$_POST["meeting_general_comment".$meeting_id]);
            }

            App::instance()->messages->addSuccess("Meetings information updated successfully");
        }

        if(isset($_POST["new_meeting_meio"])){
            $place = $_POST["new_meeting_place"];
            $meio = $_POST["new_meeting_meio"];
            $meeting_general_comment = $_POST["new_meeting_comment"];
            $date = $_POST["new_meeting_date"];
            $meeting_date  = DateTime::createFromFormat("d-m-Y G:i", $date)->format('Y-m-d H:i:s');
//            var_dump($date);
//            echo ($meeting_date->format('Y-m-d H:i:s'));
            $tutor_id = FenixEdu::getSingleton()->getIstId();

            $addMeetingControler = new TutoradosControllerAddMeeting();

            $addMeetingControler->add_meeting($tutor_id,$place,$meio,$meeting_general_comment,$meeting_date);

            $meeting_id = $addMeetingControler->get_meeting_id($place,$meio,$meeting_general_comment,$meeting_date,$tutor_id);

            if(isset($_POST["new_meeting_students"])){
                foreach ($_POST["new_meeting_students"] as $student_id) {
                    $student_comment = $_POST['new_meeting_comment'.$student_id];
                    $student_present  = 0;
                    if(isset($_POST['new_meeting_present'.$student_id])){
                        $student_present = 1;
                    }
                    $addMeetingControler->add_student_to_meeting($meeting_id,$student_id,$student_comment,$student_present);
                }
            }
            App::instance()->messages->addSuccess("Meeting added with success");
        }
    }

    private function update_student_in_meeting($meeting_id,$student_id,$present,$student_individual_comment){
        App::instance()->db->
            update("tuturado_reunion_atendence")->
            set(array(
                array("name" => "present"                  , "value" => ":present"),
                array("name" => "extra_info"               , "value" => ":extra_info"),
            ))->
            where("student_id=:student_id AND reunion_id=:meeting_id")->
            dispatch(
                array(
                    "present"                 => $present,
                    "extra_info"              => $student_individual_comment,
                    "student_id"              => $student_id,
                    "meeting_id"              => $meeting_id,
                ),false);
    }

    private function update_meeting_general_info($meeting_id,$info) {
        App::instance()->db->
                    update("tuturado_reunion")->
                    set(array(
                        array("name" => "extra_info"               , "value" => ":extra_info"),
                    ))->
                    where("reunion_id=:meeting_id")->
                    dispatch(
                        array(
                            "extra_info"              => $info,
                            "meeting_id"              => $meeting_id,
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
