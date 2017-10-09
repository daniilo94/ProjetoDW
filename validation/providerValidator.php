<?php

class ProviderValidator implements IProviderValidator {

    private $validator;

    public function __construct() {
        $this->validator = new Validator();
    }

    public function isNameValid($name) {
        if (empty($name) || strlen($name) < 3) {
            return false;
        }

        return true;
    }

    public function isPhonesValid($phones) {
        if (!is_array($phones))
            return false;

        foreach ($phones as $phone) {
            if (!$this->validator->isPhoneValid($phone)) {
                return false;
            }
        }
        return true;
    }

    public function isEmailValid($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return false;

        return true;
    }

    public function isDescriptionValid($description) {
        if (empty($description)) {
            return false;
        }

        return true;
    }

    public function isCnpjValid($cnpj) {
        if(!$this->validator->isCnpjValid($cnpj))
            return false;
        
        return true;
    }

}
