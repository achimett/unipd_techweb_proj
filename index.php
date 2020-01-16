<?php
session_start();
$_SESSION['user_id'] = 12;
require_once('includes/DB.php');

// Oggetto di accesso al database
$db = new DB();

// Titolo della pagina
$title = 'Benvenuto';

// Contengono l'HTML dei tag <head> e <body> che verranno stampati
$page_head = file_get_contents('includes/head.html');
$page_body = file_get_contents('includes/body.html');

// Concatenazione di tutti i JS da includere nell'head
$scripts = file_get_contents('includes/menuScript.html'); // . file_get_contents(...) . ecc...;


// Codice HTML del content
$content = file_get_contents('includes/index.html');


$page_head = str_replace('<title />', "<title>$title - DOIT</title>", $page_head);
$page_head = str_replace('<scripts />', $scripts, $page_head);
$page_body = str_replace('<info_utente />', '', $page_body);
$page_body = str_replace('<breadcrumb />', '', $page_body);
$page_body = str_replace('<menu />', '', $page_body);
$page_body = str_replace('<content />', $content, $page_body);

echo $page_head . $page_body;
?>
