<?php
session_start();

if (isset($_SESSION['user_id'])) {
  header("Location: bacheca.php");
}

// Titolo della pagina
$title = 'Benvenuto';

// Contengono l'HTML dei tag <head> e <body> che verranno stampati
$page_head = file_get_contents('includes/head.html');
$page_body = file_get_contents('includes/body.html');

// Codice HTML del content
$content = file_get_contents('includes/index.html');

$page_head = str_replace('<title />', "<title>$title - DOIT</title>", $page_head);
$page_head = str_replace('<scripts />', '', $page_head);
$page_body = str_replace('<info_utente />', '', $page_body);
$page_body = str_replace('<breadcrumb />', '', $page_body);
$page_body = str_replace('<menu />', '', $page_body);
$page_body = str_replace('<content />', $content, $page_body);

echo $page_head . $page_body;
?>
