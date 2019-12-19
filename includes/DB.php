<?php
/* CLASSE MOCK PER DB */
class DB {
  public function getUser($mock = NULL) {
    $usr = [
      'id' => 666,
      'img' => '../img/utentebianco_icon.png',
      'name' => 'Francesco',
      'surname' => 'De Salvador',
    ];

    return $usr;
  }
}
?>
