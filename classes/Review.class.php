<?php

/* 
* MackorCo - Wenntjänst - Projektuppgift
* Kurs: Webbutveckling III - DT173G
* Utvecklare: Jeanette Krantz 
*/


class Review {
    private $id;
    private $reviewname;
    private $text;
    private $rate; 
    private $status;
    private $db;

    function __construct() {
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if($this->db->connect_errno > 0) {
            die("Fel vid anslutning: " . $this->db->connect_error);
        }
    }

    //Hämta recension
    public function getReview() {
        $sql = "SELECT * FROM reviews ORDER BY create_date DESC;";
        $result = mysqli_query($this->db, $sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //Hämta specifik recension med id
    public function getReviewById($id) {
        $id = intval($id);
        $sql = "SELECT * FROM review WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);
        return $result->fetch_assoc();
    }

    //Set-metoder
    public function setReviewName($reviewname) {
        if($reviewname != "") {
            $this->reviewname = $reviewname;
            return true;
        } else {
            return false;
        }
    }

    public function setText($text) {
        if($text != "") {
            $this->text = $text;
            return true;
        } else {
            return false;
        }
    }
    public function setRate($rate) {
        if($rate != "") {
            $this->rate = $rate;
            return true;
        } else {
            return false;
        }
    }
    public function setStatus($status) {
        if($status != "") {
            $this->status = $status;
            return true;
        } else {
            return false;
        }
    }

    public function setReviewAndId($reviewname, $text, $rate, $status, $id) {
        if($reviewname != "") {
            $this->reviewname = $reviewname;
            $this->text = $text;
            $this->rate = $rate;
            $this->status = $status;
            $this->id = $id;
            return true;
        } else {
            return false;
        }
    }

    //Skapa recesion i databasen
    public function createReview($reviewname, $text, $rate, $status) {
        if (!$this->setReviewName($reviewname)) return false;
        if (!$this->setText($text)) return false;
        if (!$this->setRate($rate)) return false;
        if (!$this->setStatus($status)) return false;

        //Lite säkerhet
        $this->reviewname = $this->db->real_escape_string($this->reviewname);
        $this->text = $this->db->real_escape_string($this->text);
        $this->rate = $this->db->real_escape_string($this->rate);
        $this->status = $this->db->real_escape_string($this->status);


        $this->reviewname = strip_tags($this->reviewname, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->text = strip_tags($this->text, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->rate = strip_tags($this->rate, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->status = strip_tags($this->status, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');

        $sql = "INSERT INTO reviews(reviewname, text, rate, status)VALUES('". $this->reviewname . "', '" . $this->text . "', '" . $this->rate . "', '" . $this->status . "');";

        //Send sql query
        return mysqli_query($this->db, $sql);
    }

    //Uppdatera befintlig recension i databasen
    public function updateReview($reviewname, $text, $rate, $status) {
        if (!$this->setReviewName($reviewname)) return false;
        if (!$this->setText($text)) return false;
        if (!$this->setRate($rate)) return false;
        if (!$this->setStatus($status)) return false;

        //Lite säkerhet
        $this->reviewname = $this->db->real_escape_string($this->reviewname);
        $this->text = $this->db->real_escape_string($this->text);
        $this->rate = $this->db->real_escape_string($this->rate);
        $this->status = $this->db->real_escape_string($this->status);


        $this->reviewname = strip_tags($this->reviewname, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->text = strip_tags($this->text, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->rate = strip_tags($this->rate, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');
        $this->status = strip_tags($this->status, '<p><h1><h2><h3><h4><strong><i><ul><li><ol>');

        $sql = "UPDATE reviews SET reviewname='". $this->reviewname . "', text='" . $this->text . "', rate='" . $this->rate . "', status='" . $this->status . "' WHERE id=" . $this->id . ";";

        var_dump($sql);

        return mysqli_query($this->db, $sql);
    }

    //Ta bort en recension ur databasen
    public function deleteReview($id) {
        $id = intval($id);

        $sql = "DELETE FROM reviews WHERE id=$id;";

        return mysqli_query($this->db, $sql);
    }



}