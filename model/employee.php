<?php

class Employee {

    private $name;
    private $cpf;
    private $rg;
    private $phone;
    private $email;
    private $birthdate;
    private $roleId;

    public function __construct($name, $cpf, $rg, $phone, $email, $birthdate, $roleId) {
        //$this->uv = new UserValidator();
        $this->name = $name;
        $this->cpf = $cpf;
        $this->rg = $rg;
        $this->phone = $phone;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->roleId = $roleId;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function getRg() {
        return $this->rg;
    }

    public function setRg($rg) {
        $this->rg = $rg;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getBirthdate() {
        return $this->birthdate;
    }

    public function setBirthdate($birthdate) {
        $this->birthdate = $birthdate;
    }

    public function getFunctionId() {
        return $this->roleId;
    }

    public function setFunctionId($functionId) {
        $this->roleId = $roleId;
    }

}
