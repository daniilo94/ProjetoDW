<?php

class RoleValidator implements IRoleValidator {

    public function isNameValid($name) {
        if (empty($name) || strlen($name) < 3) {
            return false;
        }

        return true;
    }

    public function isDescriptionValid($description) {
        if (empty($description)) {
            return false;
        }
        
        return true;
    }

    public function isSalaryValid($salary) {
        if (empty($salary))
            return false;
        
        return true;
    }

}
