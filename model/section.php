<?php

class Section {

    private $name;
    private $description;
    private $sv;

    public function __construct($name, $description) {
        $this->sv = new SectionValidator();

        $this->setName($name);
        $this->setDescription($description);
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        if (!$this->sv->isNameValid($name))
            throw new RequestException("400", "Invalid name");

        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        if (!$this->sv->isDescriptionValid($description))
            throw new RequestException("400", "Invalid description");

        $this->description = $description;
    }

}
