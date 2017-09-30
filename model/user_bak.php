<?php
/*

class User {

    private $name;
    private $email;
    private $password;
    private $birthdate;
    private $uv;

    public function __construct($name, $email, $pass, $bd) {
        $this->uv = new UserValidator();
        $this->name = $name;
        $this->setEmail($email);
        $this->password = $pass;
        $this->birthdate = $bd;
    }

    public function setEmail($email) {
        if (!$this->uv->isValidEmail($email)) {
            throw new RequestException(400, "Invalid email format");
        }
        $this->email = $email;
    }

}
*/