<?php
include("config.php");
include("header.php"); //För authentisering

/* // Headers med inställningar för REST webbtjänst

// Webbtjänsten kan kommas åt från dessa domäner (* = alla)
header('Access-Control-Allow-Origin: *');

//Webbtjänsten skickar data i JSON-format
header('Content-Type: application/json');

//Metoder som tillåts
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');

//Tillåtna headers från klient-sidan
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

 */
//Om id-parameter finns lagras den
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$user = new User();

switch ($method) {
    case 'GET':
        if(isset($id)) {
            $response = $user->getUserById($id);

        } else {
            $response = $user->getUser();
        }

        if(count($response) === 0) {
            $response = array("message" => "Det finns inga användare");
            //Skickar respons-code
            http_response_code(404); 
        } else {
            //Skickar respons-code
            http_response_code(200);
        } 
        break;
        case 'POST':
            //Läser in JSON-data
            $data = json_decode(file_get_contents("php://input"), true);
    
            if(count($data) === 0) {
                $response = array("message" => "Skicka med information om ánvändaren");
                http_response_code(400);
            } else {
                if($user->registerUser($data['username'], $data['password'])) {
                    $response = array("message" => "Användaren är tillagd");
                    http_response_code(201);
                } else {
                    http_response_code(500);
                    $response = array("message" => "Fel vid lagring av användaren");
                }
            }
            break;
}

// Skicka tillbaka svar
echo json_encode($response);
