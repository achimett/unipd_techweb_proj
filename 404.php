<?php
session_start();
require_once('includes/DB.php');
require_once('includes/createInfoUtente.php');
require_once('includes/createMenu.php');

// Oggetto di accesso al database
$db = new DB();

// Titolo della pagina
$title = '404';

// Contengono l'HTML dei tag <head> e <body> che verranno stampati
$page_head = file_get_contents('includes/head.html');
$page_body = file_get_contents('includes/body.html');

// Contiene il codice del menù ad hamburger
$hamburger = file_get_contents('includes/hamburger.html');

// Concatenazione di tutti i JS da includere nell'head
$scripts = file_get_contents('includes/scriptMenu.html'); // . file_get_contents(...) . ecc...;

// Contiene lo snippet di codice per visualizzare l'utente loggato in alto a sinistra
$info_utente = createInfoUtente($db);

// Codice HTML del menu
$menu = createMenu(true, true, true, true, true, true);

// Codice HTML del breadcrumb
$breadcrumb = '<p id="breadcrumb">404</p>';

// Codice HTML del content
$content = file_get_contents('includes/content404.html');

$page_head = str_replace('<title />', "<title>$title - DOIT</title>", $page_head);
$page_head = str_replace('<scripts />', $scripts, $page_head);
$page_body = str_replace('<skip />', 'error_404', $page_body);
$page_body = str_replace('<info_utente />', $info_utente, $page_body);
$page_body = str_replace('<hamburger />', $hamburger, $page_body);
$page_body = str_replace('<breadcrumb />', $breadcrumb, $page_body);
$page_body = str_replace('<menu />', $menu, $page_body);
$page_body = str_replace('<content />', $content, $page_body);

echo $page_head . $page_body;
?>
