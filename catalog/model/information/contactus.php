<?php

class ModelInformationContactUs extends Model
{
    const SMTP_HOSTNAME = "";
    const SMTP_PORT = "";
    const SMTP_USERNAME = "";
    const SMTP_PASSWORD = "";

    public function sendMail(Array $data): bool{
        // Sender info
        $email_from = $data["mailFrom"];
        $firstname = $data["firstname"];
        $surname = $data["surname"];

        // Message info
        $message_type = $data["messageBody"];
        $message_body = $data["messageType"];

        // use wordwrap() if lines are longer than 70 characters
        $message_body = wordwrap($message_body,70);

        // Generate the header for the email
        $header = self::generateHeader($email_from);

        // mail()

        return True;
    }

    private function generateHeader(string $from): string {
        $headers ="
            MIME-Version: 1.0" . "\r\n" .
            "Content-type:text/html;charset=UTF-8" . "\r\n" .
            "From: %s" . "\r\n";

        return sprintf($headers, $from);
    }
}