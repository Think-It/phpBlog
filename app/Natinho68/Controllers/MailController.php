<?php
/**
 * Description of MailController
 *
 * @author nathanmeyer
 */
namespace Natinho68\Controllers;


use Natinho68\Models\Mail;
use Natinho68\Services\Mailer;
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
                $mailService = new Mailer();
                $mailService->sendMail($datas->name(), $datas->mail(), $datas->message());
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