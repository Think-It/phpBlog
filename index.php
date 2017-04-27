<?php
require 'vendor/autoload.php';
require 'Controller/Article.php';
require 'Controller/ArticlesManager.php';

$db = new PDO("mysql:host=localhost; dbname=blogtwig; charset=UTF8", 'root', 'root');
$articles = new ArticlesManager($db);

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
	echo $twig->render('blog.twig', ['listArticles' => $articles->getAllArticles()]);
	break;

	case 'single' :
		echo $twig->render('single.twig', ['particularArticle' => $articles->getSingleArticle($_GET['id'])]);
		break;

	default: 
	header('HTTP/1.0 404 Not Found');
	echo $twig->render('404.twig');
	break;
}