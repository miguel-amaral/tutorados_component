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

    private $good = 0;
    private $bads = array();

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

	private function goodLine($lineNR) {
	    $this->good += 1;

    }
    private function badLine($lineNR,$Row) {
        array_push($this->bads,array($lineNR,$Row));
    }

	private function parseFile()
    {
            //"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            //"application/vnd.ms-excel",
        if (!in_array($_FILES["students_file"]["type"], array(
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

        $lineNR = 0;

        foreach ($Sheets as $Index => $Name) {

            $Reader->ChangeSheet($Index);
            foreach ($Reader as $Row) {
                if(in_array($Row[0], array("Tutor-Username","Tutor-Nome","Tutorando-Nº","Tutorando-Nome","Tutorando-Telemóvel","Tutorando-Email","Ano-Entrada"))) continue;
                $lineNR += 1;

                if(sizeof($Row) < 6) {
                    $this->badLine($lineNR,$Row);
                }
                App::instance()->db->insert("tuturado_tutor")->
                    fields(array("istid", "tutor_name",))->
                    values(array(":istid", ":tutor_name",))->
                    dispatch(array("istid" => $Row[0], "tutor_name" => $Row[1]));

//                if($lineNR % 5 == 0){
//
//                    $confirmation_tutor = App::instance()->db->select(array("istid","tutor_name"))->
//                        from("tuturado_tutor")->
//                        where("istid=:istid AND tutor_name=:tutor_name")->
//                        dispatch(array("istid" => $Row[0], "tutor_name" => "empty"));
//                } else {
                $confirmation_tutor = App::instance()->db->select(array("istid", "tutor_name"))->
                    from("tuturado_tutor")->
                    where("istid=:istid AND tutor_name=:tutor_name")->
                    dispatch(array("istid" => $Row[0], "tutor_name" => $Row[1]));
//                }

                
                App::instance()->db->insert("tuturado_student")->
                    fields(array("istid", "name", "email", "tutor_id","entry_year"))->
                    values(array(":istid", ":name" ,":email",":tutor_id",":entry_year"))->
                    dispatch(array("istid" => $Row[2], "name" => $Row[3],"tutor_id" => $Row[0], "email" => $Row[5],"entry_year" => $Row[6]));
//                    fields(array("istid", "name","email","tutor_id","telefone"))->
//                    values(array(":istid", ":name" ,":email",":tutor_id",":telefone"))->
//                    dispatch(array("istid" => $Row[2], "name" => $Row[3],"tutor_id" => $Row[0], "email" => $Row[5],"telefone" => $Row[4]));

                $confirmation_aluno = App::instance()->db->select(array("istid","name","email","tutor_id","entry_year"))->
                    from("tuturado_student")->
                    where("istid=:istid AND name=:name AND email=:email AND tutor_id=:tutor_id AND entry_year=:entry_year")->
                    dispatch(array("istid" => $Row[2], "name" => $Row[3],"tutor_id" => $Row[0], "email" => $Row[5], "entry_year" => $Row[6]));


                if(sizeof($confirmation_tutor) > 0 AND sizeof($confirmation_aluno) > 0) {
                    $this->goodLine($lineNR);
                } else {
                    $this->badLine($lineNR,$Row);
                }
            }
        }
        $message = "Número de Linhas " . $lineNR;
        App::instance()->messages->addInfo($message);

        $message = "Com sucesso " . $this->good;
        App::instance()->messages->addInfo($message);
        foreach ($this->bads as $bad) {
            $message = "Erro na linha nº" . $bad[0] . " LINHA: " . implode(" : ",$bad[1]);
            App::instance()->messages->addDanger($message);
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
