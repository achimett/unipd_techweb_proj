<?php
/* CLASSE MOCK PER DB */
class DB {
  public function getUser($mock = NULL) {
    $usr = [
      'img' => '../img/utentebianco_icon.png',
      'name' => 'Francesco',
      'surname' => 'De Salvador',
    ];

    return $usr;
  }
}
?>
