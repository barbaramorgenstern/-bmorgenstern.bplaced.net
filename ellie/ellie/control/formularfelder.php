<?php

//send_email.php
$email_from = "absender@domain.de";   //Absender
$sendermail_antwort = false;      //E-Mail Adresse des Besuchers als Absender. false= Nein ; true = Ja
$name_von_emailfeld = "email";   //Feld in der die Absenderadresse steht
 
$empfaenger = htmlspecialchars(  $_REQUEST['email'] ); //Empfänger-Adresse
$mail_cc = "moba.morgenstern@gmail.com"; //CC-Adresse, diese E-Mail-Adresse bekommt einer weitere Kopie
$betreff = "Kontaktanfrage"; //Betreff der Email
 
$url_ok = "ok.php"; //Zielseite, wenn E-Mail erfolgreich versendet wurde
$url_fehler = "fehler.php"; //Zielseite, wenn E-Mail nicht gesendet werden konnte
 
 
 
 
//Diese Felder werden nicht in der Mail stehen
$ignore_fields = array("submit","g-recaptcha-response");
 
 
//Datum, wann die Mail erstellt wurde
$name_tag = array("Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag");
$num_tag = date("w");
$tag = $name_tag[$num_tag];
$jahr = date("Y");
$n = date("d");
$monat = date("m");
$time = date("H:i");
 
//Erste Zeile unserer Email
$msg = ":: Gesendet am $tag, den $n.$monat.$jahr - $time Uhr ::\n\n";
 
//Hier werden alle Eingabefelder abgefragt
foreach($_POST as $vorname => $value) {
   if (in_array($vorname, $ignore_fields)) {
        continue; //Ignore Felder wird nicht in die Mail eingefügt
   }
   $msg .= "::: $vorname :::\n$value\n\n";
}
 
 
 
//E-Mail Adresse des Besuchers als Absender
if ($sendermail_antwort and isset($_POST[$name_von_emailfeld]) and filter_var($_POST[$name_von_emailfeld], FILTER_VALIDATE_EMAIL)) {
   $email_from = $_POST[$name_von_emailfeld];
}
 
$header="From: $email_from";
 
if (!empty($mail_cc)) {
   $header .= "\n";
   $header .= "Cc: $mail_cc";
}
 
//Email als UTF-8 senden
$header .= "\nContent-type: text/plain; charset=utf-8";
 
$mail_senden = mail($empfaenger,$betreff,$msg,$header);
 
 
//Weiterleitung
if($mail_senden){
   header("Location: ".$url_ok); //Mail wurde gesendet
  exit();
} else{
  header("Location: ".$url_fehler); //Fehler beim Senden
  exit();
}

?>