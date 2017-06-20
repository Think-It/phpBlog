<?php
namespace Natinho68\Services;
use Natinho68\Models\Mail;
/**
 * Class Mailer is the config email sending method
 *
 */
class Mailer {
    /**
     * Send the mail with user datas
     * 
     * @param string $name user input form name
     * @param string $email user input form email adress
     * @param string $message user input form message
     */
    public function sendMail($name, $email, $message){
        // email adress reception
        $emailTo = "nathan.meyer-pro@live.fr";   
        // email subject
        $emailSubject = "Contact form : New message from " . $name;
        
        // Message datas
        $emailMessage = "Name: ".$name."\n";
        $emailMessage .= "Email: ".$email."\n \n";
        $emailMessage .= "Message: \n".$message."\n";
        
        // headers
        $headers = 'From: '.$email."\r\n".
        $headers = 'Content-Type: text/plain; charset=utf-8';
        'Reply-To: '.$email."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        
        // sending
        mail($emailTo, $emailSubject, $emailMessage, $headers);
    }
}
