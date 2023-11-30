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

$order = new Order();

switch ($method) {
    case 'GET':
        if(isset($id)) {
            $response = $order->getOrderById($id);
        } else {
            $response = $order->getOrder();
        }
        
        if(count($response) === 0) {
            $response = array("message" => "Det finns inga ordrar i databasen.");
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
            if($order->createOrder($data['foodname'], $data['drinkname'], $data['tkname'], $data['tkemail'], $data['tkphone'])) {
                $response = array("message" => "Ordern är tillagd " . $data['foodname'], $data['drinkname'], $data['tkname'], $data['tkemail'], $data['tkphone']);
                http_response_code(201);
            } else {
                http_response_code(500);
                $response = array("message" => "Fel vid lagring av ordern" . $data['foodname'], $data['drinkname'], $data['tkname'], $data['tkemail'], $data['tkphone']);
            }
        } else {
            $response = array("message" => "Skicka med information om ordern");
            http_response_code(400);
        }
        break;
    case 'PUT':
        //Läser in JSON-data
        $data = json_decode(file_get_contents("php://input"), true);

        if($order->setOrderAndId($data['foodname'], $data['drinkname'], $data['tkname'], $data['tkemail'], $data['tkphone'], $data['id'])) {
            if($order->updateOrder($data['foodname'], $data['drinkname'], $data['tkname'], $data['tkemail'], $data['tkphone'])) {
                $response = array("message" => "Ordern är uppdaterad");
                http_response_code(200);
            } else {
                http_response_code(500);
                $response = array("message" => "Fel vid uppdatering av ordern");
            }
        } else {
            $response = array("message" => "Skicka med information om ordern");
            http_response_code(400);
        }
        break;
    case 'DELETE':
        if (!isset($id)) {
            http_response_code(400);
            $response = array("message" => "Skicka med id på ordern som ska raderas");
        } else {
            if($order->deleteOrder($id)){
                http_response_code(200);
                $response = array("message" => "Ordern är raderad från databasen");
            }
        }
        break;
}

// Skicka tillbaka svar
echo json_encode($response);
