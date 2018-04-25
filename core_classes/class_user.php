<?php
require_once(realpath(__DIR__ . '/../index.php'));


class user {
    
    private $sqlCommands;
    
    public function __construct() {
        $this->sqlCommands = new SqlCommands();
        
    }
    
    public function getUserAttributes($_input) {
        try {
            if(
                !isset($_input->user_id)
            ) {
                ExitWithCode::exitWithCode(400, "Missing params!");
            }
            
            $dynamicTable = new dynamicTable();
            
            // Make dynamic table able to handle joins too!
            
            //return $dynamicTable->getFormattedTableData($_headers, $_rows, $_operations, $_pagination);
            
        } catch(Exception $e) {
            ExitWithCode::exitWithCode(201, "No content to return" . $e->getMessage()); 
        }
        
    }
    
    public function getUserAttributeValue($_input) {
        try {
            if(
                !isset($_input->user_id) ||
                !isset($_input->attribute_id)
            ) {
                ExitWithCode::exitWithCode(400, "Missing params!");
            }
            
            $stmt = $this->sqlCommands->executeQuery("getUserAttributeValue",array($_input->user_id, $_input->attribute_id));
            
            $_res = $this->sqlCommands->getDataObject($stmt);
            if(empty($_res)) {
                throw new Exception("No information found!");
            }
            
            return $_res->value;
            
        } catch(Exception $e) {
            ExitWithCode::exitWithCode(201, "No content to return" . $e->getMessage()); 
        }
    }
    
    public function setUserAttributeValue($_input) {
        try {
            if(
                !isset($_input->user_id) ||
                !isset($_input->attribute_id) ||
                !isset($_input->value)
            ) {
                ExitWithCode::exitWithCode(400, "Missing params!");
            }
            
            $stmt = $this->sqlCommands->executeQuery("setUserAttributeValue",array($_input->user_id, $_input->attribute_id, $_input->value, $_input->value));
            
            $insertedValue = $this->getUserAttributeValue($_input);
            if($_input->value != $insertedValue) {
                ExitWithCode::exitWithCode(400, "The value was not updated!");
            } else {
                return "lblSavedValue";
            }
            
        } catch(Exception $e) {
            //ExitWithCode::exitWithCode(500, "Something went horrible wrong!" . $e->getMessage()); 
            throw $e;
        }
    }
    
}


?>