<?php
session_start();
require_once('includes/DB.php');
require_once('includes/createInfoUtente.php');
require_once('includes/createMenu.php');
require_once('includes/createFormErrors.php');

// Oggetto di accesso al database
$db = new DB();

if (isset($_SESSION['user_id'])) {
  $db->logout();
  header('Location: index.php');
}

// Inserimento nel database ed eventuale generazione di stringhe di errore
$error_login = '';
$error_registrazione = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (isset($_POST['login'])) {

    if ($db->login($_POST['email'], $_POST['password'])) {
      header('Location: bacheca.php');
    } else {
      $error_login = createFormErrors(array('Utente o <span xml:lang="en">Password</span> errati'));
    }

  } else if (isset($_POST['registrazione'])) {
    $img_path = '';

    if (isset($_FILES['img']) && is_uploaded_file($_FILES['img']['tmp_name'])) {
      $img_path = $_FILES['img']['tmp_name'];
    }

    $result = $db->setProfilo(NULL,
                              $_POST['email'],
                              $_POST['password'],
                              $_POST['conf_password'],
                              $_POST['nome'],
                              $_POST['cognome'],
                              $_POST['datanascita'],
                              $_POST['cf'],
                              $_POST['bio'],
                              $img_path,
                              $_POST['telefono']);

    if (is_numeric($result)) {
      header('Location: profilo.php?id=' . $_SESSION['user_id']);
    } else {
      $error_registrazione = createFormErrors($result);
    }
  }
}

// Titolo della pagina
$title = 'Accedi / Registrati';

// Contengono l'HTML dei tag <head> e <body> che verranno stampati
$page_head = file_get_contents('includes/head.html');
$page_body = file_get_contents('includes/body.html');

// Contiene il codice del menù ad hamburger
$hamburger = file_get_contents('includes/hamburger.html');

// Concatenazione di tutti i JS da includere nell'head
$scripts = file_get_contents('includes/scriptMenu.html')
. file_get_contents('includes/scriptValidateProfilo.html')
. file_get_contents('includes/scriptLogin.html');

// Codice HTML del menu
$menu = createMenu(true, true, true, true, true, false);

// Codice HTML del breadcrumb
$breadcrumb = "<p id=\"breadcrumb\">$title</p>";

// Codice HTML del content
$content = file_get_contents('includes/contentLogin.html');

$content = str_replace('<reg />', file_get_contents('includes/registrazione.html'), $content);

$content = str_replace('<profiloEditTitolo />', "Registrati", $content);
$content = str_replace('<testoBottone />', "invia", $content);
$content = str_replace('<nomeSubmit />', "registrazione", $content);
$content = str_replace('<delButton />', "", $content);

$content = str_replace('<goto />', 'login.php', $content);

$content = str_replace('<errorLogin />', $error_login, $content);
$content = str_replace('<errorRegistrazione />', $error_registrazione, $content);

if (isset($_POST['registrazione'])) {
  $content = str_replace('<nome />', $_POST['nome'], $content);
  $content = str_replace('<cognome />', $_POST['cognome'], $content);
  $content = str_replace('<datanascita />', $_POST['datanascita'], $content);
  $content = str_replace('<cf />', $_POST['cf'], $content);
  $content = str_replace('<email />', $_POST['email'], $content);
  $content = str_replace('<telefono />', $_POST['telefono'], $content);
  $content = str_replace('<bio />', $_POST['bio'], $content);
} else {
  $content = str_replace('<nome />', '', $content);
  $content = str_replace('<cognome />', '', $content);
  $content = str_replace('<datanascita />', '', $content);
  $content = str_replace('<cf />', '', $content);
  $content = str_replace('<email />', '', $content);
  $content = str_replace('<telefono />', '', $content);
  $content = str_replace('<bio />', '', $content);
}

// Rimpiazzo dei segnaposto sull'intera pagina
$page_head = str_replace('<title />', "<title>$title - DOIT</title>", $page_head);
$page_head = str_replace('<scripts />', $scripts, $page_head);
$page_body = str_replace('<info_utente />', '', $page_body);
$page_body = str_replace('<hamburger />', $hamburger, $page_body);
$page_body = str_replace('<breadcrumb />', $breadcrumb, $page_body);
$page_body = str_replace('<menu />', $menu, $page_body);
$page_body = str_replace('<content />', $content, $page_body);

echo $page_head . $page_body;
?>
