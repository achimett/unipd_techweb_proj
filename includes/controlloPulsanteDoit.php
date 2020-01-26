<?php

/**
* La funzione reindirizza l'utente a 404 se il post non esiste
*/
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
 ?>
