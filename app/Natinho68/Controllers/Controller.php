<?php
namespace Natinho68\Controllers;
use Natinho68\Controllers\Notification as Notification;
use Natinho68\Managers\PostsManager as PostsManager;
use Natinho68\Models\Post as Post;
use Natinho68\Services\Services as Services;
ob_start();
class Controller{
    
    public function __construct(\Twig_Environment $twig, $db){
            $this->db = $db;
            $this->twig = $twig;
        }
    
    public function home($view){
            echo $this->twig->render($view);
        }
        
    public function showPost($id, $view) {
            $posts = new PostsManager($this->db);
            $post = $posts->getSinglePost($id);
            echo $this->twig->render($view, ['singlePost' => $post]);
       
        }
        
    public function addPostView($view){
            echo $this->twig->render($view);
        }
       
        
    public function addNewPost(){
    $uploadImg = new Services();
    $notification = new Notification();
    $manager = new PostsManager($this->db);
    if (isset($_POST['publish'])) {
        if (empty($_POST['title']) || empty($_POST['header']) || empty($_POST['author']) || empty($_POST['content'])) {
            $_SESSION['addPostDatas'] = $_POST;
            $notification->setFlash('"Title", "Header", "Author" and "Content are required and cannot be empty"');
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();

        } else {
            $newpost = new Post([
                'title' => $_POST['title'],
                'header' => $_POST['header'],
                'author' => $_POST['author'],
                'date' => date("Y-m-d H:i:s"),
                'content' => $_POST['content'],
                'featuredImg' => $uploadImg->uploadImg()
            ]);
            $manager->add($newpost); // Create a new post
            unset($_SESSION['addPostDatas']);
            $notification->setFlash('The post was published !', 'success');
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
            }
            
        } else {
            $notification->flash();
        }
    }
       
        
    public function updatePost(){
        $uploadImg = new Services;
        $manager = new PostsManager($this->db);
        $notification = new Notification();
            if(isset($_POST['update']  )){
                
                // Required field names
                $required = array('title', 'header', 'author', 'content');
                // Loop over field names, make sure each one exists and is not empty
                $error = false;
                foreach($required as $field) {
                  if (empty($_POST[$field])) {
                    $error = true;
                  }
                }

                if ($error) {
                      $notification->setFlash('"Title", "Header", "Author" and "Content are required and cannot be empty"');
                } else {    
                   
                        $uploadImg = $uploadImg->uploadImg();
                        $image = isset($uploadImg) ? $uploadImg : $manager->getImage($_POST['id']);
                    
                                  $post = new Post([
                                  'id' => $_POST['id'],
                                  'title' => $_POST['title'],
                                  'header' => $_POST['header'],
                                  'author' => $_POST['author'],
                                  'date' => date("Y-m-d H:i:s"),
                                  'content' => $_POST['content'],
                                  'featuredImg' => $image
                                ]);       
                                  
                                $manager->update($post);
                                $notification->setFlash('The post has been updated !', 'success');
                                header('Location: '.$_SERVER['REQUEST_URI']);
                                exit();
                                }

                } else {
                $notification->flash();
                }
    }

                
    public function deletePost(){
        $manager = new PostsManager($this->db);
        $notification = new Notification();
        if(isset($_POST['delete'])){
            $post = new Post([
                              'id' => $_POST['id']
                            ]);
            $manager->delete($post);       
            $notification->setFlash('The post has been deleted !', 'info');
            header('Location: '.$_SERVER['REQUEST_URI']);
            exit();
            } else {
                $notification->flash();
            }
        }
}