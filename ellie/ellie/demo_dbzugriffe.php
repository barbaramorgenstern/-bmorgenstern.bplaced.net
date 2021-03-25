<?php
/**
 * Schulungsbeispiel für Datenbankzugriffe und Tabellenverwaltung in PHP
 * Harald G. Müller, TBZ, 2019
 * 
 * In diesem Beispiel ist die Delete-Funktion bewusst noch nicht implementiert.
 * AUFGABEN:
 * - Bringen Sie den Code zuerst zum Laufen, indem Sie die Datenbank und die entsprechende Tabelle anlegen (SQL-Code siehe unten)
 * - Analysieren Sie den ganzen Code und fügen Sie dann das DELETE an der geeigneten Stelle hinzu.
 * - Stellen Sie von PDO nach MySQLi oder von MySQLi nach PDO um.
 */
// Datenbank-Zugangsdaten, werden hier flexibel gesetzt
$host = "localhost";
$user = "root";
$pass = "";
$database = "db_computerservice";
if ($_SERVER["SERVER_NAME"] == "bmorgenstern.ch") {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $database = "db_computerservice";
} elseif ($_SERVER["SERVER_NAME"] == "bmorgenstern.bplaced.net") {
    $host = "localhost";
    $user = "bmorgenstern_computerservice";
    $pass = "db_computerservice";
    $database = "bmorgenstern";
}
//SQL-Befehle
$sqlSelect = "SELECT * FROM t_arbeitsstunden ORDER BY astd_datum DESC;";
$sqlSelWhr = "SELECT * FROM t_arbeitsstunden WHERE astd_id = __ID__ ;";

if (isset($_REQUEST["btnSave"])) {
//     echo "<pre>save ".$_REQUEST["sqlModus"];
//     echo print_r($_REQUEST, TRUE);
    $sql = "";
    if ($_REQUEST["sqlModus"] == "INSERT") {
        $sql = "INSERT INTO t_arbeitsstunden
                    (astd_datum 
                    ,astd_pers_krzl 
                    ,astd_proj_krzl 
                    ,astd_tarif_krzl 
                    ,astd_stdzahl
                    ,astd_arbeitsbeschreibung)
                VALUES 
                    ('".$_REQUEST["date"]."'
                    ,'".$_REQUEST["pers"]."'
                    ,'".$_REQUEST["proj"]."'
                    ,'".$_REQUEST["tarif"]."'
                    ,'".$_REQUEST["zeit"]."'
                    ,'".$_REQUEST["beschr"]."'
                    )";
        //Variante PDO
//         $pdo = new PDO("mysql:host=".$host.";dbname=".$database, $user, $pass);
//         $count = $pdo->exec($sql);
//         $pdo = null;//Datenbank schliessen (ist zwar nett, muss aber nicht sein, sie schliesst sich nach Timeout alleine)
        
        //Variante MySQLi
        $sqliConn = new mysqli($host, $user, $pass, $database);
        //mysqli_query($sqliConn, $sql);
        $count = $sqliConn->query($sql);
        $sqliConn->close();
        
        echo $count." row inserted";//freiwillige Ausgabe -> kann gelöscht werden
    }
    if ($_REQUEST["sqlModus"] == "UPDATE") {
        $sql = "UPDATE t_arbeitsstunden 
                SET astd_datum = '".$_REQUEST["date"]."' 
                   ,astd_pers_krzl = '".$_REQUEST["pers"]."' 
                   ,astd_proj_krzl = '".$_REQUEST["proj"]."' 
                   ,astd_tarif_krzl = '".$_REQUEST["tarif"]."' 
                   ,astd_stdzahl = '".$_REQUEST["zeit"]."' 
                   ,astd_arbeitsbeschreibung = '".$_REQUEST["beschr"]."' 
                WHERE astd_id = ".$_REQUEST["rowID"]." ;";
        //Variante PDO
//         $pdo = new PDO("mysql:host=".$host.";dbname=".$database, $user, $pass);
//         $count = $pdo->exec($sql);
//         $pdo = null;//Datenbank schliessen (ist zwar nett, muss aber nicht sein, sie schliesst sich nach Timeout alleine)
        
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
    echo "Del ";                    //nur zu check --> kann man löschen
    echo $_REQUEST["delRow"];       //nur zu check --> kann man löschen
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
    
    //Variante PDO
    $pdo = new PDO("mysql:host=".$host.";dbname=".$database, $user, $pass);
    $resultSet = $pdo->query($sql);
    //$pdo = null;
    foreach ($resultSet as $row) {
    
    //Variante MySQLi
//     $sqliConn = new mysqli($host, $user, $pass, $database);
//     $resultSet = $sqliConn->query($sql);
//     $sqliConn->close();
//     while($row = $resultSet->fetch_assoc()) {
        
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
        $out .= " <td>".$row['astd_pers_krzl']."</td>";
        $out .= " <td>".$row['astd_proj_krzl']."</td>";
        $out .= " <td>".$row['astd_tarif_krzl']."</td>";
        $out .= " <td>".$row['astd_stdzahl']."</td>";
        $out .= " <td>".$row['astd_arbeitsbeschreibung']."</td>";
        $out .= "</tr>";
    }
    return $out;
}

function getInputFields($sql, $host, $database, $user, $pass) {
    $out  = ""; //Variablen deklarieren
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
                
        //Variante PDO
		// $pdo = new PDO("mysql:host=".$host.";dbname=".$database, $user, $pass);
		// $resultSet = $pdo->query($sql);
		// $pdo = null;//Datenbank schliessen (ist zwar nett, muss aber nicht sein, sie schliesst sich nach Timeout alleine)
		// foreach ($resultSet as $row) {

        //Variante MySQLi
        $sqliConn = new mysqli($host, $user, $pass, $database);
        $resultSet = $sqliConn->query($sql);
        $sqliConn->close();
        while($row = $resultSet->fetch_assoc()) {
            
            $date   = $row['astd_datum'];
            $pers   = $row['astd_pers_krzl'];
            $proj   = $row['astd_proj_krzl'];
            $tarif  = $row['astd_tarif_krzl'];
            $zeit   = $row['astd_stdzahl'];
            $beschr = $row['astd_arbeitsbeschreibung'];
            break;
        }
    }
    //Die Eingabefelder innerhalb der Tabellenzeile
    //Bei INSERT sind die Felder leer, bei EDIT werden sie mit der DB-Inhalt gefüllt
    $out .= "<tr>"; 
    $out .= " <td><button name='btnSave'>OK</button></td>";
    $out .= " <td><input type='date' name='date'   value='".$date."'   placeholder='2019-06-21' style='width: 11em;'></td>";
    $out .= " <td><input type='text' name='pers'   value='".$pers."'   placeholder='MUH'        style='width: 5em;'></td>";
    $out .= " <td><input type='text' name='proj'   value='".$proj."'   placeholder='TBZ-IT'     style='width: 5em;'></td>";
    $out .= " <td><input type='text' name='tarif'  value='".$tarif."'  placeholder='BK'         style='width: 5em;'></td>";
    $out .= " <td><input type='text' name='zeit'   value='".$zeit."'   placeholder='4.0'        style='width: 5em;'></td>";
    $out .= " <td><input type='text' name='beschr' value='".$beschr."' placeholder='Ein Text'   style='width: 20em;'></td>";
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
		<title>TBZ M133, Demo für DB-Zugriffe</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="view/css/main.css" />
	</head>
	<body>
		<div id="wrapper">
			<a href="db-ressourcen/t_arbeitsstunden.sql" target="_blank">db-ressourcen/t_arbeitsstunden.sql</a> &nbsp; | &nbsp;
			<a href="https://gitlab.com/harald.mueller/m133-tag6" target="_blank">https://gitlab.com/harald.mueller/m133-tag6</a> &nbsp; | &nbsp;
            <a href="view/css/main.css" target="_blank">view/css/main.css</a> 
            <h1>TBZ M133 Demo für DB-Zugriffe</h1>
            <form action="#" method="post">
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
            			<th>Datum</th>
            			<th>MA</th>
            			<th>Projekt</th>
            			<th>Tarif</th>
            			<th>Std.</th>
            			<th>Arbeitsbeschreibung</th>
            		</tr>
            		<?= getInputFields($sqlSelWhr, $host, $database, $user, $pass); ?>
            		<?= getList($sqlSelect, $host, $database, $user, $pass); ?>
            	</table>
            </form>
		</div>
	</body>
</html>

<?php 
/*
-- SQL Code für die Datenbank- und Tabellenerstellung in MySQL/MariaDB
-- (über SQL-Eingabefenster in die DB einfügen)
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `db_m133`;
USE `db_m133`;

DROP TABLE IF EXISTS `t_arbeitsstunden`;
CREATE TABLE IF NOT EXISTS `t_arbeitsstunden` (
  `astd_id` int(11) NOT NULL,
  `astd_pers_krzl` varchar(8) NOT NULL,
  `astd_proj_krzl` varchar(8) NOT NULL,
  `astd_datum` date NOT NULL,
  `astd_tarif_krzl` varchar(8) NOT NULL,
  `astd_stdzahl` float NOT NULL,
  `astd_arbeitsbeschreibung` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `t_arbeitsstunden` (`astd_id`, `astd_pers_krzl`, `astd_proj_krzl`, `astd_datum`, `astd_tarif_krzl`, `astd_stdzahl`, `astd_arbeitsbeschreibung`) VALUES
(1, 'MUH', 'TBZ-IT', '2019-04-22', 'BK', 4, 'Berufskunde-Unterricht M133 Klasse BI16c'),
(2, 'MUH', 'TBZ-IT', '2019-04-23', 'ABU', 3, 'Unterricht ABU Klasse BI16c');

ALTER TABLE `t_arbeitsstunden`
  ADD PRIMARY KEY (`astd_id`);
-- AUTO_INCREMENT für Tabelle `t_arbeitsstunden`
ALTER TABLE `t_arbeitsstunden`
  MODIFY `astd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

*/ ?>