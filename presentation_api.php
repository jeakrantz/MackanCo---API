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

$text = new Presentation();

switch ($method) {
    case 'GET':
        if (isset($id)) {
            $response = $text->getTextById($id);
        } else {
            $response = $text->getText();
        }

        if (count($response) === 0) {
            $response = array("message" => "Det finns inga texter i databasen.");
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

        if (count($data) === 0) {
            $response = array("message" => "Skicka med en text");
            http_response_code(400);
        } else {
            if ($text->createText($data['text'])) {
                $response = array("message" => "Texten är tillagd");
                http_response_code(201);
            } else {
                http_response_code(500);
                $response = array("message" => "Fel vid lagring av texten");
            }
        }
        break;
    case 'PUT':
        //Läser in JSON-data
        $data = json_decode(file_get_contents("php://input"), true);

        if ($text->setTextAndId($data['text'], $data['id'])) {
            if ($text->updateText($data['text'])) {
                $response = array("message" => "Texten är uppdaterad");
                http_response_code(200);
            } else {
                http_response_code(500);
                $response = array("message" => "Fel vid uppdatering av texten");
            }
        } else {
            $response = array("message" => "Skicka med en text.");
            http_response_code(400);
        }
        break;
    case 'DELETE':
        if (!isset($id)) {
            http_response_code(400);
            $response = array("message" => "Skicka med id på texten som ska raderas");
        } else {
            if ($text->deleteText($id)) {
                http_response_code(200);
                $response = array("message" => "Texten är raderad från databasen");
            }
        }
        break;
}

// Skicka tillbaka svar
echo json_encode($response);
