<?php

//include_once "IrequestValidator.php";

class RequestValidator implements IRequestValidator {

    //lista de métodos aceitos
    private $allowedMethods = Array('GET', 'PUT', 'POST');
    //Lista de protocolos aceitos
    private $allowedProtocols = Array('HTTP/1.1');
    //lista de resources aceitos
    private $allowedUris = Array('products', 'providers', 'employees', 'users', 'roles', 'sections', 'sales',
        'purchases', 'bonus', 'lostproducts', 'saleitems', 'purchaseitems');
    private $allowedOperations = Array("PUT" => Array("", "delete"), "GET" => Array(""), "POST" => Array(""));
    //Lista de atributos que devem vir no body. Por exemplo, se o resource que veio foi posts, no body devem ter title, username e text.
    // A validação do body só será feita se o método que veio na request exigir informações do body (POST e PUT)
    private $bodyAttributes = Array(
        'products' => Array('name', 'description', 'purchaseprice', 'saleprice', 'sections' => 'section', 'providers' => 'provider', 'currentstock'),
        'providers' => Array('name', 'cnpj', 'phones', 'email', 'description'),
        'employees' => Array('name', 'cpf', 'phones', 'email', 'birthdate', 'roles' => 'role'),
        'users' => Array('employees' => 'employee', 'usertype', 'password'),
        'roles' => Array('name', 'description', 'salary'),
        'sections' => Array('name', 'description'),
        'sales' => Array('items' => 'saleitems', 'totalprice', 'formofpayment', 'employees' => 'cashier'),
        'purchases' => Array('totalprice', 'providers' => 'provider', 'items' => 'purchaseitems'),
        'items' => Array('products' => 'product', 'quantity', 'totalvalue')
    );

    public function isUriValid($arrayUri, $method) {
        //verifica se o resource recebido está na lista de resources aceitos        
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
        if (isset($qs[0], $qs[1])) {    //no primeiro if verifica se a posição 0 está preenchida e se o valor é diferente de  vazio.
            if ($qs[0] != "" && $qs[1] != "")   //Se sim, faz a mesma verificação na posição 1. Caso os dois sejam válidos, a função retorna true.
                return true;
        }

        return false;
    }

//*********************** Validação do Body *******************************************

    public function isBodyValid($resource, $operation, $body) {
        switch ($operation){
            case "register":
                return $this->validateBodyAttributes($resource, $body);
            case "update":
                return ($this->validateBodyAttributes($resource, $body) && $this->isSetId($body, $operation));
            case "delete":
                return $this->isSetId($body);
            default:
                return true;
        }
    }

    private function validateBodyAttributes($resource, $body) {
        if (isset($body[0]))
            return $this->validateBodyArrays($resource, $body);

        foreach ($this->bodyAttributes[$resource] as $key => $value) {
            if (!isset($body[$value]))
                return false;

            if (!is_int($key)) {
                if (!$this->validateBodyAttributes($key, $body[$value]))
                    return false;
            }
        }
        return true;
    }

    private function validateBodyArrays($resource, $array) {
        foreach ($array as $value) {
            if (!$this->validateBodyAttributes($resource, $value))
                return false;
        }
        return true;
    }

    private function isSetId($body) {
        if (!isset($body["_id"]))
            return false;

        return true;
    }

//************************************************************************************
}
