<?php
require 'vendor/autoload.php';
require 'Model/Post.php';
require 'Model/PostsManager.php';
require 'Controller/Controller.php';

$db = new PDO("mysql:host=localhost; dbname=blogtwig; charset=UTF8", 'root', 'root');
$posts = new PostsManager($db);

// Routing
$page = "home";
if(isset($_GET['p'])){
	$page = $_GET['p'];
}

// Rendu du template

// Chargement des templates dans le dossier templates
$loader = new Twig_Loader_Filesystem(__DIR__ . '/View');
$twig = new Twig_Environment($loader, [
	'cache' => false, // __DIR__ . '/tmp'
	]);

$controller = new Controller($twig, $db);

switch ($page){

	case 'home' :
		$controller->home('home.twig');
		break;

	case 'contact' :
		echo $twig->render('contact.twig');
		break;
	
	case 'blog':
	echo $twig->render('allPosts.twig', ['allPosts' => $posts->getAllPosts()]);
	break;

	case 'singlepost' :
		$controller->showPost($_GET['id'], 'singlePost.twig');
		break;
            
        case 'editpost' :
        $controller->showPost($_GET['id'],'editpost.twig');
	break;
    
        case 'add-post' :
        $controller->addPostView('addPost.twig');
        $controller->addNewPost();
	break;

	default: 
	header('HTTP/1.0 404 Not Found');
	echo $twig->render('404.twig');
	break;
}