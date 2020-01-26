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

function checkData(input) {
  var d = /^(?:(0[1-9]|1[012])[\/.](0[1-9]|[12][0-9]|3[01])[\/.](19|20)[0-9]{2})$/; ////////da migliorarererererrererer
  if (d.test(input.value) == false) {
    mostraErrore(input, "Data non valida");
    return false;
  }

function checkPass(input) {
  var d = /^(?=.*[0-9])(?=.*[A-Z]).{8,}$/;
  if (d.test(input.value) == false) {
    mostraErrore(input, "Password non valida");
    return false;
  }
  
function checkMail(input) {
  var d =   /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/;
  if (d.test(input.value) == false) {
    mostraErrore(input, "Mail non valida");
    return false;
  }
  
  
function checkTel(input) {
  var d = /^[0-9]{7,12}$/;
  if (d.test(input.value) == false) {
    mostraErrore(input, "Numero di telefono non valida");
    return false;
  }
 
 function checkNome(input) {
  var d = /^[a-zA-Z ]{2,30}$/;
  if (d.test(input.value) == false) {
    mostraErrore(input, "Nome non valida");
    return false;
  }
  
  function checkCognome(input) {
  var d = /^[a-zA-Z ]{2,30}$/;
  if (d.test(input.value) == false) {
    mostraErrore(input, "Cognome non valida");
    return false;
  }
  
  function checkCF(input) {
  var d = /^[a-zA-Z]{6}[0-9]{2}[abcdehlmprstABCDEHLMPRST]{1}[0-9]{2}([a-zA-Z]{1}[0-9]{3})[a-zA-Z]{1}$/;
  if (d.test(input.value) == false) {
    mostraErrore(input, "Cognome non valida");
    return false;
  }
  
  function checkImg() {
  var img = document.getElementById("postEdit_social_sfoglia"); //// cambaire 

  var x = document.getElementById("postEdit_social_sfoglia").value;
  if (x.split('.').pop() != "png" && x.split('.').pop() != "jpg" && x.split('.').pop() != "jpeg") {
    mostraErrore(img, "Selezionare un file in formato png o jpeg");
    return false;
  }
  
  togliErrore(img);
  return true;
}


function validateProfilo() {   /////cambaire id
  var titolo = document.getElementById('postEdit_core_titolo_input');
  var descrizione = document.getElementById("postEdit_social_textarea");
  var data = document.getElementById("data");
  var ora = document.getElementById("ora");
  var luogo = document.getElementById("luogo");
  var provincia = document.getElementById("provincia");

  return (checkTitolo(titolo) & checkDescrizione(descrizione) & checkData(data) & checkOra(ora) & checkLuogo(luogo) & checkProvincia(provincia)) != 0;
}
