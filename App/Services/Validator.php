<?php

namespace Services;

class Validator
{
    /**
     * @param $input
     * @return bool
     */
    public function validatePost($input): bool
    {
        if (! isset($input['title'])) {
            return false;
        }
        if (! isset($input['body'])) {
            return false;
        }
        return true;
    }
    /**
     * @param $input
     * @return string
     */
    public function inputValidation($input): string
    {
        $data = strip_tags($input);
        $data = htmlspecialchars($data);
        return stripcslashes($data);
    }

    /**
     * @return array
     */
    public function unprocessableEntityResponse(): array
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }
}