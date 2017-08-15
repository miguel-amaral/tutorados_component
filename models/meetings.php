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
class TutoradosModelMeetings extends AppModel {

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
		$this->data["meetings"] = App::instance()->db->
            select(array("reunion_id","date","local","meio","extra_info"))->
            from("tuturado_reunion")->
            where("responsible_tutor=:tutor_id")->
            dispatch(array("tutor_id" => $istId));

        $totalStudents = App::instance()->db->
            execute("SELECT COUNT(*) as totalStudents from tuturado_student where tutor_id=:tutor_id",array("tutor_id" => $istId));
//            select(array("COUNT(*) as totalStudents"))->
//            from("tuturado_student")->
//            where("tutor_id=:tutor_id")->
//            dispatch(array("tutor_id" => $istId));

//        var_dump($totalStudents);
        echo("");
        $totalStudents = (int)$totalStudents[0]["totalStudents"];
//        var_dump($totalStudents);
        echo("");


        $istId = $fenixEdu->getIstId();
        $students = App::instance()->db->
        select(array("istid"))->
        from("tuturado_student ")->
        where("tutor_id=:tutor_id")->
        dispatch(array("tutor_id" => $istId));

        var_dump($students);

        $counter = 0;
        foreach($this->data["meetings"] as $meeting){
            $meeting_id = $meeting["reunion_id"];
            $this->data[$meeting_id] = App::instance()->db->
                execute("SELECT tuturado_reunion_atendence.student_id,tuturado_student.name,tuturado_reunion_atendence.extra_info, present
                         FROM tuturado_reunion_atendence JOIN tuturado_student ON tuturado_reunion_atendence.student_id=tuturado_student.istid
                         WHERE tuturado_reunion_atendence.reunion_id=:reunion_id
                         ORDER BY present DESC,tuturado_reunion_atendence.student_id",array("reunion_id" => $meeting_id));
//                select(array("tuturado_reunion_atendence.student_id","tuturado_student.name","tuturado_reunion_atendence.extra_info"))->
//                from(array("tuturado_reunion_atendence","tuturado_student"),"tuturado_reunion_atendence.student_id=tuturado_student.istid")->
//                where("tuturado_reunion_atendence.reunion_id=:reunion_id")->
//                dispatch(array("reunion_id" => $meeting_id));

//            var_dump($this->data[$meeting_id]);
            $attendanceNumbers = 0;
            foreach ($this->data[$meeting_id] as $student) {
                if($student["present"]==1) {
                    $attendanceNumbers++;
                }
            }

            $this->data["meetings"][$counter]["attendance"] = (int)(($attendanceNumbers * 100 ) / ($totalStudents));
            $counter  = $counter +1;
        }


//            execute("SELECT date, local, meio FROM tuturado_reunion WHERE responsible_tutor=:tutor_id",array("tutor_id" => $istId));
    }

	public function getData(){
		return $this->data;
	}
}
