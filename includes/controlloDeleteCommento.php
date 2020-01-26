<?php
function controlloDeleteCommento($db) {

  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delCommento']) === true) {
  
    $db->deleteCommento($_POST['commento_id']);
    unset($_POST['delCommento']);
  }
}

?>
