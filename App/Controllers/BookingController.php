<?php

namespace Controllers;

use Services\Validator;
class BookingController
{
    public function sendEmail(): array
    {
        $validate = new Validator();
        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if($validate->validatePost($input)) {
            return $validate->unprocessableEntityResponse();
        }

        $firstName = $validate->inputValidation($input['firstName']);
        $lastName = $validate->inputValidation($input['lastName']);
        $email = $validate->inputValidation($input['email']);
        $phoneNumber = $validate->inputValidation($input['phoneNumber']);
        $dateTime = $validate->inputValidation($input['datetime']);
        $date = date_create($dateTime);
        $formattedDate = date_format($date, 'd-m-Y');
        $formattedTime = date_format($date, 'H:i:s');
        $device = $validate->inputValidation($input['device']);

        $email_from = $email;
        $to = "info@techrepairoutpost.com";
        $headers = "From: $email_from \r\n";
        $headers .= "Reply-To: $email \r\n";
        $email_subject = "New Booking Made!";
        $email_body = "You have received a new booking from the customer $firstName $lastName.\n".
            "They would like to have their:\n $device repaired at $formattedTime on $formattedDate.\n Contact Details:\n Email: $email\n phone: $phoneNumber.";
        mail($to,$email_subject,$email_body,$headers);

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['message' => 'Contact Email Sent']);
        return $response;
    }
}