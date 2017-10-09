<?php

interface IUserValidator {

    public function isUserTypeValid($userType);

    public function isPasswordValid($password);
}