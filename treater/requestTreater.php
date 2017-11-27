<?php

class RequestTreater {

    private $controllers = Array(
        "users" => "UserController",
        'products' => 'ProductController',
        'providers' => 'ProviderController',
        'employees' => 'EmployeeController',
        'roles' => 'RoleController',
        'sections' => 'SectionController',
        'sales' => 'SaleController',
        'purchases' => 'PurchaseController',
        'login' => 'LoginController'
    );

    public function start(){
        session_start();
        try {
            //Tenta criar uma nova request
            $request = new Request($_SERVER['REQUEST_METHOD'],
                $_SERVER['SERVER_PROTOCOL'],
                $_SERVER['HTTP_HOST'],
                $_SERVER['REQUEST_URI'],
                $_SERVER['QUERY_STRING'],
                file_get_contents('php://input'));
            
            if(!isset($_SESSION['user']) && $request->getResource() != 'login')
                return json_encode(Array('code' => '401', 'message' => 'Unauthorized'));

            //Caso a request seja criada com sucesso, é criado um controller de acordo com o resource(entidade) que veio na request
            $controller = new $this->controllers[$request->getResource()]($request);

            //Por fim, é chamada a função routeOperation do controller que foi criado
            return $controller->routeOperation();

        } catch (RequestException $re) {
            //Caso ocorra um erro na criação da request, é lançada uma excessão
            return $re->toJson();
        }

    }
}










