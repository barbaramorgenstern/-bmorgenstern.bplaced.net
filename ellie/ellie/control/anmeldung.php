<?php 
  session_start();
    $_SESSION['email'] = htmlspecialchars( $_REQUEST['email']);
    $_SESSION['password'] = htmlspecialchars( $_REQUEST['password']);
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Anmeldung</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../view/css/css_main.css" />
	</head>
	<body>
		<div id="wrapper">
            <h1>Anmeldung</h1>
				<p>Die Anmeldung war erfolgreich.</p>
				<p>Sie werden in kürze automatisch weitergeleitet.</p>
				<a href=../model/dbzugriffe.php>Direkt zur Service Seite.</a>
				<meta http-equiv="refresh" content="5; URL=../model/dbzugriffe.php">
            </form>
		</div>
	</body>
</html>



