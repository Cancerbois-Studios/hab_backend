<?php
//require_once('./utility_classes/autoloader.php');

//require_once('./utility_classes/sqlCommands.php');
//require_once('../../utility_classes/sqlStatements.php');

require_once(realpath(__DIR__ . '/../../index.php'));




class Ingredient {
    private $sqlCommands;
    
    private $var;
    
    function __construct() {
        $this->var = "wiwiwiwiiw";
        $this->sqlCommands = new SqlCommands();
    }
    
    public function getAll() {
        try {
            $stmt = $this->sqlCommands->executeNoParamQuery("getAllIngredients");
            
            $returnArray = array();
            while($row = $this->sqlCommands->getDataObject($stmt)) {
                $returnArray[] = $row;
            }
            return $returnArray;
        } catch(Exception $e) {
            Logger::LogException($e);
        }
    }
    
    public function getSpecific($_input) {
        try {
            if(!isset($_input->id)) {
                ExitWithCode::exitWithCode(400, "Missing params!");
            }
            $stmt = $this->sqlCommands->executeQuery("getIngredient",array($_input->id));
            
            return $this->sqlCommands->getDataObject($stmt);
        } catch(Exception $e) {
            Logger::LogException($e);
        }
    }
    
    public function create($_input) {
        try {
            if(
                !isset($_input->name) ||
                !isset($_input->type)
            ) {
                ExitWithCode::exitWithCode(400, "Missing params!");
            }
            $stmt = $this->sqlCommands->executeQuery("insertIngredient",array($_input->name, $_input->type));
            
            return "lblCreatedIngredient";
        } catch(Exception $e) {
            Logger::LogException($e);
        }
    }
    
    public function update($_input) {
        try {
            if(
                !isset($_input->id) ||
                !isset($_input->name) ||
                !isset($_input->type)
            ) {
                ExitWithCode::exitWithCode(400, "Missing params!");
            }
            $stmt = $this->sqlCommands->executeQuery("updateIngredient",array($_input->name, $_input->type, $_input->id));
            
            return "lblUpdatedIngredient";
        } catch(Exception $e) {
            Logger::LogException($e);
        }
    }
    
    public function deleteSpecific($_input) {
        try {
            if(!isset($_input->id)) {
                ExitWithCode::exitWithCode(400, "Missing params!");
            }
            $stmt = $this->sqlCommands->executeQuery("deleteIngredient",array($_input->id));
            
            return "lblDeletedIngredient";
        } catch(Exception $e) {
            Logger::LogException($e);
        }
    }
    
}






?>