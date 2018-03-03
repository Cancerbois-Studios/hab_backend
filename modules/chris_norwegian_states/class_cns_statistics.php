<?php
require_once(realpath(__DIR__ . '/../../index.php'));

class cns_statistics {
    private $sqlCommands;
    
    public function __construct() {
        $this->sqlCommands = new SqlCommands();
        
    }
    
    public function getUserStatistics($_input) {
        try {
            if(!isset($_input->user_id)) {
                ExitWithCode::exitWithCode(400, "Missing params!");
            }
            $stmt = $this->sqlCommands->executeQuery("getCnsUserStatistics",array($_input->user_id));
            
            return $this->sqlCommands->getDataObject($stmt);
        } catch(Exception $e) {
            Logger::LogException($e);
        }
    }
    
    public function setUserStatistics($_input) {
        try {
            if(
                !isset($_input->user_id) ||
                !isset($_input->correct_count) ||
                !isset($_input->incorrect_count)
            ) {
                ExitWithCode::exitWithCode(400, "Missing params!");
            }
            
            $params = array(
                $_input->user_id,
                $_input->correct_count,
                $_input->incorrect_count,
                $_input->correct_count,
                $_input->incorrect_count
            );
            
            $stmt = $this->sqlCommands->executeQuery("setCnsUserStatistics",$params);
            
            return "lblSavedUserStatistics";
        } catch(Exception $e) {
            Logger::LogException($e);
            ExitWithCode::exitWithCode(500, $e->getMessage());
        }
    }
    
}




?>