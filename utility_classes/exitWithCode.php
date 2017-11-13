<?php


class ExitWithCode {
    
    private function __construct() {
        
    }
    
    public static function exitWithCode($httpResponseCode, $reponseText = null) {
        http_response_code($httpResponseCode);
        if(isset($reponseText)) {
            exit(json_encode($reponseText));
        }
        exit();
    }
    
}



?>