<?php

function createFormSocial($db, $postUrl) {
  $social = '';
  if ($db->isChiuso($_GET['id']) === false && isset($_SESSION['user_id']) === true && ($db->isPartecipante($_GET['id'], $_SESSION['user_id']) === true || $db->isAutore($_GET['id'], $_SESSION['user_id']) === true)) {
    $social = file_get_contents("includes/formSocial.html");
    $social = str_replace("<link />", $postUrl . $_GET['id'], $social);
  }
  else if (isset($_SESSION['user_id']) === false) {
    $social = file_get_contents("includes/replaceFormSocial.html");
  }

  return $social;
}
?>
