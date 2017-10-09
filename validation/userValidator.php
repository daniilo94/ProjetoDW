<?php

class UserValidator implements IUserValidator {

    public function isUserTypeValid($userType){
        if($userType != "normal" && $userType != "admin")
            return false;

        return true;
    }

    public function isPasswordValid($password){
        if(strlen($password) < 7)
            return false;

        return true;
    }

}