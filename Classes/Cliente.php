<?php
namespace ClassesSistema;
require('Database.php');

use PDO;

class Cliente{
    private $table = "clientes";
    public $primaryKey = "id";

    private $id;
    private $nome;
    private $cpfcnpj;
    private $data_nascimento;
    private $email;
    private $telefone;
    private $endereco;
    private $numero;
    private $bairro;
    private $cep;
    private $cidade;
    private $estado;
    private $created;
    private $updated;
    private $deleted;

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function __get($atributo){
        return $this->$atributo;
    }

    public function save(){

        $db = Database::conexao();    
        $sql = "INSERT INTO ".$this->table." (nome, cpfcnpj, data_nascimento, email, telefone, endereco, numero, bairro, cep, cidade, estado, created, updated, deleted)  
                            VALUES(?, ?,  ?,  ?, ?, ?,  ?, ?,  ?, ?,  ?, NOW(), null,  null )";
        $nome = $this->nome;
        $cpfcnpj = $this->cpfcnpj; 
        $data_nascimento = $this->data_nascimento;
        $email = $this->email;
        $telefone = $this->telefone;
        $endereco = $this->endereco;
        $numero = $this->numero;
        $bairro = $this->bairro;
        $cidade = $this->cidade;
        $estado = $this->estado;
        $cep = $this->cep;

        try {

            $insercao = $db->prepare($sql); 
            $insercao->bindParam(1, $nome); 
            $insercao->bindParam(2, $cpfcnpj); 
            $insercao->bindParam(3, $data_nascimento);
            $insercao->bindParam(4, $email);
            $insercao->bindParam(5, $telefone);
            $insercao->bindParam(6, $endereco);
            $insercao->bindParam(7, $numero);
            $insercao->bindParam(8, $bairro);
            $insercao->bindParam(9, $cep);
            $insercao->bindParam(10, $cidade);
            $insercao->bindParam(11, $estado);
            $insercao->execute();
            $retorno = ($insercao->rowCount() > 0?true:false);

            return $retorno;

        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function update(){

        $db = Database::conexao();    
        
        $sql = "UPDATE clientes SET nome = ?, cpfcnpj = ?, data_nascimento = ?, email = ?, telefone = ?, endereco = ?, numero = ?, bairro = ?, cep = ?, cidade = ?, estado = ?, updated = NOW()  WHERE id=?";
        
        $id = $this->id;
        $nome = $this->nome;
        $cpfcnpj = $this->cpfcnpj; 
        $data_nascimento = $this->data_nascimento;
        $email = $this->email;
        $telefone = $this->telefone;
        $endereco = $this->endereco;
        $numero = $this->numero;
        $bairro = $this->bairro;
        $cidade = $this->cidade;
        $estado = $this->estado;
        $cep = $this->cep;

        try {
            $atualizar = $db->prepare($sql); 
            $atualizar->bindParam(1, $nome); 
            $atualizar->bindParam(2, $cpfcnpj); 
            $atualizar->bindParam(3, $data_nascimento);
            $atualizar->bindParam(4, $email);
            $atualizar->bindParam(5, $telefone);
            $atualizar->bindParam(6, $endereco);
            $atualizar->bindParam(7, $numero);
            $atualizar->bindParam(8, $bairro);
            $atualizar->bindParam(9, $cep);
            $atualizar->bindParam(10, $cidade);
            $atualizar->bindParam(11, $estado);
            $atualizar->bindParam(12, $id);
            $atualizar->execute();
            $retorno = ($atualizar->rowCount() > 0?true:false);
            return $retorno;
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function delete($id){
        /**Aplicação de técnica de soft delete*/
        $db = Database::conexao();    
        $sql = "UPDATE ".$this->table." SET deleted = NOW() WHERE id=?";
        try {
            $deleted = $db->prepare($sql); 
            $deleted->bindParam(1, $id); 
            $deleted->execute();
            $retorno = ($deleted->rowCount() > 0?true:false);
            return $retorno;
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function show($id){
        
        try {
            $conexao = Database::conexao();
            $stmt = $conexao->prepare("SELECT * FROM ".$this->table." WHERE id = ".$id);
            if ($stmt->execute()) {
                while ($result = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $data = array(
                                    "id" => $result->id,
                                    "nome" => $result->nome,
                                    "cpfcnpj" => $result->cpfcnpj,
                                    "data_nascimento" => $result->data_nascimento,
                                    "email" => $result->email,
                                    "telefone" => $result->telefone,
                                    "endereco" => $result->endereco,
                                    "numero" => $result->numero,
                                    "bairro" => $result->bairro,
                                    "cep" => $result->cep,
                                    "cidade" => $result->cidade,
                                    "estado" => $result->estado,
                                    "created" => $result->created,
                                    "updated" => $result->updated,
                                    "deleted" => $result->deleted,
                                ); 
                }
                return $data;
            } else {
                echo "Erro: Não foi possível recuperar os dados do banco de dados";
            }
        } catch (PDOException $erro) {
            echo "Erro: ".$erro->getMessage();
        }
    }

    public static function loadObject($id){
        $classe = __CLASS__;
        $objeto = new $classe;
        return (object)$objeto->show($id);
    }

    /** Lista todos os registros não excluídos */
    public function fetchAll(){
        
        try {

            $conexao = Database::conexao();
            $stmt = $conexao->prepare("SELECT * FROM ".$this->table." WHERE deleted IS NULL");
            
            $data = [];
            if ($stmt->execute()) {
                while ($result = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $data[] = array(
                                    "id" => $result->id,
                                    "nome" => $result->nome,
                                    "cpfcnpj" => $result->cpfcnpj,
                                    "data_nascimento" => $result->data_nascimento,
                                    "email" => $result->email,
                                    "telefone" => $result->telefone,
                                    "endereco" => $result->endereco,
                                    "numero" => $result->numero,
                                    "bairro" => $result->bairro,
                                    "cep" => $result->cep,
                                    "cidade" => $result->cidade,
                                    "estado" => $result->estado,
                                    "created" => $result->created,
                                    "updated" => $result->updated,
                                    "deleted" => $result->deleted,
                                ); 
                }

                return $data;

            } else {
                echo "Erro: Não foi possível recuperar os dados do banco de dados";
            }

        } catch (PDOException $erro) {
            echo "Erro: ".$erro->getMessage();
        }

    }

}
