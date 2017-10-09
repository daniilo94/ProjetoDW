<?php

interface IProviderValidator {

    public function isNameValid($name);

    public function isPhonesValid($phones);

    public function isEmailValid($email);

    public function isDescriptionValid($description);

    public function isCnpjValid($cnpj);
}