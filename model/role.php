<?php

class Role {

    private $name;
    private $description;
    private $salary;

    public function __construct($name, $description, $salary) {
        //$this->uv = new UserValidator();
        $this->name = $name;
        $this->description = $description;
        $this->salary = $salary;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getSalary() {
        return $this->salary;
    }

    public function setSalary($salary) {
        $this->salary = $salary;
    }

}
