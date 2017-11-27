<?php

class SectionController {

    private $request;
    private $permissions = Array(
        'search' => ['admin', 'normal'],
        'register' => ['admin'],
        'update' => ['admin'],
        'delete' => ['admin'],
    );

    public function __construct($request) {
        $this->request = $request;
    }

    public function routeOperation() {
        //Pegar da request qual operação deve ser feita
        $operation = $this->request->getOperation();
        if (!$this->verifyPermission($operation))
            return json_encode(Array('code' => '401', 'message' => 'Unauthorized'));
        else
        //Chamar a operação
        return $this->$operation();
    }

    private function register() {
        $body = $this->request->getBody();
        $collection = $this->request->getResource();
        try {
            new Section($body['name'], $body['description']);
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
            new Section($body['name'], $body['description']);
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
    
    private function verifyPermission($operation) {
        session_start();
        if (isset($_SESSION['user'])) {
            if (in_array($_SESSION['user']->usertype, $this->permissions[$operation]))
                return true;
        }
        return false;
    }

}
