<?php
// Datenbank-Zugangsdaten, werden hier flexibel gesetzt
$host = "localhost";
$user = "root";
$pass = "";
$database = "bmorgenstern_dbcomputerservice";
if ($_SERVER["SERVER_NAME"] == "bmorgenstern.bplaced.net") {
    $host = "localhost";
    $user = "bmorgenstern_moba";
    $pass = "1234";
    $database = "bmorgenstern_dbcomputerservice";
}
//SQL-Befehle
$sqlSelect = "SELECT * FROM t_computerservice ORDER BY astd_datum DESC;";
$sqlSelWhr = "SELECT * FROM t_computerservice WHERE astd_id = __ID__ ;";

if (isset($_REQUEST["btnSave"])) {
//     echo "<pre>save ".$_REQUEST["sqlModus"];
//     echo print_r($_REQUEST, TRUE);
    $sql = "";
    if ($_REQUEST["sqlModus"] == "INSERT") {
        $sql = "INSERT INTO t_computerservice
                    (astd_datum 
                    ,astd_pers 
                    ,astd_servicebeschreibung)
                VALUES 
                    ('".htmlspecialchars( $_REQUEST["date"])."'
                    ,'".htmlspecialchars($_REQUEST["pers"])."'
                    ,'".htmlspecialchars($_REQUEST["beschr"])."'
                    )";
        
        //Variante MySQLi
        $sqliConn = new mysqli($host, $user, $pass, $database);
        //mysqli_query($sqliConn, $sql);
        $count = $sqliConn->query($sql);
        $sqliConn->close();
        
        echo $count." row inserted";//freiwillige Ausgabe -> kann gelöscht werden
    }
    if ($_REQUEST["sqlModus"] == "UPDATE") {
        $sql = "UPDATE t_computerservice 
                SET astd_datum = '".htmlspecialchars($_REQUEST["date"])."' 
                   ,astd_pers = '".htmlspecialchars($_REQUEST["pers"])."' 
                   ,astd_servicebeschreibung = '".htmlspecialchars($_REQUEST["beschr"])."' 
                WHERE astd_id = ".$_REQUEST["rowID"]." ;";
        
        //Variante MySQLi
        $sqliConn = new mysqli($host, $user, $pass, $database);
        $count = $sqliConn->query($sql);
        $sqliConn->close();
        
        echo $count." row updated";//freiwillige Ausgabe -> kann gelöscht werden
    }
}

//Handling für die Button-Clicks
$displayAddButton = TRUE;
if (isset($_REQUEST["addRow"])) {   //das lassen
    $displayAddButton = FALSE;      //das lassen
    echo "Add ";                    //nur zu check --> kann man löschen
    echo $_REQUEST["addRow"];       //nur zu check --> kann man löschen
}
if (isset($_REQUEST["delRow"])) {   //das lassen
    $sql = "DELETE FROM t_computerservice WHERE astd_id=".$_REQUEST["delRow"];
    $sqliConn = new mysqli($host, $user, $pass, $database);
    $count = $sqliConn->query($sql);
    $sqliConn->close();
    echo "Del ";                    //nur zu check --> kann man löschen
    echo $_REQUEST["delRow"];       //nur zu check --> kann man löschen
    echo $sql;
}
if (isset($_REQUEST["editRow"])) {  //das lassen
    $displayAddButton = FALSE;      //das lassen
    echo "edit ";                   //nur zu check --> kann man löschen
    echo $_REQUEST["editRow"];      //nur zu check --> kann man löschen
}
if (isset($_REQUEST["cancel"])) {   //nur zu check --> kann man löschen
    echo "Cancel ";                 //nur zu check --> kann man löschen
}

function getList($sql, $host, $database, $user, $pass) {
    $out = "";
    $key = 0;
    if ( isset($_REQUEST["delRow"]) ) {
        $key = $_REQUEST["delRow"];
    }
    if ( isset($_REQUEST["editRow"])) {
        $key = $_REQUEST["editRow"];
    }
    
    
    //Variante MySQLi
     $sqliConn = new mysqli($host, $user, $pass, $database);
     $resultSet = $sqliConn->query($sql);
     $sqliConn->close();
     while($row = $resultSet->fetch_assoc()) {
        
        $out .= "<tr>";
        //Entfernt die Buttons im Update- oder Insert-Modus
        if (isset($_REQUEST["addRow"]) OR isset($_REQUEST["editRow"])) {                
            if ($key == $row['astd_id']) {
                $out .= "<td style='background-color: #ffffdf;'> update -> </td>";
            } else {
                $out .= "<td> </td>";
            }
        } else {
            $out .= " <td><button name='delRow'  value='".$row['astd_id']."'>DEL</button>";
            $out .= "     <button name='editRow' value='".$row['astd_id']."'>EDT</button></td>";
        }
        $out .= " <td>".$row['astd_datum']."</td>";
        $out .= " <td>".$row['astd_pers']."</td>";
        $out .= " <td>".$row['astd_servicebeschreibung']."</td>";
        $out .= "</tr>";
    }
    return $out;
}

function getInputFields($sql, $host, $database, $user, $pass) {
    $out  = ""; 
    $key  = "";
    $date  = "";
    $pers  = "";
    $proj  = "";
    $tarif  = "";
    $zeit  = "";
    $beschr  = "";
    if (isset($_REQUEST["editRow"])) {            //Button wurde gedrückt
        $key =$_REQUEST["editRow"];               //Zuweisung der Row-ID
        
        //Setzt die Id in den SQL-Command ein
        $sql = str_replace("__ID__", $key, $sql);
                

        //Variante MySQLi
        $sqliConn = new mysqli($host, $user, $pass, $database);
        $resultSet = $sqliConn->query($sql);
        $sqliConn->close();
        while($row = $resultSet->fetch_assoc()) {
            
            $date   = $row['astd_datum'];
            $pers   = $row['astd_pers'];
            $beschr = $row['astd_servicebeschreibung'];
            break;
        }
    }
    //Die Eingabefelder innerhalb der Tabellenzeile
    //Bei INSERT sind die Felder leer, bei EDIT werden sie mit der DB-Inhalt gefüllt
    $out .= "<tr>"; 
    $out .= " <td><button name='btnSave'>OK</button></td>";
    $out .= " <td><input type='date' name='date'   value='".$date."'   placeholder='2021-06-21' style='width: 11em;'></td>";
    $out .= " <td><input type='text' name='pers'   value='".$pers."'   placeholder='Vorname Nachname'        style='width: 20em;'></td>";
    $out .= " <td><input type='text' name='beschr' value='".$beschr."' placeholder='Service Beschreibung'   style='width: 50em;'></td>";
    $out .= "</tr>";
    $out .= "<tr>";
    if (isset($_REQUEST["addRow"])) {
        $out .= "<input type='hidden' name='sqlModus' value='INSERT'>";
        return $out;
    }
    if (isset($_REQUEST["editRow"])) {
        $out .= "<input type='hidden' name='sqlModus' value='UPDATE'>";
        $out .= "<input type='hidden' name='rowID' value='".$key."'>";
        return $out;
    }
}
    
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Serviceanfragen</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../view/css/css_main.css" />
	</head>
	<body>
		<div id="wrapper">
        &nbsp; | &nbsp; <a href=../index.php>Startseite</a> &nbsp; | &nbsp;
        <a href=../control/abmeldung.php>Abmelden</a><br> &nbsp; | &nbsp; 
            <h1>Serviceanfragen</h1>
            <form action="dbzugriffe.php" method="post">
            	<table>
            		<tr>
            			<th>
            			<?php 
            			if ($displayAddButton) {
            			    echo "<button name='addRow'>Add</button>";
            			}
            			?>            				 
            				<button name='cancel'>C</button>
            			</th>
            			<th>Datum der Meldung</th>
            			<th>Kunde</th>
            			<th>Serviceschreibung</th>
            		</tr>
            		<?= getInputFields($sqlSelWhr, $host, $database, $user, $pass); ?>
            		<?= getList($sqlSelect, $host, $database, $user, $pass); ?>
            	</table>
            </form>
		</div>
	</body>
</html>
