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
class tutoradosViewCreateOutputFile extends AppView {

    public $output;
    public $cenas;


	public function __construct($model){ parent::__construct($model); }

	public function render(){
        $filename = "export.csv";
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Type: text/csv');
        header('Content-Disposition: filename="'.$filename.'"');

        $file = "";
        $file .= $this->array_to_csv_download(array($this->getData()["titles"]));

        foreach($this->data["meetings"] as $meeting){
//            $file .= $this->array_to_csv_download(array(array(
//            )));
            $meeting_id = $meeting["reunion_id"];
            foreach ($this->data[$meeting_id] as $student_in_meeting){
                $file .= $this->array_to_csv_download(array(array(
                    DateTime::createFromFormat("Y-m-d H:i:s", $meeting["time_created"])->format('d/m/Y')
                    ,DateTime::createFromFormat("Y-m-d H:i:s", $meeting["time_created"])->format('H:i')
                    ,DateTime::createFromFormat("Y-m-d H:i:s", $meeting["date"])->format('d/m/Y')
                    ,DateTime::createFromFormat("Y-m-d H:i:s", $meeting["date"])->format('H:i')
                    ,$student_in_meeting["name"]
                    ,$student_in_meeting["student_id"]
                    ,$meeting["tutor_name"]
                    ,$meeting["responsible_tutor"]
                    ,$meeting["extra_info"]


                    ,$student_in_meeting["extra_info"]
                    ,(($student_in_meeting["present"] == "1" ) ? "Presente" : "Faltou" )
                )));
            }
        }


//        $file .= $this->array_to_csv_download($this->getData()["meetings"]);
        return $file;
	}

    function backup($array, $filename = "export.csv", $delimiter=";") {
//        header('Content-Type: text/csv');
//        header('Content-Disposition: attachment; filename="'.$filename.'";');
        // open the "output" stream
        // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
//        $csv = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');

        if(!function_exists('str_putcsv'))
        {
            function str_putcsv($input, $delimiter = ',', $enclosure = '"')
            {
                // Open a memory "file" for read/write...
                $fp = fopen('php://temp', 'r+');
                // ... write the $input array to the "file" using fputcsv()...
                fputcsv($fp, $input, $delimiter, $enclosure);
                // ... rewind the "file" so we can read what we just wrote...
                rewind($fp);
                // ... read the entire line into a variable...
                $data = fread($fp, 1048576);
                // ... close the "file"...
                fclose($fp);
                // ... and return the $data to the caller, with the trailing newline from fgets() removed.
                return rtrim($data, "\n\r");
            }
        }

        $csvString = '';
        foreach ($array as $fields) {
            $csvString .= str_putcsv($fields);
        }

        return $csvString;

    }


//    function array_to_csv_download($array, $delimiter=";") {
//        // open the "output" stream
//        // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
//        $out = fopen('php://output', 'w');
//
//        foreach ($array as $line) {
//            fputcsv($out, $line, $delimiter);
//        }
//        fclose($out);
//    }

    function array_to_csv_download($array, $filename = "export.csv", $delimiter=";") {
//        header('Content-Type: text/csv');
//        header('Content-Disposition: attachment; filename="'.$filename.'";');
        // open the "output" stream
        // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
        $csv = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');

        foreach ($array as $line) {
            fputcsv($csv, $line, $delimiter);
        }
        rewind($csv);

        return stream_get_contents($csv);

    }
}
