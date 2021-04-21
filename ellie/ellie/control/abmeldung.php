<?php 
  session_start();
  unset($_SESSION['email']) ;
  unset($_SESSION['password']);
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Abmeldung</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../view/css/css_main.css" />
	</head>
	<body>
		<div id="wrapper">
            <h1>Abmeldung</h1>
				<p>Die Abmeldung war erfolgreich.</p>
				<p>Sie werden in kürze automatisch weitergeleitet.</p>
				<a href=../index.php>Zurück zur Startseite.</a>
				<meta http-equiv="refresh" content="5; URL=../index.php">
		</div>
	</body>
</html>