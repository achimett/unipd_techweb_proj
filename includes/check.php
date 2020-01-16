
<?php

/**
* La funzione reindirizza l'utente a 404 se il post non esiste
*/
function check($db) {
  if(isset($_GET['id']) === false || $db->postExist($_GET['id']) === false) {
    header("location: /404.php");
    return;
  }
}

?>
