<?php
/**
 * @package App.Site
 * @sub_packacge com_users
 *
 * @author Andre Dias
 */

defined('__APP__8B1H9MU5QI') or die();
//require_once('../../../libraries/spreadsheet-reader/SpreadsheetReader.php');

/**
 * Default controller class
 *
 * @since 1.0.0
 */
class TutoradosControllerImportStudents extends AppController {

	/**
	 * Execute the controller
	 *
	 * return boolean True if the controller finished execution, false otherwise
	 * A controller might return false is some precondition for the controller
	 * to run has not been satisfied
	 *
	 * @since 1.0.0
	 */
	public function execute(){
        if(isset($_POST["update_tutorado"])){
            $this->parseFile();
        }
	}

	private function parseFile()
    {
        if (!in_array($_FILES["students_file"]["type"], array(
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "application/vnd.ms-excel",
            "text/csv"
        ))) {
            App::instance()->messages->addWarning
            ("Formato de ficheiro inválido: " . $_FILES["students_file"]["type"]);
            return;
        }
        $tmp = tempnam(sys_get_temp_dir(), 'prefix');
        $ext = pathinfo($_FILES["students_file"]["name"], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES["students_file"]["tmp_name"], $tmp . "." . $ext);
        $Reader = new SpreadsheetReader($tmp . "." . $ext);
        $Sheets = $Reader->Sheets();

        foreach ($Sheets as $Index => $Name) {

            $Reader->ChangeSheet($Index);
            foreach ($Reader as $Row) {
//                var_dump($Row);
//                echo ("<br><br>");
                if(in_array($Row[0], array("Tutor-Username","Tutor-Nome","Tutorando-Nº","Tutorando-Nome","Tutorando-Telemóvel","Tutorando-Email"))) continue;

                App::instance()->db->insert("tuturado_tutor")->
                    fields(array("istid", "tutor_name",))->
                    values(array(":istid", ":tutor_name",))->
                    dispatch(array("istid" => $Row[0], "tutor_name" => $Row[1]));

                App::instance()->db->insert("tuturado_student")->
                    fields(array("istid", "name","email","tutor_id"))->
                    values(array(":istid", ":name" ,":email",":tutor_id",))->
                    dispatch(array("istid" => $Row[2], "name" => $Row[3],"tutor_id" => $Row[0], "email" => $Row[5]));
//                    fields(array("istid", "name","email","tutor_id","telefone"))->
//                    values(array(":istid", ":name" ,":email",":tutor_id",":telefone"))->
//                    dispatch(array("istid" => $Row[2], "name" => $Row[3],"tutor_id" => $Row[0], "email" => $Row[5],"telefone" => $Row[4]));


//                if (!in_array($Row[0], array("LEIC-A", "LEIC-T", "MEIC-A", "MEIC-T", "METI", "MERC"))) continue;

            }
        }
    }

	/**
	 * Get the Application Object
	 *
	 * @return The Application object
	 *
	 * @since 1.0.0
	 */
	public function getApplication(){
		//TODO
	}

	/**
	 * Get the input object
	 *
	 * @return The input object
	 *
	 * @since 1.0.0
	 */
	public function getInput(){
		//TODO
	}
}
