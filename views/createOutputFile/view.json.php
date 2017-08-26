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
	    return $this->getData();
//	    return $this->array_to_csv_download($this->getData()["meetings"]);
//        return $this->getData();
//		return $this->cenas;
	}

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
