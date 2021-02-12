<?php
require('../vendor/autoload.php');

use \ClassesSistema\Url;
use \ClassesSistema\Cliente;
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
            $cliente = new Cliente();
            $cliente->nome = $_POST["nome"];
            $cliente->cpfcnpj =  Common::Replace('/[^0-9]/i','',$_POST["cpfcnpj"]);
            $cliente->data_nascimento = Data::getFormat($_POST["data_nascimento"], 'Y-m-d');
            $cliente->endereco = $_POST["endereco"];
            $cliente->numero = $_POST["numero"];
            $cliente->bairro = $_POST["bairro"];
            $cliente->email = Common::checkEmail($_POST["email"]);
            $cliente->telefone = Common::Replace('/[^0-9]/i','',$_POST["telefone"]);
            $cliente->cep = Common::Replace('/[^0-9]/i','',$_POST["cep"]);
            $cliente->cidade = $_POST["cidade"];
            $cliente->estado =  $_POST["estado"];
            if($cliente->save()){
                echo json_encode(["data"=>1, "msg"=>"Salvo com sucesso !!"]);
            }else{
                echo json_encode(["data"=>0, "msg"=>"Erro ao Salvar"]);
            }
    break;

    case 2: 
        $cliente = new Cliente();
        $cliente->id = $_POST["id"];
        $cliente->nome = $_POST["nome"];
        $cliente->cpfcnpj =  Common::Replace('/[^0-9]/i','',$_POST["cpfcnpj"]);
        $cliente->data_nascimento = Data::getFormat($_POST["data_nascimento"], 'Y-m-d');
        $cliente->endereco = $_POST["endereco"];
        $cliente->numero = $_POST["numero"];
        $cliente->bairro = $_POST["bairro"];
        $cliente->email = $_POST["email"];
        $cliente->telefone = Common::Replace('/[^0-9]/i','',$_POST["telefone"]);
        $cliente->cep = Common::Replace('/[^0-9]/i','',$_POST["cep"]);
        $cliente->cidade = $_POST["cidade"];
        $cliente->estado =  $_POST["estado"];

        if($cliente->update()){
            echo json_encode(["data"=>1, "msg"=>"Atualizado com sucesso !!"]);
        }else{
            echo json_encode(["data"=>0, "msg"=>"Erro ao Atualizar"]);
        }
    break;

    case 3:
        $id = $_POST['id'];
        $dados = Cliente::loadObject($id);
        $telefone = ( strlen($dados->telefone) == 11 ? Common::Mask($dados->telefone, "(##) #####-####") : Common::Mask($dados->telefone, "(##) ####-####"));
        $informacoesdoCliente = ["data"=>1, 
                                    "info"=>[
                                                "id" => $dados->id,
                                                "nome" => $dados->nome,
                                                "cpfcnpj" => Common::getMaskedDocumento($dados->cpfcnpj),
                                                "data_nascimento" => Data::getFormat($dados->data_nascimento, 'd/m/Y'),
                                                "email" => $dados->email,
                                                "telefone" => $telefone,
                                                "endereco" => $dados->endereco,
                                                "numero" => $dados->numero,
                                                "bairro" => $dados->bairro,
                                                "cep" => Common::Mask($dados->cep, '#####-###'),
                                                "cidade" => $dados->cidade,
                                                "estado" => $dados->estado,
                                            ]
                                ];
        echo json_encode($informacoesdoCliente);
    break;

    case 4:
        $id = $_POST['id'];
        $cliente = new Cliente();
        if($cliente->delete($id)){
            echo json_encode(["data"=>1, "msg"=>"excluído com sucesso!!"]);
        }else{
            echo json_encode(["data"=>0, "msg"=>"Erro ao excluir"]);
        }

    break;



}

