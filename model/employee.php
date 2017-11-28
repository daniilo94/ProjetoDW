<?php

class Employee {

    private $name;
    private $cpf;
    private $phones;
    private $email;
    private $birthdate;
    private $role;
    private $ev;

    public function __construct($name, $cpf, $phones, $email, $birthdate, $role) {
        $this->ev = new EmployeeValidator();
        
        $this->setName($name);
        $this->setCpf($cpf);
        $this->setPhones($phones);
        $this->setEmail($email);
        $this->setBirthdate($birthdate);
        $this->setRole($role);
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        if (!$this->ev->isNameValid($name))
            throw new RequestException("400", "Invalid name");
        
        $this->name = $name;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function setCpf($cpf) {
        if (!$this->ev->isCpfValid($cpf))
            throw new RequestException("400", "Invalid CPF");
        
        $this->cpf = $cpf;
    }

    public function getPhones() {
        return $this->phones;
    }

    public function setPhones($phones) {
        if (!$this->ev->isPhonesValid($phones))
            throw new RequestException("400", "Invalid phone");
        
        $this->phones = $phones;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        if (!$this->ev->isEmailValid($email))
            throw new RequestException("400", "Invalid email");
        
        $this->email = $email;
    }

    public function getBirthdate() {
        return $this->birthdate;
    }

    public function setBirthdate($birthdate) {
        if (!$this->ev->isBirthdateValid($birthdate))
            throw new RequestException("400", "Invalid birthdate");
        
        $this->birthdate = $birthdate;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = new Role($role['name'], $role['description'], $role['salary']);
    }

}
