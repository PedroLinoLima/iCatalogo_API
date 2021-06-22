<?php
session_start();

use App\Core\Controller;

class Categorias extends Controller
{

    public function index()
    {

        $categoriaModel = $this->model("Categoria");

        $dados = $categoriaModel->listarTodas();

        //colocar os dados no corpo da requisição
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }

    public function find($id){

        $categoriaModel = $this->model("Categoria");

        $categoriaModel = $categoriaModel->buscarPorId($id);

        if($categoriaModel){

            echo json_encode($categoriaModel, JSON_UNESCAPED_UNICODE);

        }else{

            http_response_code(404);

            $erro = ["erro" => "Categoria não encontrada"];

            echo json_encode($erro, JSON_UNESCAPED_UNICODE);

        }

    }

    public function store(){



    }

}
