<?php
/**
 * @package App.Site
 * @sub_packacge com_users
 *
 * @author Andre Dias
 */

defined('__APP__8B1H9MU5QI') or die();
include_once ('controlPermissions.php');

/**
 * Profile model class for Users
 *
 * @since 1.0.0
 */
class TutoradosModelImportStudents extends AppModel {

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
	public function execute(){
        $fenixEdu = FenixEdu::getSingleton();

        $istId = $fenixEdu->getIstId();
        $this->data["isTutorAdmin"] = ControlPermissions::isTutorAdmin($istId);

        $this->data["students"] = App::instance()->db->
            select(array("istid","name",  "ist_number","email", "telefone", "other", "preferencial_contact", "entry_grade", "deslocated", "entry_phase", "option_number","extra_info"))->
            from("tuturado_student ")->
            where("tutor_id=:tutor_id")->
            dispatch(array("tutor_id" => $istId));
    }

	public function getData(){
		return $this->data;
	}
}
