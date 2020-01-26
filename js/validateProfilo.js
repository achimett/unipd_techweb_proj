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
	console.log(input, " " , p);
    p.removeChild(span[0]);
  }
}

function checkData(input) {
  var d = /^(?:(0[1-9]|1[012])[\/.](0[1-9]|[12][0-9]|3[01])[\/.](19|20)[0-9]{2})$/; ////////da migliorarererererrererer
  if (d.test(input.value) == false) {
    mostraErrore(input, "Data non valida");
    return false;
  }
  return true;
}

function checkPass(input, input2) {
  var d = /^(?=.*[0-9])(?=.*[A-Z]).{8,}$/;
  if (input.value != input2.value) {
    mostraErrore(input, "Password e Conferma password non coincidono");
    return false;
  }
  if (d.test(input.value) == false) {
    mostraErrore(input, "Password non valida : la password deve essere di almeno 8 caratteri e con almeno un alettere maiuscola ed un numero");
    return false;
  }
 return true;
  }
  
function checkMail(input) {
  var d =   /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/;
  if (d.test(input.value) == false) {
    mostraErrore(input, "Mail non valida");
    return false;
  }
  return true;
}
  
  
function checkTel(input) {
  var d = /^[0-9]{7,12}$/;
  if (d.test(input.value) == false) {
    mostraErrore(input, "Numero di telefono non valido");
    return false;
  }
  return true;
}
 
 function checkNome(input) {
  var d = /^[a-zA-Z ]{2,30}$/;
  if (d.test(input.value) == false) {
    mostraErrore(input, "Nome non valido");
    return false;
  }
  return true;
 }
  
  function checkBio(input) {
  if (input.value.length > 65535) {
    mostraErrore(input, "Hai inserito troppi caratteri");
    return false;

  } else if (input.value.length <= 0) {
    mostraErrore(input, "Biografia vuoto, raccontaci qualcosa di te :)");
    return false;
  }

  togliErrore(input);
  return true;
}
  
  function checkCognome(input) {
  var d = /^[a-zA-Z ]{2,30}$/;
  if (d.test(input.value) == false) {
    mostraErrore(input, "Nome non valido");
    return false;
  }
  return true;
  }
  
  function checkCF(input) {
  var d = /^[a-zA-Z]{6}[0-9]{2}[abcdehlmprstABCDEHLMPRST]{1}[0-9]{2}([a-zA-Z]{1}[0-9]{3})[a-zA-Z]{1}$/;
  if (d.test(input.value) == false) {
    mostraErrore(input, "Codice fiscale non valido");
    return false;
  }
  return true;
  }
  
  function checkImg() {
  var img = document.getElementById("registrazione_foto");

  var x = document.getElementById("registrazione_foto").value;
  if (x.split('.').pop() != "png" && x.split('.').pop() != "jpg" && x.split('.').pop() != "jpeg") {
    mostraErrore(img, "Selezionare un file in formato png o jpeg");
    return false;
  }
  
  togliErrore(img);
  return true;
}


function validateProfilo() {   /////cambaire id
  var nome = document.getElementById('registrazione_nome');
  var cognome = document.getElementById("registrazione_cognome");
  var data = document.getElementById("registrazione_data_di_nascita");
  var cf = document.getElementById("registrazione_codice_fiscale");
  var mail = document.getElementById("registrazione_email");
  var cell = document.getElementById("registrazione_telefono");
  var pass = document.getElementById("registrazione_password");
  var c_pass = document.getElementById("registrazione_conferma_password");
  var bio = document.getElementById("registrazione_biografia");

  return (checkNome(nome) & checkCognome(cognome) & checkData(data) & checkCF(cf) & checkTel(cell) & checkImg() & checkBio(bio)  & checkPass(pass,c_pass) & checkMail(mail)) != 0;
}
