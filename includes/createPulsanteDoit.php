<?php

function createPulsanteDoit($db) {

  $legend = '';
  $pulsante = '';
  $exe = '';

  if($db->isChiuso($_GET['id']) === false){
    if(isset($_SESSION['user_id']) === true && $db->isAutore($_GET['id'], $_SESSION['user_id']) === true){
      $legend = 'Termina attività';
      $pulsante = 'Chiudi';
    }
    else if(isset($_SESSION['user_id']) === true && $db->isPartecipante($_GET['id'], $_SESSION['user_id']) === true){
      $legend = 'Vuoi abbondonare?';
      $pulsante = 'Abbandona';
    }
    else if(isset($_SESSION['user_id']) == true && $db->isPartecipante($_GET['id'], $_SESSION['user_id']) === false){ // se non partecipa
      $legend = 'Vuoi partecipare?';
      $pulsante = 'Partecipa';
    }
    else { // se non loggato
      $exe = file_get_contents('includes/replaceFormDoit.html');
      $exe = str_replace("<log />", "Registrati per partecipare!", $exe);
    }
  } else {
    if(isset($_SESSION['user_id']) === true && $db->isAutore($_GET['id'], $_SESSION['user_id']) === true){
      $legend = 'Riapri attività';
      $pulsante = 'Apri';
    } else {
      $exe = file_get_contents('includes/replaceFormDoit.html');
      $exe = str_replace("<log />", "Attività terminata", $exe);
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

?>
