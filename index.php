<?php
require 'vendor/autoload.php';
require 'Controller/Post.php';
require 'Controller/PostsManager.php';

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

switch ($page){

	case 'home' :
		echo $twig->render('home.twig');
		break;

	case 'contact' :
		echo $twig->render('contact.twig');
		break;
	
	case 'blog':
	echo $twig->render('allPosts.twig', ['allPosts' => $posts->getAllPosts()]);
	break;

	case 'singlepost' :
		echo $twig->render('singlePost.twig', ['singlePost' => $posts->getSinglePost($_GET['id'])]);
		break;
            
        case 'editpost' :
	echo $twig->render('editPost.twig', ['editPost' => $posts->getSinglePost($_GET['id'])]);
	break;
    
        case 'add-post' :
        echo $twig->render('addPost.twig');
	break;

	default: 
	header('HTTP/1.0 404 Not Found');
	echo $twig->render('404.twig');
	break;
}