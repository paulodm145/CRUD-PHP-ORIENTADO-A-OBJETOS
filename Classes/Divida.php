<?php
namespace ClassesSistema;
//require('Database.php');

use PDO;

class Divida{
    private $table = "dividas";
    
    private $id;
    private $id_cliente;
    private $descricao;
    private $valor;
    private $vencimento;
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
        $sql = "INSERT INTO ".$this->table." (id_cliente, descricao, valor, vencimento, created, updated, deleted)  
                                              VALUES(?, ?, ?, ?, NOW(), null,  null )";
        
        $id_cliente = $this->id_cliente;
        $descricao = $this->descricao;
        $valor = $this->valor;
        $vencimento = $this->vencimento;


        try {

            $insercao = $db->prepare($sql); 
            $insercao->bindParam(1, $id_cliente); 
            $insercao->bindParam(2, $descricao); 
            $insercao->bindParam(3, $valor);
            $insercao->bindParam(4, $vencimento);
            $insercao->execute();
            $retorno = ($insercao->rowCount() > 0?true:false);

            return $retorno;

        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function update(){

        $db = Database::conexao();    
        
        $sql = "UPDATE dividas set descricao = ?, valor = ?, vencimento = ?, updated = NOW()  WHERE id=?";
        
        $id = $this->id;
        $descricao = $this->descricao;
        $valor = $this->valor;
        $vencimento = $this->vencimento;


        try {
            $atualizar = $db->prepare($sql); 
            $atualizar->bindParam(1, $descricao); 
            $atualizar->bindParam(2, $valor); 
            $atualizar->bindParam(3, $vencimento);
            $atualizar->bindParam(4, $id);
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
                                     "id_cliente" => $result->id_cliente,
                                     "descricao" => $result->descricao,
                                     "valor" => $result->valor,
                                     "vencimento" => $result->vencimento,
                                     "created" => $result->created,
                                     "updated" => $result->updated,
                                     "deleted" => $result->deleted
                                ); 
                }
                return $data;
            } else {
                echo "Erro: Não foi possível recuperar os dados do banco";
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
    public function fetchAll($id){
        
        try {
            $conexao = Database::conexao();
            $stmt = $conexao->prepare("SELECT * FROM ".$this->table." WHERE id_cliente = ".$id." and  deleted IS NULL");
            $data = [];
            if ($stmt->execute()) {
                while ($result = $stmt->fetch(PDO::FETCH_OBJ)) {
                    $data[] = array(
                                    "id" => $result->id,
                                    "id_cliente" => $result->id_cliente,
                                    "descricao" => $result->descricao,
                                    "valor" => $result->valor,
                                    "vencimento" => $result->vencimento,
                                    "created" => $result->created,
                                    "updated" => $result->updated,
                                    "deleted" => $result->deleted
                                ); 
                }

                return $data;

            }else{
                echo "Erro: Não foi possível recuperar os dados do banco de dados";
            }

        } catch (PDOException $erro) {
            echo "Erro: ".$erro->getMessage();
        }

    }

}
