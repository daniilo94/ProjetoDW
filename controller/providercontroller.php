<?php

class ProviderController {

    private $request;

    public function __construct($request) {
        $this->request = $request;
    }

    public function routeOperation() {
        //Pegar da request qual operação deve ser feita
        $operation = $this->request->getOperation();

        //Chamar a fução usando o nome da operação
        return $this->$operation();
    }

    private function register() {
        $body = $this->request->getBody();
        $collection = $this->request->getResource();
        try {
            new Provider($body['name'], $body['cnpj'], $body['phones'], $body['email'], $body['description']);
            (new DBHandler())->insert($body, $collection);

            return json_encode(Array('code' => '200', 'message' => 'Ok'));
        } catch (RequestException $ue) {
            return $ue->toJson();
        }
    }

    private function search() {
        $queryString = $this->treatSearchParameters($this->request->getQueryString());
        $collection = $this->request->getResource();
        return (new DBHandler())->search($queryString, $collection);
    }

    private function update() {
        return "função de atualizar";
    }

    private function disable() {
        return "função de desativar";
    }
    
    private function treatSearchParameters($qs) {
        if (isset($qs['id']) && (preg_match('/^[a-f\d]{24}$/i', $qs['id']))) {
            $qs['_id'] = new MongoDB\BSON\ObjectId($qs['id']);
            unset($qs['id']);
        }
        return $qs;
    }

}
