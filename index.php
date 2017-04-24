<?php
require 'vendor/autoload.php';
require 'myFunctions.php';

// Routing
$page = "home";
if(isset($_GET['p'])){
	$page = $_GET['p'];
}

// Get posts
function posts(){
	$pdo = new PDO('mysql:host=localhost;dbname=blogtwig;charset=utf8', 'root', 'root');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	$posts = $pdo->query('SELECT * FROM Posts ORDER BY id DESC LIMIT 10');
	return $posts;
}

function singlepost($id){
	$pdo = new PDO('mysql:host=localhost;dbname=blogtwig;charset=utf8', 'root', 'root');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	$singlepost = $pdo->query("SELECT * FROM Posts WHERE id=" . $id );
	return $singlepost;
}

// Rendu du template

// Chargement des templates dans le dossier templates
$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new Twig_Environment($loader, [
	'cache' => false, // __DIR__ . '/tmp'
	]);
$twig->addExtension(new myFunctions());
$twig->addGlobal('current_page', $page);
switch ($page){

	case 'home' :
		echo $twig->render('home.twig');
		break;

	case 'contact' :
		echo $twig->render('contact.twig');
		break;
	
	case 'blog':
	echo $twig->render('blog.twig', ['posts' => posts()]);
	break;

	case 'single' :
		echo $twig->render('single.twig', ['singlepost' => singlepost($_GET['id'])]);
		break;	

	default: 
	header('HTTP/1.0 404 Not Found');
	echo $twig->render('404.twig');
	break;
}