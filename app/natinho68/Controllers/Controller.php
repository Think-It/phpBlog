<?php
namespace natinho68\Controllers;
use natinho68\Controllers\Session as Session;
use natinho68\Models\PostsManager as PostsManager;
use natinho68\Models\Post as Post;
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
                $session = new Session();
                $session->setFlash("No featured image uploaded ...", "warning");
                $session->flash();
                
            } else {
            if(!in_array($extension, $extensions)) //if extensions aren't in the array
            {
                 $erreur = new Session();
                 $erreur->setFlash("You must upload a file of type png, gif, jpg or jpeg ...");
                 $erreur->flash();
                 die();
                 
            }
            if($size>$sizeMax)
            {
                 $erreur = new Session();
                 $erreur->setFlash("File too large...");
                 $erreur->flash();
                 die();
                 
            }
            if(!isset($erreur)) //if no errors, upload
            {
                 //file name formating
                 $file = bin2hex(mcrypt_create_iv).$extension;
                 if(move_uploaded_file($_FILES['image']['tmp_name'], $folder.'/'.$file)) //if true, upload ok
                 {
                      $path = $folder.'/'.$file;
                      return $path;
                 }
                 else //else return false.
                 {
                      $erreur = new Session();
                      $erreur->setFlash("Fail to upload !");
                      $erreur->flash();
                      die();
                 }
            }
        }        
    }
        
public function addNewPost()
{ 
    $session = new Session();
    $manager = new PostsManager($this->db);
    if (isset($_POST['publish'])) {
        if(empty($_POST['title']) || empty($_POST['header']) || empty($_POST['author']) || empty($_POST['content'])) {
            $_SESSION['addPostDatas'] = $_POST;
            $session->setFlash('"Title", "Header", "Author" and "Content are required and cannot be empty"');
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
            $session->setFlash('The post was published !', 'success');
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
            }
            
        } else {
            $session->flash();
        }
    }
       
        
    public function updatePost(){
      
        $manager = new PostsManager($this->db);
        $session = new Session();
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
                      $session->setFlash('"Title", "Header", "Author" and "Content are required and cannot be empty"');
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
                                $session->setFlash('The post has been updated !', 'success');
                                header('Location: '.$_SERVER['REQUEST_URI']);
                                exit();
                                }

                } else {
                $session->flash();
                }
    }

                
    public function deletePost(){
        $manager = new PostsManager($this->db);
        $session = new Session();
        if(isset($_POST['delete'])){
            $post = new Post([
                              'id' => $_POST['id']
                            ]);
            $manager->delete($post);       
            $session->setFlash('The post has been deleted !', 'info');
            header('Location: '.$_SERVER['REQUEST_URI']);
            exit();
            } else {
                $session->flash(); 
            }
        }
}