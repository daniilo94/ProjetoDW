<?php

include_once ("httpful.phar");

class SectionTest {
    
    public function testAll() {
        return '<p><b>Testes Section</b> <br>Inserir com nome inválido: ' . $this->testRegisterWithInvalidName() . '<br>' .
                'Inserir com description inválido: ' . $this->testRegisterWithInvalidDescription() . '<br>' .
                'Inserir Section válido: ' . $this->testRegisterValidSection() . '<br>' .
                'Pesquisar: ' . $this->testSearch() . '</p>';
    }

    public function testSearch() {
        $response = \Httpful\Request::get('http://localhost/ProjetoDW/sections')->send();
        try {
            $body = json_decode($response, true)[0];
            new Section($body['name'], $body['description']);
            return 'Passou';
        } catch (Exception $e) {
//            var_dump($e);
            return 'Não passou';
        }
    }

    public function testRegisterValidSection() {
        $response = \Httpful\Request::post('http://localhost/ProjetoDW/sections')
                        ->sendsJson()
                        ->body('{
	"name" : "Hortifruti",
	"description" : "Seção de frutas, verduras e legumes"
}')->send();
        $result = strcmp($response->body, '{"code":"200","message":"Ok"}') == 0;
        if ($result)
            return 'Passou';
        else
            return 'Não passou';
    }
    
    public function testRegisterWithInvalidName() {
        $response = \Httpful\Request::post('http://localhost/ProjetoDW/sections')
                        ->sendsJson()
                        ->body('{
	"name" : "H",
	"description" : "Seção de frutas, verduras e legumes"
}')->send();
        $result = strcmp($response->body, '{"code":"400","message":"Invalid name"}') == 0;
        if ($result)
            return 'Passou';
        else
            return 'Não passou';
    }
    
    public function testRegisterWithInvalidDescription() {
        $response = \Httpful\Request::post('http://localhost/ProjetoDW/sections')
                        ->sendsJson()
                        ->body('{
	"name" : "Hortifruti",
	"description" : ""
}')->send();
        $result = strcmp($response->body, '{"code":"400","message":"Invalid description"}') == 0;
        if ($result)
            return 'Passou';
        else
            return 'Não passou';
    }

}
