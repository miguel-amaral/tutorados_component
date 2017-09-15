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
class TutoradosModelCreateOutputFile extends AppModel {

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
        if(!$this->data["isTutorAdmin"]) {
            return;
        }
//        $this->data["students"] = App::instance()->db->
//            select(array("istid","name",  "ist_number","email", "telefone", "other", "preferencial_contact", "entry_grade", "deslocated", "entry_phase", "option_number","extra_info"))->
//            from("tuturado_student ")->
//            where("tutor_id=:tutor_id")->
//            dispatch(array("tutor_id" => $istId));


        $this->data["titles"] = array("Data da Inserção", "Hora da Inserção", "Data da Reunião", "Hora da Reunião", "Nome do aluno", "Nº de aluno", "Nome do Tutor", "Nº Mec. Tutor", "Resumo da Reunião", "Resumo individual da reunião", "Presente");
        $this->data["meetings"] = App::instance()->db->
            select(array("responsible_tutor","tutor_name","date","extra_info","time_created","reunion_id"))->
//            select(array("responsible_tutor","tutor_name","date","extra_info"))->
            from("tuturado_reunion JOIN tuturado_tutor ON tuturado_tutor.istid=tuturado_reunion.responsible_tutor")->
            where("true=true")->
            dispatch(array());

        $counter = 0;
        foreach($this->data["meetings"] as $meeting){
            $tutor_id = $meeting["responsible_tutor"];
            $totalStudents = App::instance()->db-> execute("SELECT COUNT(*) as totalStudents from tuturado_student where tutor_id=:tutor_id",array("tutor_id" => $tutor_id));
            $totalStudents = (int)$totalStudents[0]["totalStudents"];

            $meeting_id = $meeting["reunion_id"];
            $this->data[$meeting_id] = App::instance()->db->
            execute("SELECT tuturado_reunion_atendence.student_id,tuturado_student.name,tuturado_reunion_atendence.extra_info, present
                         FROM tuturado_reunion_atendence JOIN tuturado_student ON tuturado_reunion_atendence.student_id=tuturado_student.istid
                         WHERE tuturado_reunion_atendence.reunion_id=:reunion_id
                         ORDER BY tuturado_reunion_atendence.student_id",array("reunion_id" => $meeting_id));
//                select(array("tuturado_reunion_atendence.student_id","tuturado_student.name","tuturado_reunion_atendence.extra_info"))->
//                from(array("tuturado_reunion_atendence","tuturado_student"),"tuturado_reunion_atendence.student_id=tuturado_student.istid")->
//                where("tuturado_reunion_atendence.reunion_id=:reunion_id")->
//                dispatch(array("reunion_id" => $meeting_id));

            $attendanceNumbers = 0;
            foreach ($this->data[$meeting_id] as $student) {
                if($student["present"]==1) {
                    $attendanceNumbers++;
                }
            }

            $this->data["meetings"][$counter]["attendance"] = (int)(($attendanceNumbers * 100 ) / (sizeof($this->data[$meeting_id])));
            $counter  = $counter +1;
        }
    }

    function array_to_csv_download($array, $filename = "export.csv", $delimiter=";") {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        // open the "output" stream
        // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
        $f = fopen('php://output', 'w');

        foreach ($array as $line) {
            fputcsv($f, $line, $delimiter);
        }
        fclose($f);
    }

    public function getData(){
		return $this->data;
	}
}
