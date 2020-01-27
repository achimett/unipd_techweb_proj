function mostraError(input, testoError) {

  var span = document.createElement('span');
  span.className = "error";
  span.innerText = testoError;
  input.after(span);
	
}

function togliError() {
 while (document.getElementsByClassName('error')[0]) {
        document.getElementsByClassName('error')[0].remove();
    }
}

function checkData(input) {
  var d = /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:19|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:19|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:19|[2-9]\d)?\d{2})$/ ;
  if (d.test(input.value) == false) {
    mostraError(input, "Data non valida");
    return false;
  }
  return true;
}

function checkPass(input, input2) {
  var d = /^(?=.*[0-9])(?=.*[A-Z]).{8,}$/;
  if (input.value != input2.value) {
    mostraError(input, "Password e Conferma password non coincidono");
    return false;
  }
  if (d.test(input.value) == false) {
    mostraError(input, "Password non valida : la password deve essere di almeno 8 caratteri e con almeno un alettere maiuscola ed un numero");
    return false;
  }
 return true;
  }
  
function checkMail(input) {
  var d =   /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/;
  if (d.test(input.value) == false) {
    mostraError(input, "Mail non valida");
    return false;
  }
  return true;
}
  
  
function checkTel(input) {
  var d = /^[0-9]{7,12}$/;
  if (d.test(input.value) == false) {
    mostraError(input, "Numero non valido");
    return false;
  }
  return true;
}
 
 function checkNome(input) {
  var d = /^[a-zA-Z ]{2,30}$/;
  if (d.test(input.value) == false) {
    mostraError(input, "Nome non valido");
    return false;
  }
  return true;
 }
  
  function checkBio(input) {
  if (input.value.length > 65535) {
    mostraError(input, "Hai inserito troppi caratteri");
    return false;

  } else if (input.value.length <= 0) {
    mostraError(input, "Biografia vuota, raccontaci qualcosa di te :)");
    return false;
  }

  return true;
}
  
  function checkCognome(input) {
  var d = /^[a-zA-Z ]{2,30}$/;
  if (d.test(input.value) == false) {
    mostraError(input, "Cognome non valido");
    return false;
  }
  return true;
  }
  
  function checkCF(input) {
  var d = /^[a-zA-Z]{6}[0-9]{2}[abcdehlmprstABCDEHLMPRST]{1}[0-9]{2}([a-zA-Z]{1}[0-9]{3})[a-zA-Z]{1}$/;
  if (d.test(input.value) == false) {
    mostraError(input, "CF non valido");
    return false;
  }
  return true;
  }
  
  function checkImg() {
  var img = document.getElementById("registrazione_foto");

  var x = document.getElementById("registrazione_foto").value;
  if(x !== ""){
	  if (x.split('.').pop() != "png" && x.split('.').pop() != "jpg" && x.split('.').pop() != "jpeg") {
		mostraError(img, "Selezionare un file in formato png o jpeg");
		return false;
	  }
  }  
  return true;
}


function validateProfilo() {  
	togliError();
  var nome = document.getElementById('registrazione_nome');
  var cognome = document.getElementById("registrazione_cognome");
  var data = document.getElementById("registrazione_data_di_nascita");
  var cf = document.getElementById("registrazione_codice_fiscale");
  var mail = document.getElementById("registrazione_email");
  var cell = document.getElementById("registrazione_telefono");
  var pass = document.getElementById("registrazione_password");
  var c_pass = document.getElementById("registrazione_conferma_password");
  var bio = document.getElementById("registrazione_biografia");
  return (checkNome(nome) & checkCognome(cognome) & checkData(data) & checkCF(cf) & checkTel(cell) & checkPass(pass,c_pass) & checkMail(mail)  & checkBio(bio)  & checkImg()) != 0;
}
