<?php 
  session_start();
  unset($_SESSION['benutzer']) ;
  unset($_SESSION['password']);
  echo "Benutzer erfolgreich abgemeldet.";
?>




