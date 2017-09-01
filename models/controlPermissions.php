<?php
/**
 * @package App.Site
 * @sub_packacge com_users
 *
 * @author Andre Dias
 */

defined('__APP__8B1H9MU5QI') or die();

/**
 * Profile model class for Users
 *
 * @since 1.0.0
 */
class ControlPermissions {

//$this->data["isTutorAdmin"] = ControlPermissions::isTutorAdmin($tutor_id);
    public function isTutorAdmin($istID) {
        $allowed = array("ist178865","ist175741");
        return in_array($istID,$allowed);
    }
}
