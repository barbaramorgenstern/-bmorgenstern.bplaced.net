<?php 
  session_start();
    $_SESSION['benutzer'] = $_REQUEST['benutzer'];
    $_SESSION['password'] = $_REQUEST['password'];

// Pr�fe Inhalt von Eingabe  
    if ((strlen($_SESSION['benutzer'])>0)and (strlen($_SESSION['password'])>0))
    {
    	$html_Output = "<html><head><title>Anmeldung</title></head>";
    	$html_Output .= "<body>";
    	$html_Output .= "Hallo, ".$_SESSION["benutzer"]." die Anmeldung war erfolgreich.";
    	$html_Output .= "<a href=abmeldung.php>abmelden</a><br>";
    	$html_Output .= "</body></html>";
		$html_Output .= "<a href=../model/dbzugriffe.php>weiter zur Service Seite</a>";
    }
    else
    {
    	$html_Output = "<html><head><title>Anmeldung</title></head>";
    	$html_Output .= "<body>";
    	$html_Output .= "Hallo, die Anmeldung war nicht erfolgreich.";
    	$html_Output .= "</body></html>";    	
    }

	echo $html_Output;
?>




