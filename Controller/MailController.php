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
include_once('Mail.php');

class MailController {
    public function mailer(){
        if(isset($_POST['sendEmail'])){
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message']) || (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false))
                {
                    echo '<div class="alert alert-danger" role="alert">Empty fields or invalid email, please try again</div>';
                }else{
        $datas = new Mail([
        'Name' => $_POST['name'],
        'Mail' => $_POST['email'],
        'Message' => $_POST['message']
        ]);
        $datas->sendMail();
        echo '<div class="alert alert-success" role="alert">Your message has been sent ! Thanks</div>';
        }
    }
}}