<?PHP
  namespace ClassesSistema;
  abstract class BancoDeDados
  {
    /*
    * Esta classe abstrata define os m�todos que as classes que a herdarem
    * devem implementar de forma concreta, padronizando os nomes dos m�todos
    * independente do banco de dados a ser implementado / utilizado.        
    */
        
    protected $server;    // Armazena o endere�o do servidor
    protected $port;      // Armazena a porta de conex�o
    protected $user;      // Armazena o nome de usu�rio para conex�o
    protected $password;  // Armazena a senha de usu�rio para conex�o
    protected $db;        // Armazena o nome do banco de dados
    protected $connection;  // Armazena os dados de uma conex�o
    protected $resultSet;   // Armazena o ResultSet de uma consulta
  
    /* Define os dados de conex�o com o banco de dados */         
    abstract public function setConfig($server, $port, $user, $password, $db);
    
    /* Conecta ao banco de dados */         
    abstract public function connect();
    
    /* Desconecta do banco de dados */
    abstract public function disconnect();
        
    /* Executa comandos sql */
    abstract public function executeCommand($sql);

    /* Retorna dados em forma de um array associativo */
    abstract public function executeSelect();
    
    /* Retorna o próximo result set da consulta */
    abstract public function getNextResultSetPosition();
    
    /* Retorna o n�mero de registros do �ltimo comando realizado */
    abstract public function getAffectedRows();
    
    /* Retorna se ocorreu algum erro no �ltimo comando realizado */
    abstract public function getError();
  }
  
?>
