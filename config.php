<?php

/* 
* MackorCo - Wenntjänst - Projektuppgift
* Kurs: Webbutveckling III - DT173G
* Utvecklare: Jeanette Krantz 
*/


//inkludera klasser
spl_autoload_register(function ($class_name) {
    include 'classes/' . $class_name . '.class.php'; //sökväg till mappen för klasser
});

$devmode = false;

if($devmode) {
    // Aktivera felrapportering
    error_reporting(-1);
    ini_set("display_errors", 1);  

    //Databas-inställningar - lokalt 
    define("DBHOST", "localhost");
    define("DBUSER", "restaurant");
    define("DBPASS", "password");
    define("DBDATABASE", "restaurant");
} else {
    //Databas-inställningar - publicerat
    define("DBHOST", "studentmysql.miun.se");
    define("DBUSER", "jekr2201");
    define("DBPASS", "F@hJttm3AL");
    define("DBDATABASE", "jekr2201"); 
}

?>