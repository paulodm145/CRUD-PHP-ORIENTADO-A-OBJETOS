<?php
require('../vendor/autoload.php');

use \ClassesSistema\Url;
use \ClassesSistema\Divida;
use \Helpers\Common;
use \Helpers\Data;

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

header('Content-Type: application/json');

$opcao = $_POST['opcao'] + 0;

switch($opcao){

    case 1:
            $divida = new divida();
            $divida->descricao = $_POST["descricao"];
            $divida->id_cliente = $_POST["id_cliente"];
            $divida->valor = Common::toFloat($_POST["valor"]);
            $divida->vencimento = Data::getFormat($_POST["vencimento"], 'Y-m-d');
            if($divida->save()){
                echo json_encode(["data"=>1, "msg"=>"Salvo com sucesso !!"]);
            }else{
                echo json_encode(["data"=>0, "msg"=>"Erro ao Salvar"]);
            }
    break;

    case 2: 
        $divida = new divida();
        $divida->id = $_POST['id'];
        $divida->id_cliente = $_POST['id_cliente'];
        $divida->descricao = $_POST["descricao"];
        $divida->valor = Common::toFloat($_POST["valor"]);
        $divida->vencimento = Data::getFormat($_POST["vencimento"], 'Y-m-d');

        if($divida->update()){
            echo json_encode(["data"=>1, "msg"=>"Atualizado com sucesso !!"]);
        }else{
            echo json_encode(["data"=>0, "msg"=>"Erro ao Atualizar"]);
        }
    break;

    case 3:
        $id = $_POST['id'];
        $dados = divida::loadObject($id);
        $informacoesDivida = ["data"=>1, 
                                    "info"=>[
                                                "id" => $dados->id,
                                                "id_cliente" => $dados->id_cliente,
                                                "descricao" => $dados->descricao,
                                                "valor" => Common::parseMoney($dados->valor),
                                                "vencimento" => Data::getFormat($dados->vencimento, 'd/m/Y')
                                            ]
                                ];
        echo json_encode($informacoesDivida);
    break;

    case 4:
        $id = $_POST['id'];
        $divida = new Divida();
        if($divida->delete($id)){
            echo json_encode(["data"=>1, "msg"=>"excluído com sucesso!!"]);
        }else{
            echo json_encode(["data"=>0, "msg"=>"Erro ao excluir"]);
        }

    break;



}

