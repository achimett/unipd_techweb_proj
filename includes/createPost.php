
<?php

function check($db) {
  if(isset($_GET['id']) === false || $db->postExist($_GET['id']) === false) {
    header("location: /404.php");
    return;
  }
}

function controlloPulsanteDoit($db) {
  if (isset($_GET['id']) === true && $db->postExist($_GET['id'])) {

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['invia']) === true) {
      if(isset($_SESSION['user_id']) === true) {

        if($db->isChiuso($_GET['id']) === false){
          if($db->isAutore($_GET['id'], $_SESSION['user_id']) === true){
            $db->chiudi($_GET['id'], $_SESSION['user_id']);
          }
          else if($db->isPartecipante($_GET['id'], $_SESSION['user_id']) === true){
            $db->abbandona($_GET['id'], $_SESSION['user_id']);
          }
          else if($db->isPartecipante($_GET['id'], $_SESSION['user_id']) === false){
            $db->partecipa($_GET['id'], $_SESSION['user_id']);
          }
        } else {
          if($db->isAutore($_GET['id'], $_SESSION['user_id']) === true){
            $db->apri($_GET['id'], $_SESSION['user_id']);
          }
        }
      }
      unset($_POST['invia']);
    }
  }
}

function creazionePulsanteDoit($db) {

  $legend = '';
  $pulsante = '';
  $exe = '';

  if($db->isChiuso($_GET['id']) === false){
    if(isset($_SESSION['user_id']) === true && $db->isAutore($_GET['id'], $_SESSION['user_id']) === true){
      $legend = 'Termina attivita';
      $pulsante = 'Chiudi';
    }
    else if(isset($_SESSION['user_id']) === true && $db->isPartecipante($_GET['id'], $_SESSION['user_id']) === true){
      $legend = 'Iscrizione';
      $pulsante = 'Abbandona';
    }
    else if(isset($_SESSION['user_id']) == true){ // se non partecipa
      $legend = 'Iscrizione';
      $pulsante = 'Partecipa';
    }
    else { // se non loggato
      $exe = file_get_contents('includes/replaceFormDoit.html');
      $exe = str_replace("<log />", "Registrati per partecipare!", $exe);
    }
  } else {
    if(isset($_SESSION['user_id']) === true && $db->isAutore($_GET['id'], $_SESSION['user_id']) === true){
      $legend = 'Riapri attivita';
      $pulsante = 'Apri';
    } else {
      $exe = file_get_contents('includes/replaceFormDoit.html');
      $exe = str_replace("<log />", "Attivita terminata", $exe);
    }
  }
  if($legend !== '') {
    $exe = '<form action="/post.php?id=' . $_GET['id'] . '" id="doit" method="post"><fieldset><legend class="post_titolo">' . $legend . '</legend>
    <input type="submit" name="doit" value="' . $pulsante . '" tabindex="21" /></fieldset></form>';
  }

  return $exe;
}

function controlloNewCommento($db) {
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['invia']) === true) {
    $db->newCommento($_GET['id'], $_SESSION['user_id'], $_POST['messaggio'], $_FILES['sfoglia']['tmp_name']);
    unset($_POST['sfoglia']);
  }
}

function createPulsanteModifica($db) {
  if (isset($_SESSION['user_id']) === true && $db->isAutore($_GET['id'], $_SESSION['user_id']) === true) {
    return file_get_contents("includes/editButton.html");
  }
}

function createFormSocial($db) {
  $social = '';
  if ($db->isChiuso($_GET['id']) === false) {
    if (isset($_SESSION['user_id']) === true && ($db->isPartecipante($_GET['id'], $_SESSION['user_id']) === true || $db->isAutore($_GET['id'], $_SESSION['user_id']) === true)) {
      $social .= file_get_contents("includes/formSocial.html");
    } else {
      $social .= file_get_contents("includes/replaceFormSocial.html");
    }
  }
  return $social;
}

function createCommenti($db) {
  $listaCommenti = '';

  $commenti = $db->getCommenti($_GET['id']);
  foreach($commenti as $commento) {
    $c = file_get_contents("includes/commento.html");
    $c = str_replace('<autore />', $commento['nome'] . " " . $commento['cognome'], $c);
    $c = str_replace('<data />', $commento['data'], $c);
    $c = str_replace('<text />', $commento['text'], $c);
    $c = str_replace('<img_path />', $commento['img_path'], $c);
    $c = str_replace('<img_user_path />', $commento['img_user_path'], $c);
    $listaCommenti .= $c;
  }
  $listaCommenti .= '</div></div>';

  return $listaCommenti;
}

function createListaVolontari($db) {
  $volontari = $db->getVolontari($id);
  $result = '';
  foreach ($volontari as $volontario) {
    $v = file_get_contents("includes/volontario.html");
    $v = str_replace("<volontario />", $volontario["nome"], $v);
    $v = str_replace("<linkProfilo />", "profilo.php?id=". $volontario["id"], $v);
    $v = str_replace("<img_path />", $volontario["img_path"], $v);
    $result .= $v;
  }

  return $result;
}

function createPost($db) {

  $post = file_get_contents('includes/content_post.html');

  $getPost = $db->getPost($_GET['id']);

  check($db);
  controlloPulsanteDoit($db);
  controlloNewCommento($db);


  $postEdit = 'postEdit.php?id=';
  $profilo = "profilo.php?id=";

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
  $post = str_replace('<formPartecipa />', creazionePulsanteDoit($db), $post);
  $post = str_replace('<descrizione />', $getPost['descrizione'], $post);
  $post = str_replace('<volontari />', createListaVolontari($db), $post);
  $post = str_replace('<formSocial />', createFormSocial($db), $post);
  $post = str_replace('<commenti />', createCommenti($db), $post);


  return $post;

  
}
?>
