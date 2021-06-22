<?php

namespace App\Core;

class Router{

    private $controller;

    private $method;

    private $controllerMethod;

    private $params = [];

    function __construct(){
        
        //pegar a url que está sendo acessada
        $url = $this->parseURL();

        header("content-type: aplication/json");

        //existe um controller com este nome
        if(file_exists("../App/Controllers/" . $url[1] . ".php")){

            $this->controller = $url[1];
            unset($url[1]);

        }elseif(empty($url[1])){

            $this->controller = "produtos";

        }else{
            $this->controller = "erro404";
        }

        require_once "../App/Controllers/" . $this->controller . ".php";

        $this->controller = new $this->controller;

        $this->method = $_SERVER["REQUEST_METHOD"];

        switch($this->method){
            case "GET":
                if(isset($url[2])){
                    $this->controllerMethod = "find";
                    $this->params = [$url[2]];
                }else{
                    $this->controllerMethod = "index";
                }
                
                break;

            case "POST":
                $this->controllerMethod = "store";
                break;

            case "PUT":
                $this->controllerMethod = "update";
                break;

            case "DELETE":
                $this->controllerMethod = "delete";
                break;

            default:
                echo "Método não suportado";
                exit;
                break;
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
        
    }

    //retorna o controller, o método e os params da url em um vetor
    private function parseURL(){
        return explode("/", $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
    }

}