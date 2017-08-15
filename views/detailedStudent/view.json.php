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
class tutoradosViewDetailedStudent extends AppView {

	public function __construct($model){ parent::__construct($model); }

	public function render(){ 
		return $this->getData();
	}
}
