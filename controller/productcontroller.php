<?php

class ProductController {

    private $request;

    public function __construct($request) {
        $this->request = $request;
    }

    public function routeOperation() {
        //Pegar da request qual operação deve ser feita
        $operation = $this->request->getOperation();

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
        $body = $this->request->getBody();
        $collection = $this->request->getResource();
        $id = new MongoDB\BSON\ObjectId($body['_id']);

        (new DBHandler())->delete($collection, $id);

        return json_encode(Array('code' => '200', 'message' => 'Ok'));

        //return "função de desativar";
    }

}
