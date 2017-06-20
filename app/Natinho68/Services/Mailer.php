<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Natinho68\Services;
use Natinho68\Models\Mail;
/**
 * Description of Mailer
 *
 * @author nathanmeyer
 */
class Mailer {
    public function sendMail($name, $email, $message){
       
        $emailTo = "nathan.meyer-pro@live.fr";   
        $emailSubject = "Contact form : New message from " . $name;

        $emailMessage = "Name: ".$name."\n";
        $emailMessage .= "Email: ".$email."\n \n";
        $emailMessage .= "Message: \n".$message."\n";

        $headers = 'From: '.$email."\r\n".
        $headers = 'Content-Type: text/plain; charset=utf-8';
        'Reply-To: '.$email."\r\n" .
        'X-Mailer: PHP/' . phpversion();

        mail($emailTo, $emailSubject, $emailMessage, $headers);

    }
}
