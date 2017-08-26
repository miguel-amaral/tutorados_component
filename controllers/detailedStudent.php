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
class TutoradosControllerDetailedStudent extends AppController {

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
        if(isset($_POST["IST_ID"])){
            $IST_ID         = $_POST["IST_ID"];
            $name           = $_POST["name"];
            $email          = $_POST["email"];
            $telefone       = $_POST["telefone"];
            $outro          = $_POST["outro"];
            $preferencial   = $_POST["preferencial"];
            $observations   = $_POST["observations"];
            $entry_grade    = $_POST["entry_grade"];
            $option_number  = $_POST["option_number"];
            $entry_phase    = $_POST["entry_phase"];
            if(isset($_POST["deslocated"])){
                $deslocated = 1;
            } else {
                $deslocated = 0;
            }
            $this->updateStudent($IST_ID,$name,$email,$telefone,$outro,$preferencial,$observations, $deslocated,$entry_grade,$entry_phase,$option_number);

            if(isset($_POST["meetings"])){
                foreach ($_POST["meetings"] as $meeting_id) {
                    $present=0;
                    if(isset($_POST["present".$meeting_id])) {
                        $present=1;
                    }
                    $extra_info = $_POST["extra_reunion_info".$meeting_id];
                    $this->updateStudentInMeeting($IST_ID,$meeting_id,$present,$extra_info);

                }
            }


            App::instance()->messages->addSuccess("Student information updated successfully");
        }


        return true;
	}

	private function updateStudent($studentID, $name, $email, $telefone, $other,$preferencial,$observations,$deslocated,$entry_grade,$entry_phase,$option_number) {
	                    App::instance()->db->
                        update("tuturado_student")->
                        set(array(
                                array("name" => "name"                  , "value" => ":name"),
                                array("name" => "email"                  , "value" => ":email"),
                                array("name" => "telefone"              , "value" => ":telefone"),
                                array("name" => "preferencial_contact"  , "value" => ":preferencial_contact"),
                                array("name" => "deslocated"            , "value" => ":deslocated"),
                                array("name" => "other"                 , "value" => ":other"),
                                array("name" => "extra_info"            , "value" => ":extra_info"),
                                array("name" => "entry_grade"            , "value" => ":entry_grade"),
                                array("name" => "entry_phase"            , "value" => ":entry_phase"),
                                array("name" => "option_number"            , "value" => ":option_number"),))->
                        where("istid=:istid")->
                        dispatch(array(
                                "istid"                 => $studentID,
                                "name"                  => $name,
                                "email"                  => $email,
                                "telefone"              => $telefone,
                                "preferencial_contact"  => $preferencial,
                                "deslocated"            => $deslocated,
                                "other"                 => $other,
                                "entry_grade"           => $entry_grade,
                                "entry_phase"           => $entry_phase,
                                "option_number"         => $option_number,
                                "extra_info"            => $observations,),false);
    }

    private function updateStudentInMeeting($IST_ID,$meeting_id,$present,$extra_info){
        App::instance()->db->
            update("tuturado_reunion_atendence")->
            set(array(
                    array("name" => "present"                  , "value" => ":present"),
                    array("name" => "extra_info"               , "value" => ":extra_info"),
        ))->
            where("student_id=:istid AND reunion_id=:meeting_id")->
            dispatch(array(
                        "istid"                 => $IST_ID,
                        "meeting_id"            => $meeting_id,
                        "present"               => $present,
                        "extra_info"            => $extra_info,
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
