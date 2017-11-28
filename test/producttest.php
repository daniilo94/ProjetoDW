<?php

include_once ("httpful.phar");

class ProductTest {

    public function __construct() {
        
        
    }
    
    public function testAll() {
        return '<p><b>Testes Product</b> <br>Inserir com nome inválido: ' . $this->testRegisterWithInvalidName() . '<br>' .
                'Inserir com preço inválido: ' . $this->testRegisterWithInvalidPrice() . '<br>' .
                'Inserir Product válido: ' . $this->testRegisterValidProduct() . '<br>' .
                'Pesquisar: ' . $this->testSearch() . '</p>';
    }

    public function testSearch() {
        $response = \Httpful\Request::get('http://localhost/ProjetoDW/products')->send();
        try {
            $body = json_decode($response, true)[0];
            new Product($body['name'], $body['description'], $body['purchaseprice'], $body['saleprice'], $body['measure'], $body['section'], $body['provider'], $body['currentstock']);
            return 'Passou';
        } catch (Exception $e) {
//            var_dump($e);
            return 'Não passou';
        }
    }

    public function testRegisterValidProduct() {
        $response = \Httpful\Request::post('http://localhost/ProjetoDW/products')
                        ->sendsJson()
                        ->body('{
	"name" : "Cebola roxa",
	"description" : "Cebola roxa do Himalaia",
	"purchaseprice" : "2.0",
	"saleprice" : "3.0",
	"measure" : "quilograma",
	"section" : {
		"name" : "Hortifruti",
		"description" : "Seção de frutas, verduras e legumes"
	},
	"provider" : {
		"name": "Cebolas Inc", 
		"cnpj" : "28.338.875/0001-17", 
		"phones" : ["(61)99876-3272"], 
		"email" : "cebolas@mail.com", 
		"description" : "Fornecedor de cebolas"
	},
	"currentstock" : 10
}')->send();
        $result = strcmp($response->body, '{"code":"200","message":"Ok"}') == 0;
        if ($result)
            return 'Passou';
        else
            return 'Não passou';
    }
    
    public function testRegisterWithInvalidName() {
        $response = \Httpful\Request::post('http://localhost/ProjetoDW/products')
                        ->sendsJson()
                        ->body('{
	"name" : "",
	"description" : "Cebola roxa do Himalaia",
	"purchaseprice" : "2.0",
	"saleprice" : "3.0",
	"measure" : "quilograma",
	"section" : {
		"name" : "Hortifruti",
		"description" : "Seção de frutas, verduras e legumes"
	},
	"provider" : {
		"name": "Cebolas Inc", 
		"cnpj" : "28.338.875/0001-17", 
		"phones" : ["(61)99876-3272"], 
		"email" : "cebolas@mail.com", 
		"description" : "Fornecedor de cebolas"
	},
	"currentstock" : 10
}')->send();
        $result = strcmp($response->body, '{"code":"400","message":"Invalid name"}') == 0;
        if ($result)
            return 'Passou';
        else
            return 'Não passou';
    }
    
    public function testRegisterWithInvalidPrice() {
        $response = \Httpful\Request::post('http://localhost/ProjetoDW/products')
                        ->sendsJson()
                        ->body('{
	"name" : "Cebola",
	"description" : "Cebola roxa do Himalaia",
	"purchaseprice" : "2.0",
	"saleprice" : "0",
	"measure" : "quilograma",
	"section" : {
		"name" : "Hortifruti",
		"description" : "Seção de frutas, verduras e legumes"
	},
	"provider" : {
		"name": "Cebolas Inc", 
		"cnpj" : "28.338.875/0001-17", 
		"phones" : ["(61)99876-3272"], 
		"email" : "cebolas@mail.com", 
		"description" : "Fornecedor de cebolas"
	},
	"currentstock" : 10
}')->send();
        $result = strcmp($response->body, '{"code":"400","message":"Invalid price"}') == 0;
        if ($result)
            return 'Passou';
        else
            return 'Não passou';
    }

}
