<?php
require_once(realpath(__DIR__ . '/../index.php'));

class Logger {
    
    public static function LogException($e) {
        try {
            $sqlCommands = new SqlCommands();
            $stmt = $sqlCommands->executeExitQuery("createLogEntry",array(-1,5,$e));
            
            return true;
        } catch(Exception $e) {
            ExitWithCode::exitWithCode(500, "Error: logger not working!");
        }
    }
    
}




?>