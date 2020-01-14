<?php
session_start();
require_once('includes/DB.php');
require_once('includes/createInfoUtente.php');
require_once('includes/createMenu.php');
require_once('includes/createTableRows.php');
require_once('includes/createProfiloEditButton.php');

// Oggetto di accesso al database
$db = new DB();

//Controllo sicurezza
if (!isset($_GET['id'])) {
  header('Location: 404.php');
}

// Titolo della pagina
$title = 'Profilo';

// Contengono l'HTML dei tag <head> e <body> che verranno stampati
$page_head = file_get_contents('includes/head.html');
$page_body = file_get_contents('includes/body.html');

// Concatenazione di tutti i JS da includere nell'head
$scripts = file_get_contents('includes/scriptMenu.html'); // . file_get_contents(...) . ecc...;

// Contiene lo snippet di codice per visualizzare l'utente loggato in alto a sinistra
$info_utente = createInfoUtente($db);

// Codice HTML del menu
$menu = createMenu(false, true, true, true, true, true);

// Codice HTML del breadcrumb
$breadcrumb = '<p id="breadcrumb">Profilo</p>';

// Attributo checked filtro
$check1 = '';
$check2 = '';
$check3 = '';
$status = 0;
if (isset($_POST['status'])) {
  $status = $_POST['status'];
}

if ($status == 0) {
  $check1 = 'checked="checked"';
} else if ($status > 0) {
  $check2 = 'checked="checked"';
} else if ($status < 0) {
  $check3 = 'checked="checked"';
}

// Dati del profilo
$profilo = $db->getProfilo($_GET['id']);

// Codice del pulsante Modifica
$modifica = createProfiloEditButton($_GET['id'], 21);

// Codice HTML del content
$content = file_get_contents('includes/contentProfilo.html');
$content = str_replace('<img_path />', $profilo['img_path'], $content);
$content = str_replace('<nome />', $profilo['nome'], $content);
$content = str_replace('<cognome />', $profilo['cognome'], $content);
$content = str_replace('<data_di_nascita />', $profilo['datanascita'], $content);
$content = str_replace('<email />', $profilo['email'], $content);
$content = str_replace('<telefono />', $profilo['telefono'], $content);
$content = str_replace('<biografia />', $profilo['bio'], $content);
$content = str_replace('<riga_tabella />', createTableRows($db->getProfiloTable($_GET['id'], $status), 24), $content);
$content = str_replace('<action />', 'profilo.php?id=' . $_GET['id'], $content);
$content = str_replace('<check1 />', $check1, $content);
$content = str_replace('<check2 />', $check2, $content);
$content = str_replace('<check3 />', $check3, $content);
$content = str_replace('<modifica />', $modifica, $content);

$page_head = str_replace('<title />', "<title>$title - DOIT</title>", $page_head);
$page_head = str_replace('<scripts />', $scripts, $page_head);
$page_body = str_replace('<info_utente />', $info_utente, $page_body);
$page_body = str_replace('<breadcrumb />', $breadcrumb, $page_body);
$page_body = str_replace('<menu />', $menu, $page_body);
$page_body = str_replace('<content />', $content, $page_body);

echo $page_head . $page_body;
?>
