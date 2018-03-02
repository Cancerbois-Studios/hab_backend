<?php
require_once(realpath(__DIR__ . '/../index.php'));


class authentication {
    private $sqlCommands;
    
    private $secret = "login";
    private $algorithm = "sha256";
    
    public function __construct() {
        $this->sqlCommands = new SqlCommands();
        
    }
    
    public function login($input) {
        try {
            if(
                !isset($input->username) ||
                !isset($input->password)
            ) {
                ExitWithCode::exitWithCode(400, "Missing params!");
            }
            
            $hashedPassword = hash_hmac($this->algorithm,$input->password,$this->jwtSecret);
            $stmt = $this->sqlCommands->executeQuery("userLogin",array($input->username, $hashedPassword));
            $res = $this->sqlCommands->getDataObject($stmt);
            if(empty($res)) {
                //Logger::LogException($e);
                ExitWithCode::exitWithCode(401, "Wrong password!");
            }
            
            $jwtTokenClass = new jwtToken();
            return $jwtTokenClass->getJwtToken($input->username, $res->id);
        } catch(Exception $e) {
            Logger::LogException($e);
        }
        
//        $token = $jwtTokenClass->getJwtToken($input->username, $)
    }
    
    public function register($input) {
        try {
            if(
                !isset($input->username) ||
                !isset($input->password)
            ) {
                ExitWithCode::exitWithCode(400, "Missing params!");
            }
            
            $stmt = $this->sqlCommands->executeQuery("getUsername",array($input->username));
            //print_r($this->sqlCommands->getDataObject($stmt));
            //exit;
            if(!empty($this->sqlCommands->getDataObject($stmt))) {
                //Logger::LogException($e);
                return "lblUsernameTaken";
            }
            
            $hashedPassword = hash_hmac($this->algorithm,$input->password,$this->jwtSecret);
            $stmt = $this->sqlCommands->executeQuery("userRegistration",array($input->username, $hashedPassword));
            
            $stmt = $this->sqlCommands->executeQuery("getUsername",array($input->username));
            $newId = $this->sqlCommands->getDataObject($stmt)->id;
            
            $jwtTokenClass = new jwtToken();
            
            return $jwtTokenClass->getJwtToken($input->username, $newId);
            
        } catch(Exception $e) {
            Logger::LogException($e);
        }
        
    }
    
    public function validateToken($input) {
        try {
            if(
                !isset($input->jwt_token) 
            ) {
                ExitWithCode::exitWithCode(400, "Missing params!");
            }
            
            $jwtTokenClass = new jwtToken();
            
            return $jwtTokenClass->validateToken($input->jwt_token);
            
        } catch(Exception $e) {
            Logger::LogException($e);
        }
        
    }
    
    
    
    
}









?>