
<?php


function createPost($db) {
  $post = $db->getPost($_GET['id']);
  $volontari = $db->getVolontari($_GET['id']);
  $commenti = $db->getCommenti($_GET['id']);

  // immagine di copertina e titolo

  $result = '
  <div class="content" id="post">
  <img id="post_immagineiniziale" src="' . $post['img_path'] . '" alt="foto iniziale" />
  <h1 class="titolo_post">' . $post['titolo'] . '</h1>
  <div id="post_informazioni">
  <h2 class="post_titolo">Informazioni</h2>
  <ul id="post_informazioni_lista">
  <li><p class="post_informazioni_record" id="post_informazioni_utente">Post di<br /><a href="/unipd_techweb_proj/profilo.php?' . $post['id_autore'] . '"><strong>' . $post['nome'] . ' ' . $post['cognome'] . '</strong></a></p></li>';

  // pulsante di modifica del post

  if (isset($_SESSION['user_id']) === true && $_SESSION['user_id'] == $post['id_autore']) {
    $result .= '<li><form action="/unipd_techweb_proj/postEdit.php?' . $_GET["id"] . '" method="get"><input type="submit" value="Modifica post"></form></li>';
  }

  // Informazioni, Iscrizione e Descrizione

  $result .= '<li><p class="post_informazioni_record" id="post_informazioni_data">Ritrovo<br /><strong>' . $post['data'] . '</strong><br />Ore<br /><strong>' . $post['ora'] . '</strong></p></li>
  <li><p class="post_informazioni_record" id="post_informazioni_posizione"><a href="' . $post['link'] . '"><strong>' . $post['via'] . '</strong>,<br />' . $post['provincia'] . '</p></a></li>
  <li><p class="post_informazioni_record" id="post_informazioni_volontari"><strong>' . $post['nvolontari'] . ' volontari</strong> aiutano ' . $post['nome'] . '</p></li>
  </ul>
  </div>';


  $pulsante = '';
  $legend = '';


  $pulsante = '';
  $legend = '';

  if ($post['chiuso'] === true && $_SESSION['user_id'] !== $post['id_autore']) {
    $result .= '<p class="post_titolo">ATTIVITA TERMINATA!</p><div id="post_core">';
  } else {
    if (isset($_SESSION['user_id']) === true && $_SESSION['user_id'] == $post['id_autore'] && $post['chiuso'] === false) {
      $legend .= 'Stato del post';
      $pulsante .= 'Chiudi';
    }
    else if (isset($_SESSION['user_id']) === true && $_SESSION['user_id'] == $post['id_autore'] && $post['chiuso'] === true) {
      $legend .= 'Stato del post';
      $pulsante .= 'Riapri';
    }
    else if($post['chiuso'] === false && $post['partecipo'] === false) {
      $legend .= 'Iscrizione';
      $pulsante .= 'Insieme!';
    }
    else if($post['chiuso'] === false && $post['partecipo'] === true) {
      $legend .= 'Iscrizione';
      $pulsante .= 'Abbandono';
    }

    $result .= '<form action="#" id="doit"><fieldset><legend class="post_titolo">' . $legend . '</legend><input type="button" name="DOIT" value="' . $pulsante . '" tabindex="21" /></fieldset></form><div id="post_core">';
  }

  $result .= '<h2 class="post_titolo" id="post_titolodescrizione">Descrizione</h2>
  <p class="post_core_descrizione">' . $post['descrizione'] . '</p></div>';

  // Lista volontari

  $result .= '<div id="post_listavolontari">
  <h2 class="post_titolo">Volontari DOIT</h2>
  <ol>';

  for($i = 0; $i < count($volontari); $i++) {
    $result .= '<li class="post_listavolontario"><a href="/unipd_techweb_proj/profilo.php?' . $volontari[$i]['id'] . '" class="usr"><img alt="' . $volontari[$i]['nome'] . '" src="' . $volontari[$i]['img_path'] . '" />' . $volontari[$i]['nome'] . '</a></li>';
  }

  $result .= '</ol></div>';

  // Commenti

  $result .=
  '<div id="post_social">
  <form id="post_social_form" action="#">
  <fieldset>
  <legend class="post_titolo">Foto e commenti</legend>';

  if (isset($_SESSION['user_id']) === true && ($_SESSION['user_id'] == $post['id_autore'] || $post['partecipo'] === true)) {
    $result .=
    '<p class="post_infobox">La sezione commenti permette l&#39organizzazione dei volontari. Contibuisci anche tu a questa attivit&agrave; di volotariato.</p>
    <p class="post_infobox">Scegli una foto</p>
    <input id="post_sfoglia" type="file" alt="sfoglia" value="SFOGLIA" tabindex="22" />
    <p class="post_infobox">Scrivi un messaggio</p>
    <textarea id="post_social_textarea" rows="5" cols="50" tabindex="23">[Messaggio] </textarea>
    <input id="post_social_invia" class="buttons" type="submit" alt="invia" value="INVIA" tabindex="24" />
    </fieldset>
    </form>';
  } else {
    $result .= '<p class="post_infobox">La sezione commenti permette l&#39organizzazione dei volontari. Registrati per contribuire anche tu a questa attivit&agrave; di volotariato.</p>';
  }

  for($i = 0; $i < count($commenti); $i++) {
    $result .= '<div class="commento">
    <a href="#" class="usr autore_commento"><img alt="' . $commenti[$i]['nome'] . ' ' . $commenti[$i]['cognome'] . '" src="' . $commenti[$i]['img_usr_path'] . '" />' . $commenti[$i]['nome'] . ' ' . $commenti[$i]['cognome'] . '<span>' . $commenti[$i]['data'] . '</span></a>
    <img class="user_image" src="' . $commenti[$i]['img_path'] . '" alt="immagine utente" />
    <p>' . $commenti[$i]['text'] . '</p>
    </div>';
  }

  $result .= '</div></div>';
  return $result;
}
?>
