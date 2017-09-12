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
        $import_students_link = App::instance()->buildURL("com_tutorados", "importStudents");
        $list_all_students_link = App::instance()->buildURL("com_tutorados", "listAllStudents");
        $list_all_meetings_link = App::instance()->buildURL("com_tutorados", "listAllMeetings");
        $output_file_link = App::instance()->buildURL("com_tutorados", "createOutputFile",array("file"=> true));

        $html  ="<div class=\"collapse navbar-collapse\" role=\"tablist\" id=\"bs-example-navbar-collapse-1\">";
        $html .="    <ul class=\"nav nav-tabs\">";
        $html .="            <li ><a href=$students_link>Alunos</a></li>";
        $html .="            <li class=active><a href=$meetings_link>Reuniões</a></li>";
        $html .="            <li><a href=$add_meetings_link>Adicionar Reunião</a></li>";
        if($this->getData()["isTutorAdmin"]) {
            $html .="            <li ><a href=$import_students_link>Importar Alunos</a></li>";
            $html .="            <li ><a href=$output_file_link>Criar ficheiro output</a></li>";
            $html .="            <li ><a href=$list_all_students_link>Listar Todos Alunos</a></li>";
            $html .="            <li ><a href=$list_all_meetings_link>Listar Todas Reuniões</a></li>";
        }

        $html .="    </ul>";
        $html .="    <style>";
//        $html .="    div {border:1px solid black;}";
        $html .="    </style>";

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

            $html .= "<form action=\"/index.php?com=".$_GET["com"]."&view=".$_GET["view"]."\" method=\"POST\">";

            $html .= "<div class='row' style='margin-top: 10px'>";
            $html .= "	<div class=\"text-center col-xs-2\" style='margin-left: 10px'>Data</div>";
            $html .= "	<div class=\"text-center col-xs-2\">Local</div>";
            $html .= "	<div class=\"text-center col-xs-2\">Meio</div>";
            $html .= "	<div class=\"text-center col-xs-2\">Responsável</div>";
            $html .= "	<div class=\"text-center col-xs-2\">Attendance</div>";
            $html .= "	<div class='col-xs-1'></div>";
            $html .= "</div>";

            $html .= "    <form>";

			foreach($this->getData()["meetings"] as $meeting){
                $html .= "    <div class=\"row\" style='margin-top: 30px'>";


                $html .= "		<div class=\"col-xs-2\" style='margin-left: 10px'>";# " . $meeting["date"] . " </div>";

//                $html .= "          <div class=\"input-group\">";
                $html .= "                <input style=\"text-align:center;\" readonly='readonly' id=\"date". $meeting["reunion_id"] ."\" type=\"text\" class=\"form-control\" name=\"historic\" placeholder=\"\" value=\"" . $meeting["date"] . "\">";
//                $html .= "          </div>";
                $html .= "      </div>";

                $html .= "		<div class=\"col-xs-2\">";
//                $html .= "          <div class=\"input-group text-center\">";
                $html .= "                <input style=\"text-align:center;\" readonly='readonly' id=\"local". $meeting["reunion_id"] ."\" type=\"text\" class=\"form-control\" name=\"historic\" placeholder=\"\" value=\"" . $meeting["local"] . "\">";
//                $html .= "          </div>";
                $html .= "      </div>";

                $html .= "		<div class=\"col-xs-2\" >";
//                $html .= "          <div class=\"input-group\">";
                $html .= "                <input style=\"text-align:center;\" readonly='readonly' id=\"meio". $meeting["reunion_id"] ."\" type=\"text\" class=\"form-control\" name=\"historic\" placeholder=\"\" value=\"" . $meeting["meio"] . "\">";
//                $html .= "          </div>";
                $html .= "      </div>";
                $html .= "		<div class=\"col-xs-2\" >";
//                $html .= "          <div class=\"input-group\">";
                $html .= "                <input style=\"text-align:center;\" readonly='readonly' id=\"responsible". $meeting["reunion_id"] ."\" type=\"text\" class=\"form-control\" name=\"historic\" placeholder=\"\" value=\"" . $meeting["responsible_tutor"] . "\">";
//                $html .= "          </div>";
                $html .= "      </div>";
                $html .= "		<div class=\"col-xs-2\" >";
//                $html .= "          <div class=\"input-group\">";
                $html .= "                <input style=\"text-align:center;\" readonly='readonly' id=\"attendence". $meeting["reunion_id"] ."\" type=\"text\" class=\"form-control\" name=\"historic\" placeholder=\"\" value=\"" . $meeting["attendance"] . "%\">";
//                $html .= "          </div>";
                $html .= "      </div>";
                $html .= "		<div class=\"col-xs-1\"><a data-toggle=\"collapse\" href=\"#expandable_geral" . $meeting["reunion_id"] . "\" aria-expanded='true' aria-controls=\"expandable" . $meeting["reunion_id"] . "\">Detalhes</a></div>";
                $html .= "    </div >";

                //more details
                $html .= "    <div class=\"collapse\" style=\"margin-top: 10px\" id=\"expandable_geral" . $meeting["reunion_id"] . "\">";
                $html .= "		<input type='hidden' name='meetings[]' value='".$meeting["reunion_id"]."'>";
                $html .= "      <div class=\"row\" style='margin-top: 00px'>";
                $html .= "        <div class='col-xs-2' style='margin-left: 10px'></div>";
                $html .= "        <div class='col-xs-8'>";

                $html .= "          <div class=\"input-group\">";
                $html .= "                <span class=\"input-group-addon\">Tutor Responsável:</span>";
                $html .= "                <input readonly='readonly' id=\"tutor_name". $meeting["reunion_id"] ."\" type=\"text\" class=\"form-control\" placeholder=\"Nome do tutor responsável\" value=\"" . $meeting["tutor_name"] . "\">";
                $html .= "          </div>";
                $html .= "        </div>";
                $html .= "      </div>";


                $html .= "      <div class=\"row\" style='margin-top: 0px'>";
                $html .= "        <div class='col-xs-2' style='margin-left: 10px'></div>";
                $html .= "        <div class='col-xs-8'>";

                $html .= "            <h2>Comentário Geral da Reunião:</h2>";
                $html .= "        </div>";
                $html .= "      </div>";
                $html .= "      <div class=\"row\" style='margin-top: 10px'>";
                $html .= "        <div class='col-xs-2' style='margin-left: 10px'></div>";
                $html .= "        <div class='col-xs-8'>";

                $html .= '            <div class="form-group">';
//                $html .= '                <label for="comment"></label>';
                $html .= '                <textarea class="form-control" rows="4" id="meeting_general_comment'.$meeting["reunion_id"].'" name="meeting_general_comment'.$meeting["reunion_id"].'">' . $meeting["extra_info"] . '</textarea>';
                $html .= '            </div>';

                $html .= "        </div>";
                $html .= "      </div>";

                $html .= "      <div class=\"row\" style='margin-top: 0px'>";
                $html .= "        <div class='col-xs-2' style='margin-left: 10px'></div>";
                $html .= "        <div class='col-xs-8'>";

                $html .= "            <h2>Alunos</h2>";
                $html .= "        </div>";
                $html .= "      </div>";

                foreach ($this->getData()[$meeting["reunion_id"]] as $student_in_meeting) {
                    $exists_extra_info = $student_in_meeting["extra_info"] != "";

                    $html .= "		<input type='hidden' name='students_in_".$meeting["reunion_id"]."[]' value='".$student_in_meeting["student_id"]."'>";

                    $html .= "      <div class=\"row\" style='margin-top: 10px'>";
                    $html .= "        <div class='col-xs-2 'style='margin-left: 10px'></div>";

                    $url = App::instance()->buildURL("com_tutorados", "detailedStudent", array("detailedStudent" => $student_in_meeting["student_id"]));
                    $html .= "		<div class=\"col-xs-1 text-center \" style='margin-left: 0px'> <a href='$url'>" . $student_in_meeting["student_id"] . " </a></div>";

                    $html .= "        <div class='col-xs-4'>".$student_in_meeting["name"]."</div>";

                    $html .= '        <div class="col-xs-1">';
                    $html .= '            <label class="checkbox-inline"><input name="'.$student_in_meeting["student_id"].'_present_in_meeting_'.$meeting["reunion_id"].'" type="checkbox" ' . (($student_in_meeting["present"] == "1" ) ? "checked" : " " ). '>Present</label>';
                    $html .= '        </div>';
                    $html .= "        <div class='col-xs-2'><a  data-toggle=\"collapse\" href=\"#".$meeting["reunion_id"]."expandable" . $student_in_meeting["student_id"] . "\" aria-expanded='true' aria-controls=\"expandable" . $student_in_meeting["student_id"] . "\">Comentário Individual</a></div>";

                    $html .= "      </div >";


                    $html .= "     <div class=\"collapse ".($exists_extra_info ? 'in':'in')."\" style=\"margin-top: 10px\" id=\"".$meeting["reunion_id"]."expandable" . $student_in_meeting["student_id"] . "\">";
                    $html .= "      <div class=\"row\" style='margin-top: 0px'>";
                    $html .= "        <div class='col-xs-2' style='margin-left: 10px'></div>";
                    $id_for_pic = $student_in_meeting['student_id'];
                    if (strpos($id_for_pic, 'ist1') === false) {
                        $id_for_pic = "ist1" . $id_for_pic;
                    }
                    $html .= '  <div class="col-xs-1 ">';
//                $html .= '    <div class="thumbnail" style="margin-left:10px;margin-top: 30px">';
                    $html .= "          <a href='$url'>";

                    $html .= '              <img class="center-block img-responsive img-thumbnail" src="https://fenix.tecnico.ulisboa.pt/user/photo/'.$id_for_pic.'" alt="Nature" style="">';
                    $html .= "          </a>";
//                $html .= '    </div>';
                    $html .= '  </div>';
                    $html .= "        <div class='col-xs-7'>";
                    $html .= '        <div class="form-group">';
                    $html .= '            <label for="comment">Comentário Individual:</label>';
                    $html .= '            <textarea name="'.$student_in_meeting["student_id"].'_comment_in_meeting_'.$meeting["reunion_id"].'" class="form-control" rows="4" id="comment">' . $student_in_meeting["extra_info"] . '</textarea>';
                    $html .= '        </div>';

                    $html .= "        </div>";
                    $html .= "      </div>";
                    $html .= "     </div>";
                }

                $html .= "    </div >";


            }
            $html .= "<div class='row' style='margin-top: 20px;'>";
//            $html .= "    <div class='col-xs-1'   ></div>";
            $html .= "    <div class='text-center col-xs-2' style='margin-left: 10px' >";
            $html .= '        <button type="submit" name="submit" class="btn btn-primary">Guardar Alterações</button>';
            $html .= "    </div>";
            $html .= "</div>";
            $html .= "</form>";
            $html .= "  <script> $( document ).ready(function() {  $('form').areYouSure({
                message: 'As alterações feitas à página não estão guardadas. '
                           + 'Se sair agora as alterações serão perdidas.'
                });});</script>";
		}
		$html .= "        </div>";
		$html .= "    </div>";
	    $html .= "</div>";
        $html .= "</div>";
		$this->output = $html;
	}
}
