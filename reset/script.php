<?php
session_start();
require_once('../includes/DB.php');

$db = new DB();

$email = file("email.txt");
$nome = file("nomi.txt");
$password = file("password.txt");
$text = file("text.txt");

$titolo = file("titolo.txt");
$provincia = file("provincia.txt");
$luogo = file("luogo.txt");
$char = file("char.txt");

$lim = 300;
$tot = 4;

$db->empty();
for($i = 0; $i < $tot; $i++) {



  echo "c";

  $r["email"] = rand(0, $lim);

  $r["password"] = rand(0, $lim);
  $r["nome"] = rand(0, $lim);
  $r["cognome"] = rand(0, $lim);
  $r["tel"] = rand(1111111, 111111111);
  $r["birthday"] =  sprintf("%02d", rand(1, 12)) . "/" . sprintf("%02d", rand(1, 12)) . "/" . rand(1990, 2000);
    $r["data"] = sprintf("%02d",rand(1, 12)) . "/" . sprintf("%02d",rand(1, 12)) . "/" . rand(2019, 2021);
  $r["ora"] = rand(10, 23) . ":" . 15*rand(1, 3);

  $r["bio"] = rand(0, $lim);
  $r["titolo"] = $titolo[rand(0, $lim)] . $titolo[rand(0, $lim)] . $titolo[rand(0, $lim)];
  $r["provincia"] = rand(0, $lim);
  $r["luogo"] = rand(0, $lim);
  $r["descrizione"] = rand(0, $lim);



  $cf = '';



  $cf .= $char[rand(0, 25)];
  $cf .= $char[rand(0, 25)];
  $cf .= $char[rand(0, 25)];
  $cf .= $char[rand(0, 25)];
  $cf .= $char[rand(0, 25)];
  $cf .= $char[rand(0, 25)];
  $cf .= rand(11, 99);
  $cf .= $char[rand(0, 25)];
  $cf .= rand(11, 99);
  $cf .= $char[rand(0, 25)];
  $cf .= rand(111, 999);
  $cf .= $char[rand(0, 25)];
  $cf = preg_replace('/\s+/', '', $cf);


  $x = $db->setProfilo(NULL, $email[$r["email"]], $password[$r["password"]], $password[$r["password"]], $nome[$r["nome"]], $nome[$r["cognome"]],
   $r['birthday'], $cf, $text[$r['bio']], NULL, $r['tel']);

    $y = $db->setPost(NULL, $r['titolo'], 1, $r['data'], $r['ora'], $text[$r['descrizione']], NULL, $luogo[$r['luogo']], $provincia[$r['provincia']]);


$c = rand(50, 100);
for($k = 0; $k < $c; $k++) {

    $o = $db->partecipa(rand(0, $i), $y);
$z = $db->newCommento(rand(0, $i), rand(0, $tot), $text[$r['bio']], NULL);
}

}

?>
