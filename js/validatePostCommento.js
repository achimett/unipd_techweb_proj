function checkCommento(input) {

  if (input.value.length > 1000) {
    mostraErrore(input, "Hai inserito troppi caratteri");
    return false;
  }

  togliErrore(input);
  return true;

}

function checkImg() {

  var x = document.getElementById("post_sfoglia").value;
  if (x.split('.').pop() != "png" && x.split('.').pop() != "jpg" && x.split('.').pop() != "jpeg") {
    mostraErrore(x, "Selezionare un file in formato png o jpeg");
    return false;
  }
  togliErrore(x);
  return true;
}

// Mostra un messaggio di errore per un determinato input
function mostraErrore(input, testoErrore) {
  togliErrore(input);
  var p = input.parentNode;
  var span = document.createElement('span');
  span.className = "error";
  span.innerText = testoErrore;
  p.appendChild(span);

}

function togliErrore(input) {
  var p = input.parentNode;

  var span = p.getElementsByTagName('span');
  if (span.length > 0) {
    p.removeChild(span[0]);
  }
}

/*
Per richiamare validazione form devo avere il seguente HTML:
<form action="..." onsubmit="return validazioneForm()" ... >
*/
function validatePostCommento() {

  var textarea = document.getElementById('post_social_textarea');
  //foto
  var img = document.getElementById("post_sfoglia");

  return checkCommento(textarea) & checkImg();
}
