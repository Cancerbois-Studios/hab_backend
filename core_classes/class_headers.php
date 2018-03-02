<?php

class headers {
    private $headers;
    
    function __construct() {
        $this->getHeaders();
    }
    
    private function getHeaders() {
        //$this->headers = (object)getallheaders();
    }
    
    public function getAuthToken() {
        print_r(getallheaders());
        exit;
        if(isset($this->headers->authorization)) {
            return $this->headers->authorization;
        } else{
            return null;
        }
    }
    
    
    
    
}


?>