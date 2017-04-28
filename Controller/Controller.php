<?php

class Controller{
    
        public function __construct(Twig_Environment $twig, $db){
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
        
        public function addNewPost(){
            $manager = new PostsManager($this->db);
            if(isset($_POST['publish'])){
                if (empty($_POST['title']) || empty($_POST['header']) || empty($_POST['author']) || empty($_POST['content']))
                {
                    echo '<div class="alert alert-danger" role="alert">Something get wrong</div>';
                }
                else
                { 
                    $newpost = new Post([
                                'title' => $_POST['title'],
                                'header' => $_POST['header'],
                                'author' => $_POST['author'],
                                'date' => date("Y-m-d H:i:s"),
                                'content' => $_POST['content']
                                //'featuredImg' => $_POST['featuredImg'],
                                ]); 
                    $manager->add($newpost); // Create a new post

                    echo '<div class="alert alert-success" role="alert">The post was published !</div>';
                }
            }
        }
}

