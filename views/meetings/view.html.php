<?php
/**
 * @package App.Site
 * @sub_packacge com_users
 *
 * @author Andre Dias
 */

defined('__APP__8B1H9MU5QI') or die();

/**
 * Profile view class for Users
 *
 * @since 1.0.0
 */
class TutoradosViewMeetings extends AppView {

	public function __construct($model){ parent::__construct($model); }

	public function render(){
        $students_link = App::instance()->buildURL("com_tutorados", "students");
        $meetings_link = App::instance()->buildURL("com_tutorados", "meetings");
        $add_meetings_link = App::instance()->buildURL("com_tutorados", "addMeeting");

        $html  ="<div class=\"collapse navbar-collapse\" role=\"tablist\" id=\"bs-example-navbar-collapse-1\">";
        $html .="    <ul class=\"nav nav-tabs\">";
        $html .="            <li ><a href=$students_link>Alunos</a></li>";
        $html .="            <li class=active><a href=$meetings_link>Reuniões</a></li>";
        $html .="            <li><a href=$add_meetings_link>Adicionar Reunião</a></li>";

        $html .="    </ul>";

        $html .= "<div class=\"tab-content\" style=\"margin-top:10px\">";
    	$html .= "	<div class=\"tab-pane active\" id=\"temp\">";
		$html .= "      <div class=\"panel panel-default\">";
        $html .= "  	    <div class=\"panel-heading\">";
        $html .= "  	    	<h3 class=\"panel-title\">Lista de Reuniões</h3>";
        $html .= "  	    </div>";
		if(sizeof($this->getData()["meetings"]) == 0){
			$html .= "<div class=\"panel-body\">";
			$html .= "	<h3>There are no meetings registered</h3>";
			$html .= "</div>";
		}else{
//            $html .= "		<div class=\"col-xs-1\"><a data-toggle=\"collapse\" href=\"#expandable" . $student['istid'] . "\" aria-expanded='true' aria-controls=\"expandable" . $student['istid'] . "\">more details</a></div>";


            $html .= "    <div class=\"row\">";

            $html .= "		<div class=\"col-xs-2\" style='margin-left: 10px'>Data</div>";
            $html .= "		<div class=\"col-xs-2\">Local</div>";
            $html .= "		<div class=\"col-xs-4\">Meio</div>";
            $html .= "		<div class=\"col-xs-2\">Attendance</div>";
            $html .= "		<div class='col-xs-1'></div>";
            $html .= "    </div>";
            $new_line="<br>";
//            var_dump($this->getData());
//            var_dump($new_line);

			foreach($this->getData()["meetings"] as $meeting){
                $html .= "    <div class=\"row\" style='margin-top: 10px'>";


                $html .= "		<div class=\"col-xs-2\" style='margin-left: 10px'> " . $meeting["date"] . " </div>";
                $html .= "		<div class=\"col-xs-2\">" . $meeting["local"] . " </div>";
//                $html .= "		<div class=\"col-xs-1\">" . $student["attendence"] . " </div>";
                $html .= "		<div class=\"col-xs-4\" >". $meeting["meio"] . "</div>";
                $html .= "		<div class=\"col-xs-2\" >". $meeting["attendance"] . "%</div>";
                $html .= "		<div class=\"col-xs-1\"><a data-toggle=\"collapse\" href=\"#expandable_geral" . $meeting["reunion_id"] . "\" aria-expanded='true' aria-controls=\"expandable" . $meeting["reunion_id"] . "\">Detalhes</a></div>";
                $html .= "    </div >";

                //more details
                $html .= "    <div class=\"collapse\" style=\"margin-top: 10px\" id=\"expandable_geral" . $meeting["reunion_id"] . "\">";

//                var_dump($new_line);
//                var_dump($new_line);
//                var_dump($meeting);
//                var_dump($new_line);
//                var_dump($meeting["reunion_id"]);
//                var_dump($meeting[$meeting["reunion_id"]]);

                $html .= "      <div class=\"row\" style='margin-top: 10px'>";
                $html .= "        <div class='col-xs-2' style='margin-left: 10px'></div>";
                $html .= "        <div class='col-xs-8'>";

                $html .= '        <div class="form-group">';
                $html .= '            <label for="comment">Comentários Gerais da Reunião:</label>';
                $html .= '            <textarea class="form-control" rows="4" id="comment">' . $meeting["extra_info"] . '</textarea>';
                $html .= '        </div>';

                $html .= "        </div>";
                $html .= "      </div>";


                foreach ($this->getData()[$meeting["reunion_id"]] as $student_in_meeting) {
//                    $html .= '<div>'.print($student_in_meeting).'</div>';
//                    var_dump($student_in_meeting);
                    $exists_extra_info = $student_in_meeting["extra_info"] != "";

                    $html .= "      <div class=\"row\" style='margin-top: 10px'>";
                    $html .= "        <div class='col-xs-2 'style='margin-left: 10px'></div>";
                    $html .= "        <div class='col-xs-1'>".$student_in_meeting["student_id"]."</div>";
                    $html .= "        <div class='col-xs-4'>".$student_in_meeting["name"]."</div>";
                    $html .= '        <div class="checkbox col-xs-2">';
                    $html .= '            <label><input type="checkbox" ' . (($student_in_meeting["present"] == "1" ) ? "checked" : " " ). '>Present</label>';
                    $html .= '        </div>';
                    $html .= "        <div class='col-xs-2'><a  data-toggle=\"collapse\" href=\"#expandable" . $student_in_meeting["student_id"] . "\" aria-expanded='true' aria-controls=\"expandable" . $student_in_meeting["student_id"] . "\">Adicionar Comentário</a></div>";

                    $html .= "      </div >";


                    $html .= "     <div class=\"collapse ".($exists_extra_info ? 'in':'')."\" style=\"margin-top: 10px\" id=\"expandable" . $student_in_meeting["student_id"] . "\">";
                    $html .= "      <div class=\"row\" style='margin-top: 10px'>";
                    $html .= "        <div class='col-xs-3' style='margin-left: 10px'></div>";
                    $html .= "        <div class='col-xs-8'>";

                    $html .= '        <div class="form-group">';
                    $html .= '            <label for="comment">Comentário Individual:</label>';
                    $html .= '            <textarea class="form-control" rows="4" id="comment">' . $student_in_meeting["extra_info"] . '</textarea>';
                    $html .= '        </div>';

                    $html .= "        </div>";
                    $html .= "      </div>";
                    $html .= "     </div>";
                }

                $html .= "    </div >";


            }
		}
		$html .= "        </div>";
		$html .= "    </div>";
	    $html .= "</div>";
        $html .= "</div>";
		$this->output = $html;
	}
}
