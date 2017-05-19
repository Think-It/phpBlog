<?php
class PostsManager
{
  private $_db; // Instance de PDO

  public function __construct($db)
  {
    $this->setDb($db);
  }

  public function add(Post $post)
  {
    $q = $this->_db->prepare('INSERT INTO posts(title, content, date, author, header, featuredImg) VALUES(:title, :content, :date, :author, :header, :featuredImg)');

    $q->bindValue(':title', $post->title());
    $q->bindValue(':content', $post->content(), PDO::PARAM_INT);
    $q->bindValue(':date', $post->date(), PDO::PARAM_INT);
    $q->bindValue(':author', $post->author(), PDO::PARAM_INT);
    $q->bindValue(':header', $post->header(), PDO::PARAM_INT);
    $q->bindValue(':featuredImg', $post->featuredImg(), PDO::PARAM_INT);

    $q->execute();
  }

  public function delete(Post $post)
  {
    $this->_db->exec('DELETE FROM posts WHERE id = '.$post->id());
  }
  

   public function getSinglePost($id)
  {
    $post = [];

    $q = $this->_db->query('SELECT * FROM posts  WHERE id = '.$id );

    while ($datas = $q->fetch(PDO::FETCH_ASSOC))
    {
      $post[] = new Post($datas);
    }

    return $post;
  }

  public function getAllPosts()
  {
      if(isset($_GET['p']) && (!isset($_GET['page']))){
          //die("ici");
          $currentPage =  1;
      }
      else {
          $currentPage = $_GET['page'];
      }
    $q= $this->_db->query('SELECT COUNT(id) AS numberposts FROM posts');
    $data = $q->fetch(PDO::FETCH_ASSOC);
      
    $number_posts= $data['numberposts'];
    $perPage = 3;
    $numberPages = ceil($number_posts/$perPage);
    //$currentPage = 1;


    $q = $this->_db->query("SELECT * FROM posts ORDER BY date DESC LIMIT ".(($currentPage-1)*$perPage).",$perPage");

    while($data = $q->fetch(PDO::FETCH_ASSOC))
    {
      $datas[] = new Post($data);
    }
              for($i=1;$i<=$numberPages;$i++){
        echo "<div class='container'><a href=\"index.php?p=blog&page=$i\">$i</a></div>";
    }

    return $datas;

  }

  public function update(Post $post)
  {
    try {
    $q = $this->_db->prepare('UPDATE posts SET title = :title, featuredImg = :featuredImg, content = :content, author = :author, date = :date, header = :header WHERE id = :id');
    
    $q->bindValue(':id', $post->id(), PDO::PARAM_INT);
    $q->bindValue(':title', $post->title(), PDO::PARAM_STR );
    $q->bindValue(':content', $post->content(), PDO::PARAM_STR );
    $q->bindValue(':author', $post->author(), PDO::PARAM_STR );
    $q->bindValue(':header', $post->header(), PDO::PARAM_STR );
    $q->bindValue(':date', $post->date(), PDO::PARAM_STR );
    $q->bindValue(':featuredImg', $post->featuredImg(), PDO::PARAM_STR);
    
    
    $q->execute();
    
    } catch (Exception $e) {
     echo "Problem happened: " . $e->getMessage();
    }
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}