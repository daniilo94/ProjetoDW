<?php

class Section {

    private $name;
    private $description;

    public function __construct($name, $description) {
        //$this->uv = new UserValidator();
        $this->name = $name;
        $this->description = $description;
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

}
