<?php
/**
* Prende in input un array bidimensionale contenente i dati per popolare la tabella
* dei contributi di una pagina profilo utente. Ogni riga sara' un array associativo
* con i seguenti campi: id, titolo, data e chiuso, rappresentanti gli ominimi dati
* dei post in cui l'utente ha contribuito.
*
* Restituisce il codice html delle righe e colonne della tabella dei contributi.
*/
function createTableRows($table_data) {
  $result = '';
  foreach ($table_data as $row) {
    $result .=  '<tr>
                 <td><a href="post.php?id=' . $row['id'] . '">' .$row['titolo']. '</a></td>
                 <td>' .$row['data']. '</td>
                 <td>' . ($row['chiuso'] ? 'Chiuso' : 'Aperto') . '</td>
                 </tr>' . "\n";
  }
  return $result;
}
?>
