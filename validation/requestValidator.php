<?php

//include_once "IrequestValidator.php";

class RequestValidator implements IRequestValidator {

    //lista de métodos aceitos
    private $allowedMethods = Array('GET', 'PUT', 'POST');
    //Lista de protocolos aceitos
    private $allowedProtocols = Array('HTTP/1.1');
    //lista de resources aceitos
    private $allowedUris = Array('products', 'providers', 'employees', 'users', 'roles', 'sections', 'sales',
        'purchases', 'bonus', 'lostproducts', 'saleitems', 'purchaseitems', 'login', 'logout', 'test');
    private $allowedOperations = Array("PUT" => Array("", "delete"), "GET" => Array(""), "POST" => Array(""));
    //Lista de atributos que devem vir no body. Se um dos atributos for outro objeto, vai estar como 'nome_do_resource' => 'nome_do_atributo_no_corpo', para saber que deve fazer a validaçao tb.
    private $bodyAttributes = Array(
        'products' => Array('name', 'description', 'purchaseprice', 'saleprice', 'sections' => 'section', 'providers' => 'provider', 'currentstock'),
        'providers' => Array('name', 'cnpj', 'phones', 'email', 'description'),
        'employees' => Array('name', 'cpf', 'phones', 'email', 'birthdate', 'roles' => 'role'),
        'users' => Array('employees' => 'employee', 'usertype', 'password'),
        'roles' => Array('name', 'description', 'salary'),
        'sections' => Array('name', 'description'),
        'sales' => Array('items' => 'saleitems', 'totalprice', 'formofpayment', 'employees' => 'cashier'),
        'purchases' => Array('totalprice', 'providers' => 'provider', 'items' => 'purchaseitems'),
        'items' => Array('products' => 'product', 'quantity', 'totalvalue'),
        'login' => Array('email', 'password')
    );

    public function isUriValid($arrayUri, $method) {
        //verifica se o resource recebido está na lista de resources aceitos e se a operação é válida
        if ((!in_array($arrayUri[1], $this->allowedUris)) || !$this->isUriOperationValid($arrayUri, $method))
            return false;

        //Se passar por todas as validações, retorna true
        return true;
    }

    private function isUriOperationValid($arrayUri, $method) {
        if (isset($arrayUri[2])) {
            if (!in_array($arrayUri[2], $this->allowedOperations[$method]))
                return false;
        }

        return true;
    }

    public function isMethodValid($method) {
        //Verifica se o método recebido está na lista de métodos aceitos. Se não estiver, retorna false.
        if (!in_array($method, $this->allowedMethods))
            return false;

        return true;
    }

    public function isProtocolValid($protocol) {
        //Verifica se o protocolo recebido está na lista de protocolos aceitos.
        if (!in_array($protocol, $this->allowedProtocols))
            return false;

        return true;
    }

    public function isQueryStringValid($qs) {
        //A variável $qs deve ser uma array com duas posições, na posição 0 deve estar a chave e na posição 1 deve estar o valor, por exemplo, $qs[0] = "name" e $qs[1] = "cebola".
        if (isset($qs[0], $qs[1])) {    //no primeiro if verifica se as duas posições estão setadas
            if ($qs[0] != "" && $qs[1] != "")   //Se sim, verifica se não estão vazias.
                return true;
        }

        return false;
    }

//*********************** Validação do Body *******************************************
//    public function isBodyValid($resource, $operation, $body) {
//        //Faz a validação de acordo com a operação a ser feita
//        switch ($operation){
//            case "register":
//                return $this->validateBodyAttributes($resource, $body); //valida só os atributos do corpo
//            case "update":
//                return ($this->validateBodyAttributes($resource, $body) && $this->isSetId($body)); // valida os atributos e o _id
//            case "delete":
//                return $this->isSetId($body);   //valida só o _id
//            default:
//                return true;   //Se não veio uma das três operações, retorna true.
//        }
//    }

    public function isBodyValid($resource, $operation, $body) {
        if (!$this->isSetId($body, $operation))
            return false;

        if ($operation == 'register' || $operation == 'update' || $operation == 'login')
            return $this->validateBodyAttributes($resource, $body);

        return true;
    }

    private function validateBodyAttributes($resource, $body) {
        //Se no body veio a posição 0, é pq é um array de objetos dentro de um atributo. É necessario fazer um for nesse array pra validar cada objeto
        if (isset($body[0]))
            return $this->validateBodyArrays($resource, $body);

        //Pega o $bodyAttributes de acordo com o resource, e vai verificando se todos os atributos estão setados no body
        foreach ($this->bodyAttributes[$resource] as $key => $value) {
            if (!isset($body[$value]))
                return false;

            //Se a chave não for numérica, é pq se trata de um outro objeto. É feita a validação desse objeto de acordo com o resource que está indicado na chave
            if (!is_int($key)) {
                if (!$this->validateBodyAttributes($key, $body[$value]))
                    return false;
            }
        }
        return true;
    }

    //valida o body de todos os objetos dentro de array
    private function validateBodyArrays($resource, $array) {
        foreach ($array as $value) {
            if (!$this->validateBodyAttributes($resource, $value))
                return false;
        }
        return true;
    }

    //Verifica se está setado o _id no body. Só é necessário para update e delete
    private function isSetId($body, $operation) {
        if (($operation == 'update' || $operation == 'delete') && !isset($body["_id"]))
            return false;

        return true;
    }

//************************************************************************************
}
