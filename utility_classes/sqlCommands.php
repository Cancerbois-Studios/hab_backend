<?php
require_once('sqlConnection.php');
require_once("exitWithCode.php");

class SqlCommands {
    private $sqlConnection;
    private $con;
    private $sqlStatements;
    
    function __construct() {
        $this->sqlConnection = new SqlConnection();
        $this->con = $this->sqlConnection->getDbConnection();
        $this->sqlStatements = new SqlStatements();
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
    public function executeQuery($sqlName,$params = null,$con = null){
      
        
        try{
            
            if($con == null){
                $con = $this->con;    
            }
            if($params == null || empty($params)) {
                ExitWithCode::exitWithCode(500, "Error: no params given for the sql, consider using executeNoParamQuery instead!");
            }
            
            $sql = $this->sqlStatements->getSql($sqlName);
            $stmt = $con->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        }catch(Exception $e){
            Logger::LogException($e);
            throw $e;
            //ExitWithCode::exitWithCode(500, $e->getMessage());            
        }
    }
    
    public function executeNoParamQuery($sqlName,$con = null){
        try{
            if($con == null){
                $con = $this->con;    
            }
            //$stmt = $con->prepare($sql);
            //$result = $stmt->execute();
            $sql = $this->sqlStatements->getSql($sqlName);
            $result = $con->query($sql);
            return $result;
        }catch(Exception $e){   
            Logger::LogException($e); 
            //ExitWithCode::exitWithCode(500, $e->getMessage());            
        }
    }
    
    public function executeExitQuery($sqlName,$params = null,$con = null){
        try{
            
            if($con == null){
                $con = $this->con;    
            }
            if($params == null || empty($params)) {
                ExitWithCode::exitWithCode(500, "Error: no params given for the sql, consider using executeNoParamQuery instead!");
            }
            
            $sql = $this->sqlStatements->getSql($sqlName);
            $stmt = $con->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        }catch(Exception $e){
            ExitWithCode::exitWithCode(500);           
        }
    }
    
    public function getDataAssoc($res){
         
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getDataObject($res){
        return $res->fetchObject();
    }
    
}


/*
*********** EXAMPLE OF THE TWO QUERY METHODS **************
public function getTest() {
    try {
        $stmt = $this->sqlCommands->executeNoParamQuery("getAllRecipes");
        
        $returnArray = array();
        while($row = $this->sqlCommands->getDataObject($stmt)) {
            $returnArray[] = $row;
        }
        return $returnArray;
    } catch(Exception $e) {
        Logger::LogException($e);
    }
}

public function getSpecificTest($_input) {
    try {
        if(!isset($_input->id)) {
            ExitWithCode::exitWithCode(400, "Missing params!");
        }
        $stmt = $this->sqlCommands->executeQuery("getRecipe",array($_input->id));
        
        return $this->sqlCommands->getDataObject($stmt);
    } catch(Exception $e) {
        Logger::LogException($e);
    }
}

****************** END EXAMPLE *****************
*/


?>