<?php
/* CLASSE MOCK PER DB */
class DB {
  public function postExist($id) {return true;}
  public function newCommento($id, $user_id, $messaggio, $foto){}

  public function abbandona($id, $user_id){ return true;}
  public function partecipa($id, $user_id){ return true;}
  public function apri($id, $user_id){ return true;}
  public function chiudi($id, $user_id){ return true;}

  public function isChiuso($id) {
    return false;
  }

  public function isPartecipante($id, $user_id) {
    return true;
  }
  public function isAutore($id, $user_id)  {
return true;
  }
  public function getUser($mock = NULL) {
    $usr = [
      'img_path' => 'img/utentebianco_icon.png',
      'nome' => 'Francesco',
      'cognome' => 'De Salvador',
    ];

    return $usr;
  }

  public function doit($id, $user_id, $mock = NULL){
    echo "DOIT";
  }

  public function getCommenti($mock = NULL) {

    $postSocial = array();
    $postSocial[0] = [
      'user_id' => '89',
      'nome' => 'Gianni',
      'cognome' => 'Bianchi',
      'data' => '12/02/12 - 13:12',
      'text' => 'dksdhtfgjkghjhj uisdfh dsui',
      'img_user_path' => '../img/_template_foto/gianni_morandi.jpg',
      'img_path' => '../img/_template_foto/back.jpeg',
    ];
    $postSocial[1] = [

      'user_id' => '14',
      'nome' => 'Gianni',
      'cognome' => 'Bianchi',
      'data' => '12/02/13 - 13:12',
      'text' => 'dksdhfuiodf usdfh uisdfh dsui',
      'img_user_path' => '../img/_template_foto/gianni_morandi.jpg',
      'img_path' => '../img/_template_foto/back.jpeg',
    ];

    if(isset($_SESSION['newCommento'])) {
      $postSocial[2] = [

        'user_id' => '14',
        'nome' => 'Gianni',
        'cognome' => 'Bianchi',
        'data' => '12/02/13 - 13:12',
        'text' => 'dksdhfuiodf usdfh uisdfh dsui',
        'img_usr_path' => 'img/_template_foto/gianni_morandi.jpg',
        'img_path' => 'img/_template_foto/back.jpeg',
      ];

      unset($_SESSION['newCommento']);
    }

    return $postSocial;
  }

  public function getVolontari($mock = NULL) {
    $postVolontari = array();
    $postVolontari[0] = [
      'img_path' => 'img/_template_foto/gianni_morandi.jpg',
      'id' => '23',
      'nome' => 'ALdo',
      'cognome' => 'Morin',
    ];
    $postVolontari[1] = [
      'id' => '23',
      'img_path' => 'img/_template_foto/gianni_morandi.jpg',
      'nome' => 'Francesco',
      'cognome' => 'Decet',
    ];
    return $postVolontari;
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

  public function getProfiloTable($id, $status = 0) {
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
    );
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

  public function getPost($id, $mock = NULL) {
    $post = [
      'link' => 'https://goo.gl/maps/KpxfvzkjXvCUyFcr7',
      'img_path' => '../img/_template_foto/rifiuti3.jpg',
      'titolo' => 'RACCOLTA RIFIUTI',
      'id_autore' => 1,
      'nome' => 'Paolo',
      'cognome' => 'Rossi',
      'nvolontari' => 6,
      'data' => '12/02/2020',
      'ora' => '12:00',
      'luogo' => 'Via Luigi Luzzatti',
      'provincia' => 'Padova',
      'descrizione' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc consectetur luctus mi. Nulla id luctus lorem. Suspendisse semper in lectus sed convallis. Sed imperdiet lectus non rhoncus laoreet. Duis condimentum vel mauris facilisis sollicitudin. Mauris nec sapien ipsum. In vulputate tincidunt sapien, et porta lorem commodo a. Aenean vitae mer augue.'
    ];

    return $post;
  }

  // public function getPost($id = NULL) {
  //   return [
  //     'id' => $id,
  //     'titolo' => 'Coperte ai senzatetto',
  //     'id_autore' => 12,
  //     'data' => '12/12/2020',
  //     'ora' => '20:30',
  //     'descrizione' => 'Minima ipsa eos consequuntur. Iure vel commodi in magni autem non. Fuga exercitationem nesciunt unde accusantium molestias eligendi voluptatem voluptatem. Non ut dicta perspiciatis ea consequatur dolor. Adipisci et provident velit ducimus est temporibus nisi.',
  //     'img_path' => 'img/_template_foto/rifiuti3.jpg',
  //     'luogo' => 'Via dei Cipressi 25, Borgoricco',
  //     'provincia' => 'Padova',
  //     'chiuso' => false,
  //     'nvolontari' => 25,
  //   ];
  // }

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
