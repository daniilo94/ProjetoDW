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

    //Lista de atributos que devem vir no body. Por exemplo, se o resource que veio foi posts, no body devem ter title, username e text.
    // A validação do body só será feita se o método que veio na request exigir informações do body (POST e PUT)
    private $requiredBodys =
        Array(
            'products' => Array('name', 'description', 'purchasePrice', 'salePrice', 'sectionId', 'providerId', 'stock'),
            'providers' => Array('name', 'cnpj', 'fone', 'email', 'description'),
            'employees' => Array('name', 'cpf', 'rg', 'fone', 'email', 'birthdate', 'roleId'),
            'users' => Array('employeeId', 'userType', 'password'),
            'roles' => Array('name', 'description', 'salary'),
            'sections' => Array('name', 'description'),
            'sales' => Array('timestamp', 'totalPrice', 'formOfPayment'),
            'purchases' => Array('timestamp', 'totalPrice', 'providerId', 'finished'),
            'lostproducts' => Array('productId', 'timestamp', 'reason', 'quantity', 'totalPrice'),
            'bonus' => Array('productId', 'timestamp', 'reason', 'quantity'),
            'saleitems' => Array('saleId', 'productId', 'quantity', 'totalValue'),
            'purchaseitems' => Array('purchaseId', 'productId', 'quantity', 'totalValue')
        );

    public function isUriValid($arrayUri, $method)
    {
        //verifica se o resource recebido está na lista de resources aceitos
        if (!in_array($arrayUri[1], $this->allowedUris))
            return false;

        //verifica se a operação recebida está de acordo com o método. Por exemplo, a operação delete só é aceita se vier com o metódo PUT.
        //Para fazer esta validação, verifica o que está na posição 2 do arrayAuri, que é onde deve vir a operação
        if (isset($arrayUri[2])) {
            if ($method == "PUT") {
                if ($arrayUri[2] != "" && $arrayUri[2] != "delete")
                    return false;
            } else {
                if ($arrayUri[2] != "")
                    return false;
            }
        }
        //verifica se a quantidade de informações passadas na uri é válida. 
        //A posição 3 do array de uri (se estiver setada) só pode estar vazia, e não podem ter mais informações na uri
        if (isset($arrayUri[3])) {
            if ($arrayUri[3] != "" || count($arrayUri) > 4)
                return false;
        }
        //Se passar por todas as validações, retorna true
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

        if (isset($qs[0]) && $qs[0] != "") {    //no primeiro if verifica se a posição 0 está preenchida e se o valor é diferente de  vazio.
            if (isset($qs[1]) && $qs[1] != "")   //Se sim, faz a mesma verificação na posição 1. Caso os dois sejam válidos, a função retorna true.
                return true;
        }
        return false;
    }

    public function isBodyValid($body, $operation, $resource)
    {
        //Se a operação for register ou update, é feita a validação dos atributos no body.
        if ($operation == "register" || $operation == "update") {
            //Pega cada item do array de atributos requeridos no body ($this->requiredBodys) de acordo com o resource que foi passado e faz um for com eles, jogando na variável $value
            foreach ($this->requiredBodys[$resource] as $value) {
                if (!isset($body[$value]))  //Por meio do foreach, vai verificando se cada item na lista de atributos exigidos esta setado no corpo da requisição recebida
                    return false;           //Se algum não estiver setado, retorna false
            }
        }
        //Se a operação for update ou delete, também é verificado se foi enviado o id do objeto a ser manipulado
        if (($operation == "update" || $operation == "delete") && !isset($body["_id"]))
            return false;           //Se não for recebido, retorna false

        // Se passar pelas validações, retorna true
        return true;
    }
}