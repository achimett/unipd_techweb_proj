<?php
/* CLASSE MOCK PER DB */
class DB {
  public function getUser($mock = NULL) {
    return [
      'img_path' => 'img/utentebianco_icon.png',
      'nome' => 'Francesco',
      'cognome' => 'De Salvador',
    ];

    return $usr;
  }

  public function getProfilo($mock = NULL) {
    return [
      'nome' => 'Gianfranco',
      'cognome' => 'Piruvato',
      'datanascita' => '11/11/2011',
      'cf' => 'ZSTHSP82B45H086C',
      'email' => 'abc@def.gh',
      'telefono' => '3333333333',
      'password' => 'unoduetre',
      'img_path' => 'img/utentenero_icon.png',
      'bio' => 'Ei fu, e adesso non c\'è più.',
    ];
  }

  public function setProfilo($id, $email, $password, $conf_password, $nome,
  $cognome, $datanascita, $cf, $bio, $img_path, $telefono) {
    //return 12;
    return array('errore 1', 'errore 2', 'errore 3');
  }

  public function login($email, $password) {
    $_SESSION['user_id'] = 12;
    return true;
    //return false;
  }

  public function logout() {
    unset($_SESSION['user_id']);
  }
}
?>
