<?php
namespace natinho68\Controllers;
use natinho68\Models\Mail;
use natinho68\Controllers\Session;
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



class MailController {
    public function mailer(){
        $session = new Session();
        if(isset($_POST['sendEmail'])){
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message']) || (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false))
                {
                $_SESSION['emailDatas'] = $_POST;
                $session->setFlash("Empty fields or invalid email address, pleasy try again");
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
                $session->setFlash('Your message has been sent ! Thanks', 'success');
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit();
                }
                
        } else {
          $session->flash();
        }
    }

}