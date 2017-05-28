<?php
namespace natinho68\Models;
Class Post{

    private $_id;
    private $_title;
    private $_content;
    private $_author;
    private $_date;
    private $_header;
    private $_featuredImg;
    
      
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
    public function id()
    {
    return $this->_id;
    }
  
    public function title()
    {
    return $this->_title;
    }
  
    public function content()
    {
    return $this->_content;
    }

    public function author()
    {
    return $this->_author;
    }
    
    public function date()
    {
    return $this->_date;
    }
    
    public function header()
    {
    return $this->_header;
    }
    
    public function featuredImg()
    {
    return $this->_featuredImg;
    }
    
    // Setters
    public function setId($id)
    {
    $id = (int) $id;
    
    if ($id > 0)
        {
        $this->_id = $id;
        }
    }
    
    public function setTitle($title)
    {
    if (is_string($title))
        {
        $this->_title = $title;
        }
    }

    public function setContent($content)
    {
    if (is_string($content))
        {
        $this->_content = $content;
        }
    }

    public function setAuthor($author)
    {
    if (is_string($author))
        {
        $this->_author = $author;
        }
    }  

    public function setDate($date)
    {
    if (is_string($date) == true)
        {
        $this->_date = $date;
        }
    }
    
    public function setHeader($header)
    {
    if (is_string($header))
        {
        $this->_header = $header;
        }
    }
    
    public function setFeaturedImg($featuredImg)
    {
    if (is_string($featuredImg))
        {
        $this->_featuredImg = $featuredImg;
        }
    }
    
}