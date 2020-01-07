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
    return '<p id="breadcrumb">Crea Nuovo Post</p>';
  }

  return '<p id="breadcrumb">' .
  '<a href="index.html">Bacheca</a> &gt;&gt; ' .
  '<a href="post?id=' . $id . '">Post</a> &gt;&gt; ' .
  'Modifica</p>';
}
?>
