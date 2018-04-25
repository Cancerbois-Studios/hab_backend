<?php
require_once(realpath(__DIR__ . '/../index.php'));


class dynamicTable {
    
    private $sqlCommands;
    private $allowedOperators = array("=", ">=", "<=", "<", ">");
    
    public function __construct() {
        $this->sqlCommands = new SqlCommands();
        
    }
    
    
    
    public function getTableData($_input) {
        try {
            if(
                !isset($_input->tableName) ||
                !isset($_input->headersToSelect) ||
                !isset($_input->show) ||
                !isset($_input->page)
            ) {
                ExitWithCode::exitWithCode(400, "Missing params!");
            }
            if(
                !is_numeric($_input->show) ||
                !is_numeric($_input->page) ||
                !is_array($_input->headersToSelect)
            ) {
                ExitWithCode::exitWithCode(400, "Wrong format of params!");
            }
            
            $_tableInformation = $this->getTableInformation($_input->tableName);
            $sqlHeaders = array();
            $_tableInformation->possibleHeaders = array();
            //print_r($_tableInformation);exit;
            foreach($_tableInformation->header_info_json AS $index => $headerInfo) {
                array_push($_tableInformation->possibleHeaders, $headerInfo->sql_name);
                if(in_array($headerInfo->sql_name, $_input->headersToSelect, true)) {
                    array_push($sqlHeaders, $headerInfo->sql_name);
                }
            }
            
            $sql = "SELECT ";
            
            $idIndex = array_push($sqlHeaders, "id");
            $sql .= implode(",",$sqlHeaders);
            unset($sqlHeaders[$idIndex]);
            
            $sql .= " FROM " . $_tableInformation->sql_table_name . " ";
            
            $filters = array();
            // This late "isset" can only be allowed because we have no accessflow that could potentially block the lacking parameters
            if(isset($_input->filter)) {
                foreach($_input->filter AS $index => $filterInfo) {
                    if(in_array($filterInfo->sql_name, $_tableInformation->possibleHeaders, true) && in_array($filterInfo->match_type, $this->allowedOperators, true)) {
                        $str = "" . $filterInfo->sql_name;
                        if($filterInfo->match_type == "=" && is_array($filterInfo->value)) {
                            $str .= " IN (" . implode(",",$filterInfo->value) . ")";
                        } else {
                            $str .= $filterInfo->match_type . $filterInfo->value;
                        }
                        array_push($filters,$str);
                    }
                }
            }
            
            if(count($filters) > 0) {
                $sql .= "WHERE " . implode(" AND ", $filters);
            }
            
            $sqlOffset = ($_input->page - 1) * $_input->show;
            $sqlLimit = $_input->show;
            
            $sql .= " LIMIT " . $sqlLimit . " OFFSET " . $sqlOffset;
            
            //return $sql;
            $stmt = $this->sqlCommands->executeTextQuery($sql);
            
            $retArr = array();
            while($_row = $this->sqlCommands->getDataObject($stmt)) {
                array_push($retArr,$_row);
            }
            
            $countSql = "SELECT count(*) AS count FROM " . $_tableInformation->sql_table_name . " ";
            if(count($filters) > 0) {
                $countSql .= "WHERE " . implode(" AND ", $filters);
            }
            $stmt = $this->sqlCommands->executeTextQuery($countSql);
            $count = $this->sqlCommands->getDataObject($stmt)->count;
            
            return $this->getFormattedTableData($sqlHeaders, $retArr, $_tableInformation->operation_info_json, 1);
            
            //return $sql;
            
            
            return $this->sqlCommands->getDataObject($stmt);
        } catch(Exception $e) {
            ExitWithCode::exitWithCode(201, "No content to return" . $e->getMessage()); 
        }
    }
    
    
    public function getTableInformation($_tableName) {
        try {
            $stmt = $this->sqlCommands->executeQuery("getTableInformation",array($_tableName));
            
            $_res = $this->sqlCommands->getDataObject($stmt);
            if(empty($_res)) {
                throw new Exception("Invalid number of rows found (0 or 1<x)!");
            }
            
            $_res->header_info_json = json_decode($_res->header_info_json);
            $_res->operation_info_json = json_decode($_res->operation_info_json);
            
            return $_res;
        } catch(Exception $e) {
            $e = new Exception(__METHOD__ . " failed, with: " .$e->getMessage());
            Logger::LogException($e);
            throw $e; // Should this be a thing?
        }
    }
    
    public function insertRow($_input) {
        try {
            if(
                !isset($_input->tableName) ||
                !isset($_input->values)
            ) {
                ExitWithCode::exitWithCode(400, "Missing params!");
            }
            if(
                !is_array($_input->values)
            ) {
                ExitWithCode::exitWithCode(400, "Wrong format of params!");
            }
            
            $_tableInformation = $this->getTableInformation($_input->tableName);
            
            
            
            
            //return $this->sqlCommands->getDataObject($stmt);
        } catch(Exception $e) {
            ExitWithCode::exitWithCode(201, "No content to return" . $e->getMessage()); 
        }
    }
    
    public function getFormattedTableData($_headers, $_rows, $_operations, $_pagination) {
        $retObj = (object)array(
            "table" => array("headers" => $_headers),
            "rows" => array(),
            "pagination" => $_pagination
        );
        
        foreach($_rows AS $index => $row) {
            $id = $row->id;
            unset($row->id);
            array_push($retObj->rows, array("row_id" => $id, "data" => get_object_vars($row), "operations" => $_operations));
        }
        
        return $retObj;
    }
    
    
    // ***************************
    // ***** Private methods *****
    // ***************************
    
}

































?>