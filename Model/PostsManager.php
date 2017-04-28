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
    $articles = [];

    $q = $this->_db->query('SELECT * FROM posts  WHERE id = '.$id );

    while ($datas = $q->fetch(PDO::FETCH_ASSOC))
    {
      $articles[] = new Post($datas);
    }

    return $articles;
  }

  public function getAllPosts()
  {
    $post = [];

    $q = $this->_db->query('SELECT * FROM posts ORDER BY date DESC');

    while ($datas = $q->fetch(PDO::FETCH_ASSOC))
    {
      $post[] = new Post($datas);
    }

    return $post;
  }

  public function update(Post $post)
  {
    $q = $this->_db->prepare('UPDATE posts SET title = :title, content = :content, author = :author, date = :date, header = :header WHERE id = :id');

    $q->bindValue(':title', $post->title(), PDO::PARAM_INT);
    $q->bindValue(':content', $post->content(), PDO::PARAM_INT);
    $q->bindValue(':author', $post->author(), PDO::PARAM_INT);
    $q->bindValue(':header', $post->header(), PDO::PARAM_INT);
    $q->bindValue(':date', $post->date(), PDO::PARAM_INT);
    $q->bindValue(':featuredImg', $post->featuredImg(), PDO::PARAM_INT);
    $q->bindValue(':id', $post->id(), PDO::PARAM_INT);

    $q->execute();
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}