<?php
/**
* La funzione ha in input l'id dell'utente di cui si sta visualizzando il profilo
* e richiede che la sesssione sia aperta. La funzione ritorna una stringa vuota se
* l'utente non e' loggato oppure se l'utente che sta visualizzando il profilo non
* ne e' il proprietario, altrimenti viene ritornato il codice del pulsante per
* modificare il profilo.
* L'input tabindex indica il valore di tabindex del pulsante generato
*/
function createProfiloEditButton($id, $tabindex) {
  $result = '';

  if (isset($_SESSION['user_id']) === true && $_SESSION['user_id'] == $id) {
    $result = '<form action="profiloEdit.php"><div>' .
               '<input type="hidden" name="id" value="' . $id . '" />' .
               '<input id="profilo_modifica_profilo" type="submit" value="Modifica il tuo profilo" tabindex="' . $tabindex . '" />' .
               '</div></form>' . "\n";
  }

  return $result;
}
?>
