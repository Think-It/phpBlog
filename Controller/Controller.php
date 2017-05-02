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
        
        public function uploadImg(){
        $folder = 'img/uploads';
        $file = basename($_FILES['image']['name']);
        $path = $folder.'/'.$file;
        $sizeMax = 4000000;
        $size = filesize($_FILES['image']['tmp_name']);
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($_FILES['image']['name'], '.'); 
        //Security verification
            if(!in_array($extension, $extensions)) //if extensions aren't in the array
            {
                 $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
            }
            if($size>$sizeMax)
            {
                 $erreur = 'Le fichier est trop gros...';
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
                      return $path;
                 }
                 else //else return false.
                 {
                      echo 'Echec de l\'upload !';
                 }
            }
            else
            {
                 echo $erreur;
            }
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
                                'content' => $_POST['content'],
                                'featuredImg' => $this->uploadImg()
                                ]); 
                    $manager->add($newpost); // Create a new post

                    echo '<div class="alert alert-success" role="alert">The post was published !</div>';
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
                    var_dump($error);
                  }
                }

                if ($error) {
                  echo "All fields are required.";
                } else {
                                  $post = new Post([
                                  'id' => $_POST['id'],
                                  'title' => $_POST['title'],
                                  'header' => $_POST['header'],
                                  'author' => $_POST['author'],
                                  'date' => date("Y-m-d H:i:s"),
                                  'content' => $_POST['content'],
                                  'featuredImg' => $this->uploadImg()
                                ]);
                                $manager->update($post);
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
            }
        }
}