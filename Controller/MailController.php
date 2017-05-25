<?php
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

include_once('Model/Mail.php');
require_once 'Session.php';


class MailController {
    public function mailer(){
        if(isset($_POST['sendEmail'])){
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message']) || (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false))
                {
                $session = new Session();
                $session->setFlash("Empty fields or invalid email address, pleasy try again");
                $session->flash();
                }else{
        $datas = new Mail([
        'Name' => $_POST['name'],
        'Mail' => $_POST['email'],
        'Message' => $_POST['message']
        ]);
        $datas->sendMail();
        $session = new Session();
        $session->setFlash('Your message has been sent ! Thanks', 'success');
        $session->flash();
        }
    }
}}