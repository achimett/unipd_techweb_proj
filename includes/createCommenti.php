<?php
function createCommenti($db, $profilo, $k) {
  $listaCommenti = '';


  $commenti = $db->getCommenti($_GET['id']);

  echo "get comme --";

  foreach($commenti as $commento) {
    $c = file_get_contents("includes/commento.html");

    $c = str_replace("<linkProfilo />", $profilo . $commento["id_autore"], $c);
    $c = str_replace('<autore />', $commento['nome'] . " " . $commento['cognome'], $c);
    $c = str_replace('<data />', $commento['data'], $c);
    $c = str_replace('<text />', $commento['text'], $c);
    $c = str_replace('<img_path />', $commento['img_path'], $c);
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
