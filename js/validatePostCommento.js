function checkCommento(input) {

  if (input.value.length > 1000) {
    mostraErrore(input, "Hai inserito troppi caratteri");
    return false;
  } else if (checkImg() === false) {
    return false;
  }

  if(document.getElementById("post_sfoglia").value == "" && input.value.length == 0) {
    mostraErrore(input, "Devi inserire almeno un testo o una fotografia");
    return false;
  }

  togliErrore(input);
  return true;

}

function checkImg() {

  var img = document.getElementById("post_sfoglia");

  var x = document.getElementById("post_sfoglia").value;
  if (x !== "" && x.split('.').pop() != "png" && x.split('.').pop() != "jpg" && x.split('.').pop() != "jpeg") {
    mostraErrore(img, "Selezionare un file in formato png o jpeg");
    return false;
  }
  togliErrore(img);
  return true;
}

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

function validatePostCommento() {

  var textarea = document.getElementById('post_social_textarea');

  return checkCommento(textarea);
}
