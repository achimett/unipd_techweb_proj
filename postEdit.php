<?php
session_start();
require_once('includes/DB.php');
require_once('includes/createInfoUtente.php');
require_once('includes/createMenu.php');
require_once('includes/createFormErrors.php');
require_once('includes/createPostEditBreadcrumb.php');

// Oggetto di accesso al database
$db = new DB();


// Controlli sicurezza
if (!isset($_SESSION['user_id'])) {
  header('Location: 404.php');
}

$post_id = NULL; // Id del post da modificare. Se resta NULL questa pagina farà inserimento
$post = NULL; // Contiene le informazioni del post da modificare oppure le info scritte prima che il submit ritornasse errore

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $post_id = $_GET['id'];
  $post = $db->getPost($post_id);

  if (($post['id_autore'] != $_SESSION['user_id']) || $post['chiuso'] === true) {
    header('Location: 404.php');
  }
}

// Inserimento nel database ed eventuale generazione di stringhe di errore
$errors = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['salva'])) {
    $img_path = '';

    if (is_uploaded_file($_FILES['img']['tmp_name'])) {
      $img_path = $_FILES['img']['tmp_name'];
    }

    $post = $_POST;

    $result = $db->setPost($post_id,
                           $_POST['titolo'],
                           $_SESSION['user_id'],
                           $_POST['data'],
                           $_POST['ora'],
                           $_POST['descrizione'],
                           $img_path,
                           $_POST['luogo'],
                           $_POST['provincia']);

    if (is_numeric($result)) {
      header('Location: post.php?id=' . $result);
    } else {
      $errors = createFormErrors($result);
    }
  }
  else if (isset($_POST['elimina'])) {
    $db->deletePost($post_id);
    header('Location: bacheca.php');
  }
}

// Titolo della pagina
$title = '';
if ($post === NULL) {
  $title = 'Crea Nuovo Post';
} else {
  $title = 'Modifica Post';
}

// Contengono l'HTML dei tag <head> e <body> che verranno stampati
$page_head = file_get_contents('includes/head.html');
$page_body = file_get_contents('includes/body.html');

// Contiene il codice del menù ad hamburger
$hamburger = file_get_contents('includes/hamburger.html');

// Concatenazione di tutti i JS da includere nell'head
$scripts = file_get_contents('includes/scriptMenu.html')
. file_get_contents('includes/scriptConfirmDelete.html')
. file_get_contents('includes/scriptValidatePostEdit.html');

// Contiene lo snippet di codice per visualizzare l'utente loggato in alto a sinistra
$info_utente = createInfoUtente($db);

// Codice HTML del menu
$menu = createMenu(true, true, false, true, true, true);

// Codice HTML del breadcrumb
$breadcrumb = createPostEditBreadcrumb($db, $post_id);

// Codice HTML del content
$content = file_get_contents('includes/contentPostEdit.html');

$content = str_replace('<error />', $errors, $content);

if ($post_id === NULL) {
  $content = str_replace('<elimina />', '', $content);
} else {
  $content = str_replace('<elimina />', file_get_contents('includes/contentEliminaPost.html'), $content);
}

if ($post === NULL) {
  $content = str_replace('<action />', 'postEdit.php', $content);
  $content = str_replace('<titolo />', '', $content);
  $content = str_replace('<data />', '', $content);
  $content = str_replace('<ora />', '', $content);
  $content = str_replace('<descrizione />', "Inserisci qui la descrizione dell'attività che vuoi svolgere", $content);
  $content = str_replace('<luogo />', '', $content);
  $content = str_replace('<provincia />', '', $content);
  $content = str_replace('<titoloContainer />', "Nuovo post", $content);
} else {
  $content = str_replace('<action />', 'postEdit.php?id=' . $post_id, $content);
  $content = str_replace('<titolo />', $post['titolo'], $content);
  $content = str_replace('<data />', $post['data'], $content);
  $content = str_replace('<ora />', $post['ora'], $content);
  $content = str_replace('<descrizione />', $post['descrizione'], $content);
  $content = str_replace('<luogo />', $post['luogo'], $content);
  $content = str_replace('<provincia />', $post['provincia'], $content);
  $content = str_replace('<titoloContainer />', "Modifica post", $content);
}

// Rimpiazzo dei segnaposto sull'intera pagina
$page_head = str_replace('<title />', "<title>$title - DOIT</title>", $page_head);
$page_head = str_replace('<scripts />', $scripts, $page_head);
$page_body = str_replace('<skip />', 'postEdit', $page_body);
$page_body = str_replace('<info_utente />', $info_utente, $page_body);
$page_body = str_replace('<hamburger />', $hamburger, $page_body);
$page_body = str_replace('<breadcrumb />', $breadcrumb, $page_body);
$page_body = str_replace('<menu />', $menu, $page_body);
$page_body = str_replace('<content />', $content, $page_body);

echo $page_head . $page_body;
?>
