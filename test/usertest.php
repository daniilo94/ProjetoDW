<?php

include_once ("httpful.phar");

class UserTest {

    public function testAll() {
        return '<p><b>Testes User</b> <br>Inserir com email inválido: ' . $this->testRegisterWithInvalidEmail() . '<br>' .
                'Inserir com CPF inválido: ' . $this->testRegisterWithInvalidCpf() . '<br>' .
                'Inserir User válido: ' . $this->testRegisterValidUser() . '<br>' .
                'Pesquisar: ' . $this->testSearch() . '</p>';
    }

    public function testSearch() {
        $response = \Httpful\Request::get('http://localhost/ProjetoDW/users')->send();
        try {
            $body = json_decode($response, true)[0];
            new User($body['employee'], $body['usertype'], '12345678');
            return 'Passou';
        } catch (Exception $e) {
//            var_dump($e);
            return 'Não passou';
        }
    }

    public function testRegisterValidUser() {
        $response = \Httpful\Request::post('http://localhost/ProjetoDW/users')
                        ->sendsJson()
                        ->body('{
	"employee" : {
		"name" : "João da Silva",
		"cpf" : "941.277.330-71",
		"phones" : ["(61)99645-8282"],
		"email" : "joao@mlkdoido.com",
		"birthdate" : "1990-01-01",
		"role" : {
			"name" : "Caixa",
			"description" : "Funcionário que opera o caixa",
			"salary" : 1200
		}
	},
	"usertype" : "admin",
	"password" : "1234"
}')->send();
        $result = strcmp($response->body, '{"code":"200","message":"Ok"}') == 0;
        if ($result)
            return 'Passou';
        else
            return 'Não passou';
    }

    public function testRegisterWithInvalidEmail() {
        $response = \Httpful\Request::post('http://localhost/ProjetoDW/users')
                        ->sendsJson()
                        ->body('{
	"employee" : {
		"name" : "João da Silva",
		"cpf" : "941.277.330-71",
		"phones" : ["(61)99645-8282"],
		"email" : "joaomlkdoido.com",
		"birthdate" : "1990-01-01",
		"role" : {
			"name" : "Caixa",
			"description" : "Funcionário que opera o caixa",
			"salary" : 1200
		}
	},
	"usertype" : "admin",
	"password" : "1234"
}')->send();
        $result = strcmp($response->body, '{"code":"400","message":"Invalid email"}') == 0;
        if ($result)
            return 'Passou';
        else
            return 'Não passou';
    }
    
    public function testRegisterWithInvalidCpf() {
        $response = \Httpful\Request::post('http://localhost/ProjetoDW/users')
                        ->sendsJson()
                        ->body('{
	"employee" : {
		"name" : "João da Silva",
		"cpf" : "941.277.330-7",
		"phones" : ["(61)99645-8282"],
		"email" : "joao@mlkdoido.com",
		"birthdate" : "1990-01-01",
		"role" : {
			"name" : "Caixa",
			"description" : "Funcionário que opera o caixa",
			"salary" : 1200
		}
	},
	"usertype" : "admin",
	"password" : "1234"
}')->send();
        $result = strcmp($response->body, '{"code":"400","message":"Invalid CPF"}') == 0;
        if ($result)
            return 'Passou';
        else
            return 'Não passou';
    }

}
