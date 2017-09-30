<?php

class EmployeeValidator {

    public function isValidEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return false;
        return true;
    }
    
    public function isNameValid($name) {
        if(empty($name))
            return false;
        
        return true;
    }

}
