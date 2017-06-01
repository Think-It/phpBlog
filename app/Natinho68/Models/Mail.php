<?php
namespace Natinho68\Models;
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

    
}
