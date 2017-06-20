<?php
// Autoload
require 'vendor/autoload.php';
use Natinho68\Config\Database as Database;
use Natinho68\Controllers\Notification as Notification;
use Natinho68\Managers\PostsManager as PostsManager;
use Natinho68\Controllers\MailController as MailController;
use Natinho68\Controllers\Controller as Controller;

// Instance of objects
$db = new Database();
$session = new Notification();
$posts = new PostsManager($db);
$contact = new MailController();


// Routing
$page = "home";
if(isset($_GET['p'])){
	$page = $_GET['p'];
}

// Template render
// Loading templates in "Views" folder
$loader = new Twig_Loader_Filesystem(__DIR__ . '/Views');
$twig = new Twig_Environment($loader, [
	'cache' => false, // __DIR__ . '/tmp'
        'debug' => true
	]);
$twig->addExtension(new Twig_Extension_Debug());


// add  globals variables for forms with errors and save them in sessions
// when adding a post
if(!empty($_SESSION['addPostDatas'])){
    $twig->addGlobal('addPostDatas', $_SESSION['addPostDatas']);
}
// when emailing something
if(!empty($_SESSION['emailDatas'])){
    $twig->addGlobal('emailDatas', $_SESSION['emailDatas']);
}

// Instance of Controller
$controller = new Controller($twig, $db);

// access to view by url and accessing to functions in them
switch ($page){
        
        // p = home
	case 'home' :
        // display home view
	$controller->home('home.twig');
        // use mailer function
        $contact->mailer();
	break;
        
        // p = contact
	case 'contact' :
        // display contact view
	echo $twig->render('contact.twig');
        // use mailer function
        $contact->mailer();
	break;
	
        // p = blog
	case 'blog':
        // display blog view and getAllPosts function
	echo $twig->render('allPosts.twig', ['allPosts' => $posts->getAllPosts()]);
	break;
    
        // ...
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
        
        // if != case render 404 page
	default: 
	header('HTTP/1.0 404 Not Found');
	echo $twig->render('404.twig');
	break;
}