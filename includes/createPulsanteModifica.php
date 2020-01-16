<?php
function createPulsanteModifica($db) {
  if (isset($_SESSION['user_id']) === true && $db->isAutore($_GET['id'], $_SESSION['user_id']) === true) {
    $result = file_get_contents("includes/editButton.html");
    $result = str_replace('<id />', $_GET['id'], $result);
    return $result;
  }
}
?>
