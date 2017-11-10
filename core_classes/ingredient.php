<?php
require_once('./utility_classes/sqlCommands.php');



class Ingredient {
    private $sqlCommands;
    
    private $var;
    
    function __construct() {
        $this->var = "wiwiwiwiiw";
        $this->sqlCommands = new SqlCommands();
    }
    
    public function getTest() {
        $stmt = $this->sqlCommands->executeNoParamQuery("hej");
        return $this->sqlCommands->getDataObject($stmt);
    }
    
}






?>