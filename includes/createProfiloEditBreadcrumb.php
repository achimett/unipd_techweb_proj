<?php
/**
* Richiede che la sessione sia attiva e che isset($_SESSION['user_id']) === ture.
* Ha come imput un oggetto di tipo DB per relazionarsi con il database.
*
* Restituisce lo snippet di codice HTML del div con id="breadcrumb" per
* la pagina di profiloEdit
*/
function createPostEditBreadcrumb($db) {
  return '<p id="breadcrumb">' .
  '<a href="profilo.php?id=' . $_SESSION['user_id'] . '">Profilo</a> &gt;&gt; Modifica</p>';
}
?>
