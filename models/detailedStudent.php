<?php
/**
 * @package App.Site
 * @sub_packacge com_users
 *
 * @author Andre Dias
 */

defined('__APP__8B1H9MU5QI') or die();

/**
 * Profile model class for Users
 *
 * @since 1.0.0
 */
class TutoradosModelDetailedStudent extends AppModel {

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
		$this->data = array("student" => array());
	}
	public function execute(){
        $fenixEdu = FenixEdu::getSingleton();
        if(isset($_GET["detailedStudent"]))
            $studentID = $_GET["detailedStudent"];
        else
            $studentID = "ERROR";
        $istId = $fenixEdu->getIstId();
		$this->data["student"] = App::instance()->db->
            select(array("istid","deslocated","name", "extra_info", "ist_number","email", "telefone", "other", "preferencial_contact","entry_year" ,"entry_grade", "deslocated", "entry_phase", "option_number"))->
            from("tuturado_student ")->
            where("tutor_id=:tutor_id AND istid=:studentID")->
            dispatch(array("tutor_id" => $istId,"studentID"=> $studentID));

		$this->data["meetings"] = App::instance()->db->
            execute("SELECT tuturado_reunion_atendence.reunion_id, tuturado_reunion_atendence.present, tuturado_reunion_atendence.extra_info, tuturado_reunion.date, tuturado_reunion.local, tuturado_reunion.meio
                    FROM tuturado_reunion JOIN tuturado_reunion_atendence ON tuturado_reunion.reunion_id=tuturado_reunion_atendence.reunion_id
                    WHERE student_id=:student_id
                    ORDER BY date DESC ",array("student_id"=>$studentID));

		$this->data["number_present"] = 0;
		$index = 0;
		foreach ($this->data["meetings"] as $meeting){
		    if($meeting["present"] == "1" ) {
                $this->data["number_present"]++;
            }
            $meeting_id = $meeting["reunion_id"];
            $this->data["meetings"][$index]["per_cent"] = App::instance()->db->
            execute("SELECT 100*count(*) / total.total as per_cent
		     FROM tuturado_reunion_atendence JOIN (SELECT count(*) as total FROM tuturado_reunion_atendence WHERE reunion_id = :reunion_id) total
		     WHERE reunion_id = :reunion_id AND present = 1
		     GROUP BY present
		    ",array("reunion_id"=>$meeting_id));

//            var_dump($this->data["meetings"][$index]["per_cent"]);

            $this->data["meetings"][$index]["per_cent"] = $this->data["meetings"][$index]["per_cent"][0]["per_cent"];
//            var_dump(explode( '.',$this->data["meetings"][$index]["per_cent"]));
            $this->data["meetings"][$index]["per_cent"] = explode( '.',$this->data["meetings"][$index]["per_cent"])[0];
            $index++;
        }
        $this->data["total_reunions"] = sizeof($this->getData()["meetings"]);
        $this->data["percentage_attended"] = (string)((100*$this->data["number_present"])/ $this->data["total_reunions"]);
    }

    public function getPercentageAttended() {

    }

	public function getData(){
		return $this->data;
	}
}
