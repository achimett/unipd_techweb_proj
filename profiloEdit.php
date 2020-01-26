<?php
session_start();
require_once('includes/DB.php');
require_once('includes/createInfoUtente.php');
require_once('includes/createMenu.php');
require_once('includes/createFormErrors.php');
require_once('includes/createProfiloEditBreadcrumb.php');

// Oggetto di accesso al database
$db = new DB();

// Controllo sicurezza
if (!(isset($_GET['id']) &&
      isset($_SESSION['user_id']) &&
      $_GET['id'] == $_SESSION['user_id'])) {
  header('Location: 404.php');
}

// Gestione del metodo POST
$profilo = '';
$errors = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['salva'])) {
    $img_path = '';

    if (isset($_FILES['img']) && is_uploaded_file($_FILES['img']['tmp_name'])) {
      $img_path = $_FILES['img']['tmp_name'];
    }

    $result = $db->setProfilo($_SESSION['user_id'],
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

    if ($result == $_SESSION['user_id']) {
      header('Location: profilo.php?id=' . $_SESSION['user_id']);
    } else {
      $profilo = $_POST;
      $errors = createFormErrors($result);
    }
  } else if (isset($_POST['elimina'])) {
    $db->deleteProfilo($_SESSION['user_id']);
    header('Location: index.php');
  }
}

// Titolo della pagina
$title = 'Modifica Profilo';

// Contengono l'HTML dei tag <head> e <body> che verranno stampati
$page_head = file_get_contents('includes/head.html');
$page_body = file_get_contents('includes/body.html');

// Concatenazione di tutti i JS da includere nell'head
$scripts = file_get_contents('includes/scriptMenu.html')
. file_get_contents('includes/scriptConfirmDelete.html');

// Contiene lo snippet di codice per visualizzare l'utente loggato in alto a sinistra
$info_utente = createInfoUtente($db);

// Codice HTML del menu
$menu = createMenu(true, true, true, true, true, true);

// Codice HTML del breadcrumb
$breadcrumb = createPostEditBreadcrumb($db);

// Codice HTML del content
$content = file_get_contents('includes/contentProfiloEdit.html');

$content = str_replace('<mod />', file_get_contents('includes/registrazione.html'), $content);

$content = str_replace('<delButton />', file_get_contents('includes/contentProfiloEditDeletebutton.html'), $content);


$content = str_replace('<profiloEditTitolo />', "Modifica profilo", $content);
$content = str_replace('<testoBottone />', "Salva", $content);
$content = str_replace('<nomeSubmit />', "salva", $content);

$content = str_replace('<goto />', 'profiloEdit.php?id=' . $_SESSION['user_id'], $content);

$content = str_replace('<action />', 'profiloEdit.php?id=' . $_SESSION['user_id'], $content);
$content = str_replace('<errorRegistrazione />', $errors, $content);

if ($profilo == '') {
  $profilo = $db->getProfilo($_SESSION['user_id']);
}
$content = str_replace('<nome />', $profilo['nome'], $content);
$content = str_replace('<cognome />', $profilo['cognome'], $content);
$content = str_replace('<datanascita />', $profilo['datanascita'], $content);
$content = str_replace('<cf />', $profilo['cf'], $content);
$content = str_replace('<email />', $profilo['email'], $content);
$content = str_replace('<telefono />', $profilo['telefono'], $content);
$content = str_replace('<password />', '', $content);
$content = str_replace('<img_path />', '', $content);
$content = str_replace('<bio />', $profilo['bio'], $content);

// Rimpiazzo dei segnaposto sull'intera pagina
$page_head = str_replace('<title />', "<title>$title - DOIT</title>", $page_head);
$page_head = str_replace('<scripts />', $scripts, $page_head);
$page_body = str_replace('<info_utente />', $info_utente, $page_body);
$page_body = str_replace('<breadcrumb />', $breadcrumb, $page_body);
$page_body = str_replace('<menu />', $menu, $page_body);
$page_body = str_replace('<content />', $content, $page_body);

echo $page_head . $page_body;
?>
