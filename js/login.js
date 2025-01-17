/**
* La seguenti funzioni controllano che l'email e la password inseriti nel forma
* di login siano corrette.
*
* Per quanto riguarda l'espressione regolare, si ci aspetta una stringa composta
* da un qualsiasi numero di caratteri alfanumerici che può comprendere i simboli
* "_", "-" e ".", dopo questa stringa ci si aspetta un'altra stringa di uno o
* più caratteri preceduta dal simbolo "@", quindi un'ultima stringa di due o
* più caratteri preceduta dal simbolo ".".
*/

function checkEmail(input) {
  var emailRE = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z.]{2,5}$/;
  if(input.value=="user") {
    return true;
  }
  if (emailRE.test(input.value) == false) {
    mostraErrore(input, "Email non valida");
    return false;
  }
  togliErrore(input);
  return true;
}

function checkPassword(input) {
  var passRE = /^(?=.*[0-9])(?=.*[A-Z]).{8,}$/;
  if(input.value=="user") {
    return true;
  }
  if (passRE.test(input.value) == false) {
    mostraErrore(input, "Password non valida, inserire una password di almeno 8 caratteri tra cui un simbolo e una lettera maiuscola");
    return false;
  }
  togliErrore(input);
  return true;
}

// Mostra un messaggio di errore per un determinato input
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

function validateLogin() {
  var email = document.getElementById('login_email');
  var password = document.getElementById("login_password");

  return (checkEmail(email) & checkPassword(password)) != 0;
}
