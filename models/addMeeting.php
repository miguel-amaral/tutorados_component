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
class TutoradosModelAddMeeting extends AppModel {

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
		$this->data = array("real_students" => array());
		$this->data = array("selected_tutoria_year" => "");
	}
	public function execute(){
        $fenixEdu = FenixEdu::getSingleton();



        $istId = $fenixEdu->getIstId();
        //For counting purposes
            $this->data["real_students"] = App::instance()->db->
                select(array("istid"))->
                from("tuturado_student ")->
            where("tutor_id=:tutor_id")->
            dispatch(array("tutor_id" => $istId));


        if(isset($_POST["tutoria_year"])) {
            $tutoria_year = $_POST["tutoria_year"];
            $this->data["selected_tutoria_year"] = $tutoria_year;
            $this->data["students"] = App::instance()->db->
                select(array("istid","name",  "ist_number","email", "telefone", "other", "preferencial_contact", "entry_grade", "deslocated", "entry_phase", "option_number","extra_info"))->
                from("tuturado_student ")->
                where("tutor_id=:tutor_id AND entry_year=:tutoria_year")->
                dispatch(array("tutor_id" => $istId,"tutoria_year" => $tutoria_year));
        }
        $this->data["possible_tutoria_years"] = App::instance()->db->
                execute("select distinct entry_year from tuturado_student where tutor_id = :tutor_id",array("tutor_id" => $istId));

        $this->data["isTutorAdmin"] = ControlPermissions::isTutorAdmin($istId);

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
