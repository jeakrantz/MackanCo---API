<?php


/* 
* MackorCo - Wenntjänst - Projektuppgift
* Kurs: Webbutveckling III - DT173G
* Utvecklare: Jeanette Krantz 
*/

/* // Webbtjänsten kan kommas åt från dessa domäner (* = alla) */

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

header('Content-Type: application/json');

header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With, Access-Control-Request-Method, Access-Control-Request-Headers, Authorization, X-API-KEY, Origin');

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "OPTIONS") {

    die();
}

$apikey = "21967af6-237b-4b5e-9dae-9f710b802c4e";

if (!isset($_SERVER['HTTP_X_API_KEY'])) {

    http_response_code(401);
    $response = array("message" => "Ingen API-nyckel skickad");

    echo json_encode($response);

    exit;
} else {
    //Kontroll om skickad Api-nyckel stämmer
    if (isset($_SERVER['HTTP_X_API_KEY']) === $apikey) {

        http_response_code(200);
        $response = array("message" => "Tillgång till API");
    }
} 
