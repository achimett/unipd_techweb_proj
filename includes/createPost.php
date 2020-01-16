
<?php

function check($db) {
  if(isset($_GET['id']) === false || $db->postExist($_GET['id']) === false) {
    header("location: /404.php");
    return;
  }
}

function controlloPulsanteDoit($db) {
  if (isset($_GET['id']) === true && $db->postExist($_GET['id'])) {

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) === true) {
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
      unset($_POST['action']);
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
      $legend = 'Vuoi abbondonare?';
      $pulsante = 'Abbandona';
    }
    else if(isset($_SESSION['user_id']) == true){ // se non partecipa
      $legend = 'Vuoi partecipare?';
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
    $exe = file_get_contents('includes/formDoit.html');
    $exe = str_replace('<link />', '/post.php?id=' . $_GET['id'], $exe);
    $exe = str_replace('<iscrizione />', $legend, $exe);
    $exe = str_replace('<val />', $pulsante, $exe);


  }

  return $exe;
}

function controlloNewCommento($db) {
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['invia']) === true) {
    $db->newCommento($_GET['id'], $_SESSION['user_id'], $_POST['messaggio'], $_FILES['sfoglia']['tmp_name']);
    unset($_POST['invia']);
  }
}


function controlloDeleteCommento($db) {

  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['commento_id']) === true) {
    $db->deleteCommento($_GET['id'], $_POST['commento_id'], $_SESSION['user_id']);
    unset($_POST['commento_id']);
  }
}

function createPulsanteModifica($db) {
  if (isset($_SESSION['user_id']) === true && $db->isAutore($_GET['id'], $_SESSION['user_id']) === true) {
    $result = file_get_contents("includes/editButton.html");
    $result = str_replace('<id />', $_GET['id'], $result);
    return $result;
  }
}

function createFormSocial($db, $postUrl) {
  $social = '';
  if ($db->isChiuso($_GET['id']) === false && isset($_SESSION['user_id']) === true && ($db->isPartecipante($_GET['id'], $_SESSION['user_id']) === true || $db->isAutore($_GET['id'], $_SESSION['user_id']) === true)) {
    $social = file_get_contents("includes/formSocial.html");
    $social = str_replace("<link />", $postUrl . $_GET['id'], $social);
  }
  else if (isset($_SESSION['user_id']) === false) {
    $social = file_get_contents("includes/replaceFormSocial.html");
  }

  return $social;
}

function createCommenti($db, $profilo, $k) {
  $listaCommenti = '';


  $commenti = $db->getCommenti($_GET['id']);

  foreach($commenti as $commento) {
    $c = file_get_contents("includes/commento.html");

    $c = str_replace("<linkProfilo />", $profilo . $commento["id_autore"], $c);
    $c = str_replace('<autore />', $commento['nome'] . " " . $commento['cognome'], $c);
    $c = str_replace('<data />', $commento['data'], $c);
    $c = str_replace('<text />', $commento['text'], $c);
    $c = str_replace('<img_path />', $commento['img_path'], $c);
    $c = str_replace('<img_user_path />', $commento['img_user_path'], $c);
    $c = str_replace('<tabIndex />', $k, $c);
        $k += 1;
    if (isset($_SESSION['user_id']) && $commento['id_autore'] === $_SESSION['user_id']) {
      $c = str_replace('<formImpostazoni />', file_get_contents('includes/formImpostazioni.html'), $c);
      $c = str_replace('<id />', $commento['id'], $c);
      $c = str_replace('<impostazioniTabIndex />', $k, $c);
      $k += 1;
    } else {
      $c = str_replace('<formImpostazoni />', '', $c);
    }
    $listaCommenti .= $c;

  }

  $blob['k'] = $k;
  $blob['html'] = $listaCommenti;

  return $blob;
}

function createListaVolontari($db, $profilo, $k) {
  $volontari = $db->getVolontari($db);
  $result = '';
  foreach ($volontari as $volontario) {
    $v = file_get_contents("includes/volontario.html");
    $v = str_replace("<volontario />", $volontario["nome"], $v);
    $v = str_replace("<linkProfilo />", $profilo . $volontario["id"], $v);
    $v = str_replace("<img_path />", $volontario["img_path"], $v);
    $v = str_replace('<tabIndex />', $k, $v);
    $result .= $v;
    $k += 1;
  }
  $blob['k'] = $k;
  $blob['html'] = $result;

  return $blob;

}

function createPost($db) {

  $post = file_get_contents('includes/content_post.html');

  $getPost = $db->getPost($_GET['id']);

  check($db);
  controlloPulsanteDoit($db);
  controlloNewCommento($db);
  controlloDeleteCommento($db);

  $postEdit = 'postEdit.php?id=';
  $profilo = "profilo.php?id=";
  $postUrl = "post.php?id=";

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
  $post = str_replace('<formPartecipa />', creazionePulsanteDoit($db), $post);
  $post = str_replace('<descrizione />', $getPost['descrizione'], $post);
  $post = str_replace('<volontari />', $blob['volontari']['html'], $post);
  $post = str_replace('<formSocial />', createFormSocial($db, $postUrl), $post);
  $post = str_replace('<commenti />', $blob['commenti']['html'], $post);


  return $post;


}
?>
