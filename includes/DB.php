<?php
/* CLASSE MOCK PER DB */

class DB {

  public function deleteCommento($id, $id_commento, $user_id) {echo "del commento";}
  public function postExist($id) {return true;}
  public function newCommento($id, $user_id, $messaggio, $foto) {echo "new commento";}

  public function abbandona($id, $user_id){echo "abbandona"; return true;}
  public function partecipa($id, $user_id){echo "partecipa"; return true;}
  public function apri($id, $user_id){echo "apri"; return true;}
  public function chiudi($id, $user_id){echo "chiudi"; return true;}

  public function isChiuso($id) {
    return true;
  }

  public function isPartecipante($id, $user_id) {
    return false;
  }
  public function isAutore($id, $user_id)  {
return false;
  }
  public function getUser($id) {
     return [
       'img_path' => 'img/utentebianco_icon.png',
       'nome' => 'Francesco',
       'cognome' => 'De Salvador',
     ];
     return $usr;
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

  public function getCommenti($mock = NULL) {

    $postSocial = array();
    $postSocial[0] = [
      'id' => 23,
      'id_autore' => 2,
      'nome' => 'Gianni',
      'cognome' => 'Bianchi',
      'data' => '12/02/12 - 13:12',
      'text' => 'dksdhtfgjkghjhj uisdfh dsui',
      'img_user_path' => '../img/_template_foto/gianni_morandi.jpg',
      'img_path' => '../img/_template_foto/back.jpeg',
    ];
    $postSocial[1] = [      'id' => 23,
          'id_autore' => 345,
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


}
?>
