<?php
define("POSTCARD_PER_PAGE", 6);
session_start();
require_once('includes/DB.php');
require_once('includes/createInfoUtente.php');
require_once('includes/createMenu.php');
require_once('includes/createFormErrors.php');
require_once('includes/createPostEditBreadcrumb.php');

// Oggetto di accesso al database
$db = new DB();

// Titolo della pagina
$title = 'Bacheca';

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
$menu = createMenu(true, false, true, true, true, true);

// Codice HTML del breadcrumb
$breadcrumb = '<p id="breadcrumb">Bacheca</p>';

// Numero di pagina
$page = 1;
if (isset($_GET['page']) && $_GET['page'] > 1) {
  $page = $_GET['page'];
}

// Codice HTML del content
$content = file_get_contents('includes/contentBacheca.html');

$provincia = ''; // Ricerca per provincia
if (isset($_GET['provincia'])) {
  $provincia = $_GET['provincia'];
}

$page_count = 1; // Pagine totali
$postcard_data = $db->getPostcard($page, POSTCARD_PER_PAGE, $page_count, $provincia); // Tutti i dati delle postcard

$tabindex = 22; // Valore di tabindex nel titolo delle postcard e elementi successivi
$postlist = ''; // HTML delle postcard;
foreach ($postcard_data as $postcard) {
  $result = file_get_contents('includes/contentPostcard.html');
  $result = str_replace('<link />', 'post.php?id=' . $postcard['id'], $result);
  $result = str_replace('<ti />', $tabindex++, $result);
  $result = str_replace('<titolo />', $postcard['titolo'], $result);
  $result = str_replace('<img_path />', $postcard['img_path'], $result);
  $result = str_replace('<data />', $postcard['data'], $result);
  $result = str_replace('<provincia />', $postcard['provincia'], $result);
  $result = str_replace('<nvolontari />', $postcard['nvolontari'], $result);

  $descrizione = $postcard['descrizione'];
  if (strlen($descrizione) > 200) {
    $descrizione = substr($descrizione, 0, 197) . '...';
  }
  $result = str_replace('<descrizione />', $descrizione, $result);

  $postlist .= $result . "\n";
}

// Gestione Pagine
$previous = ''; // HTML con link alla pagina precedente
$next = ''; // HTML con link alla pagina precedente
if ($page !== 1) {
  $previous = '<a href="bacheca.php?page=' . ($page - 1) . '&amp;provincia='. $provincia . '" tabindex="' . $tabindex++ . '">
  <img src="img/freccia_sx.png" alt="Pagina precedente" /></a>';
}
if ($page < $page_count) {
  $next = '<a href="bacheca.php?page=' . ($page + 1) . '&amp;provincia='. $provincia . '" tabindex="' . $tabindex++ . '">
  <img src="img/freccia_dx.png" alt="Pagina successiva" /></a>';
}

$content = str_replace('<action />', "bacheca.php?page=$page&amp;provincia=$provincia", $content);
$content = str_replace('<provincia />', $provincia, $content);
$content = str_replace('<postlist />', $postlist, $content);
$content = str_replace('<previous />', $previous, $content);
$content = str_replace('<page />', $page, $content);
$content = str_replace('<next />', $next, $content);

// Rimpiazzo dei segnaposto sull'intera pagina
$page_head = str_replace('<title />', "<title>$title - DOIT</title>", $page_head);
$page_head = str_replace('<scripts />', $scripts, $page_head);
$page_body = str_replace('<info_utente />', $info_utente, $page_body);
$page_body = str_replace('<hamburger />', $hamburger, $page_body);
$page_body = str_replace('<breadcrumb />', $breadcrumb, $page_body);
$page_body = str_replace('<menu />', $menu, $page_body);
$page_body = str_replace('<content />', $content, $page_body);

echo $page_head . $page_body;
?>
