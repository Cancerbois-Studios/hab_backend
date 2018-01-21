<?php


class SqlStatements {
    
    public function getSql($sqlName) {
        return $this->$sqlName;
    }
    
    private $createLogEntry = "INSERT INTO hab_fw_log_entry(user_id,log_level,message) VALUES (?,?,?)";
    
    private $getAllRecipes = "SELECT * FROM hab_cb_recipe";
    private $getRecipe = "SELECT * FROM hab_cb_recipe WHERE id=?";
    
    private $getAllIngredients = "SELECT * FROM hab_cb_ingredient";
    private $getIngredient = "SELECT * FROM hab_cb_ingredient WHERE id=?";
    private $insertIngredient = "INSERT INTO `hab_cb_ingredient`(`name`,`type`) VALUES (?, ?)";
    private $updateIngredient = "UPDATE hab_cb_ingredient SET name=?, type=? WHERE id=?";
    private $deleteIngredient = "DELETE FROM hab_cb_ingredient WHERE id=?";
    
    
    
    
    
}




?>