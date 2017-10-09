<?php

//include_once "IrequestValidator.php";

class RequestValidator implements IRequestValidator
{

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
        'products' => Array('name', 'description', 'purchaseprice', 'saleprice', 'section', 'provider', 'currentstock'),
        'providers' => Array('name', 'cnpj', 'phones', 'email', 'description'),
        'employees' => Array('name', 'cpf', 'phones', 'email', 'birthdate', 'role'),
        'users' => Array('employee', 'usertype', 'password'),
        'roles' => Array('name', 'description', 'salary'),
        'sections' => Array('name', 'description'),
        'sales' => Array('saleitems', 'totalprice', 'formofpayment', 'cashier'),
        'purchases' => Array('totalprice', 'provider', 'purchaseitems'),
        'items' => Array('product', 'quantity', 'totalvalue')
    );

    public function isUriValid($arrayUri, $method)
    {
        //verifica se o resource recebido está na lista de resources aceitos        
        if ((!in_array($arrayUri[1], $this->allowedUris)) || !$this->isUriOperationValid($arrayUri, $method) || !$this->isUriSizeValid($arrayUri))
            return false;

        //Se passar por todas as validações, retorna true
        return true;
    }

    private function isUriOperationValid($arrayUri, $method)
    {
        if (isset($arrayUri[2])) {
            if (!in_array($arrayUri[2], $this->allowedOperations[$method]))
                return false;
        }

        return true;
    }

    private function isUriSizeValid($arrayUri)
    {
        //verifica se a quantidade de informações passadas na uri é válida. 
        //A posição 3 do array de uri (se estiver setada) só pode estar vazia, e não podem ter mais informações na uri
        if (isset($arrayUri[3])) {
            if ($arrayUri[3] != "" || count($arrayUri) > 4)
                return false;
        }

        return true;
    }

    public function isMethodValid($method)
    {

        //Verifica se o método recebido está na lista de métodos aceitos. Se não estiver, retorna false.
        if (!in_array($method, $this->allowedMethods))
            return false;

        return true;
    }

    public function isProtocolValid($protocol)
    {
        //Verifica se o protocolo recebido está na lista de protocolos aceitos.
        if (!in_array($protocol, $this->allowedProtocols))
            return false;

        return true;
    }

    public function isQueryStringValid($qs)
    {
        //A variável $qs deve ser uma array com duas posições, na posição 0 deve estar a chave e na posição 1 deve estar o valor, por exemplo, $qs[0] = "name" e $qs[1] = "cebola".
        if (isset($qs[0], $qs[1])) {    //no primeiro if verifica se a posição 0 está preenchida e se o valor é diferente de  vazio.
            if ($qs[0] != "" && $qs[1] != "")   //Se sim, faz a mesma verificação na posição 1. Caso os dois sejam válidos, a função retorna true.
                return true;
        }

        return false;
    }

/////////////////////////////////Validação do Body///////////////////////////////////
// Esta função direciona a validação do body de acordo com o recurso


    public function isBodyValid($body, $operation, $resource)
    {
        if ($operation != "search") {
            $functionName = "is" . $resource . "BodyValid";
            return ($this->$functionName($body) && $this->isSetId($body, $operation));
        }

        return true;
    }

    private function validBodyAttributes($validations)
    {
        foreach ($validations as $v) {
            $resource = $v[0];
            $array = $v[1];

            foreach ($this->bodyAttributes[$resource] as $value) {
                if (!isset($array[$value]))
                    return false;
            }
        }
        return true;
    }

    private function isSetId($body, $operation)
    {
        //Se a operação for update ou delete, também é verificado se foi enviado o id do objeto a ser manipulado
        if (($operation == "update" || $operation == "delete") && !isset($body["id"]))
            return false;           //Se não for recebido, retorna false

        return true;
    }

//********************Validações para cada recurso*************************
//Products
    private function isProductsBodyValid($body)
    {
        $validations = Array();
        $validations[] = ["products", $body];
        $validations[] = ["sections", $body['section']];
        $validations[] = ["providers", $body['provider']];

        return $this->validBodyAttributes($validations);
    }

    //Employees
    private function isEmployeesBodyValid($body)
    {
        $validations = Array();
        $validations[] = ["employees", $body];
        $validations[] = ["roles", $body['role']];

        return $this->validBodyAttributes($validations);
    }

    //Providers
    private function isProvidersBodyValid($body)
    {
        return $this->validBodyAttributes(['providers', $body]);
    }

    //Items
    private function isItemsBodyValid($body)
    {
        $validations = Array();
        $validations[] = ['items', $body];
        $validations[] = ["products", $body['product']];
        $validations[] = ["sections", $body['product']['section']];
        $validations[] = ["providers", $body['product']['provider']];

        return $this->validBodyAttributes($validations);
    }

    //Roles
    private function isRolesBodyValid($body)
    {
        return $this->validBodyAttributes(['roles', $body]);

    }

    //Sections
    private function isSectionsBodyValid($body)
    {
        return $this->validBodyAttributes(['sections', $body]);

    }

    //Users
    private function isUsersBodyValid($body)
    {
        $validations = Array();
        $validations[] = ['users', $body];
        $validations[] = ['employees', $body['employee']];

        return $this->validBodyAttributes($validations);
    }

    //Purchases
    private function isPurchasesBodyValid($body)
    {
        $validations = Array();
        $validations[] = ['purchases', $body];
        $validations[] = ['providers', $body['provider']];
        if (!$this->validBodyAttributes($validations))
            return false;

        foreach ($body['purchaseitems'] as $item) {
            if (!$this->isItemsBodyValid($item))
                return false;
        }

        return true;
    }

    private function isSalesBodyValid($body)
    {
        $validations = Array();
        $validations[] = ['sales', $body];
        $validations[] = ['employees', $body['cashier']];
        if (!$this->validBodyAttributes($validations))
            return false;

        foreach ($body['saleitems'] as $item) {
            if (!$this->isItemsBodyValid($item))
                return false;
        }

        return true;
    }

//***********************************************************************
//////////////////////////////////////////////////////////////////////////
}
