<?php

class Request {

    private $method;
    private $protocol;
    private $host;
    private $uri;
    private $queryString;
    private $body;
    private $resource;
    private $operation;
    private $rv;
    private $arrayOperations = Array('POST/' => 'register', 'PUT/' => 'update', 'PUT/delete' => 'delete', 'GET/' => 'search');

    public function __construct($method, $protocol, $host, $uri = null, $queryString = null, $body = null) {
        //Cria uma instância da classe requestValidador e joga na variável $rv
        $this->rv = new RequestValidator();

        //Tenta setar os atributos da request, por meio dos métodos 'set', que fazem as validações de cada atributo. Caso encontre algum erro, lança uma excessão e encerra o programa
        $this->setMethod($method);
        $this->setProtocol($protocol);
        $this->setHost($host);
        $this->setUri($uri);
        $this->setResource();
        $this->setOperation();
        $this->setQueryString($queryString);
        $this->setBody($body);
    }

    public function getMethod() {
        return $this->method;
    }

    public function getPath() {
        return $this->path;
    }

    public function getBody() {
        return $this->body;
    }

    public function getResource() {
        return $this->resource;
    }

    public function getOperation() {
        return $this->operation;
    }

    public function getQueryString() {
        return $this->queryString;
    }

    private function setMethod($method) {
        //Se o método não for válido, lança uma excessão. Se for válido, é atribuído à classe.
        if (!$this->rv->isMethodValid($method))
            throw new RequestException("405", "Method not allowed");
        $this->method = $method;
    }

    private function setProtocol($protocol) {
        //Se o protocolo não for válido, lança uma excessão. Se for válido, é atribuído à classe.
        if (!$this->rv->isProtocolValid($protocol))
            throw new RequestException("505", "HTTP Version Not Supported");
        $this->protocol = $protocol;
    }

    private function setHost($host) {
        //O host não precisa de validação. Se chegou ao servidor, é porque está certo.
        $this->host = $host;
    }

    private function setUri($uri) {
        $cleanUri = explode('?', $uri); //Quebra a uri na '?' para separar da query string
        $arrayUri = explode('/', $cleanUri[0]); //Depois, quebra a uri na '/' para separar cada parte e joga na variável $arrayUri
        //Apenas para ajustar as posições do array caso os arquivos não estejam na raiz da pasta html ou htdocs. 
        //Essa parte não é necessária para o projeto
        if ($arrayUri[1] == "danilo-silva") {
            unset($arrayUri[1]);
            $arrayUri = array_values($arrayUri);
        }

        if (!$this->rv->isUriValid($arrayUri, $this->method))
            throw new RequestException("400", "Bad request");

        $this->uri = $arrayUri;
    }

    private function setQueryString($queryString) {
        $finalQueryString = Array();
        if (strlen($queryString) > 0) {
            $queryArray = explode('&', $queryString);

            foreach ($queryArray as $value) {
                $a = explode('=', $value);
                if (!$this->rv->isQueryStringValid($a))
                    throw new RequestException("400", "Bad request");
            }
        }
        $this->queryString = $finalQueryString;
    }

    private function setBody($body) {
        $bodyArray = json_decode($body, true);
        if (!$this->rv->isBodyValid($bodyArray, $this->operation, $this->resource))
            throw new RequestException("400", "Bad request");


        $this->body = $bodyArray;
    }

    private function setResource() {
        $uri = $this->uri;
        $this->resource = $uri[1];
    }

    private function setOperation() {
        $uriOperation = (!isset($this->uri[2])) ? "" : $this->uri[2];

        $this->operation = $this->arrayOperations[$this->method . '/' . $uriOperation];
    }

}
