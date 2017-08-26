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
class TutoradosModelListAllStudents extends AppModel {

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

    public function fetchAllStudents() {
        $detailedStudent = new TutoradosModelDetailedStudent();

        $this->data["students"] = App::instance()->db->execute("select tutor_name,ts.istid, name,  ist_number,email, telefone,entry_year, other, preferencial_contact, entry_grade, deslocated, entry_phase, option_number,extra_info FROM tuturado_student ts JOIN tuturado_tutor tt ON  ts.tutor_id=tt.istid" );

        $counter = 0;
        foreach($this->getData()["students"] as $student){
            $this->data["students"][$counter]["attendance"] = $detailedStudent->getPercentageMeetingsAttended($student['istid']) ;
            $counter = $counter +1 ;
        }
    }

	public function execute(){

        $fenixEdu = FenixEdu::getSingleton();

        $istId = $fenixEdu->getIstId();
        $isTutorAdmin = ControlPermissions::isTutorAdmin($istId);
        $this->data["isTutorAdmin"] = $isTutorAdmin;

        if($isTutorAdmin) {
            $this->fetchAllStudents();
        }

    }

	public function getData(){
		return $this->data;
	}
}
