<?php
namespace natinho68\Controllers;
use natinho68\Controllers\Session as Session;
use natinho68\Models\PostsManager as PostsManager;
use natinho68\Models\Post as Post;
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
            echo $this->twig->render($view, ['addPost']);
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
                 $file = strtr($file, 
                      'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
                      'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                 $file = preg_replace('/([^.a-z0-9]+)/i', '-', $file);
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
        
    public function addNewPost(){
            $manager = new PostsManager($this->db);
            if(isset($_POST['publish'])){
                if (empty($_POST['title']) || empty($_POST['header']) || empty($_POST['author']) || empty($_POST['content']))
                {
                      $session = new Session();
                      $session->setFlash('"Title", "Header", "Author" and "Content are required and cannot be empty"');
                      $session->flash();
                }
                else
                { 
                    $newpost = new Post([
                                'title' => $_POST['title'],
                                'header' => $_POST['header'],
                                'author' => $_POST['author'],
                                'date' => date("Y-m-d H:i:s"),
                                'content' => $_POST['content'],
                                'featuredImg' => $this->uploadImg()
                                ]); 
                    $manager->add($newpost); // Create a new post
                    
                      $session = new Session();
                      $session->setFlash('The post was published !', 'success');
                      $session->flash();
                }
            }
        }
        
       
        
        
    public function updatePost(){
        $manager = new PostsManager($this->db);
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
                      $session = new Session();
                      $session->setFlash('"Title", "Header", "Author" and "Content are required and cannot be empty"');
                      $session->flash();
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
                                $session = new Session();
                                $session->setFlash('The post has been updated !', 'success');
                                $session->flash();
                                echo "<meta http-equiv='refresh' content='0'>";
                                }
                }

                }

                
    public function deletePost(){
        $manager = new PostsManager($this->db);
        if(isset($_POST['delete'])){
            $post = new Post([
                              'id' => $_POST['id']
                            ]);
            $manager->delete($post);
            $session = new Session();
            $session->setFlash('The post has been deleted !', 'info');
            $session->flash();            
            echo "<meta http-equiv='refresh' content='0'>";

            }
        }
}