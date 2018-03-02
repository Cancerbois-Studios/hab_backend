<?php
require_once(realpath(__DIR__ . '/../index.php'));

class jwtToken {
    private $headers;
    
    private $jwtSecret = "top_secret";
    private $algorithm = "sha256";
    private $type = "jwt";
    
    function __construct() {
        $this->headers = new headers();
    }
    
    public function getJwtToken($username, $userId) {
        $header = $this->createTokenHeader();
        $payload = array(
            "username" => $username,
            "user_id" => $userId,
            "expire"=>time() + (60*60*24*1) // 1 day
        );
        
        $jwtSecret = hash_hmac($this->algorithm,base64_encode(json_encode($header)).".".base64_encode(json_encode($payload)),$this->jwtSecret);
        $jwt = base64_encode(json_encode($header)).".".base64_encode(json_encode($payload)).".".$jwtSecret;
        return $jwt;
    }
    
    private function createTokenHeader() {
        return array(
            "alg"=>$this->algorithm,
            "type"=>$this->type
        );
    }
    
    private function splitToken($_token) {
        $splitToken = explode(".", $_token);
        return array("header"=>$splitToken[0],"payload"=>$splitToken[1],"secret"=>$splitToken[2]);
    }
    
    private function decodeTokenPayload($_tokenPayload) {
        $tokenPayload = json_decode(base64_decode($_tokenPayload));
        return $tokenPayload;
    }
    
    public function validateToken($token) {
        //$token = $this->headers->getAuthToken();
        $splitToken = $this->splitToken($token);
        $decodedTokenPayload = $this->decodeTokenPayload($splitToken["payload"]);
        //echo $decodedTokenPayload->expire . ":" . time();
        //print_r($token);
        //exit;
        if($decodedTokenPayload->expire < time()) {
            ExitWithCode::exitWithCode(401, "Unauthorized: token expired!");
        }
        
        $jwtSecret = hash_hmac($this->algorithm,base64_encode(json_encode($this->createTokenHeader())).".".base64_encode(json_encode($decodedTokenPayload)),$this->jwtSecret);
        if($jwtSecret == $splitToken["secret"]) {
            return true;
        } else {
            return false;
        }
    }
    
    
    
    
    
    
    
    
}









?>