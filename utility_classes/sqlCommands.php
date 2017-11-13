<?php
require_once('sqlConnection.php');
require_once("exitWithCode.php");

class SqlCommands {
    private $sqlConnection;
    private $con;
    
    function __construct() {
        $this->sqlConnection = new SqlConnection();
        $this->con = $this->sqlConnection->getDbConnection();
    }
    
    /**
    * Prepair statments for later execute
    * @param Sql Statment  
    * @param Uniqe name for the query (optional)
    * @param sql Connection (optional)
    */       
    /*public function prepareQuery($sql,$con = null){
  
        try{
            if($con == null){    
                $con = $this->con;
            }                    
            $result = $con->prepare($sql);            
            return $result;
        }catch(Exception $e){
            exitWithCode::exitWithCode(500, $e->getMessage());   
        }
    }*/
    
    /**
    * Execute statments for with resultset returned
    * @param Parameters that the statement requires  
    * @param Uniqe name for the query (optional)
    * @param sql Connection (optional)
    */ 
    public function executeQuery($sql,$params = null,$con = null){
      
        
        try{
            
            if($con == null){
                $con = $this->con;    
            }
            if($params == null || empty($params)) {
                ExitWithCode::exitWithCode(500, "Error: no params given for the sql, consider using executeNoParamQuery instead!");
            }
            
            $stmt = $con->prepare($sql);
            $result = $stmt->execute($params);
            return $result;
        }catch(Exception $e){
            ExitWithCode::exitWithCode(500, $e->getMessage());            
        }
    }
    
    public function executeNoParamQuery($sql,$con = null){
        try{
            if($con == null){
                $con = $this->con;    
            }
            //$stmt = $con->prepare($sql);
            //$result = $stmt->execute();
            $result = $con->query($sql);
            return $result;
        }catch(Exception $e){       
            ExitWithCode::exitWithCode(500, $e->getMessage());            
        }
    }
    
    public function getDataAssoc($res){
         
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getDataObject($res){
        return $res->fetchObject();
    }
    
}




?>