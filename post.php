<?php
session_start();
require_once('includes/DB.php');
require_once('includes/createInfoUtente.php');
require_once('includes/createMenu.php');
require_once('includes/check.php');
require_once('includes/controlloDeleteCommento.php');
require_once('includes/controlloNewCommento.php');
require_once('includes/controlloPulsanteDoit.php');
require_once('includes/createCommenti.php');
require_once('includes/createFormSocial.php');
require_once('includes/createListaVolontari.php');
require_once('includes/createPulsanteModifica.php');
require_once('includes/createPulsanteDoit.php');
require_once('includes/createPost.php');

// Oggetto di accesso al database
$db = new DB();

$post = file_get_contents('includes/contentPost.html');

$getPost = $db->getPost($_GET['id']);

$postEdit = 'postEdit.php?id=';
$profilo = "profilo.php?id=";
$postUrl = "post.php?id=";

check($db);
controlloPulsanteDoit($db);
controlloNewCommento($db);
controlloDeleteCommento($db);

// Titolo della pagina
$title = $getPost['titolo'];//$postInfo['titolo'];

// Contengono l'HTML dei tag <head> e <body> che verranno stampati
$page_head = file_get_contents('includes/head.html');
$page_body = file_get_contents('includes/body.html');

// Concatenazione di tutti i JS da includere nell'head
$scripts = file_get_contents('includes/scriptMenu.html'); // . file_get_contents(...) . ecc...;

// Contiene lo snippet di codice per visualizzare l'utente loggato in alto a sinistra
$info_utente = createInfoUtente($db);

// Codice HTML del menu
$menu = createMenu(true, true, true, true, true, true);

// Codice HTML del breadcrumb

$breadcrumb = '<p id="breadcrumb">Bacheca &gt;&gt; Post ' . $title . '</p>';

$page_head = str_replace('<title />', "<title>$title - DOIT</title>", $page_head);
$page_head = str_replace('<scripts />', $scripts, $page_head);
$page_body = str_replace('<info_utente />', $info_utente, $page_body);
$page_body = str_replace('<breadcrumb />', $breadcrumb, $page_body);
$page_body = str_replace('<menu />', $menu, $page_body);

// Codice HTML del content




$k = 27;
$blob['commenti'] = createCommenti($db, $profilo, $k);
$blob['volontari'] = createListaVolontari($db, $profilo, $blob['commenti']['k']);


$post = str_replace('<img_path />', $getPost['img_path'], $post);
$post = str_replace('<titolo />', $getPost['titolo'], $post);
$post = str_replace('<modifica />', createPulsanteModifica($db), $post);
$post = str_replace('<id />', $postEdit . $_GET['id'], $post);
$post = str_replace('<autore />', $getPost['nome'] . " " . $getPost['cognome'], $post);
$post = str_replace('<linkProfilo />', $profilo . $getPost['id_autore'], $post);
$post = str_replace('<data />', $getPost['data'], $post);
$post = str_replace('<ora />', $getPost['ora'], $post);
$post = str_replace('<luogo />', $getPost['luogo'], $post);
$post = str_replace('<provincia />', $getPost['provincia'], $post);
$post = str_replace('<nvolontari />', $getPost['nvolontari'], $post);
$post = str_replace('<formPartecipa />', createPulsanteDoit($db), $post);
$post = str_replace('<descrizione />', $getPost['descrizione'], $post);
$post = str_replace('<volontari />', $blob['volontari']['html'], $post);
$post = str_replace('<formSocial />', createFormSocial($db, $postUrl), $post);
$post = str_replace('<commenti />', $blob['commenti']['html'], $post);
$page_body = str_replace('<content />', $post, $page_body);

echo $page_head . $page_body;

?>
