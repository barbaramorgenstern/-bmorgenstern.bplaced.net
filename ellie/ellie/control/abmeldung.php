<?php 
  session_start();
  unset($_SESSION['benutzer']) ;
  unset($_SESSION['password']);
  echo "Benutzer abgemeldet.<br>";
  $html_Output = "<a href=../index.php>Startseite</a>";
  echo $html_Output;
?>

