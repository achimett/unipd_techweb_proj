<?php
function createCommenti($db, $profilo, $k) {
  $listaCommenti = '';


  $commenti = $db->getCommenti($_GET['id']);

  foreach($commenti as $commento) {
    $c = file_get_contents("includes/commento.html");

    $c = str_replace("<linkProfilo />", $profilo . $commento["id_autore"], $c);
    $c = str_replace('<autore />', $commento['nome'] . " " . $commento['cognome'], $c);
    $c = str_replace('<data />', $commento['data'], $c);
    $c = str_replace('<text />', $commento['text'], $c);
    var_dump($commento['img_path']);
    if(empty($commento['img_path']) == false) {
      $c = str_replace('<img_path />', '  <img class="post_commento_image" src="' . $commento['img_path'] . '" alt="immagine di <autore />" />', $c);
      $c = str_replace('<autore />', $commento['nome'], $c);
    } else {
      $c = str_replace('<img_path />', '', $c);
    }
    $c = str_replace('<img_user_path />', $commento['img_user_path'], $c);
    $c = str_replace('<tabIndex />', $k, $c);
    $k += 1;
    if (isset($_SESSION['user_id']) && $commento['id_autore'] === $_SESSION['user_id']) {
      $c = str_replace('<formImpostazoni />', file_get_contents('includes/formImpostazioni.html'), $c);
      $c = str_replace('<id />', $commento['id'], $c);
      $c = str_replace('<impostazioniTabIndex />', $k, $c);
      $k += 1;
    } else {
      $c = str_replace('<formImpostazoni />', '', $c);
    }
    $listaCommenti .= $c;

  }

  $blob['k'] = $k;
  $blob['html'] = $listaCommenti;

  return $blob;
}
?>
