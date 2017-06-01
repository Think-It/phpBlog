<?php
namespace Natinho68\Controllers;
use Natinho68\Controllers\Notification as Notification;
use Natinho68\Managers\PostsManager as PostsManager;
use Natinho68\Models\Post as Post;
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
       
       

    public function uploadImg(){
        $folder = 'img/uploads';
        $file = basename($_FILES['image']['name']);
        $sizeMax = 4000000;
        $size = filesize($_FILES['image']['tmp_name']);
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($_FILES['image']['name'], '.'); 
        //Security verification
            if(empty($file)){
                $notification = new Notification();
                $notification->setFlash("No featured image uploaded ...", "warning");
                $notification->flash();
                
            } else {
            if(!in_array($extension, $extensions)) //if extensions aren't in the array
            {
                 $erreur = new Notification();
                 $erreur->setFlash("You must upload a file of type png, gif, jpg or jpeg ...");
                 $erreur->flash();
                 die();
                 
            }
            if($size>$sizeMax)
            {
                 $erreur = new Notification();
                 $erreur->setFlash("File too large...");
                 $erreur->flash();
                 die();
                 
            }
            if(!isset($erreur)) //if no errors, upload
            {
                 //file name formating
                 $file = rand().$extension;
                 if(move_uploaded_file($_FILES['image']['tmp_name'], $folder.'/'.$file)) //if true, upload ok
                 {
                      $path = $folder.'/'.$file;
                      return $path;
                 }
                 else //else return false.
                 {
                      $erreur = new Notification();
                      $erreur->setFlash("Fail to upload !");
                      $erreur->flash();
                      die();
                 }
            }
        }        
    }
        
public function addNewPost()
{
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
                'featuredImg' => $this->uploadImg()
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
                   
                        $uploadImg = $this->uploadImg();
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