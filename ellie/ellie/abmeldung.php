<!DOCTYPE html>
<?php 
  session_start();
  unset($_SESSION['benutzer']) ;
  unset($_SESSION['password']);
  echo "Benutzer erfolgreich abgemeldet.";
?>

<input type="button" name="back" value="Zurück" onClick="index.php" />


