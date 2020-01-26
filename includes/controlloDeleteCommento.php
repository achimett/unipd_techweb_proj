<?php
function controlloDeleteCommento($db) {

  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delCommento']) === true) {
    $db->deleteCommento($_GET['id'], $_POST['commento_id'], $_SESSION['user_id']);
    unset($_POST['delCommento']);
  }
}

?>
