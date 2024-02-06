<?php

include "SMTP.php";
include "Exception.php";
include "PHPMailer.php";

use PHPMailer\PHPMailer\PHPMailer;

class Send{

    public function __construct($subject, $content, $receiver_email){

        return $this->send($subject, $content, $receiver_email);
    }

    public function send($subject, $content, $receiver_email){

        $sender_email = 'dev.mail.darshana@gmail.com';
        $app_password = 'eebl zelr oueu snww';
        $website_name = 'HowsApp';

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username =  $sender_email;
        $mail->Password = $app_password;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom($sender_email, $website_name);
        $mail->addReplyTo($sender_email, $website_name);
        $mail->addAddress($receiver_email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $bodyContent = $content;
        // $bodyContent .= '';
        $mail->Body    = $bodyContent;

        if(!$mail->send()){
            return false;
        }
        else{
            return true;
        }
    }
}
