<?php
namespace Natinho68\Controllers;
use Natinho68\Controllers\Notification as Notification;
use Natinho68\Managers\PostsManager as PostsManager;
use Natinho68\Models\Post as Post;
use Natinho68\Services\ImgUploader as ImgUploader;
ob_start();

/**
 * Class Controller control views and CRUD actions
 */
class Controller{
    
    /**
     * 
     * @param \Twig_Environment $twig the twig config
     * @param type $db access to the database
     */
    public function __construct(\Twig_Environment $twig, $db){
            $this->db = $db;
            $this->twig = $twig;
        }
    
        
    /**
     * 
     * @param type $view is the view you want to render ex : home.twig 
     * and echo this one
     */
    public function home($view){
            echo $this->twig->render($view);
        }
        
        
    /**
     * 
     * @param type $id the post id you want to show
     * @param type $view the view you want to render
     * echo the view with this specific id post
     */
    public function showPost($id, $view) {
            $posts = new PostsManager($this->db);
            $post = $posts->getSinglePost($id);
            echo $this->twig->render($view, ['singlePost' => $post]);
       
        }
    
        
    /**
     * 
     * @param type $view echo the view for add post functionnality
     *
     */    
    public function addPostView($view){
            echo $this->twig->render($view);
        }
       
        
    /**
     * adding a new post with errors check and notification handler
     */    
    public function addNewPost(){
    // Instance of ImgUploader service
    $uploadImg = new ImgUploader();
    // Instance of Notification for alert handler
    $notification = new Notification();
    // Instance of post manager 
    $manager = new PostsManager($this->db);
    if (isset($_POST['publish'])) {
        // fields are empty = error
        if (empty($_POST['title']) || empty($_POST['header']) || empty($_POST['author']) || empty($_POST['content'])) {
            
            // saving datas in session for users
            $_SESSION['addPostDatas'] = $_POST;
            
            // set notification message 
            $notification->setFlash('"Title", "Header", "Author" and "Content are required and cannot be empty"');
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
        // fields are not empty, creating a new Post
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
            unset($_SESSION['addPostDatas']); // unset the session with datas
            // set notification message and class
            $notification->setFlash('The post was published !', 'success');
            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit();
            }
            
        // display notifications    
        } else {
            $notification->flash();
        }
    }
       
    /**
     * Updating a post with errors check and notification handler
     */
    public function updatePost(){
        // Instance of ImgUploader
        $uploadImg = new ImgUploader;
        // Instance of post manager for db select 
        $manager = new PostsManager($this->db);
        // Instance of notification for alerts handler
        $notification = new Notification();
            if(isset($_POST['update']  )){
                
                // Required field names
                $required = array('title', 'header', 'author', 'content');
                // Loop over field names, make sure each one exists and is not empty
                $error = false;
                foreach($required as $field) {
                // fields empty = error
                  if (empty($_POST[$field])) {
                    $error = true;
                  }
                }
                // display error notification
                if ($error) {
                      $notification->setFlash('"Title", "Header", "Author" and "Content are required and cannot be empty"');
                } else {    
                        // no errors, updating the post
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
                                // update in db  
                                $manager->update($post);
                                // set notification message and class
                                $notification->setFlash('The post has been updated !', 'success');
                                // refresh page
                                header('Location: '.$_SERVER['REQUEST_URI']);
                                exit();
                                }
                // display notifications                
                } else {
                $notification->flash();
                }
    }

    /**
     * deleting a post with errors check and notification handler
     */            
    public function deletePost(){
        $manager = new PostsManager($this->db);
        $notification = new Notification();
        if(isset($_POST['delete'])){
            $post = new Post([
                              'id' => $_POST['id']
                            ]);
            $manager->delete($post);
            // set notification message and class
            $notification->setFlash('The post has been deleted !', 'info');
            header('Location: '.$_SERVER['REQUEST_URI']);
            exit();
            
            // display notifications
            } else {
                $notification->flash();
            }
        }
}