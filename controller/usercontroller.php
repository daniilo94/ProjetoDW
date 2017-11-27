<?php

class UserController {

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

    private function register() {
        $body = $this->request->getBody();
        $collection = $this->request->getResource();
        try {
            $body['password'] = md5($body['password']);
            new User($body['employee'], $body['usertype'], $body['password']);
            var_dump($body);
            (new DBHandler())->insert($body, $collection);

            return json_encode(Array('code' => '200', 'message' => 'Ok'));
        } catch (RequestException $ue) {
            return $ue->toJson();
        }
    }

    private function search() {
        $queryString = $this->request->getQueryString();
        $collection = $this->request->getResource();
        return (new DBHandler())->search($queryString, $collection);
    }

    private function update() {
        $body = $this->request->getBody();
        $collection = $this->request->getResource();
        $id = $body['_id'];
        unset($body['_id']);
        try {
            new User($body['employee'], $body['usertype'], $body['password']);
            $result = (new DBHandler())->update($collection, ['_id' => $id, 'enabled' => true], ['$set' => $body]);
            if ($result->getMatchedCount() == 0)
                throw new RequestException('404', 'Object not found');
            return json_encode(Array('code' => '200', 'message' => 'Ok'));
        } catch (RequestException $ue) {
            return $ue->toJson();
        }
    }

    private function delete() {
        $body = $this->request->getBody();
        $collection = $this->request->getResource();
        $id = $body['_id'];
        $result = (new DBHandler())->delete($collection, $id);
        if ($result->getModifiedCount() == 0)
            throw new RequestException('404', 'Object not found');
        return json_encode(Array('code' => '200', 'message' => 'Ok'));
    }

}
