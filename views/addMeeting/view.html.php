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
class TutoradosViewAddMeeting extends AppView {

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
        $html .='<script src="http://localhost/libraries/js/combodate.js"></script>';
        $html .="    <ul class=\"nav nav-tabs\">";
        $html .="            <li><a href=$students_link>Alunos</a></li>";
        $html .="            <li><a href=$meetings_link>Reuniões</a></li>";
        $html .="            <li class=active><a href=$add_meetings_link>Adicionar Reunião</a></li>";
        if($this->getData()["isTutorAdmin"]) {
            $html .="            <li ><a href=$import_students_link>Importar Alunos</a></li>";
            $html .="            <li ><a href=$output_file_link>Criar ficheiro output</a></li>";
            $html .="            <li ><a href=$list_all_students_link>Listar Todos Alunos</a></li>";
            $html .="            <li ><a href=$list_all_meetings_link>Listar Todas Reuniões</a></li>";
        }
        $html .="    <style>";
//        $html .="    div {border:1px solid black;}";
        $html .="    </style>";
        $html .="    </ul>";


        $html .= "<div class=\"tab-content\" style=\"margin-top:10px\">";
        $html .= "	<div class=\"tab-pane active\" id=\"temp\">";
		$html .= "    <div class=\"panel panel-default\">";
		$html .= "  	<div class=\"panel-heading\">";
		$html .= "  		<h3 class=\"panel-title\">Adicionar Reunião</h3>";
		$html .= "  	</div>";
		if(sizeof($this->getData()["real_students"]) == 0){
			$html .= "<div class=\"panel-body\">";
			$html .= "	<h3>You have no students associated</h3>";
			$html .= "</div>";
		}else{
			$html .= "<script>";
            $html .= ' function validateForm() { ';
            $html .= '     return false; ';
//            $html .= '     var x = document.forms["myForm"]["fname"].value; ';
//            $html .= '     if (x == "") { ';
//            $html .= '         alert("Name must be filled out"); ';
//            $html .= '         return false; ';
//            $html .= '     } ';
            $html .= ' } ';
			$html .= "</script>";

//            $html .= "<div class=\"panel-body\" >";
            $html .= '<div class="container">';
            $html .= "<div class=\"row\" style='margin-top: 20px'>";
            $html .= "    <div class=\"col-xs-1\"></div>";
            $html .= "    <div class=\"col-xs-11\">";


            $html .= "<form action=\"/index.php?com=" . $_GET["com"] . "&view=".$_GET["view"]."\" method=\"POST\">";
            $html .= "     <div class=\"row\">";

            $html .= "        <div class='col-xs-5'>";

            $html .= '            <div class="input-group">';
            $html .= "               <span class=\"input-group-addon\">Ano Tutoria</span>";
            $html .= '              <select class="form-control" id="tutoria_year" name="tutoria_year">';
            $html .= '                <option ' . (false ? "selected" : "") . ' value="" >Ano de Tutoria</option>';
            foreach ($this->getData()["possible_tutoria_years"] as $possible_year) {
                $selected = ($possible_year["entry_year"] === $this->getData()["selected_tutoria_year"]);
                $html .= '                <option ' . ($selected ? "selected" : "") . ' value="'.$possible_year["entry_year"].'" >'.$possible_year["entry_year"].'</option>';
            }
            $html .= '              </select>';
            $html .= '            </div>';
            $html .= "        </div>";
            $html .= "        <div class='col-xs-1'>";
            $html .= '            <button type="submit" name="submit" class="btn btn-primary">Escolher Ano</button>';
            $html .= "        </div>";
            $html .= "     </div>";

            $html .= "    <script>";
            $html .= '$("#tutoria_year").change(function () {';
            $html .= '    var end = this.value;';
            $html .= '    $("#change_this").prop("href","/index.php?com='.$_GET["com"].'&view='.$_GET["view"].'&tutoria_year=" + end);';
            $html .= '});';
            $html .= "    </script>";
            $html .= "</form>";

            if(sizeof($this->getData()["students"]) == 0) {
//                $html .= '        <h2>Alunos</h2>';
                $html .= "<h3>Por favor selecione um ano de tutoria.</h3>";
            } else {
                $html .= "<form action=\"/index.php?com=" . $_GET["com"] . "&view=meetings\" method=\"POST\">";

                $html .= '    <div class="row">';
                $html .= '        <div class="col-xs-5 form-group">';
                $html .= "          <div class=\"input-group\">";
                $html .= "                <span class=\"input-group-addon\">Data</span>";
                $validity_message = 'Formato Inválido. Por favor use DD-MM-YYYY h:mm (exemplo: 26-08-2017 15:30) ';
                $html .= '                <input onkeyup="this.onchange();" onchange="try{setCustomValidity(\'\')}catch(e){}" oninvalid="setCustomValidity(\'' . $validity_message . '\')" required name="new_meeting_date" type="text" id="new_meeting_date" class="form-control" pattern="\d{1,2}-\d{1,2}-\d{4}[ ]+\d{1,2}[:]{1}\d{2}[ ]*" data-format="DD-MM-YYYY h:mm" data-template="DD / MM / YYYY     hh : mm" name="datetime" value="' . date("d-m-Y G:i") . '">';
                $html .= "          </div>";
                $html .= '        </div>';

                //            $html .= '        <script>';
                //            $html .= '        $(function(){';
                //            $html .= "            $('#new_meeting_date').combodate();  ";
                //            $html .= '        });';
                //            $html .= '        </script>';
                $html .= '    </div>';

                //            $html .= '        <script>';
                //            $html .= "              var date_input = document.getElementById('new_meeting_date'); ";
                //            $html .= "              input.oninvalid = function(event) { ";
                //            $html .= "                  event.target.setCustomValidity('Username should only contain lowercase letters. e.g. john'); ";
                //            $html .= "              } ";
                //            $html .= '        </script>';

                $html .= "     <div class=\"row\">";
                $html .= '        <div class="col-xs-5 form-group">';
                $html .= "          <div class=\"input-group\">";
                $html .= "                <span class=\"input-group-addon\">Local</span>";
                $html .= "                <input  required name='new_meeting_place' id=\"place\" type=\"text\" class=\"form-control\" name=\"Local\" placeholder=\"Local onde foi/será a reunião\" value=\"\">";
                $html .= "          </div>";
                $html .= '        </div>';
                $html .= "     </div>";
                $html .= "     <div class=\"row\">";
                $html .= '        <div class="col-xs-5 form-group">';
                $html .= "          <div class=\"input-group\">";
                $html .= "                <span class=\"input-group-addon\">Meio&nbsp;</span>";
                $html .= "                <input required name='new_meeting_meio' id=\"meio\" type=\"text\" class=\"form-control\" name=\"meio\" placeholder=\"e.g. skype, slack ou presencial\" value=\"\">";
                $html .= "          </div>";
                $html .= '        </div>';
                $html .= "     </div>";


                $html .= "     <div class=\"row\">";
                $html .= '        <div class="col-xs-11 form-group" style="margin-top: 20px">';
                $html .= '            <label for="comment">Comentários Gerais:</label>';
                $html .= '            <textarea name="new_meeting_comment" class="form-control" rows="4" id="comment"></textarea>';
                $html .= '        </div>';
                $html .= "     </div>";
                $html .= '        <h2>Presenças</h2>';

                $html .= "<div class=\"row\" STYLE='color: white'>empty space</div>";
                foreach ($this->getData()["students"] as $student) {
                    $html .= "		<input type='hidden' name='new_meeting_students[]' value='" . $student["istid"] . "'>";

                    $html .= "<div style='margin: 25px'>";
                    $html .= "         <div class=\"row\">";
                    $url = App::instance()->buildURL("com_tutorados", "detailedStudent", array("detailedStudent" => $student["istid"]));

                    $html .= "		<div class=\"text-center col-xs-2\" style='margin-left: 0px'> <a href='$url'>" . $student["istid"] . " </a></div>";

                    //                $html .= "            <div class='col-xs-1'>".$student["istid"]."</div>";
                    $html .= "            <div class='col-xs-7'>" . $student["name"] . "</div>";
                    $html .= '            <div class="col-xs-2">';
                    $html .= '                <label class="checkbox-inline"><input name="new_meeting_present' . $student["istid"] . '" type="checkbox" >Presente</label>';
                    $html .= '            </div>';
                    //                $html .= "	    	  <div class=\"col-xs-2\"><a data-toggle=\"collapse\" href=\"#expandable" . $student["istid"] . "\" aria-expanded='true' aria-controls=\"expandable" . $student["istid"] . "\">Adicionar Comentário</a></div>";
                    $html .= "         </div>";
                    $html .= "         <div class=\"collapse in\" style=\"margin-top: 10px\" id=\"expandable" . $student["istid"] . "\">";
                    $html .= "             <div class=\"row\">";

                    //                $html .= '                <div class="col-xs-1"></div>';
                    $id_for_pic = $student['istid'];
                    if (strpos($id_for_pic, 'ist1') === false) {
                        $id_for_pic = "ist1" . $id_for_pic;
                    }
                    $html .= '  <div class="col-xs-2 ">';
                    $html .= "    <a href='$url'>";
                    $html .= '        <img class="center-block img-thumbnail img-responsive" src="https://fenix.tecnico.ulisboa.pt/user/photo/' . $id_for_pic . '" alt="Nature" style="">';
                    $html .= "    </a>";
                    $html .= '  </div>';

                    $html .= '                <div class="col-xs-9 form-group">';
                    $html .= '                    <label for="comment">Informações Individuais:</label>';
                    $html .= '                    <textarea name="new_meeting_comment' . $student["istid"] . '" class="form-control" rows="4" id="comment"></textarea>';
                    $html .= '                </div>';
                    $html .= "             </div>";
                    $html .= "         </div>";
                    $html .= "</div>";
                }


                $html .= "     </div>";


                $html .= "</div>";

                if (sizeof($this->getData()["students"]) != 0) {
                    $html .= "<div class='row'>";
                    $html .= "    <div class='col-xs-1'></div>";
                    $html .= "    <div class='col-xs-1' style='margin-bottom: 50px'>";
                    $html .= '        <button type="submit" name="submit" class="btn btn-primary">Adicionar Reunião</button>';
                    $html .= "    </div>";
                    $html .= "</div>";
                }
                //			}
                $html .= "</form>";
                $html .= "</div>";
                $html .= "  <script> $( document ).ready(function() {  $('form').areYouSure({
                    message: 'As alterações feitas à página não estão guardadas. '
                               + 'Se sair agora as alterações serão perdidas.'
                    });});</script>";
            }
		}

        $html .= "        </div>";
        $html .= "    </div>";
        $html .= "</div>";
        $html .= "</div>";
		$this->output = $html;
	}
}
