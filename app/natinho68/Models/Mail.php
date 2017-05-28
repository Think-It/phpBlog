<?php
namespace natinho68\Models;
class Mail{
    
    private $name;
    private $mail;
    private $message;
    
    public function __construct(array $datas)
    {
    $this->hydrate($datas);
    }
    
    public function hydrate(array $datas)
    {
    foreach ($datas as $key => $value)
        {
        $method = 'set'.ucfirst($key);
      
    if (method_exists($this, $method))
        {
        $this->$method($value);
        }
      }
    }
    
    // Getters
    public function name()
    {
    return $this->name;
    }

    public function mail()
    {
    return $this->mail;
    }
    
    public function message(){
        return $this->message;
    }
    
    // Setters
    
    public function setName($name)
    {
    if (is_string($name))
        {
        $this->name = $name;
        }
    }
    
    public function setMail($mail)
    {
    if (is_string($mail))
        {
        $this->mail = $mail;
        }
    }
    
    public function setMessage($message)
    {
    if (is_string($message))
        {
        $this->message = $message;
        }
    }
    
    public function sendMail(){
        
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
    }
    
}
