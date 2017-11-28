<?php

class Provider {

    private $name;
    private $cnpj;
    private $phones;
    private $email;
    private $description;
    private $pv;

    public function __construct($name, $cnpj, $phones, $email, $description) {
        $this->pv = new ProviderValidator();

        $this->setName($name);
        $this->setCnpj($cnpj);
        $this->setPhones($phones);
        $this->setEmail($email);
        $this->setDescription($description);
    }

    public function getName() {
        return $this->name;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function getPhones() {
        return $this->phones;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setName($name) {
        if (!$this->pv->isNameValid($name))
            throw new RequestException("400", "Invalid name");
        $this->name = $name;
    }

    public function setCnpj($cnpj) {
        if (!$this->pv->isCnpjValid($cnpj))
            throw new RequestException("400", "Invalid cnpj");
        $this->cnpj = $cnpj;
    }

    public function setPhones($phones) {
            if (!$this->pv->isPhonesValid($phones))
                throw new RequestException("400", "Invalid phone");
            
        $this->phones = $phones;
    }

    public function setEmail($email) {
        if (!$this->pv->isEmailValid($email))
            throw new RequestException("400", "Invalid email");
        $this->email = $email;
    }

    public function setDescription($description) {
        if (!$this->pv->isDescriptionValid($description))
            throw new RequestException("400", "Invalid description");
        $this->description = $description;
    }

}
