<?php

require_once(realpath(__DIR__ . '/../index.php'));

class jwtToken {
    
    private $jwtSecret = "top_secret";
    private $algorithm = "sha256";
    
    function __construct() {
        
    }
    
    public function getJwtToken($_input) {
        $header = array(
            "alg"=>$this->algorithm,
            "type"=>"jwt"
        );
        $payload = array(
            "expire"=>time() + (60*60*24*7)
        );
        
        $jwtSecret = hash_hmac($this->algorithm,base64_encode(json_encode($header)).".".base64_encode(json_encode($payload)),$this->jwtSecret);
        $jwt = base64_encode(json_encode($header)).".".base64_encode(json_encode($payload)).".".$jwtSecret;
        return $jwt;
    }
    
    public function decodeJwtToken($_input) {
        $tokenSplit = explode(".", $_input->token);
        $tokenPayload = json_decode(base64_decode($tokenSplit[1]));
        return $tokenPayload;
    }
    
    
    
    
    
    
    
    
    
    
}









?>