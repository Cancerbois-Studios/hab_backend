<?php
require_once("utility_classes/exitWithCode.php");

require_once("core_classes/ingredient.php");


$headers = getallheaders();
$method = $_SERVER['REQUEST_METHOD'];
$contentType = $_SERVER['CONTENT_TYPE'];

$request = $_SERVER['REQUEST_URI'];



header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET");
//header('Content-Type: application/json');

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
        
        $indexClass->method = $_SERVER['REQUEST_METHOD'];
        $indexClass->body = (object)json_decode(file_get_contents("php://input"));
        
        $indexClass->execute();
    }
    
    public $method;
    public $body;
    
    public function execute() {
        if(!isset($this->body->class) || !isset($this->body->method)) {
            ExitWithCodeClass::exitWithCode(400, "Error: class or method not set!");
        }
        
        $class = new $this->body->class();
        $method = $this->body->method;
        ExitWithCodeClass::exitWithCode(200,$class->$method());
        
        ExitWithCodeClass::exitWithCode(400, "Made it too far in the execute method!");
    }
}

?>