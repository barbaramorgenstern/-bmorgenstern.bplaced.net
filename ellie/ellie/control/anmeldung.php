<?php 
  session_start();
    $_SESSION['email'] = htmlspecialchars( $_REQUEST['email']);
    $_SESSION['password'] = htmlspecialchars( $_REQUEST['password']);

// Pr�fe Inhalt von Eingabe  
    if ((strlen($_SESSION['email'])>0)and (strlen($_SESSION['password'])>0))
    {
    	$html_Output = "<html><head><title>Anmeldung</title></head>";
    	$html_Output .= "<body>";
    	$html_Output .= "Hallo, die Anmeldung war erfolgreich, weiter zur ";
		$html_Output .= "<a href=../model/dbzugriffe.php>Service Seite.</a>";
    	$html_Output .= "</body></html>";

    }
    else
    {
    	$html_Output = "<html><head><title>Anmeldung</title></head>";
    	$html_Output .= "<body>";
    	$html_Output .= "Anmeldung fehlgeschlagen!<br>";
		$html_Output .= "<a href=../index.php>Zurück zur Startseite</a>"; 
    	$html_Output .= "</body></html>";
   	
    }

	echo $html_Output;
?>




