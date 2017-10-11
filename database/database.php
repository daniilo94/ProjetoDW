<?php

class DBHandler {

    const DB_NAME = "test";

    public function getConnection() {
        try {

            $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

            return $mng;
        } catch (MongoDB\Driver\Exception\Exception $e) {

            return json_encode(
                    Array(
                        "msg" => $e->getMessage(),
                        "file" => $e->getFile(),
                        "line" => $e->getLine()
            ));
        }
    }

    public function insert($document, $collection) {
        $conn = $this->getConnection();
        $document["_id"] = new MongoDB\BSON\ObjectId();
        $document["enabled"] = true;
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert($document);
        $result = $conn->executeBulkWrite(
                "test." . $collection, $bulk);
        return $result;
    }

    public function search($parameters, $collection, $options = []) {
        $conn = $this->getConnection();
        $parameters["enabled"] = true;
        $options['projection'] = ['enabled' => 0, 'password'=> 0];
        $query = new MongoDB\Driver\Query($parameters, $options);
        $rows = $conn->executeQuery("test." . $collection, $query);
        $result = Array();
        foreach ($rows as $row) {

            array_push($result, $row);
        }
        return json_encode($result);
    }

    public function update($collection, $filter, $doc){
        $conn = $this->getConnection();
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update($filter, $doc);
        $result = $conn->executeBulkWrite('test.'.$collection, $bulk);
        return $result;
    }

    public function delete($collection, $id){
        return $this->update($collection, ['_id' => $id], ['$set'=>['enabled' => false]]);
    }

}
