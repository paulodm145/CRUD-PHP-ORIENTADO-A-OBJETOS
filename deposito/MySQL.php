<?php
namespace ClassesSistema;

  include_once("BancoDeDados.php");
  
  class MySQL extends BancoDeDados
  {
    /*
    * Esta classe foi implementada para interagir com o banco de dados MySQL,
    * herdando os métodos abstratos definidos na classe BancoDeDados.
    */
        
    /* Define os dados de conexão com o banco de dados */    
    public function setConfig($server, $port, $user, $password, $db)
    {
      $this->server = $server;
      $this->port = $port;
      $this->user = $user;
      $this->password = $password;
      $this->db = $db;
    }
  
    /* Conecta ao banco de dados */          
    public function connect()
    {
      // Formata o endereço e porta do servidor
      $address = $this->server;
      if($this->port != "")
        $address .= ":".$this->port;
  
      $this->connection = mysqli_connect($address, $this->user, $this->password, $this->db)
        or die('Não foi possivel conectar: ' . mysqli_error($this->connection));
    }
    
    /* Desconecta do banco de dados */
    public function disconnect()
    {
      if($this->connection)
        mysqli_close($this->connection);
    }
        
    /* Executa comandos sql */
    public function executeCommand($sql)
    {
      if($this->connection)
        $this->resultSet = mysqli_query($this->connection, $sql);
      else
        return FALSE;
    }

    public function executeSelect(){
      return  mysqli_fetch_assoc($this->resultSet); 
    }
    /* Retorna o próximo result set da consulta */
    public function getNextResultSetPosition()
    {
      return mysqli_fetch_array($this->resultSet);
    }
    
    /* Retorna o número de registros alterados no último comando realizado */
    public function getAffectedRows()
    {
      return mysqli_affected_rows($this->connection);
    }
    
    /* Retorna se ocorreu algum erro no último comando realizado */
    public function getError()
    {
      return mysqli_error($this->connection);
    }
  }
  
?>
