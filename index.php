<?php
require_once(__DIR__ . '/utility_classes/autoloader.php');

/*
$headers = getallheaders();
$method = $_SERVER['REQUEST_METHOD'];
$contentType = $_SERVER['CONTENT_TYPE'];

$request = $_SERVER['REQUEST_URI'];*/




Index::indexIt();


class Index {
    public static $indexInstance = null;
    public static function getInstance() {
        if(!isset(static::$indexInstance)) {
            static::$indexInstance = new static;
        }
        return static::$indexInstance;
    }
    
    public static function indexIt() {
        $indexClass = Index::getInstance();
        $indexClass->setHeaders();
        
        $indexClass->method = $_SERVER['REQUEST_METHOD'];
        //print_r(file_get_contents("php://input"));
        //exit();
        $indexClass->body = (object)json_decode(file_get_contents("php://input"));
        
        $indexClass->execute();
    }
    
    public $method;
    public $body;
    
    private function setHeaders() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Methods: GET");
        header('Content-Type: application/json');
    }
    
    public function execute() {
        if($this->method == "OPTIONS") {
            exit;
        }
        
        if(!isset($this->body->class) || !isset($this->body->method)) {
            ExitWithCode::exitWithCode(400, "Error: class or method not set!");
        }
        
        $class = new $this->body->class();
        $method = $this->body->method;
        $input = (object)array();
        foreach($this->body AS $key => $value) {
            if($key == "class" || $key == "method") { continue; }
            $input->$key = $value;
        }
        $retval = $class->$method($input);
        if(!is_array($retval) && !is_object($retval)) {
            $retval = array($retval);
        }
        
        ExitWithCode::exitWithCode(200,$retval);
        
        ExitWithCode::exitWithCode(400, "Made it too far in the execute method!");
    }
}

?>