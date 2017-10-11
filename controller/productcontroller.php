<?php

//require_once ("model/user.php");
//require_once ("database/database.php");
//require_once ("exception/requestException.php");

class ProductController {

//    private $allowedOperations = Array('info' => 'search', 'register' => 'create', 'update' => 'update', 'disable' => 'disable');
    private $request;

    public function __construct($request) {
        $this->request = $request;
    }

    public function routeOperation() {
        //Pegar da request qual operação deve ser feita
        $operation = $this->request->getOperation();

        //Sabendo qual operação ser feita, chamar a função correspondente por meio do array de operações
        //$func = $this->allowedOperations[$operation];

        return $this->$operation();
    }

    private function register() {
        $body = $this->request->getBody();
        $collection = $this->request->getResource();
        try {
            new Product($body['name'], $body['description'], $body['purchaseprice'], $body['saleprice'],
                $body['measure'], $body['section'], $body['provider'], $body['currentstock']);
            (new DBHandler())->insert($body, $collection);

            return json_encode(Array('code' => '200', 'message' => 'Ok'));
        } catch (RequestException $ue) {
            return $ue->toJson();
        }
    }

    private function search() {
        $options = Array(
            'sort' => ['bdate' => -1]
        );
        $queryString = $this->request->getQueryString();
        $collection = $this->request->getResource();
        return (new DBHandler())->search($queryString, $collection, $options);
    }

    private function update() {
        return "função de atualizar";
    }

    private function delete() {
        return "função de desativar";
    }

}
