<?php
/**
 * @package App.Site
 * @sub_packacge com_users
 *
 * @author Andre Dias
 */

defined('__APP__8B1H9MU5QI') or die();
include_once ('detailedStudent.php');
include_once ('controlPermissions.php');
/**
 * Profile model class for Users
 *
 * @since 1.0.0
 */
class TutoradosModelStudents extends AppModel {

	/**
	 * @var Object	The user profile data
	 * @since 1.0
	 */
	public $data;
	public $params;
	public $offset;
	public $step;
	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct(){
		$this->data = array("students" => array());
	}

    public function fetchTutorStudents($tutor_id) {
        $detailedStudent = new TutoradosModelDetailedStudent();

        $this->data["students"] = App::instance()->db->
        select(array("istid","name",  "ist_number","email", "telefone","entry_year", "other", "preferencial_contact", "entry_grade", "deslocated", "entry_phase", "option_number","extra_info"))->
        from("tuturado_student ")->
        where("tutor_id=:tutor_id")->
        dispatch(array("tutor_id" => $tutor_id));

        $counter = 0;
        foreach($this->getData()["students"] as $student){
            $this->data["students"][$counter]["attendance"] = $detailedStudent->getPercentageMeetingsAttended($student['istid']) ;
            $counter = $counter +1 ;
        }
    }

	public function execute(){

        $fenixEdu = FenixEdu::getSingleton();

        $istId = $fenixEdu->getIstId();
        $this->data["isTutorAdmin"] = ControlPermissions::isTutorAdmin($istId);

        $this->fetchTutorStudents($istId);

        $meetings = App::instance()->db->
            select(array("responsible_tutor","date","reunion_id","local","meio","extra_info","tutor_name"))->
            from("tuturado_reunion JOIN tuturado_tutor ON tuturado_tutor.istid=tuturado_reunion.responsible_tutor")->
            where("responsible_tutor=:tutor_id")->
            dispatch(array("tutor_id" => $istId));

        if(sizeof($meetings) == 0){
            App::instance()->messages->addInfo("Relembre e incentive os seus Tutorandos a atualizar a fotografia de perfil no fénix.");
        }


    }

	public function getData(){
		return $this->data;
	}
}
