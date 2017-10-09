<?php

interface IEmployeeValidator {


    public function isEmailValid($email);

    public function isNameValid($name);

    public function isPhonesValid($phones);

    public function isCpfValid($cpf);

    public function isBirthdateValid($birthdate);
}