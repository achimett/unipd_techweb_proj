<?php
/**
* Richiede che la sessione sia attiva e che isset($_SESSION['user_id']) === ture.
* Ha come imput un oggetto di tipo DB per relazionarsi con il database e l'id del
* post che si sta modificando. Se id = NULL allora si sta creando un post nuovo.
*
* Restituisce lo snippet di codice HTML del div con id="breadcrumb" per la
* pagina di postEdit
*/
function createPostEditBreadcrumb($db, $id = NULL) {
  if ($id === NULL) {
    return '<p id="breadcrumb">Crea Nuovo <span xml:lang="en">Post</span></p>';
  }

  return '<p id="breadcrumb">' .
  '<a href="bacheca.php" tabindex="3">Bacheca</a> <img src="img/freccia_dx.png" alt="" /> ' .
  '<a href="post.php?id=' . $id . '" tabindex="4">Post</a> <img src="img/freccia_dx.png" alt="" /> ' .
  'Modifica</p>';
}
?>
