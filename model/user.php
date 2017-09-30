<?php

class User {

    private $employeeId;
    private $userType;
    private $passWord;

    public function __construct($employeeId, $userType, $passWord) {
        //$this->uv = new UserValidator();
        $this->employeeId = $employeeId;
        $this->userType = $userType;
        $this->passWord = $passWord;
    }

    public function getEmployeeId() {
        return $this->employeeId;
    }

    public function setEmployeeId($employeeId) {
        $this->employeeId = $employeeId;
    }

    public function getUserType() {
        return $this->userType;
    }

    public function setUserType($userType) {
        $this->userType = $userType;
    }

    public function getPassWord() {
        return $this->passWord;
    }

    public function setPassWord($passWord) {
        $this->passWord = $passWord;
    }

}
