<?php
/* CLASSE MOCK PER DB */

class DB {
  public function postExist($id) {return true;}
  public function newCommento($id, $user_id, $messaggio, $foto){

    $_SESSION['newCommento'] = '';
    //unset($_SESSION['newCommento']);
      }

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
return false;
  }
  public function getUser($mock = NULL) {
    $usr = [
      'img' => '../img/utentebianco_icon.png',
      'name' => 'Francesco',
      'surname' => 'De Salvador',
    ];

    return $usr;
  }

  public function doit($id, $user_id, $mock = NULL){
    echo "DOIT";
  }

  public function getPost($id, $mock = NULL) {
    $post = [

      'link' => 'https://goo.gl/maps/KpxfvzkjXvCUyFcr7',
      'img_path' => 'img/_template_foto/rifiuti3.jpg',
      'titolo' => 'RACCOLTA RIFIUTI',
      'id_autore' => 1,
      'nome' => 'Paolo',
      'cognome' => 'Rossi',
      'nvolontari' => 6,
      'data' => '12/02/2020',
      'ora' => '12:00',
      'via' => 'Via Luigi Luzzatti',
      'provincia' => 'Padova',
      'descrizione' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc consectetur luctus mi. Nulla id luctus lorem. Suspendisse semper in lectus sed convallis. Sed imperdiet lectus non rhoncus laoreet. Duis condimentum vel mauris facilisis sollicitudin. Mauris nec sapien ipsum. In vulputate tincidunt sapien, et porta lorem commodo a. Aenean vitae mer augue.'
    ];

    return $post;
  }

  public function getCommenti($mock = NULL) {

    $postSocial = array();
    $postSocial[0] = [
      'user_id' => '89',
      'nome' => 'Gianni',
      'cognome' => 'Bianchi',
      'data' => '12/02/12 - 13:12',
      'text' => 'dksdhtfgjkghjhj uisdfh dsui',
      'img_usr_path' => 'img/_template_foto/gianni_morandi.jpg',
      'img_path' => 'img/_template_foto/back.jpeg',
    ];
    $postSocial[1] = [

      'user_id' => '14',
      'nome' => 'Gianni',
      'cognome' => 'Bianchi',
      'data' => '12/02/13 - 13:12',
      'text' => 'dksdhfuiodf usdfh uisdfh dsui',
      'img_usr_path' => 'img/_template_foto/gianni_morandi.jpg',
      'img_path' => 'img/_template_foto/back.jpeg',
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


}
?>
