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
class TutoradosViewStudents extends AppView {

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
        $html .="            <li class=active><a href=$students_link>Alunos</a></li>";
        $html .="            <li><a href=$meetings_link>Reuniões</a></li>";
        $html .="            <li><a href=$add_meetings_link>Adicionar Reunião</a></li>";
        if($this->getData()["isTutorAdmin"]) {
            $html .="            <li ><a href=$import_students_link>Importar Alunos</a></li>";
            $html .="            <li ><a href=$output_file_link>Criar ficheiro output</a></li>";
            $html .="            <li ><a href=$list_all_students_link>Listar Todos Alunos</a></li>";
            $html .="            <li ><a href=$list_all_meetings_link>Listar Todas Reuniões</a></li>";
        }
        $html .="    </ul>";


        $html .= "<div class=\"tab-content\" style=\"margin-top:10px\">";
        $html .= "	<div class=\"tab-pane active\" id=\"temp\">";
		$html .= "    <div class=\"panel panel-default\">";
		$html .= "  	<div class=\"panel-heading\">";
		$html .= "  		<h3 class=\"panel-title\">Lista de Alunos</h3>";
		$html .= "  	</div>";
		if(sizeof($this->getData()["students"]) == 0){
			$html .= "<div class=\"panel-body\">";
			$html .= "	<h3>You have no students associated</h3>";
			$html .= "</div>";
		}else{
//            $html .= "<div class=\"panel-body\" >";
            $html .= "    <div class=\"row\" style='margin-top: 10px'>";

            $html .= "		<div class=\"text-center col-xs-1 panel-title\" style='margin-left: 10px'>Número IST</div>";
            $html .= "		<div class=\"text-center col-xs-7 panel-title\">Nome do Aluno</div>";
            $html .= "		<div class=\"text-center col-xs-1 \">Histórico de Reuniões</div>";
            $html .= "		<div class=\"text-center col-xs-1 \">Ano Tutoria</div>";
            $html .= "		<div class='col-xs-1 panel-title'></div>";
            $html .= "    </div>";

//			$html .= "<table class=\"table\">";
//			$html .= "	<tr>";
//			$html .= "		<th>ist id</td>";
//			$html .= "		<th>ist number</td>";
			foreach($this->getData()["students"] as $student){
                $html .= "    <div class=\"row\" style='margin-top: 20px'>";

//                $html .= "		<div class=\"col-xs-1\" >";
                $url = App::instance()->buildURL("com_tutorados", "detailedStudent", array("detailedStudent" => $student["istid"]));

                $html .= "		<div class=\"col-xs-1\" style='margin-left: 10px'> <a href='$url'>" . $student["istid"] . " </a></div>";

//                $html .= "          <div class=\"input-group\">";
//                $html .= "                <span class=\"input-group-addon\">IST ID</span>";
//                $html .= "                <input id=\"istid". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"IST ID\" placeholder=\"IST ID\" value=\"" . $student["istid"] . "\">";
//                $html .= "          </div>";
//                $html .= "      </div>";

                $html .= "		<div class=\"col-xs-7\">";
                $html .= "          <div class=\"input-group\">";
                $html .= "                <span class=\"input-group-addon\">Nome</span>";
                "";
                $html .= "                <input readonly='readonly' id=\"name". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"IST ID\" placeholder=\"Nome Do Aluno\" value=\"".$student["name"]."\">";
                $html .= "          </div>";
                $html .= "      </div>";
//                $html .= "		<div class=\"col-xs-1\"></div>";
//                $html .= "    </div >";
//
//                $html .= "    <div class=\"row\" style='margin-top: 10px'>";
//
//                $html .= "		<div class=\"col-xs-1\" style='margin-left: 10px'> " . $student["istid"] . " </div>";
//                $html .= "		<div class=\"col-xs-8\">" . $student["name"] . " </div>";
////                $html .= "		<div class=\"col-xs-1\">" . $student["attendence"] . " </div>";

                $html .= "		<div class=\"col-xs-1\" >";
                $html .= "          <div class=\"input-group\">";
//                $html .= "                <span class=\"input-group-addon\"></span>";
                $html .= "                <input readonly='readonly' id=\"historic". $student["istid"] ."\" type=\"text\" class=\"form-control\" name=\"historic\" placeholder=\"\" value=\"" . $student['attendance'] . "\">";
                $html .= "          </div>";
                $html .= "      </div>";
                $html .= "		<div class=\"col-xs-1\" >";
                $html .= "          <div class=\"input-group\">";
//                $html .= "                <span class=\"input-group-addon\"></span>";
                $html .= "                <input readonly='readonly' id=\"entry_year". $student["istid"] ."\" type=\"text\" class=\"form-control\" name=\"entry_year\" placeholder=\"\" value=\"" . $student['entry_year'] . "\">";
                $html .= "          </div>";
                $html .= "      </div>";

//                $html .= "		<div class=\"col-xs-1\" >" . " TODO " . " </div>";
//                $html .= "		<div class=\"col-xs-1\" >" . $student['entry_year'] . " </div>";

                $html .= "		<div class=\"col-xs-1\"><a data-toggle=\"collapse\" href=\"#expandable" . $student['istid'] . "\" aria-expanded='true' aria-controls=\"expandable" . $student['istid'] . "\">more details</a></div>";
                $html .= "    </div >";

//              more details of the student (hidden)
                $html .= "    <div class=\"collapse\" style=\"margin-top: 10px\" id=\"expandable" . $student['istid'] . "\">";
                $html .= "      <div class=\"row\" style='margin-top: 10px'>";
                $html .= "        <div class='col-xs-1' style='margin-left: 10px'></div>";
                $html .= "        <div class='col-xs-5'>";
                $html .= "          <div class=\"input-group\">";
                $html .= "                <span class=\"input-group-addon\">Email</span>";
                $html .= "                <input readonly='readonly' id=\"email". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"email\" placeholder=\"Email do Aluno\" value=\"" . $student["email"] . "\">";
                $html .= "          </div>";
                $html .= "        </div>";
                $html .= "        <div class='col-xs-4'>";
                $html .= "          <div class=\"input-group\">";
                $html .= "                <span class=\"input-group-addon\">Telefone</span>";
                $html .= "                <input readonly='readonly' id=\"telefone". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"telefone\" placeholder=\"Telefone do Aluno\" value=\"" . $student["telefone"] . "\">";
                $html .= "          </div>";
                $html .= "        </div>";
                $html .= "      </div>";

                $html .= "      <div class=\"row\" style='margin-top: 10px'>";
                $html .= "        <div class='col-xs-1' style='margin-left: 10px'></div>";
                $html .= "        <div class='col-xs-5'>";
                $html .= "          <div class=\"input-group\">";
                $html .= "                <span class=\"input-group-addon\">Outro</span>";
                $html .= "                <input readonly='readonly' id=\"outro". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"outro\" placeholder=\"Outro Contacto\" value=\"" . $student["other"] . "\">";
                $html .= "          </div>";
                $html .= "        </div>";
                $html .= "        <div class='col-xs-4'>";
                $html .= "          <div class=\"input-group\">";
                $html .= "                <span class=\"input-group-addon\">Preferencial</span>";
                $html .= "                <input readonly='readonly' id=\"telefone". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"telefone\" placeholder=\"Contacto Preferencial\" value=\"" . $student["preferencial_contact"] . "\">";
                $html .= "          </div>";
                $html .= "        </div>";
                $html .= "      </div>";

                $html .= "      <div class=\"row\" style='margin-top: 0px'>";
                $html .= "        <div class='col-xs-1'></div>";
                $html .= "      </div>";


                $html .= "      <div class=\"row\" style='margin-top: 10px'>";
                $html .= "        <div class='col-xs-1' style='margin-left: 10px'></div>";
                $html .= "        <div class='col-xs-3'>";
                $html .= "          <div class=\"input-group\">";
                $html .= "                <span class=\"input-group-addon\">Nota Entrada</span>";
                $html .= "                <input readonly='readonly' id=\"entry_grade". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"entry_grade\" placeholder=\"Nota de Entrada\" value=\"" . $student["entry_grade"] . "\">";
                $html .= "          </div>";
                $html .= "        </div>";
                $html .= "        <div class='col-xs-2'>";
                $html .= "          <div class=\"input-group\">";
                $html .= "                <span class=\"input-group-addon\">Fase de Entrada</span>";
                $html .= "                <input readonly='readonly' id=\"entry_phase". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"entry_phase\" placeholder=\"Fase de entrada\" value=\"" . $student["entry_phase"] . "\">";
                $html .= "          </div>";
                $html .= "        </div>";
                $html .= "        <div class='col-xs-4'>";
                $html .= "          <div class=\"input-group\">";
                $html .= "                <span class=\"input-group-addon\">Opção Número</span>";
                $html .= "                <input readonly='readonly' id=\"option_number". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"option_number\" placeholder=\"Fase de entrada\" value=\"" . $student["option_number"] . "\"f>";
                $html .= "          </div>";
                $html .= "        </div>";
                $html .= "      </div>";

                $html .= "      <div class=\"row\" style='margin-top: 10px'>";
                $html .= "        <div class='col-xs-1' style='margin-left: 10px'></div>";
                $html .= "        <div class='col-xs-5'>";
                $html .= "          <div class=\"input-group\">";
                if($student["deslocated"] === "1"){
                    $valor = "Sim";
                } elseif ($student["deslocated"] === "0") {
                    $valor = "Não";
                } else {
                    $valor = "";
                }
                $html .= "                <span class=\"input-group-addon\">Aluno Deslocado</span>";
                $html .= "                <input readonly='readonly' id=\"option_number". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"option_number\" placeholder=\"Aluno Deslocado\" value=\"" . $valor . "\"f>";
                $html .= "          </div>";
                $html .= "        </div>";
                $html .= "      </div>";
                 
                $html .= "      <div class=\"row\" style='margin-top: 10px'>";
                $html .= "        <div class='col-xs-1' style='margin-left: 10px'></div>";
                $html .= "        <div class='col-xs-9'>";

                $html .= '        <div class="form-group">';
                $html .= '            <label for="comment">Informações Adicionais:</label>';
                $html .= '            <textarea readonly=\'readonly\' class="form-control" rows="5" id="comment"> '.$student["extra_info"].' </textarea>';
                $html .= '        </div>';

                $html .= "        </div>";
                $html .= "      </div>";



////               , , ,
                $html .= "    </div>";
			}
            $html .= "      <div class=\"row\" style='margin-top: 10px'>";
            $html .= "        <div class='col-xs-1' style='margin-left: 10px'></div>";
            $html .= "      </div>";

            $html .= "</div>";
		}

        $html .= "        </div>";
        $html .= "    </div>";
        $html .= "</div>";
        $html .= "</div>";
		$this->output = $html;
	}
}
