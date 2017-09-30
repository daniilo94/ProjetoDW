<?php

class Provider {

    private $name;
    private $cnpj;
    private $phone;
    private $email;
    private $description;

    public function __construct($name, $cnpj, $phone, $email, $description) {
        $this->pv = new ProviderValidator();
        $this->name = $name;
        $this->cnpj = $cnpj;
        $this->phone = $phone;
        $this->email = $email;
        $this->description = $description;
    }

    public function getName() {
        return $this->name;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

}
