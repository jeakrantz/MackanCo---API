<?php

/* 
* MackorCo - Wenntjänst - Projektuppgift
* Kurs: Webbutveckling III - DT173G
* Utvecklare: Jeanette Krantz 
*/


class Order {
    private $id;
    private $foodname;
    private $drinkname;
    private $tkname; 
    private $tkemail;
    private $tkphone;
    private $db;

    function __construct() {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if($this->db->connect_errno > 0) {
            die("Fel vid anslutning: " . $this->db->connect_error);
        }
    }

    //Hämta ordrar
    public function getOrder() {
        $sql = "SELECT * FROM takeaway ORDER BY create_date;";
        $result = mysqli_query($this->db, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //Hämta specifik order med id
    public function getOrderById($id) {
        $id = intval($id);
        $sql = "SELECT * FROM takeaway WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();
    }

    //Set-metoder
    public function setFoodName($foodname) {
        if($foodname != "") {
            $this->foodname = $foodname;
            return true;
        } else {
            return false;
        }
    }

    public function setDrinkName($drinkname) {
        if($drinkname != "") {
            $this->drinkname = $drinkname;
            return true;
        } else {
            return false;
        }
    }
    public function setTKName($tkname) {
        if($tkname != "") {
            $this->tkname = $tkname;
            return true;
        } else {
            return false;
        }
    }
    public function setTKEmail($tkemail) {
        if($tkemail != "") {
            $this->tkemail = $tkemail;
            return true;
        } else {
            return false;
        }
    }

    public function setTKPhone($tkphone) {
        if($tkphone != "") {
            $this->tkphone = $tkphone;
            return true;
        } else {
            return false;
        }
    }


    public function setOrderAndId($foodname, $drinkname, $tkname, $tkemail, $tkphone, $id) {
        if($foodname != "") {
            $this->foodname = $foodname;
            $this->drinkname = $drinkname;
            $this->tkname = $tkname;
            $this->tkemail = $tkemail;
            $this->tkphone = $tkphone;
            $this->id = $id;
            return true;
        } else {
            return false;
        }
    }

    //Skapa order i databasen
    public function createOrder($foodname, $drinkname, $tkname, $tkemail, $tkphone) {
        if (!$this->setFoodName($foodname)) return false;
        if (!$this->setDrinkName($drinkname)) return false;
        if (!$this->setTKName($tkname)) return false;
        if (!$this->setTKEmail($tkemail)) return false;
        if (!$this->setTKPhone($tkphone)) return false;

        //Lite säkerhet
        $this->foodname = $this->db->real_escape_string($this->foodname);
        $this->drinkname = $this->db->real_escape_string($this->drinkname);
        $this->tkname = $this->db->real_escape_string($this->tkname);
        $this->tkemail = $this->db->real_escape_string($this->tkemail);
        $this->tkphone = $this->db->real_escape_string($this->tkphone);


        $this->foodname = strip_tags($this->foodname, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->drinkname = strip_tags($this->drinkname, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->tkname = strip_tags($this->tkname, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->tkemail = strip_tags($this->tkemail, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->tkphone = strip_tags($this->tkphone, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');

        $sql = "INSERT INTO takeaway(foodname, drinkname, tkname, tkemail, tkphone)VALUES('". $this->foodname . "', '" . $this->drinkname . "', '" . $this->tkname . "', '" . $this->tkemail . "', '" . $this->tkphone . "');";

        //Send sql query
        return mysqli_query($this->db, $sql);
    }

    //Uppdatera befintlig order i databasen
    public function updateOrder($foodname, $drinkname, $tkname, $tkemail, $tkphone) {
        if (!$this->setFoodName($foodname)) return false;
        if (!$this->setDrinkName($drinkname)) return false;
        if (!$this->setTKName($tkname)) return false;
        if (!$this->setTKEmail($tkemail)) return false;
        if (!$this->setTKPhone($tkphone)) return false;

        //Lite säkerhet
        $this->foodname = $this->db->real_escape_string($this->foodname);
        $this->drinkname = $this->db->real_escape_string($this->drinkname);
        $this->tkname = $this->db->real_escape_string($this->tkname);
        $this->tkemail = $this->db->real_escape_string($this->tkemail);
        $this->tkphone = $this->db->real_escape_string($this->tkphone);

        $this->foodname = strip_tags($this->foodname, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->drinkname = strip_tags($this->drinkname, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->tkname = strip_tags($this->tkname, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->tkemail = strip_tags($this->tkemail, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->tkphone = strip_tags($this->tkphone, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');

        $sql = "UPDATE takeaway SET foodname='". $this->foodname . "', drinkname='" . $this->drinkname . "', tkname='" . $this->tkname . "', tkemail='" . $this->tkemail . "', tkphone='" . $this->tkphone . "' WHERE id=" . $this->id . ";";

        return mysqli_query($this->db, $sql);
    }

    //Ta bort en order ur databasen
    public function deleteOrder($id) {
        $id = intval($id);

        $sql = "DELETE FROM takeaway WHERE id=$id;";

        return mysqli_query($this->db, $sql);
    }



}