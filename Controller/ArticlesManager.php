<?php
class ArticlesManager
{
  private $_db; // Instance de PDO

  public function __construct($db)
  {
    $this->setDb($db);
  }

  public function add(Article $article)
  {
    $q = $this->_db->prepare('INSERT INTO articles(title, content, date, author, callToRead, featuredImg) VALUES(:title, :content, :date, :author, :callToRead, :featuredImg)');

    $q->bindValue(':title', $article->title());
    $q->bindValue(':content', $article->content(), PDO::PARAM_INT);
    $q->bindValue(':date', $article->date(), PDO::PARAM_INT);
    $q->bindValue(':author', $article->author(), PDO::PARAM_INT);
    $q->bindValue(':callToRead', $article->callToRead(), PDO::PARAM_INT);
    $q->bindValue(':featuredImg', $article->featuredImg(), PDO::PARAM_INT);

    $q->execute();
  }

  public function delete(Article $article)
  {
    $this->_db->exec('DELETE FROM articles WHERE id = '.$article->id());
  }
  
   public function getSingleArticle($id)
  {
    $articles = [];

    $q = $this->_db->query('SELECT * FROM articles  WHERE id = '.$id );

    while ($datas = $q->fetch(PDO::FETCH_ASSOC))
    {
      $articles[] = new Article($datas);
    }

    return $articles;
  }

  public function getAllArticles()
  {
    $articles = [];

    $q = $this->_db->query('SELECT * FROM articles ORDER BY date DESC');

    while ($datas = $q->fetch(PDO::FETCH_ASSOC))
    {
      $articles[] = new Article($datas);
    }

    return $articles;
  }

  public function update(Article $article)
  {
    $q = $this->_db->prepare('UPDATE articles SET title = :title, content = :content, author = :author, date = :date, callToRead = :callToRead WHERE id = :id');

    $q->bindValue(':title', $article->title(), PDO::PARAM_INT);
    $q->bindValue(':content', $article->content(), PDO::PARAM_INT);
    $q->bindValue(':author', $article->author(), PDO::PARAM_INT);
    $q->bindValue(':callToRead', $article->callToRead(), PDO::PARAM_INT);
    $q->bindValue(':date', $article->date(), PDO::PARAM_INT);
     $q->bindValue(':featuredImg', $article->featuredImg(), PDO::PARAM_INT);
    $q->bindValue(':id', $article->id(), PDO::PARAM_INT);

    $q->execute();
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}