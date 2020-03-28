<?php
/**
* Crea lo snippet di codice HTML per la gestione pagine (spostamento da una pagina
* all'altra) della bacheca.
*
* $page => è la pagina attuale
* $page_count => è il numero di pagine totali
* $tabindex => è il numero di tabindex di partenza per i link che verranno generati;
*   verrà incrementato automaticamente per arrivare al numero di sequenza corretto
*   una volta terminata la funzione
* $provincia => è il testo presente nella barra di ricerca
*/
function createGestionePagine($page, $page_count, &$tabindex, $provincia) {
  $result = '<p class="gestione_pagina">';

  if ($page !== 1) {
    $result .= '<a href="bacheca.php?page=' . ($page - 1) . '&amp;provincia='. $provincia . '" tabindex="' . $tabindex++ . '">
    <img src="img/freccia_sx.png" alt="Pagina precedente" /></a>';
  }

  $result .= ' ' . $page . ' ';

  if ($page < $page_count) {
    $result .= '<a href="bacheca.php?page=' . ($page + 1) . '&amp;provincia='. $provincia . '" tabindex="' . $tabindex++ . '">
    <img src="img/freccia_dx.png" alt="Pagina successiva" /></a>';
  }

  return $result . '</p>';
}
?>
