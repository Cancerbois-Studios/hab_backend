<?php
require_once(realpath(__DIR__ . '/../../index.php'));

class iod_ipconfig {
    private $sqlCommands;
    
    public function __construct() {
        $this->sqlCommands = new SqlCommands();
        
    }
    
    public function getIps($_input) {
        try {
            $stmt = $this->sqlCommands->executeNoParamQuery("getIodIps");
            
            $retArr = array();
            while($_row = $this->sqlCommands->getDataObject($stmt)) {
                array_push($retArr, $_row);
            }
            return $retArr;
        } catch(Exception $e) {
            Logger::LogException($e);
        }
    }
    
    public function setIp($_input) {
        try {
            if(
                !isset($_input->ip)
            ) {
                ExitWithCode::exitWithCode(400, "Missing params!");
            }
            
            $params = array(
                $_input->ip
            );
            
            $stmt = $this->sqlCommands->executeQuery("setIodIp",$params);
            
            return "lblSavedIp";
        } catch(Exception $e) {
            Logger::LogException($e);
            ExitWithCode::exitWithCode(500, $e->getMessage());
        }
    }
    
    public function callAggerACunt($_input) {
        //$response = http_get("http://www.example.com/file.xml");
        $response = file_get_contents("http://62.44.134.95:8080/test");
        return $response;
        
        $r = new HttpRequest('http://10.126.95.131:8080/test', HttpRequest::METH_GET);
        //$r->setOptions(array('lastmodified' => filemtime('local.rss')));
        //$r->addQueryData(array('category' => 3));
        try {
            $r->send();
            if ($r->getResponseCode() == 200) {
                //file_put_contents('local.rss', $r->getResponseBody());
                return $r->getResponseBody();
            }
        } catch (HttpException $ex) {
            return $ex;
        }
    }
    
}




?>