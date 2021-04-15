<?php 
  session_start();
  unset($_SESSION['email']) ;
  unset($_SESSION['password']);
  echo "Benutzer abgemeldet.<br>";
  $html_Output .= "<a href=../index.php>Zurück zur Startseite</a>";
  echo $html_Output;
?>