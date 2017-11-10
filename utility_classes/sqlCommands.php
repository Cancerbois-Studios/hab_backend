<?php
require_once('sqlConnection.php');

class SqlCommands {
    private $sqlConnection;
    
    function __construct() {
        $this->sqlConnection = new SqlConnection();
    }
    
    
    public function executeNoParamQuery($statement) {
        $db = $this->sqlConnection->getDbConnection();
        $stmt = $db->prepare("SELECT * FROM hab_recipe");
        $stmt->execute();
        return $stmt;
    }
    
    public function getDataObject($stmt) {
        return $stmt->fetchObject();
    }
    
}




?>