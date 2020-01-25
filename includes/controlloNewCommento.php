<?php
function controlloNewCommento($db) {
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['invia']) === true && ($_POST['messaggio'] !== '' || $_FILES['sfoglia']['tmp_name'] !== "")) {
    $db->newCommento($_GET['id'], $_SESSION['user_id'], $_POST['messaggio'], $_FILES['sfoglia']['tmp_name']);
    unset($_POST['invia']);
  }
}

 ?>
