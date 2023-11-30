<?php
include("config.php");

/* 
* MackorCo - Wenntjänst - Projektuppgift
* Kurs: Webbutveckling III - DT173G
* Utvecklare: Jeanette Krantz 
*/


//Anslut
$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
if($db->connect_errno > 0) {
    die("Fel vid anslutning: " . $db->connect_error);
}

// SQL-frågor
$sql = "DROP TABLE IF EXISTS user;";

$sql .= "
CREATE TABLE user(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR (128) NOT NULL,
    password VARCHAR (256) NOT NULL
); 
";

$sql .= "
INSERT INTO user(username, password) VALUES ('admin','sandwichpassword'); 
";

$sql .= "DROP TABLE IF EXISTS food;";

$sql .= "
CREATE TABLE food(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR (128) NOT NULL,
    price VARCHAR (11) NOT NULL,
    ingredients VARCHAR (256)
); 
";

$sql .= "
INSERT INTO food(name, price, ingredients) VALUES ('Ostfralla','12','Ost, fralla'); 
";

$sql .= "DROP TABLE IF EXISTS drink;";

$sql .= "
CREATE TABLE drink(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR (128) NOT NULL,
    price VARCHAR (11) NOT NULL
); 
";

$sql .= "
INSERT INTO drink(name, price) VALUES ('Mjölk','10'); 
";

$sql .= "DROP TABLE IF EXISTS presentation;";

$sql .= "
CREATE TABLE presentation(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    text TEXT NOT NULL
); 
";

$sql .= "
INSERT INTO presentation(text) VALUES ('En kort presentation...'); 
";


$sql .= "DROP TABLE IF EXISTS takeaway;";

$sql .= "
CREATE TABLE takeaway(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    foodname VARCHAR (128) NOT NULL,
    drinkname VARCHAR (128) NOT NULL,
    tkname VARCHAR (128) NOT NULL, 
    tkemail VARCHAR (128) NOT NULL,
    tkphone INT(11) NOT NULL,
    create_date timestamp NOT NULL DEFAULT current_timestamp()
); 
";

$sql .= "DROP TABLE IF EXISTS reviews;";

$sql .= "
CREATE TABLE reviews(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    reviewname VARCHAR (128) NOT NULL,
    text TEXT NOT NULL,
    rate INT (1) NOT NULL, 
    status INT (1) NOT NULL,
    create_date timestamp NOT NULL DEFAULT current_timestamp()
); 
";

$sql .= "
INSERT INTO reviews(reviewname, text, rate, status) VALUES ('Olle', 'Har ätit bättre mackor', 2, 1); 
";

echo "<pre>$sql</pre>";

//Skicka SQL-frågorna till server
if($db -> multi_query($sql)) {
    echo "Tabell installerad.";
} else {
    echo "Fel vid installation av tabell.";
}

$db->close();

?>