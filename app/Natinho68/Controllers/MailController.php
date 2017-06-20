<?php
namespace Natinho68\Controllers;
use Natinho68\Models\Mail;
use Natinho68\Services\Mailer;
use Natinho68\Services\Notification;

/**
 * Class MailController check if emails contain errors and display notifications handler
 */
class MailController {
    /**
     * Check if email contains errors and display notifications
     */
    public function mailer(){
        // Instance of notification
        $notification = new Notification();
        // if empty form
        if(isset($_POST['sendEmail'])){
            if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message']) || (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false))
                {
                // save datas in session
                $_SESSION['emailDatas'] = $_POST;
                // set the error message
                $notification->setFlash("Empty fields or invalid email address, pleasy try again");
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit();
                
                // no errors, create Mail object
                }else{
                $datas = new Mail([
                'Name' => $_POST['name'],
                'Mail' => $_POST['email'],
                'Message' => $_POST['message']
                ]);
                // instance of Mailer service
                $mailService = new Mailer();
                // sending the mail with datas
                $mailService->sendMail($datas->name(), $datas->mail(), $datas->message());
                unset($_SESSION['emailDatas']);
                // set success notification message
                $notification->setFlash('Your message has been sent ! Thanks', 'success');
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit();
                }
        
        // display notifications
        } else {
          $notification->flash();
        } 
    } 

}