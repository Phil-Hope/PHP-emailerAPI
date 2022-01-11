<?php

namespace Controllers;

use Services\Validator;

class ContactController
{
    public function sendEmail(): array
    {
        $validate = new Validator();
        $input = (array)json_decode(file_get_contents('php://input'), TRUE);
        if($validate->validatePost($input)) {
            return $validate->unprocessableEntityResponse();
        }

        $email = $validate->inputValidation($input['email']);
        $firstName = $validate->inputValidation($input['firstName']);
        $lastName = $validate->inputValidation($input['lastName']);
        $phoneNumber = $validate->inputValidation($input['phoneNumber']);
        $message = $validate->inputValidation($input['message']);

        $email_from = $email;
        $to = "info@techrepairoutpost.com";
        $headers = "From: $email_from \r\n";
        $headers .= "Reply-To: $email \r\n";
        $email_subject = "New Contact Request Made!";
        $email_body = "You have received a new contact request from customer: $firstName $lastName.\n".
           "Contact Details:\n Email: $email\n phone: $phoneNumber.\n".
           "Message: $message";
        mail($to,$email_subject,$email_body,$headers);

        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['message' => 'Contact Email Sent']);
        return $response;
    }

}