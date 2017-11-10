<?php

class SqlConnection {
    // Constants for the database connection
    private $DB_SERVER = "skjoldtoft.dk.mysql";
    private $DB_USER = "skjoldtoft_dk";
    private $DB_PASS = "fUuGrSAr";
    private $DB_NAME = "skjoldtoft_dk";
    
    function __contruct() {
    }
    
    public function getDbConnection() {
        $db = new PDO('mysql:host='.$this->DB_SERVER.';dbname='.$this->DB_NAME, $this->DB_USER,$this-> DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
}

?>