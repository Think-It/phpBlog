<?php
require 'vendor/autoload.php';
use natinho68\Models\SPDO as SPDO;
use natinho68\Controllers\Session as Session;
use natinho68\Models\PostsManager as PostsManager;
use natinho68\Controllers\MailController as MailController;
use natinho68\Controllers\Controller as Controller;





$db = new SPDO();
$session = new Session();
$posts = new PostsManager($db);
$contact = new MailController();

// Routing
$page = "home";
if(isset($_GET['p'])){
	$page = $_GET['p'];
}

// Rendu du template

// Chargement des templates dans le dossier templates
$loader = new Twig_Loader_Filesystem(__DIR__ . '/Views');
$twig = new Twig_Environment($loader, [
	'cache' => false, // __DIR__ . '/tmp'
        'debug' => true
	]);
$twig->addExtension(new Twig_Extension_Debug());

if(!empty($_SESSION['addPostDatas'])){
$twig->addGlobal('addPostDatas', $_SESSION['addPostDatas']);    
}



$controller = new Controller($twig, $db);

switch ($page){

	case 'home' :
	$controller->home('home.twig');
        $contact->mailer();
	break;

	case 'contact' :
	echo $twig->render('contact.twig');
        $contact->mailer();
	break;
	
	case 'blog':
	echo $twig->render('allPosts.twig', ['allPosts' => $posts->getAllPosts()]);
	break;

	case 'singlepost' :
        $controller->showPost($_GET['id'], 'singlePost.twig');
        break;
            
        case 'editpost' :
        $controller->showPost($_GET['id'],'editpost.twig');
        $controller->updatePost();
        $controller->deletePost();
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