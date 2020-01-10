<?php
session_start();
require_once('includes/DB.php');
require_once('includes/createInfoUtente.php');
require_once('includes/createMenu.php');

require_once('includes/createPost.php');

$_SESSION['user_id'] = 1;
//unset($_SESSION['user_id']);
 //$_SESSION['post_id'] = 1;

// Oggetto di accesso al database
$db = new DB();

$post = createPost($db);
if($post == '') {
  header("location: /unipd_techweb_proj/404.php");
  return;
}

// Titolo della pagina
$title = $db->getPost($_GET['id'])['titolo'] . ' - DOIT';

// Contengono l'HTML dei tag <head> e <body> che verranno stampati
$page_head = file_get_contents('includes/head.html');
$page_body = file_get_contents('includes/body.html');

// Concatenazione di tutti i JS da includere nell'head
$scripts = file_get_contents('includes/menuScript.html'); // . file_get_contents(...) . ecc...;

// Contiene lo snippet di codice per visualizzare l'utente loggato in alto a sinistra
$info_utente = createInfoUtente($db);

// Codice HTML del menu
$menu = createMenu(true, true, true, true, true, true);

// Codice HTML del breadcrumb

$breadcrumb = '<p id="breadcrumb">' .
'<a href="bacheca.php">Bacheca</a> &gt;&gt; ' .
'<a href="post?id=' . $_GET['id'] . '">Post ' . $db->getPost($_GET['id'])['titolo'] . '</a></p>';

$page_head = str_replace('<title />', "<title>$title - DOIT</title>", $page_head);
$page_head = str_replace('<scripts />', $scripts, $page_head);
$page_body = str_replace('<info_utente />', $info_utente, $page_body);
$page_body = str_replace('<breadcrumb />', $breadcrumb, $page_body);
$page_body = str_replace('<menu />', $menu, $page_body);


// Codice HTML del content
$page_body = str_replace('<content />', $post, $page_body);

echo $page_head . $page_body;

?>
