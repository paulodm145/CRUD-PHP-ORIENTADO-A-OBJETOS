<?PHP
  namespace ClassesSistema;

  require('MySQL.php');

  class Utils
  {
    /*
    * Esta classe define algumas funções úteis para a aplicação, como carregar
    * o banco de dados e arquivo de configurações.    
    */
    
    public function getConfigVars()
    {
      /* 
      * Esta função lê o arquivo de configurações da aplicação, definido pelo
      * usuário, em busca do valor de uma variável específica. Este método
      * pode ser otimizado, lendo todas as variáveis e disponibilizando-as
      * em um array armazenado em sessão.   
      */
      
      // Caminho do arquivo de configurações, em diretório que não possua
      // acesso externo (internet), mas sim, somente interno no servidor.
      $arquivo = parse_ini_file("./Config/properties.ini");
      $configVars = $arquivo;
      return $configVars;
    }
    
    public function getConnection()
    {
      /*
      * Esta função obtem as informações de banco de dados a ser utilizado em um
      * arquivo de configuração criado pelo programador, para esta aplicação.
      * Baseado nas informações, cria o objeto de acordo com o tipo desejado.        
      */
          
      // Captura os dados de um arquivo de configuração, inclusive se é MYSQL, ou outros
      $configVars = $this->getConfigVars();
      
      $dbTempAddress = $configVars["DB_ADDRESS"];
      $dbTempPort = $configVars["DB_PORT"];
      $dbTempUser = $configVars["DB_USER"];
      $dbTempPassword = $configVars["DB_PASSWORD"];
      $dbTempName = $configVars["DB_NAME"];
      $dbTemp = null;
      $bdTempType = "MySQL";
      
      if($bdTempType == "MySQL")
        $dbTemp = new MySQL();
  
      else if($bdTempType == "PostgreSQL")
        $dbTemp = new PostgreSQL(); //É necessário implementar a classe PostgreSQL
  
      else if($bdServer == "SQLServer")
        $dbTemp = new SQLServer(); //É necessário implementar a classe SQLServer
  
      if($dbTemp != null)    
        $dbTemp->setConfig($dbTempAddress, $dbTempPort, 
                           $dbTempUser, $dbTempPassword, $dbTempName);
                           
      return $dbTemp;    
    }
  }
  
?>
