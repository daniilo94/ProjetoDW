<?php

class LoginController {

    private $request;

    public function __construct($request) {
        $this->request = $request;
    }

    public function routeOperation() {
        //Pegar da request qual operação deve ser feita
        $operation = $this->request->getOperation();
        //Chamar a operação
        return $this->$operation();
    }

    private function login() {
        $email = $this->request->getBody()['email'];
        $password = md5($this->request->getBody()['password']);
        $result = (new DBHandler())->search(Array('employee.email' => $email, 'password' => $password), 'users');
        if ($result != '[]') {
            $this->initLogin($result);
            return $result;
        } else {
            return json_encode(Array('code' => '401', 'message' => 'Unauthorized'));
        }
    }

    private function initLogin($result) {
        $user = json_decode($result);
        $_SESSION['user'] = $user;
//        var_dump($_SESSION);
    }

}
