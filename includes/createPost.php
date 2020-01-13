
<?php


function createPost($db) {

  $result = '';

  if (isset($_GET['id']) === true && $db->postExist($_GET['id'])) {

    $post = $db->getPost($_GET['id']);
    $volontari = $db->getVolontari($_GET['id']);


    if(isset($_SESSION['user_id']) === true && isset($_POST['doit'])) {

      if($db->isChiuso($_GET['id']) === false){
        if($db->isAutore($_GET['id'], $_SESSION['user_id']) === true){
          $db->chiudi($_GET['id'], $_SESSION['user_id']);
        }
        else if($db->isPartecipante($_GET['id'], $_SESSION['user_id']) === true){
          $db->abbandona($_GET['id'], $_SESSION['user_id']);
        }
        else if($db->isPartecipante($_GET['id'], $_SESSION['user_id']) === false){
          $db->partecipa($_GET['id'], $_SESSION['user_id']);
        }
      } else {
        if($db->isAutore($_GET['id'], $_SESSION['user_id']) === true){
          $db->apri($_GET['id'], $_SESSION['user_id']);
        }
      }
    }



    // immagine di copertina e titolo

    $result = '
    <div class="content" id="post">
    <img id="post_immagineiniziale" src="' . $post['img_path'] . '" alt="foto iniziale" />
    <h1 class="titolo_post">' . $post['titolo'] . '</h1>
    <div id="post_informazioni">
    <h2 class="post_titolo">Informazioni</h2>
    <ul id="post_informazioni_lista">
    <li><p class="post_informazioni_record" id="post_informazioni_utente">Post di<br /><a href="/unipd_techweb_proj/profilo.php?user_id=' . $post['id_autore'] . '"><strong>' . $post['nome'] . ' ' . $post['cognome'] . '</strong></a></p></li>';

    // pulsante di modifica del post

    if (isset($_SESSION['user_id']) === true && ($db->isPartecipante($_GET['id'], $_SESSION['user_id']) || $db->isAutore($_GET['id'], $_SESSION['user_id']))) {
      $result .= '<li><form action="/unipd_techweb_proj/postEdit.php"><input type="submit" name="edit" value="Modifica post" /></form></li>';
    }

    // Informazioni, Iscrizione e Descrizione

    $result .= '<li><p class="post_informazioni_record" id="post_informazioni_data">Ritrovo<br /><strong>' . $post['data'] . '</strong><br />Ore<br /><strong>' . $post['ora'] . '</strong></p></li>
    <li><p class="post_informazioni_record" id="post_informazioni_posizione"><a href="' . $post['link'] . '"><strong>' . $post['via'] . '</strong>,<br />' . $post['provincia'] . '</p></a></li>
    <li><p class="post_informazioni_record" id="post_informazioni_volontari"><strong>' . $post['nvolontari'] . ' volontari</strong> aiutano ' . $post['nome'] . '</p></li>
    </ul>
    </div>';

    $legend = '';
    $pulsante = '';

    if($db->isChiuso($_GET['id']) === false){
      if($db->isAutore($_GET['id'], $_SESSION['user_id']) === true){
        $legend = 'Termina attivita';
        $pulsante = 'Chiudi';
      }
      else if($db->isPartecipante($_GET['id'], $_SESSION['user_id']) === true){
        $legend = 'Iscrizione';
        $pulsante = 'Abbandona';
      }
      else if(isset($_SESSION['user_id']) == true){
        $legend = 'Iscrizione';
        $pulsante = 'Partecipa';
      }
      else {
        $result .= '<p class="post_titolo">Registrati per partecipare!</p>';
      }
    } else {
      if($db->isAutore($_GET['id'], $_SESSION['user_id']) === true){
        $legend = 'Riapri attivita';
        $pulsante = 'Apri';
      } else {
        $result .= '<p class="post_titolo">Attivita terminata</p>';
      }
    }

    if($legend !== '') {
      $result .= '<form action="/unipd_techweb_proj/post.php?id=' . $_GET['id'] . '" id="doit" method="post"><fieldset><legend class="post_titolo">' . $legend . '</legend><input type="submit" name="doit" value="' . $pulsante . '" tabindex="21" /></fieldset></form>';
    }


    $result .= '<div id="post_core"><h2 class="post_titolo" id="post_titolodescrizione">Descrizione</h2>
    <p class="post_core_descrizione">' . $post['descrizione'] . '</p></div>';

    // Lista volontari

    $result .= '<div id="post_listavolontari">
    <h2 class="post_titolo">Volontari DOIT</h2>
    <ol>';

    foreach ($volontari as $volontario) {
      $result .= '<li class="post_listavolontario"><a href="/unipd_techweb_proj/profilo.php?id=' . $volontario['id'] . '" class="usr"><img alt="' . $volontario['nome'] . '" src="' . $volontario['img_path'] . '" />' . $volontario['nome'] . '</a></li>';
    }

    $result .= '</ol></div>';

    // Commenti

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['invia']) === true) {


      $db->newCommento($_GET['id'], $_SESSION['user_id'], $_POST['messaggio'], $_FILES['sfoglia']['tmp_name']);
      unset($_POST);

    }



    $commenti = $db->getCommenti($_GET['id']);


    $result .=
    '<div id="post_social">
    <form id="post_social_form" action="/unipd_techweb_proj/post.php?id=' . $_GET['id'] . '" method="post" enctype="multipart/form-data">
    <fieldset>
    <legend class="post_titolo">Foto e commenti</legend>';

    if ($db->isChiuso($_GET['id']) === false) {
      if (isset($_SESSION['user_id']) === true && ($db->isPartecipante($_GET['id'], $_SESSION['user_id']) === true || $db->isAutore($_GET['id'], $_SESSION['user_id']) === true)) {

        $result .=
        '<p class="post_infobox">La sezione commenti permette l&#39organizzazione dei volontari. Contibuisci anche tu a questa attivit&agrave; di volotariato.</p>
        <p class="post_infobox">Scegli una foto</p>
        <input id="post_sfoglia" type="file" name="sfoglia" value="SFOGLIA" tabindex="22" />
        <p class="post_infobox">Scrivi un messaggio</p>
        <textarea id="post_social_textarea" name="messaggio" rows="5" cols="50" tabindex="23">[Messaggio] </textarea>
        <input id="post_social_invia" class="buttons" type="submit" name="invia" value="INVIA" tabindex="24" />
        </fieldset>
        </form>';
      } else {
        $result .= '<p class="post_infobox">La sezione commenti permette l&#39organizzazione dei volontari. Registrati per contribuire anche tu a questa attivit&agrave; di volotariato.</p>';
      }
    }


    foreach($commenti as $commento) {

      $result .= '<div class="commento">
      <a href="/unipd_techweb_proj/profilo.php?user_id=' . $commento['user_id'] . '" class="usr autore_commento"><img alt="' . $commento['nome'] . ' ' . $commento['cognome'] . '" src="' . $commento['img_usr_path'] . '" />' . $commento['nome'] . ' ' . $commento['cognome'] . '<span>'
      . $commento['data'] . '</span></a><img class="user_image" src="' . $commento['img_path'] . '" alt="immagine utente" />
      <p>' . $commento['text'] . '</p>
      </div>';
    }

    $result .= '</div></div>';

  }

  return $result;
}
?>
