<?php

class EmployeeValidator implements IEmployeeValidator {

    private $validator;

    public function __construct() {
        $this->validator = new Validator();
    }

    public function isEmailValid($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return false;
        return true;
    }

    public function isNameValid($name) {
        if (empty($name))
            return false;

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

    public function isCpfValid($cpf) {
        if (!$this->validator->isCpfValid($cpf))
            return false;

        return true;
    }

    public function isBirthdateValid($birthdate) {
        $d = DateTime::createFromFormat('Y-m-d', $birthdate);
        return $d && $d->format('Y-m-d') === $birthdate;
    }

}
