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
        $datas = new Mail([
        'Name' => $_POST['name'],
        'Mail' => $_POST['email'],
        'Message' => $_POST['message']
        ]);
        $datas->sendMail();
        
        }
    }
}