<?php

/* 
* MackorCo - Wenntjänst - Projektuppgift
* Kurs: Webbutveckling III - DT173G
* Utvecklare: Jeanette Krantz 
*/


class Food {
    private $id;
    private $name;
    private $price;
    private $ingredients;
    private $db;

    function __construct() {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if($this->db->connect_errno > 0) {
            die("Fel vid anslutning: " . $this->db->connect_error);
        }
    }

    //Hämta maträtter ur databasen
    public function getFood() {
        $sql = "SELECT * FROM food;";
        $result = mysqli_query($this->db, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //Hämta specifik maträtt 
    public function getFoodById($id) {
        $id = intval($id);
        $sql = "SELECT * FROM food WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();
    }

    //Set-metoder
    public function setName($name) {
        if($name != "") {
            $this->name = $name;
            return true;
        } else {
            return false;
        }
    }

    public function setPrice($price) {
        if($price != "") {

            $this->price = $price;
            return true;
        } else {
            return false;
        }
    }

    public function setIngredients($ingredients) {
        if($ingredients != "") {

            $this->ingredients = $ingredients;
            return true;
        } else {
            return false;
        }
    }

    public function setFoodAndId($name, $price, $ingredients, $id) {
        if($name != "") {
            $this->name = $name;
            $this->price = $price;
            $this->ingredients = $ingredients;
            $this->id = $id;
            return true;
        } else {
            return false;
        }
    }

    //Skapa maträtt 
    public function createFood($name, $price, $ingredients) {
        if (!$this->setName($name)) return false;
        if (!$this->setPrice($price)) return false;
        if (!$this->setIngredients($ingredients)) return false;

        //Lite säkerhet
        $this->name = $this->db->real_escape_string($this->name);
        $this->price = $this->db->real_escape_string($this->price);
        $this->ingredients = $this->db->real_escape_string($this->ingredients);

        $this->name = strip_tags($this->name, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->price = strip_tags($this->price, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->ingredients = strip_tags($this->ingredients, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');

        
        $sql = "INSERT INTO food(name, price, ingredients)VALUES('". $this->name . "', '" . $this->price . "', '" .  $this->ingredients . "');";

        //Send sql query
        return mysqli_query($this->db, $sql);
    }

    //Uppdatera befintlig maträtt
    public function updateFood($name, $price, $ingredients) {
        if (!$this->setName($name)) return false;
        if (!$this->setPrice($price)) return false;
        if (!$this->setIngredients($ingredients)) return false;

        //Lite säkerhet
        $this->name = $this->db->real_escape_string($this->name);
        $this->price = $this->db->real_escape_string($this->price);
        $this->ingredients = $this->db->real_escape_string($this->ingredients);

        $this->name = strip_tags($this->name, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->price = strip_tags($this->price, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->ingredients = strip_tags($this->ingredients, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');


        $sql = "UPDATE food SET name='". $this->name . "', price='" . $this->price . "', ingredients='" . $this->ingredients . "' WHERE id=" . $this->id . ";";

        return mysqli_query($this->db, $sql);
    }

    //Ta bort maträtt
    public function deleteFood($id) {
        $id = intval($id);

        $sql = "DELETE FROM food WHERE id=$id;";

        return mysqli_query($this->db, $sql);
    }



}