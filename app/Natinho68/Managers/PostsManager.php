<?php
namespace Natinho68\Managers;
use Natinho68\Models\Post as Post;

/**
 * Class PostsManager manage queries datas from db
 */
class PostsManager
{
  private $_db; 


  public function __construct($db)
  {
    $this->setDb($db);
  }
  
  
  /**
   * Adding a post in db
   * @param Post $post
   */
  public function add(Post $post)
  {
    $q = $this->_db->prepare('INSERT INTO posts(title, content, date, author, header, featuredImg) VALUES(:title, :content, :date, :author, :header, :featuredImg)');
    
    // Binds a value to a parameter 
    $q->bindValue(':title', $post->title(), \PDO::PARAM_STR);
    $q->bindValue(':content', $post->content(), \PDO::PARAM_STR);
    $q->bindValue(':date', $post->date(), \PDO::PARAM_STR);
    $q->bindValue(':author', $post->author(), \PDO::PARAM_STR);
    $q->bindValue(':header', $post->header(), \PDO::PARAM_STR);
    $q->bindValue(':featuredImg', $post->featuredImg(), \PDO::PARAM_STR);

    $q->execute();
  }

  /**
   * Delete a post in db
   * @param Post $post
   */
  public function delete(Post $post)
  {
    $this->_db->exec('DELETE FROM posts WHERE id = '.$post->id());
  }
  
  /**
   * Select a single post by its id
   * @param int $id the id of the post
   * @return object Post
   */
   public function getSinglePost($id)
  {
    $post = [];

    $q = $this->_db->query('SELECT * FROM posts  WHERE id = '.$id );

    while ($datas = $q->fetch(\PDO::FETCH_ASSOC))
    {
      $post[] = new Post($datas);
    }

    return $post;
  }

  /**
   * Select the path of the image as a string from the database
   * 
   * @param int $id
   * @return string
   */
  public function getImage($id){
        
      $req = $this->_db->query('SELECT featuredImg FROM posts WHERE id ='.$id);
      $image = $req->fetch(\PDO::FETCH_ASSOC);
      return $image["featuredImg"];
  }
  
  /**
   * Select all the post from db and display limit it with pagination
   * 
   * @return array $datas and $numberPages 
   */
  public function getAllPosts()
  {
      // if no 'page= ..' in url, current page = 1 
      if(isset($_GET['p']) && (!isset($_GET['page']))){
          
          $currentPage =  1;
      }
      // else page = page
      else {
          $currentPage = $_GET['page'];
      }
    // count number of post
    $q= $this->_db->query('SELECT COUNT(id) AS numberposts FROM posts');
    $data = $q->fetch(\PDO::FETCH_ASSOC);
      
    $number_posts= $data['numberposts'];
    // Number of post per page
    $perPage = 3;
    // calculation number of pages
    $numberPages = ceil($number_posts/$perPage);


    // limit the query with number of post and of pages
    $q = $this->_db->query("SELECT * FROM posts ORDER BY date DESC LIMIT ".(($currentPage-1)*$perPage).",$perPage");
    
    while($data = $q->fetch(\PDO::FETCH_ASSOC))
    {
      $datas[] = new Post($data);
    }
    
    
        return array(
        'records'     => $datas,
        'numberPages' => $numberPages,
    );

  }
  

  /**
   * Update a post from db
   * 
   * @param Post $post
   */
  public function update(Post $post)
  {
    try {
    $q = $this->_db->prepare('UPDATE posts SET title = :title, featuredImg = :featuredImg, content = :content, author = :author, date = :date, header = :header WHERE id = :id');
    
    // Binds a value to a parameter 
    $q->bindValue(':id', $post->id(), \PDO::PARAM_INT);
    $q->bindValue(':title', $post->title(), \PDO::PARAM_STR );
    $q->bindValue(':content', $post->content(), \PDO::PARAM_STR );
    $q->bindValue(':author', $post->author(), \PDO::PARAM_STR );
    $q->bindValue(':header', $post->header(), \PDO::PARAM_STR );
    $q->bindValue(':date', $post->date(), \PDO::PARAM_STR );
    $q->bindValue(':featuredImg', $post->featuredImg(), \PDO::PARAM_STR);
    
    // execute the query
    $q->execute();
    
    } catch (Exception $e) {
     echo "Problem happened: " . $e->getMessage();
    }
  }
  
  public function setDb($db)
  {
    $this->_db = $db;
  }

}