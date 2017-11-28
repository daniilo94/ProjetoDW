<?php

class User {

    private $employee;
    private $userType;
    private $password;
    private $uv;

    public function __construct($employee, $userType, $password) {
        $this->uv = new UserValidator();

        $this->setEmployee($employee);
        $this->setUserType($userType);
        $this->setPassword($password);
    }

    public function getEmployee() {
        return $this->employee;
    }

    public function setEmployee($employee) {
        $this->employee = new Employee($employee['name'], $employee['cpf'], $employee['phones'],
            $employee['email'], $employee['birthdate'], $employee['role']);
    }

    public function getUserType() {
        return $this->userType;
    }

    public function setUserType($userType) {
        if (!$this->uv->isUserTypeValid($userType))
            throw new RequestException("400", "Invalid user type");

        $this->userType = $userType;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        if (!$this->uv->isPasswordValid($password))
            throw new RequestException("400", "Invalid password");

        $this->password = $password;
    }

}
