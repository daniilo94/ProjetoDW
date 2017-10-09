<?php

class Role {

    private $name;
    private $description;
    private $salary;
    private $rv;

    public function __construct($name, $description, $salary) {
        $this->rv = new RoleValidator();

        $this->setName($name);
        $this->setDescription($description);
        $this->setSalary($salary);
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        if (!$this->rv->isNameValid($name))
            throw new RequestException("400", "Bad request");
        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        if (!$this->rv->isDescriptionValid($description))
            throw new RequestException("400", "Bad request");
        $this->description = $description;
    }

    public function getSalary() {
        return $this->salary;
    }

    public function setSalary($salary) {
        if (!$this->rv->isSalaryValid($salary))
            throw new RequestException("400", "Bad request");
        $this->salary = $salary;
    }

}
