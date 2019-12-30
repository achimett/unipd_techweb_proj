<?php
/**
* Richiede che la sessione sia attiva e riceve in input i campi booleani:
* $profilo, $bacheca, $nuovo, $help, $about, $logout, $isLogout.
* Ogni campo true fa sì che la corrispondente voce del menù sia abilitata.
*
* Restituisce lo snippet di codice HTML del div id="menu" con le entry
* (dis)abilitate sulla base dei valori ricevuti in input.
*/
function createMenu($profilo, $bacheca, $nuovo, $help, $about, $logout) {
  $str_profilo = 'Il Mio Profilo';
  $menu_profilo = '<li id="menu_profilo"><?></li>';

  $str_bacheha = 'Bacheca';
  $menu_bacheca = '<li id="menu_bacheca"><?></li>';

  $str_nuovo = 'Nuovo Post';
  $menu_nuovo = '<li id="menu_nuovo_post"><?></li>';

  $str_help = 'Aiuto';
  $menu_help = '<li id="menu_help"><?></li>';

  $str_about = 'Chi Siamo';
  $menu_about = '<li id="menu_about"><?></li>';

  $str_login = '<span xml:lang="en">Login</span> Registrazione';
  $str_logout = '<span xml:lang="en">Logout</span>';
  $menu_logout = '<li id="menu_logout"><?></li>';

  $in = '';

  if ($profilo == true) {
    if (isset($_SESSION['user_id']) === true) {
      $in = '<a tabindex="11" href=\"profilo.php?id="' . $_SESSION['user_id'] . '\">' . $str_profilo . '</a>';
    } else {
      $in = "<a tabindex=\"11\" href=\"login.php\">$str_profilo</a>";
    }
  } else {
    $in = $str_profilo;
  }
  $menu_profilo = str_replace('<?>', $in, $menu_profilo);

  if ($bacheca == true) {
    $in = "<a tabindex=\"12\" href=\"index.php\">$str_bacheha</a>";
  } else {
    $in = $str_bacheha;
  }
  $menu_bacheca = str_replace('<?>', $in, $menu_bacheca);

  if ($nuovo == true) {
    $in = "<a tabindex=\"13\" href=\"editPost.php\">$str_nuovo</a>";
  } else {
    $in = $str_nuovo;
  }
  $menu_nuovo = str_replace('<?>', $in, $menu_nuovo);

  if ($help == true) {
    $in = "<a tabindex=\"14\" href=\"editPost.php\">$str_help</a>";
  } else {
    $in = $str_help;
  }
  $menu_help = str_replace('<?>', $in, $menu_help);

  if ($about == true) {
    $in = "<a tabindex=\"15\" href=\"about.php\">$str_about</a>";
  } else {
    $in = $str_about;
  }
  $menu_about = str_replace('<?>', $in, $menu_about);

  if ($logout == true) {
    if (isset($_SESSION['user_id']) === true) {
      $in = "<a tabindex=\"16\" href=\"logout.php\">$str_logout</a>";
    } else {
      $in = "<a tabindex=\"16\" href=\"logoin.php\">$str_login</a>";
    }
  } else {
    $in = '';
  }
  $menu_logout = str_replace('<?>', $in, $menu_logout);

  $menu = "<div id=\"menu\">\n<ul id=\"menu_up\">\n";
  $menu .= "$menu_profilo\n$menu_bacheca\n$menu_nuovo\n$menu_help\n";
  $menu .= "</ul>\n<ul id=\"menu_down\">\n";
  $menu .= "$menu_about\n$menu_logout\n";
  $menu .= "</ul>\n</div>\n";

  return $menu;
}
?>
