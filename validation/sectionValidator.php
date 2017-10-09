<?php

class SectionValidator implements ISectionValidator {

    public function isNameValid($name) {
        if (empty($name) || strlen($name) < 3) {
            return false;
        }

        return true;
    }

    public function isDescriptionValid($description) {
        if (empty($description)) {
            return false;
        }

        return true;
    }

}
