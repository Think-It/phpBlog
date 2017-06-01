<?php
namespace Natinho68\Services;
use Natinho68\Controllers\Notification;
use Natinho68\Models\Mail;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Services
 *
 * @author nathanmeyer
 */
class Services {

    public function uploadImg(){
        $folder = 'img/uploads';
        $file = basename($_FILES['image']['name']);
        $sizeMax = 4000000;
        $size = filesize($_FILES['image']['tmp_name']);
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($_FILES['image']['name'], '.'); 
        //Security verification
            if(empty($file)){
                $notification = new Notification();
                $notification->setFlash("No featured image uploaded ...", "warning");
                $notification->flash();
                
            } else {
            if(!in_array($extension, $extensions)) //if extensions aren't in the array
            {
                 $erreur = new Notification();
                 $erreur->setFlash("You must upload a file of type png, gif, jpg or jpeg ...");
                 $erreur->flash();
                 die();
                 
            }
            if($size>$sizeMax)
            {
                 $erreur = new Notification();
                 $erreur->setFlash("File too large...");
                 $erreur->flash();
                 die();
                 
            }
            if(!isset($erreur)) //if no errors, upload
            {
                 //file name formating
                 $file = rand().$extension;
                 if(move_uploaded_file($_FILES['image']['tmp_name'], $folder.'/'.$file)) //if true, upload ok
                 {
                      $path = $folder.'/'.$file;
                      return $path;
                 }
                 else //else return false.
                 {
                      $erreur = new Notification();
                      $erreur->setFlash("Fail to upload !");
                      $erreur->flash();
                      die();
                 }
            }
        }        
    }

    public function sendMail(){
        /*
        
        $emailTo = "nathan.meyer-pro@live.fr";   
        $emailSubject = "Contact form : New message from " . $this->name;

        $emailMessage = "Name: ".$this->name."\n";
        $emailMessage .= "Email: ".$this->mail."\n \n";
        $emailMessage .= "Message: \n".$this->message."\n";

        $headers = 'From: '.$this->mail."\r\n".
        $headers = 'Content-Type: text/plain; charset=utf-8';
        'Reply-To: '.$this->mail."\r\n" .
        'X-Mailer: PHP/' . phpversion();

        mail($emailTo, $emailSubject, $emailMessage, $headers);
         */
        
    }
    
}
