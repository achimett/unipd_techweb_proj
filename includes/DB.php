<?php
/* CLASSE MOCK PER DB */
class DB {
  public function getUser($id) {
    return [
      'img_path' => 'img/utentebianco_icon.png',
      'nome' => 'Francesco',
      'cognome' => 'De Salvador',
    ];

    return $usr;
  }

  public function getProfilo($id) {
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

  public function getProfiloTable($id, $open_close) {
    return array (
      array (
        'id'=>'2',
        'titolo'=>'Attivita1',
        'data'=>'12/12/2012',
        'chiuso'=>true,
      ),
      array (
        'id'=>'56',
        'titolo'=>'Attivita2',
        'data'=>'12/12/2000',
        'chiuso'=>false,
      ),
      array (
        'id'=>'89',
        'titolo'=>'Attivita3',
        'data'=>'12/12/2012',
        'chiuso'=>true,
      ),
      array (
        'id'=>'42',
        'titolo'=>'Attivita4',
        'data'=>'12/12/2012',
        'chiuso'=>false,
      ),
    )
  }

  public function setProfilo($id, $email, $password, $conf_password, $nome,
  $cognome, $datanascita, $cf, $bio, $img_path, $telefono) {
    //return 12;
    return array('errore 1', 'errore 2', 'errore 3');
  }

  public function deleteProfilo($id) {
    unset($_SESSION['user_id']);
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
      'luogo' => 'Via dei Cipressi 25, Borgoricco',
      'provincia' => 'Padova',
      'chiuso' => false,
      'nvolontari' => 25,
    ];
  }

  public function setPost($id, $titolo, $id_autore, $data, $ora, $descrizione,
  $img_path, $via, $provincia) {
    //return 24;
    return array('errore 1', 'errore 2', 'errore 3');
  }

  public function deletePost($id) {

  }

  public function getPostcard($page, $postcard_per_page, &$page_count, $filter = NULL) {
    return array(
      array(
        'id' => 7,
        'titolo' => 'Raccolta Rifiuti',
        'data' => '12/12/2020',
        'provincia' => 'Padova',
        'nvolontari' => 42,
        'descrizione' => "Ei fu, e adesso non c'è più",
      ),
      array(
        'id' => 14,
        'titolo' => 'Raccolta Rifiuti',
        'data' => '12/12/2020',
        'provincia' => 'Padova',
        'nvolontari' => 987,
        'descrizione' => "Ei fu, e adesso non c'è più",
      ),
      array(
        'id' => 21,
        'titolo' => 'Raccolta Rifiuti',
        'data' => '12/12/2020',
        'provincia' => 'Padova',
        'nvolontari' => 456,
        'descrizione' => "Ei fu, e adesso non c'è più",
      ),
      array(
        'id' => 28,
        'titolo' => 'Raccolta Rifiuti',
        'data' => '12/12/2020',
        'provincia' => 'Padova',
        'nvolontari' => 333,
        'descrizione' => "Ei fu, e adesso non c'è più",
      ),
      array(
        'id' => 35,
        'titolo' => 'Raccolta Rifiuti',
        'data' => '12/12/2020',
        'provincia' => 'Padova',
        'nvolontari' => 333,
        'descrizione' => "Ei fu, e adesso non c'è più",
      ),
      array(
        'id' => 42,
        'titolo' => 'Raccolta Rifiuti',
        'data' => '12/12/2020',
        'provincia' => 'Padova',
        'nvolontari' => 333,
        'descrizione' => "Ei fu, e adesso non c'è più",
      ),
    );
  }
}
?>
