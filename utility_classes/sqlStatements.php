<?php
require_once(realpath(__DIR__ . '/../index.php'));


class SqlStatements {
    
    public function getSql($sqlName) {
        return $this->$sqlName;
    }
    
    private $getUsername = "SELECT id FROM hab_fw_user WHERE username = ?";
    private $userRegistration = "INSERT INTO hab_fw_user (username, password) VALUES (?, ?)";
    private $userLogin = "SELECT id FROM hab_fw_user WHERE username = ? AND password = ?";
    
    private $createLogEntry = "INSERT INTO hab_fw_log_entry(user_id,log_level,message) VALUES (?,?,?)";
    
    private $getAllRecipes = "SELECT * FROM hab_cb_recipe";
    private $getRecipe = "SELECT * FROM hab_cb_recipe WHERE id=?";
    
    private $getAllIngredients = "SELECT * FROM hab_cb_ingredient";
    private $getIngredient = "SELECT * FROM hab_cb_ingredient WHERE id=?";
    private $insertIngredient = "INSERT INTO `hab_cb_ingredient`(`name`,`type`) VALUES (?, ?)";
    private $updateIngredient = "UPDATE hab_cb_ingredient SET name=?, type=? WHERE id=?";
    private $deleteIngredient = "DELETE FROM hab_cb_ingredient WHERE id=?";
    
    private $getCnsUserStatistics = "SELECT correct_count, incorrect_count FROM hab_cns_statistics WHERE user_id=?";
    private $setCnsUserStatistics = "INSERT INTO hab_cns_statistics(user_id, correct_count, incorrect_count) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE correct_count = correct_count + ?, incorrect_count = incorrect_count + ?;";
    
    
    
    
}




?>