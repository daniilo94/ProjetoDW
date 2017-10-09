<?php

interface IRoleValidator {

    public function isNameValid($name);

    public function isDescriptionValid($description);

    public function isSalaryValid($salary);
}