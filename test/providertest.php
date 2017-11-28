<?php

include_once ("httpful.phar");

class ProviderTest {

    public function __construct() {
        
        
    }
    
    public function testAll() {
        return '<p><b>Testes Provider</b> <br>Inserir com email inválido: ' . $this->testRegisterWithInvalidEmail() . '<br>' .
                'Inserir com CNPJ inválido: ' . $this->testRegisterWithInvalidCnpj() . '<br>' .
                'Inserir Provider válido: ' . $this->testRegisterValidProvider() . '<br>' .
                'Pesquisar: ' . $this->testSearch() . '</p>';
    }

    public function testSearch() {
        $response = \Httpful\Request::get('http://localhost/ProjetoDW/providers')->send();
        try {
            $provider = json_decode($response, true)[0];
            new Provider($provider['name'], $provider['cnpj'], $provider['phones'], $provider['email'], $provider['description']);
            return 'Passou';
        } catch (Exception $e) {
            return 'Não passou';
        }
    }

    public function testRegisterValidProvider() {
        $response = \Httpful\Request::post('http://localhost/ProjetoDW/providers')
                        ->sendsJson()
                        ->body('{
	"name": "Cebolas Inc", 
	"cnpj" : "28.338.875/0001-17", 
	"phones" : ["(61)99876-3272"], 
	"email" : "cebolas@mail.com", 
	"description" : "Fornecedor de cebolas"
}')->send();
        $result = strcmp($response->body, '{"code":"200","message":"Ok"}') == 0;
        if ($result)
            return 'Passou';
        else
            return 'Não passou';
    }
    
    public function testRegisterWithInvalidEmail() {
        $response = \Httpful\Request::post('http://localhost/ProjetoDW/providers')
                        ->sendsJson()
                        ->body('{
	"name": "Cebolas Inc", 
	"cnpj" : "28.338.875/0001-17", 
	"phones" : ["(61)99876-3272"], 
	"email" : "cebolas@mail", 
	"description" : "Fornecedor de cebolas"
}')->send();
        $result = strcmp($response->body, '{"code":"400","message":"Invalid email"}') == 0;
        if ($result)
            return 'Passou';
        else
            return 'Não passou';
    }
    
    public function testRegisterWithInvalidCnpj() {
        $response = \Httpful\Request::post('http://localhost/ProjetoDW/providers')
                        ->sendsJson()
                        ->body('{
	"name": "Cebolas Inc", 
	"cnpj" : "28.338.875/0001-173", 
	"phones" : ["(61)99876-3272"], 
	"email" : "cebolas@mail.com", 
	"description" : "Fornecedor de cebolas"
}')->send();
        $result = strcmp($response->body, '{"code":"400","message":"Invalid cnpj"}') == 0;
        if ($result)
            return 'Passou';
        else
            return 'Não passou';
    }

}
