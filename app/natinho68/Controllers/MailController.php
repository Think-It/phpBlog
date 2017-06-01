<?php
namespace Natinho68\Controllers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MailController
 *
 * @author nathanmeyer
 */

use Natinho68\Models\Mail;
use Natinho68\Controllers\Notification;


class MailController {
    public function mailer(){
        $notification = new Notification();
        if(isset($_POST['sendEmail'])){
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message']) || (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false))
                {
                $_SESSION['emailDatas'] = $_POST;
                $notification->setFlash("Empty fields or invalid email address, pleasy try again");
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit();
                
                
                }else{
                $datas = new Mail([
                'Name' => $_POST['name'],
                'Mail' => $_POST['email'],
                'Message' => $_POST['message']
                ]);
                $datas->sendMail();
                unset($_SESSION['emailDatas']);
                $notification->setFlash('Your message has been sent ! Thanks', 'success');
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit();
                }
                
        } else {
          $notification->flash();
        }
    }

}