<?php

/* 
* MackorCo - Wenntjänst - Projektuppgift
* Kurs: Webbutveckling III - DT173G
* Utvecklare: Jeanette Krantz 
*/


class Presentation {
    private $id;
    private $text;
    private $db;

    function __construct() {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if($this->db->connect_errno > 0) {
            die("Fel vid anslutning: " . $this->db->connect_error);
        }
    }

    //Hämta text från databas
    public function getText() {
        $sql = "SELECT * FROM presentation;";
        $result = mysqli_query($this->db, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //Hämta text från databas med specifikt id
    public function getTextById($id) {
        $id = intval($id);
        $sql = "SELECT * FROM presentation WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();
    }

    //Setmetoder
    public function setText($text) {
        if($text != "") {
            $this->text = $text;
            return true;
        } else {
            return false;
        }
    }

    public function setTextAndId($text, $id) {
        if($text != "") {
            $this->text = $text;
            $this->id = $id;
            return true;
        } else {
            return false;
        }
    }

    //Skapa ny text i databas
    public function createText($text) {
        if (!$this->setText($text)) return false;

        //Lite säkerhet
        $this->text = $this->db->real_escape_string($this->text);

        $this->text = strip_tags($this->text, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        
        $sql = "INSERT INTO presentation(text)VALUES('". $this->text . "');";

        //Send sql query
        return mysqli_query($this->db, $sql);
    }

    //Uppdatera befintlig text i databas
    public function updateText($text) {
        if (!$this->setText($text)) return false;

        //Lite säkerhet
        $this->text = $this->db->real_escape_string($this->text);

        $this->text = strip_tags($this->text, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');

        $sql = "UPDATE presentation SET text='". $this->text . "' WHERE id=" . $this->id . ";";

        return mysqli_query($this->db, $sql);
    }

        //Ta bort text
        public function deleteText($id) {
            $id = intval($id);
    
            $sql = "DELETE FROM presentation WHERE id=$id;";
    
            return mysqli_query($this->db, $sql);
        }
}