<?php
require_once('./utility_classes/sqlConnection.php');



class Ingredient {
    private $sqlConnection;
    
    private $var;
    
    function __construct() {
        $this->var = "wiwiwiwiiw";
        //$this->sqlConnection = new sqlConnection();
    }
    
    public function getTest() {
        return $this->var;
    }
    
}






?>