<?php
namespace natinho68\Models;
class SPDO
{
  /**
   * Instance de la classe SPDO
   *
   * @var SPDO
   * @access private
   */ 
  private $PDOInstance = null;
 
  /**
   * Constante: nom d'utilisateur de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_USER = 'root';
 
  /**
   * Constante: hôte de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_HOST = 'localhost';
 
  /**
   * Constante: hôte de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_PASS = 'root';
 
  /**
   * Constante: nom de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_DTB = 'blogtwig';
 
  /**
   * Constructeur
   *
   * @param void
   * @return void
   * @see PDO::__construct()
   */ 
  public function __construct()
  {
      $this->PDOInstance = new \PDO('mysql:dbname='.self::DEFAULT_SQL_DTB.';host='.self::DEFAULT_SQL_HOST,self::DEFAULT_SQL_USER ,self::DEFAULT_SQL_PASS);
  }
  
    public static function getInstance()
  {  
    if(is_null(self::$instance))
    {
      self::$instance = new SPDO();
    }
    return self::$instance;
  }
 
  /**
   * Exécute une requête SQL avec PDO
   *
   * @param string $query La requête SQL
   * @return PDOStatement Retourne l'objet PDOStatement
   */
  public function query($query)
  {
    return $this->PDOInstance->query($query);
  }
  
  public function prepare($query)
  {
    return $this->PDOInstance->prepare($query);
  }
  
    public function fetch($query)
  {
    return $this->PDOInstance->fetch($query);
  }
  
  public function exec($query)
  {
    return $this->PDOInstance->exec($query);
  }
}
