<?php

/* 
* MackorCo - Wenntjänst - Projektuppgift
* Kurs: Webbutveckling III - DT173G
* Utvecklare: Jeanette Krantz 
*/


class Drink {
    private $id;
    private $name;
    private $price;
    private $db;

    function __construct() {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if($this->db->connect_errno > 0) {
            die("Fel vid anslutning: " . $this->db->connect_error);
        }
    }

    //Hämta drycker
    public function getDrink() {
        $sql = "SELECT * FROM drink;";
        $result = mysqli_query($this->db, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //Hämta specifik dryck 
    public function getDrinkById($id) {
        $id = intval($id);
        $sql = "SELECT * FROM drink WHERE id=$id;";
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

    public function setDrinkAndId($name, $price, $id) {
        if($name != "") {
            $this->name = $name;
            $this->price = $price;
            $this->id = $id;
            return true;
        } else {
            return false;
        }
    }

    //Skapa dryck
    public function createDrink($name, $price) {
        if (!$this->setName($name)) return false;
        if (!$this->setPrice($price)) return false;

        //Lite säkerhet
        $this->name = $this->db->real_escape_string($this->name);
        $this->price = $this->db->real_escape_string($this->price);

        $this->name = strip_tags($this->name, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->price = strip_tags($this->price, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');

        $sql = "INSERT INTO drink(name, price)VALUES('". $this->name . "', '" . $this->price . "');";

        //Send sql query
        return mysqli_query($this->db, $sql);
    }

    //Uppdatera befintlig dryck
    public function updateDrink($name, $price) {
        if (!$this->setName($name)) return false;
        if (!$this->setPrice($price)) return false;

        //Lite säkerhet
        $this->name = $this->db->real_escape_string($this->name);
        $this->price = $this->db->real_escape_string($this->price);

        $this->name = strip_tags($this->name, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->price = strip_tags($this->price, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');

        $sql = "UPDATE drink SET name='". $this->name . "', price='" . $this->price . "' WHERE id=" . $this->id . ";";

        return mysqli_query($this->db, $sql);
    }

    //Ta bort dryck
    public function deleteDrink($id) {
        $id = intval($id);

        $sql = "DELETE FROM drink WHERE id=$id;";

        return mysqli_query($this->db, $sql);
    }



}