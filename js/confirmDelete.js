/**
* La seguente funzione visualizza un confirm() per chedere all'utente se è
* sicuro di voler effettuare una eliminazione irreversibile di dati.
*
* La variabile confirmType specifica la destinazione d'uso del messaggio:
* 1 -> Profilo
* 2 -> Post
*/
function confirmDelete(confirmType) {
  var mex = 'ATTENZIONE! ';

  switch (confirmType) {
    case 1:
      mex = mex.concat('Sei sicuro di voler abbandonare DOIT?');
      break;

    case 2:
      mex = mex.concat('Sei sicuro di voler eliminare il tuo post?');
      break;

    default:
      return true;
  }

  mex = mex.concat(' Questa azione è irreversibile!');
  return confirm(mex);
}
