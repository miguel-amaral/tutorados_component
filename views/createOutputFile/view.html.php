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
class TutoradosViewCreateOutputFile extends AppView {

	public function __construct($model){ parent::__construct($model); }

	public function render(){
        $students_link = App::instance()->buildURL("com_tutorados", "students");
        $meetings_link = App::instance()->buildURL("com_tutorados", "meetings");
        $add_meetings_link = App::instance()->buildURL("com_tutorados", "addMeeting");
        $import_students_link = App::instance()->buildURL("com_tutorados", "importStudents");
        $list_all_students_link = App::instance()->buildURL("com_tutorados", "listAllStudents");
        $list_all_meetings_link = App::instance()->buildURL("com_tutorados", "listAllMeetings");
        $output_file_link = App::instance()->buildURL("com_tutorados", "createOutputFile");

        $html  ="<div class=\"collapse navbar-collapse\" role=\"tablist\" id=\"bs-example-navbar-collapse-1\">";
        $html .='<script src="http://localhost/libraries/js/combodate.js"></script>';
        $html .="    <ul class=\"nav nav-tabs\">";
        $html .="            <li><a href=$students_link>Alunos</a></li>";
        $html .="            <li><a href=$meetings_link>Reuniões</a></li>";
        $html .="            <li><a href=$add_meetings_link>Adicionar Reunião</a></li>";
        if($this->getData()["isTutorAdmin"]) {
            $html .="            <li ><a  href=$import_students_link>Importar Alunos</a></li>";
            $html .="            <li class='active'><a href=$output_file_link>Criar ficheiro output</a></li>";
            $html .="            <li ><a href=$list_all_students_link>Listar Todos Alunos</a></li>";
            $html .="            <li ><a href=$list_all_meetings_link>Listar Todas Reuniões</a></li>";
        }
        $html .="    </ul>";


        $html .= "<div class=\"tab-content\" style=\"margin-top:10px\">";
        $html .= "	<div class=\"tab-pane active\" id=\"temp\">";
		$html .= "    <div class=\"panel panel-default\">";
		$html .= "  	<div class=\"panel-heading\">";
		$html .= "  		<h3 class=\"panel-title\">Importar Alunos</h3>";
		$html .= "  	</div>";
//            $html .= "<div class=\"panel-body\" >";

        if($this->getData()["isTutorAdmin"]) {

            $html .= '<div class="container" style="margin-top: 20px">';

            $html .= '<form method="POST" enctype="multipart/form-data" class="form-horizontal" action="index.php?com='.$_GET["com"].'&view='.$_GET["view"].'">';
			$html .= '	<div class="row">';
			$html .= '	    <input type="hidden" name="update_tutorado">';
			$html .= '	    <div class="form-group">';
			$html .= '	    	<label class="col-xs-2 control-label">Ficheiro</label>';
			$html .= '	    	<div class="col-xs-8">';
			$html .= '	    		<input name="students_file" type="file" class="form-control">';
			$html .= '	    	</div>';
			$html .= '	    </div>';
			$html .= '	</div>';
			$html .= '	<div class="row">';
			$html .= '	    <div class="col-xs-2"></div>';
			$html .= '	    <input type="submit" class="btn btn-primary" value="Atualizar">';
			$html .= '	</div>';
			$html .= '</form>';

            $html .= "</div>";
        } else {
            $html .= 'Forbidden!!';
        }


        $html .= "        </div>";
        $html .= "    </div>";
        $html .= "</div>";
        $html .= "</div>";
		$this->output = $this->getData()["meetings"];
	}
}
