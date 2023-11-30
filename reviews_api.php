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

$review = new Review();

switch ($method) {
    case 'GET':
        if(isset($id)) {
            $response = $review->getReviewById($id);
        } else {
            $response = $review->getReview();
        }
        
        if(count($response) === 0) {
            $response = array("message" => "Det finns inga recensioner i databasen.");
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

        if($data != "") {
            if($review->createReview($data['reviewname'], $data['text'], $data['rate'], $data['status'])) {
                $response = array("message" => "Recensionen är tillagd ");
                http_response_code(201);
            } else {
                http_response_code(500);
                $response = array("message" => "Fel vid lagring av recensionen" + $data['reviewname'], $data['text'], $data['rate'], $data['status']);
            }
        } else {
            $response = array("message" => "Skicka med information om recensionen");
            http_response_code(400);
        }
        break;
    case 'PUT':
        //Läser in JSON-data
        $data = json_decode(file_get_contents("php://input"), true);

        if($review->setReviewAndId($data['reviewname'], $data['text'], $data['rate'], $data['status'], $data['id'])) {
            if($review->updateReview($data['reviewname'], $data['text'], $data['rate'], $data['status'])) {
                $response = array("message" => "Recensionen är uppdaterad");
                http_response_code(200);
            } else {
                http_response_code(500);
                $response = array("message" => "Fel vid uppdatering av recesionen");
            }
        } else {
            $response = array("message" => "Skicka med information om recensionen");
            http_response_code(400);
        }
        break;
    case 'DELETE':
        if (!isset($id)) {
            http_response_code(400);
            $response = array("message" => "Skicka med id på recensionen som ska raderas");
        } else {
            if($review->deleteReview($id)){
                http_response_code(200);
                $response = array("message" => "Recensionen är raderad från databasen");
            }
        }
        break;
}

// Skicka tillbaka svar
echo json_encode($response);
