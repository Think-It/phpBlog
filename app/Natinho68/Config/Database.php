<?php
namespace Natinho68\Config;
/**
 * Class Database access to db and execute sql query with PDO
 */
class Database
{
  /**
   * Instance of Database class
   *
   * @var Database
   * @access private
   */ 
  private $PDOInstance = null;
 
  /**
   * Constant: username of db
   *
   * @var string
   */
  const DEFAULT_SQL_USER = 'root';
 
  /**
   * Constant: host of db
   *
   * @var string
   */
  const DEFAULT_SQL_HOST = 'localhost';
 
  /**
   * Constant: password of db
   *
   * @var string
   */
  const DEFAULT_SQL_PASS = 'root';
 
  /**
   * Constant: name of db
   *
   * @var string
   */
  const DEFAULT_SQL_DTB = 'blogtwig';
 
  /**
   * Construct
   *
   * @param void
   * @return void
   * @see PDO::__construct()
   */ 
  public function __construct()
  {
      $this->PDOInstance = new \PDO('mysql:dbname='.self::DEFAULT_SQL_DTB.';host='.self::DEFAULT_SQL_HOST,self::DEFAULT_SQL_USER ,self::DEFAULT_SQL_PASS);
  }
  
  
    /**
    * Method that creates the unique instance of Database class
    * If it does not exist yet then return it.
    *
    * @param void
    * @return Database
    */
    public static function getInstance()
  {  
    if(is_null(self::$instance))
    {
      self::$instance = new Database();
    }
    return self::$instance;
  }
 
  /**
  * Execute SQL query with PDO
  *
  * @param string $query sql query
  * @return PDOStatement return PDOStatement
  */
  public function query($query)
  {
    return $this->PDOInstance->query($query);
  }
  
  /**
  * Prepare a sql query
  * 
  * @param string $query sql query
  * @return object of the query
  */
  public function prepare($query)
  {
    return $this->PDOInstance->prepare($query);
  }
  
    /**
    * fetches the next row from a result set
    * 
    * @param string $query sql query
    * @return row of the query
    */
    public function fetch($query)
  {
    return $this->PDOInstance->fetch($query);
  }
  
  /**
  * Execute an SQL statement and return the number of affected rows
  * 
  * @param string $query
  * @return number of rows affected by the statement.
  */
  public function exec($query)
  {
    return $this->PDOInstance->exec($query);
  }
}
