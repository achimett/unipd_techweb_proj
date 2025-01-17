function checkData(input) {
  var d = /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:19|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:19|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:19|[2-9]\d)?\d{2})$/ ;
  if (d.test(input.value) == false) {
    mostraErrore(input, "Data non valida, formato data: dd/mm/aaaa");
    return false;
  }
  togliErrore(input);
  return true;
}

function checkOra(input) {
  var d = new RegExp('^(0[0-9]|1[0-9]|2[0-3]|[0-9]):[0-5][0-9]$');
  if (d.test(input.value) == false) {
    mostraErrore(input, "Orario non valido, formato ora: hh:mm");
    return false;
  }

  togliErrore(input);
  return true;
}

function checkLuogo(input) {
  if (input.value.length > 150) {
    mostraErrore(input, "Luogo troppo lungo (max 150 caratteri)");
    return false;

  } else if (input.value.length <= 0) {
    mostraErrore(input, "Luogo mancante");
    return false;
  }

  togliErrore(input);
  return true;
}

function checkProvincia(input) {
  if (input.value.length > 50) {
    mostraErrore(input, "Provincia troppo lunga (max 50 caratteri)");
    return false;

  } else if (input.value.length <= 0) {
    mostraErrore(input, "Provincia mancante");
    return false;
  }

  togliErrore(input);
  return true;
}

function checkDescrizione(input) {
  if (input.value.length > 1000) {
    mostraErrore(input, "Hai inserito troppi caratteri (max 1000 caratteri)");
    return false;

  } else if (input.value.length <= 0) {
    mostraErrore(input, "Descrizione vuota");
    return false;
  }

  togliErrore(input);
  return true;
}

function checkTitolo(input) {
  if (input.value.length > 100) {
    mostraErrore(input, "Hai inserito troppi caratteri (max 100 caratteri)");
    return false;

  } else if (input.value.length <= 0) {
    mostraErrore(input, "Titolo vuoto");
    return false;
  }

  togliErrore(input);
  return true;
}

function mostraErrore(input, testoErrore) {
  togliErrore(input);
  var p = input.parentNode;
  var span = document.createElement('span');
  span.className = "postEdit_error";
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

function validatePostEdit() {
  var titolo = document.getElementById('postEdit_core_titolo_input');
  var descrizione = document.getElementById("postEdit_social_textarea");
  var data = document.getElementById("data");
  var ora = document.getElementById("ora");
  var luogo = document.getElementById("luogo");
  var provincia = document.getElementById("provincia");

  return (checkTitolo(titolo) & checkDescrizione(descrizione) & checkData(data) & checkOra(ora) & checkLuogo(luogo) & checkProvincia(provincia)) != 0;
}

function checkImg() {
  var img = document.getElementById("postEdit_social_sfoglia");

  var x = document.getElementById("postEdit_social_sfoglia").value;
  if (x.split('.').pop() != "png" && x.split('.').pop() != "jpg" && x.split('.').pop() != "jpeg") {
    mostraErrore(img, "Selezionare un file in formato png o jpeg");
    return false;
  }

  togliErrore(img);
  return true;
}
