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

  public function getPost($id = NULL) {
    return [
      'id' => $id,
      'titolo' => 'Coperte ai senzatetto',
      'id_autore' => 12,
      'data' => '12/12/2020',
      'ora' => '20:30',
      'descrizione' => 'Minima ipsa eos consequuntur. Iure vel commodi in magni autem non. Fuga exercitationem nesciunt unde accusantium molestias eligendi voluptatem voluptatem. Non ut dicta perspiciatis ea consequatur dolor. Adipisci et provident velit ducimus est temporibus nisi.',
      'img_path' => 'img/_template_foto/rifiuti3.jpg',
      'via' => 'Via dei Cipressi, 25',
      'provincia' => 'Padova',
      'chiuso' => false,
    ];
  }

  public function setPost($id, $titolo, $id_autore, $data, $ora, $descrizione,
  $img_path, $via, $provincia) {
    //return 24;
    return array('errore 1', 'errore 2', 'errore 3');
  }

  getPostcard($page, $postcard_per_page, &$page_count, $filter = NULL) {
    
  }
}
?>
