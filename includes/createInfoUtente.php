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

  if (isset($_SESSION['user_id']) === true) {
    $usr = $db->getUser($_SESSION['user_id']);

    $result = '<a id="info_utente" class="usr" tabindex="2"
    href="profilo.php?id=' . $_SESSION['user_id'] . '">
    <img src="' . $usr['img_path'] . '" alt="" />
    <span>' . $usr['nome'] . ' ' . $usr['cognome'] . '</span></a>';
  }

  return $result;
}
?>
