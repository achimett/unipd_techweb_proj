<?php
/**
* Richiede che la sessione sia attiva e ha come imput un oggetto di
* tipo DB per relazionarsi con il database.
*
* Restituisce lo snippet di codice HTML del div con id="info_utente" se c'è un
* utente loggato altrimenti restituisce ''.
*/
function createInfoUtente($db) {
  $result = '';

  if (isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true) {
    $usr = $db->getUser($_SESSION['user_id']);

    $result = '<a id="info_utente" class="usr" tabindex="1"
    href="profilo.php?user_id=' . $usr['id'] . '">
    <img src="' . $usr['img'] . '" alt="" />
    <span>' . $usr['name'] . ' ' . $usr['surname'] . '</span></a>';
  }

  return $result;
}
?>
