<?php

use Controllers\BookingController;
use Controllers\ContactController;
require $_SERVER['DOCUMENT_ROOT'].'/bootstrap.php';

session_start();
header("Access-Control-Allow-Origin: https://techrepairoutpost.web.app");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Accept-Type");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod === 'POST') {
    if (isset($uri)) {
        switch ($uri[1]) {
            case 'contact': $contactEmail = new ContactController();
            try {
                $contactEmail->sendEmail();
            } catch (Exception $e) {
                $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
                $response['body'] = json_encode(['message' => 'ERROR MESSAGE: '
                    .$e->getMessage().' ERROR CODE: '
                    .$e->getCode()
                    . 'Failed to send contact email!']);
                return $response;
            }
            break;
            case 'booking': $bookingEmail = new BookingController();
            try {
                $bookingEmail->sendEmail();
            } catch(Exception $e) {
                $response['status_code_header'] = 'HTTP/1.1 500 Internal Server Error';
                $response['body'] = json_encode(['message' =>
                    'ERROR MESSAGE: '
                    .$e->getMessage().' ERROR CODE: '
                    .$e->getCode()
                    .' Failed to send booking email!']);
                return $response;
            }
            break;
            default:
                $response['status_code_header'] = 'HTTP/1.1 400 Bad Request Error';
                $response['body'] = json_encode(['message' => 'Request Failed: Invalid URI supplied!']);
                return $response;
        }
    }
} else {
    $response['status_code_header'] = 'HTTP/1.1 400 Bad Request Error';
    $response['body'] = json_encode(['message' => 'Request Failed: Wrong Request Method!']);
    return $response;
}
