<?php
//require_once('./utility_classes/autoloader.php');

//require_once('./utility_classes/sqlCommands.php');
//require_once('../../utility_classes/sqlStatements.php');

require_once(realpath(__DIR__ . '/../../index.php'));




class Ingredient {
    private $sqlCommands;
    private $sqlStatements;
    
    private $var;
    
    function __construct() {
        $this->var = "wiwiwiwiiw";
        $this->sqlCommands = new SqlCommands();
        $this->sqlStatements = new SqlStatements();
    }
    
    public function getTest() {
        $sql = $this->sqlStatements->getAllRecipes;
        $stmt = $this->sqlCommands->executeNoParamQuery($sql);
        
        $returnArray = array();
        while($row = $this->sqlCommands->getDataObject($stmt)) {
            $returnArray[] = $row;
        }
        return $returnArray;
    }
    
}






?>