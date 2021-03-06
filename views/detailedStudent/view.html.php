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
class TutoradosViewDetailedStudent extends AppView {

	public function __construct($model){ parent::__construct($model); }

	public function render(){
        $students_link = App::instance()->buildURL("com_tutorados", "students");
        $meetings_link = App::instance()->buildURL("com_tutorados", "meetings");
        $add_meetings_link = App::instance()->buildURL("com_tutorados", "addMeeting");
        $import_students_link = App::instance()->buildURL("com_tutorados", "importStudents");
        $list_all_students_link = App::instance()->buildURL("com_tutorados", "listAllStudents");
        $list_all_meetings_link = App::instance()->buildURL("com_tutorados", "listAllMeetings");
        $output_file_link = App::instance()->buildURL("com_tutorados", "createOutputFile",array("file"=> true));



//        $html = " <script src=\"jquery.are-you-sure.js\"></script>";

        $html  ="<div class=\"collapse navbar-collapse\" role=\"tablist\" id=\"bs-example-navbar-collapse-1\">";
        $html .="    <ul class=\"nav nav-tabs\">";
        $html .="            <li><a href=$students_link>Alunos</a></li>";
        $html .="            <li><a href=$meetings_link>Reuniões</a></li>";
        $html .="            <li><a href=$add_meetings_link>Adicionar Reunião</a></li>";
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
        $html .= "</div>";

        $html .= "<div class=\"tab-content\" style=\"margin-top:10px\">";
        $html .= "	<div class=\"tab-pane active\" id=\"temp\">";
		$html .= "    <div class=\"panel panel-default\">";
		$html .= "  	<div class=\"panel-heading\">";
		$html .= "  		<h3 class=\"panel-title\">Informações Pessoais</h3>";
		$html .= "  	</div>";
		if(sizeof($this->getData()["student"]) == 0){
			$html .= "<div class=\"panel-body\">";
			$html .= "	<h3>Student is not avaiable</h3>";
			$html .= "</div>";
            $html .= "        </div>";
            $html .= "    </div>";
            $html .= "</div>";
		}else{


            $html .= "<form id=\"detailed-student\" action=\"/index.php?com=".$_GET["com"]."&view=".$_GET["view"]."&detailedStudent=".$_GET["detailedStudent"]."\" method=\"POST\">";
			foreach($this->getData()["student"] as $student){
//                $html .= "<div class=\"panel-body\" >";

                $html .= "<div class=\"row\" >";
                $html .= '  <div class="col-xs-1" ></div>';
                $html .= '  <div class="col-xs-10" >';

                $html .= "<div class=\"row\" >";
                $html .= '       <div class="col-xs-9" >';
                $html .= "           <h3 >Aluno</h3>";
                $html .= "           <div class=\"row\" style='margin-top: 10px'>";

//                $html .= "   	     	<div class=\"col-xs-1\" ></div>";
                $html .= "	   	     <div class=\"col-xs-4\" style='margin-left: 10px'>";
                $html .= "              <div class=\"input-group\">";
                $html .= "                        <span class=\"input-group-addon\">IST ID</span>";
                $html .= "                        <input readonly='readonly' id=\"istid". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"IST ID\" placeholder=\"IST ID\" value=\"" . $student["istid"] . "\">";
                $html .= "                  </div>";
                $html .= "              </div>";
                $html .= "            </div >";

                $html .= "            <div class=\"row\" style='margin-top: 10px'>";

                $html .= "	   	     <div class=\"col-xs-7\" style='margin-left: 10px'>";
                $html .= "                  <div class=\"input-group\">";
                $html .= "                        <span class=\"input-group-addon\">Nome</span>";
                $html .= "                        <input readonly='readonly' id=\"name". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"name\" placeholder=\"Nome Do Aluno\" value=\"" . $student["name"] . "\">";
                $html .= "                  </div>";
                $html .= "              </div>";
                $html .= "            </div >";
                $html .= "    </div >";

//                $html .= "    <h3 >&nbsp;</h3>";
                $html .= '  <div class="col-xs-2 ">';
                $html .= '    <div class="thumbnail" style="margin-left:10px;margin-top: 30px">';

                $id_for_pic = $student['istid'];
                if (strpos($id_for_pic, 'ist1') === false) {
                    $id_for_pic = "ist1" . $id_for_pic;
                }
                $html .= '        <img class="img" src="https://fenix.tecnico.ulisboa.pt/user/photo/'.$id_for_pic.'" alt="Nature" style="">';
                $html .= '    </div>';
                $html .= '  </div>';

                $html .= "</div >";


//                $html .= "    <div class=\"row\" style='margin-top: 10px'>";
//                $html .= "    </div >";


                $html .= "    <h3 >Contactos</h3>";
                $html .= "    <div class=\"\" style=\"margin-top: 10px\" id=\"expandable" . $student['istid'] . "\">";
                $html .= "      <div class=\"row\" style='margin-top: 10px'>";
//                $html .= "        <div class='col-xs-1'></div>";
                $html .= "        <div class='col-xs-7' style='margin-left: 10px'>";
                $html .= "          <div class=\"input-group\">";
                $html .= "                <span class=\"input-group-addon\">Email</span>";
                $html .= "                <input id=\"email". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"email\" placeholder=\"Email do Aluno\" value=\"" . $student["email"] . "\">";
                $html .= "          </div>";
                $html .= "        </div>";
                $html .= "        <div class='col-xs-4'>";
                $html .= "          <div class=\"input-group\">";
                $html .= "                <span class=\"input-group-addon\">Telefone</span>";
                $html .= "                <input id=\"telefone". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"telefone\" placeholder=\"Telefone do Aluno\" value=\"" . $student["telefone"] . "\">";
                $html .= "          </div>";
                $html .= "        </div>";
                $html .= "      </div>";

                $html .= "      <div class=\"row\" style='margin-top: 10px'>";
//                $html .= "        <div class='col-xs-1'></div>";
                $html .= "        <div class='col-xs-7' style='margin-left: 10px'>";
                $html .= "          <div class=\"input-group\">";
                $html .= "                <span class=\"input-group-addon\">Outro</span>";
                $html .= "                <input id=\"outro". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"outro\" placeholder=\"Outro Contacto\" value=\"" . $student["other"] . "\">";
                $html .= "          </div>";
                $html .= "        </div>";
                $html .= "        <div class='col-xs-4'>";
                $html .= '            <div class="input-group">';
                $html .= "               <span class=\"input-group-addon\">Preferencial</span>";
                $html .= '              <select class="form-control" id="preferencial" name="preferencial">';
                $telefone = ($student["preferencial_contact"] === "Telefone");
                $email = ($student["preferencial_contact"] === "Email");
                $other = ($student["preferencial_contact"] === "Other");
                $html .= '                <option '.($email?"selected":"").' value="Email" >Email</option>';
                $html .= '                <option '.($telefone?"selected":"").' value="Telefone" >Telefone</option>';
                $html .= '                <option '.($other?"selected":"").' value="Other" >Other</option>';
                $html .= '              </select>';
                $html .= '            </div>';
                $html .= "        </div>";
                $html .= "      </div>";




                $html .= "    <div class=\"row\" style='margin-top: 10px'>";
                $html .= "    </div >";

                $html .= "    <h3 >Entrada</h3>";
                $html .= "      <div class=\"row\" style='margin-top: 10px'>";
//                $html .= "        <div class='col-xs-1'></div>";
                $html .= "        <div class='col-xs-4' style='margin-left: 10px'>";
                $html .= "          <div class=\"input-group\">";
                $html .= "                <span class=\"input-group-addon\">Nota Entrada</span>";
                $html .= "                <input id=\"entry_grade". $student['istid'] ."\" step=\"any\" type=\"number\" max='20' min='0' class=\"form-control\" name=\"entry_grade\" placeholder=\"Nota de Entrada\" value=\"" . $student["entry_grade"] . "\">";
                $html .= "          </div>";
                $html .= "        </div>";
//                $html .= "        <div class='col-xs-3'></div>";
                $html .= "        <div class='col-xs-4'>";

                $html .= '            <div class="input-group">';
                $html .= "               <span class=\"input-group-addon\">Fase de Entrada</span>";
                $html .= '              <select class="form-control" id="entry_phase" name="entry_phase">';
                $one = ($student["entry_phase"] === "1");
                $two = ($student["entry_phase"] === "2");
                $three = ($student["entry_phase"] === "3");
                if($one or $two or $three){
                    $none = true;
                } else {
                    $none = false;
                }
                $html .= '                <option '.($none ?"selected":"").' value=" " >Fase de Entrada</option>';
                $html .= '                <option '.($one ?"selected":"").' value="1" >1ª</option>';
                $html .= '                <option '.($two ?"selected":"").' value="2" >2ª</option>';
                $html .= '                <option '.($three ?"selected":"").' value="3" >3ª</option>';
                $html .= '              </select>';
                $html .= '            </div>';

//                $html .= "          <div class=\"input-group\">";
//                $html .= "                <span class=\"input-group-addon\">Fase de Entrada</span>";
//                $html .= "                <input id=\"entry_phase". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"entry_phase\" placeholder=\"Fase de entrada\" value=\"" . $student["entry_phase"] . "\">";
//                $html .= "          </div>";
                $html .= "        </div>";
                $html .= "      </div>";

                $html .= "      <div class=\"row\" style='margin-top: 10px'>";
                $html .= "        <div class='col-xs-4' style='margin-left: 10px'>";
                $html .= '            <div class="input-group">';
                $html .= "               <span class=\"input-group-addon\">Opção Número</span>";
                $html .= '              <select class="form-control" id="option_number" name="option_number">';
                $one = ($student["option_number"] === "1");
                $two = ($student["option_number"] === "2");
                $three = ($student["option_number"] === "3");
                $four = ($student["option_number"] === "4");
                $five = ($student["option_number"] === "5");
                $six = ($student["option_number"] === "6");
                if($one or $two or $three or $four or $five or $six){
                    $none = true;
                } else {
                    $none = false;
                }
                $html .= '                <option '.($none ?"selected":"").' value="" >Opção Número</option>';
                $html .= '                <option '.($one ?"selected":"").' value="1" >1ª</option>';
                $html .= '                <option '.($two ?"selected":"").' value="2" >2ª</option>';
                $html .= '                <option '.($three ?"selected":"").' value="3" >3ª</option>';
                $html .= '                <option '.($four ?"selected":"").' value="4" >4ª</option>';
                $html .= '                <option '.($five ?"selected":"").' value="5" >5ª</option>';
                $html .= '                <option '.($six ?"selected":"").' value="6" >6ª</option>';
                $html .= '              </select>';
                $html .= '            </div>';
                $html .= "        </div>";
//                $html .= "        <div class='col-xs-3'></div>";
                $html .= "        <div class='col-xs-4'>";
                $html .= "          <div class=\"input-group\">";
                $html .= "              <span class=\"input-group-addon\">Ano de Entrada</span>";
                $html .= "              <input readonly='readonly' id=\"entry_year". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"entry_year\" placeholder=\"Telefone do Aluno\" value=\"" . $student["entry_year"] . "\">";
                $html .= "          </div>";
                $html .= "        </div>";
                $html .= "      </div>";


                $html .= '      <div class="col-xs-5" style="padding: 10px">';
                $html .= "          <div class=\"input-group\">";
                $html .= '            <label class="checkbox-inline"><input name="deslocated" type="checkbox" ' . (($student["deslocated"] == "1" ) ? "checked" : " " ). '>Aluno Deslocado</label>';
                $html .= '          </div>';
                $html .= '      </div>';

//                $html .= "        <div class='col-xs-5' style='margin-left: 10px'>";
//                $html .= "              <div class=\"input-group\">";
//                $html .= "               <label style='margin-right: 20px'>Aluno Deslocado</label>";

//                $html .= '                  <label class="radio-inline "><input ' .((((int)$student["deslocated"]) == 1 ) ? "checked" : " " ).' type="radio" checked name="deslocatedY"></input>Sim</label>';
//                $html .= '                  <label class="radio-inline " ><input '.((((int)$student["deslocated"]) == 0 ) ? "checked" : " ").' type="radio" name="deslocatedN"></input>Não</label>';
////                $html .= '                  <label class="radio-inline " ><input type="radio" name="deslocated"></input>TODO AUTO SELECT</label>';
//                $html .= "            </div>";
//                $html .= "        </div>";
                $html .= "      </div>";
                 
                $html .= "      <div class=\"row\" style='margin-top: 10px'>";
//                $html .= "        <div class='col-xs-1' ></div>";
                $html .= "        <div class='col-xs-11' style='margin-left: 10px'>";

                $html .= '        <div class="form-group">';
                $html .= '            <label for="comment">Informações Adicionais:</label>';
                $html .= '            <textarea name="observations" class="form-control" rows="5" id="comment">'.$student["extra_info"].'</textarea>';

//                $html .= '            <input name="observations" type="text" hidden >';

//                $html .= '        <script>';
//                $html .= '            ';
//                $html .= '        </script>';
                $html .= '        </div>';

                $html .= "        </div>";
                $html .= "      </div>";


                $html .= '  </div>';

////               , , ,
                $html .= "    </div>";

//                $html .= "    <h3 >&nbsp;</h3>";
//                $html .= '  <div class="col-xs-1 ">';
//                $html .= '    <div class="thumbnail" style="margin-left:10px;margin-top: 10px">';
//                $html .= '      <a href="https://fenix.tecnico.ulisboa.pt/user/photo/ist178865">';
//                $html .= '        <img class="img" src="https://fenix.tecnico.ulisboa.pt/user/photo/ist178865" alt="Nature" style="">';
//                $html .= '      </a>';
//                $html .= '    </div>';
//                $html .= '  </div>';
			}
            $html .= "</div>";
            $html .= "</div>";
            $html .= "<div class='row'>";
            $html .= "    <div class='col-xs-1' style='margin-top: 10px;'  ></div>";
            $html .= "    <div class='col-xs-10' style='margin-left: 10px' >";
            $html .= '        <button type="submit" name="submit" class="btn btn-primary">Guardar Alterações</button>';
            $html .= "    </div>";
            $html .= "</div>";
            $html .= "<div class=\"tab-content\" style=\"margin-top:10px\">";
            $html .= "	<div class=\"tab-pane active\" id=\"temp\">";
            $html .= "    <div class=\"panel panel-default\" >";
            $html .= "  	<div class=\"panel-heading\">";
            $html .= "  		<h3 class=\"panel-title\">Reuniões</h3>";
            $html .= "  	</div>";


            $html .= "    <div class=\"row\" style='margin-top: 10px'>";
            $html .= "		<div class=\"col-xs-1\" ></div>";
            $html .= "		<div class=\"col-xs-4\" style='margin-left: 10px'>";
            $html .= "          <div class=\"input-group\">";
            $html .= "                <span class=\"input-group-addon\">Percentagem Reuniões Presente</span>";
            $html .= "                <input readonly='readonly' id=\"istid". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"to_ignore\" placeholder=\"IST ID\" value=\"" . $this->data["percentage_attended"]  . "%\">";
            $html .= "          </div>";
            $html .= "      </div>";
            $html .= "    </div >";

            $html .= "    <div class=\"row\" style='margin-top: 10px'>";
            $html .= "		<div class=\"col-xs-1\" ></div>";
            $html .= "		<div class=\"col-xs-4\" style='margin-left: 10px'>";
            $html .= "          <div class=\"input-group\">";
            $html .= "                <span class=\"input-group-addon\">Reuniões Presente</span>";
            $html .= "                <input readonly='readonly' id=\"istid". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"to_ignore\" placeholder=\"IST ID\" value=\"". $this->data["number_present"] . "\">";
            $html .= "          </div>";
            $html .= "      </div>";
            $html .= "    </div >";

            $html .= "    <div class=\"row\" style='margin-top: 10px'>";
            $html .= "		<div class=\"col-xs-1\" ></div>";
            $html .= "		<div class=\"col-xs-4\" style='margin-left: 10px'>";
            $html .= "          <div class=\"input-group\">";
            $html .= "                <span class=\"input-group-addon\">Total Reuniões</span>";
            $html .= "                <input readonly='readonly' id=\"istid". $student['istid'] ."\" type=\"text\" class=\"form-control\" name=\"to_ignore\" placeholder=\"IST ID\" value=\"" . $this->data["total_reunions"] . "\">";
            $html .= "          </div>";
            $html .= "      </div>";
            $html .= "    </div >";



            foreach($this->getData()["meetings"] as $meeting) {
                $html .= "<div class=\"row\" style='margin-top: 10px'>";


                $html .= "		<input type='hidden' name='meetings[]' value='".$meeting["reunion_id"]."'>";
                $html .= "		<div class=\"col-xs-1\" style='margin-left: 10px'></div>";
                $html .= "		<div class=\"col-xs-2\" > " . $meeting["date"] . " </div>";
                $html .= "		<div class=\"text-center col-xs-2\">@ " . $meeting["local"] . " </div>";
//                $html .= "		<div class=\"col-xs-1\">" . $student["attendence"] . " </div>";
                $html .= "		<div class=\"text-center col-xs-2\" >via " . $meeting["meio"] . "</div>";
                $html .= '      <div class="text-center col-xs-2">';
                $html .= '          <label class="checkbox-inline"><input name="present'.$meeting["reunion_id"].'" type="checkbox" ' . (($meeting["present"] == "1" ) ? "checked" : " " ). '>Present</label>';
                $html .= '      </div>';
                $html .= "		<div class=\"text-center col-xs-2\" >" . $meeting["per_cent"] . "% Alunos Presentes</div>";
                $html .= "</div>";
                $html .= "<div class=\"row\" style='margin-top: 10px'>";
                $html .= "		<div class=\"col-xs-1\" style='margin-left: 10px'></div>";
                $html .= "      <div class='col-xs-10'>";
                $html .= '            <div class="form-group">';
                $html .= '                <label for="comment">Comentários da Reunião Específicos ao Aluno:</label>';
                $html .= '                <textarea name="extra_reunion_info'.$meeting["reunion_id"].'" class="form-control" rows="5" id="comment"> '.$meeting["extra_info"].' </textarea>';
                $html .= '            </div>';

                $html .= "      </div>";
                $html .= "</div>";

                }



            $html .= "      </div>";
            $html .= "    </div>";
            $html .= "</div>";
            $html .= "<div class='row'>";
            $html .= "    <div class='col-xs-1' style='margin-top: 10px;'  ></div>";
            $html .= "    <div class='col-xs-10' style='margin-left: 10px;margin-bottom: 25px' >";
            $html .= '        <button type="submit" name="submit" class="btn btn-primary">Guardar Alterações</button>';
            $html .= "    </div>";
            $html .= "</div>";
            $html .= "</form>";



            $html .= "  <script> $( document ).ready(function() {  $('form').areYouSure({
        message: 'As alterações feitas à página não estão guardadas. '
               + 'Se sair agora as alterações serão perdidas.'
                });});</script>";

        }

		$this->output = $html;
	}
}
