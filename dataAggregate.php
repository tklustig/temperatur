<!Doctype html> <!-- Definition des doctype-Modus -->
<html> <!-- Definition des Stammverzeichnises -->
    <head> <!-- Definition des Kopfbereiches -->
        <meta charset="utf-8"><!-- charset[utf-8:]  definiert den deutschen Zeichensatz -->
        <meta name="msvalidate.01" content="8B12875037645A4090EE64488042FDA9" /><!--validiert die Website für Bing und Yahoo-->
        <meta name="date" content="2019-05-19T08:49:37+02:00">		<!-- Angaben, wann die Seite publiziert wurde-->
        <meta name="keywords" content="Temperatur, Analyse, Graphics">	<!-- versorgt die Spider der Suchmaschinen mit Informationen zwecks Suchbegriffen -->
        <meta name="description" content="Eine Auswertung der Datenbankdaten / Pi-Temperatursensor">	<!-- Beschreibung, die in den Suchmaschinen erscheinen soll. -->
        <meta name="robots" content="index,follow">			<!-- Links sollen mitindiziert werden //NOINDEX:Seite soll nicht aufgenommen werden//NOFOLLOW Links werden nicht verfolgt-->
        <meta name="audience" content="alle">				<!-- definiert die Zielgruppe der Website  -->
        <meta name="page-topic" content="Hobby">		<!-- Zuordnungsdefinition für die Suchmaschine -->
        <meta name="revisit-after" CONTENT="7 days">			<!-- definiert den erneuten Besuch des Spiders//hier:nach sieben Tagen  -->
        <title lang="de">Temperatur Analyse</title> 	<!-- weist dem HTML-Dokument in der Registerkarte einen Namen zu -->     
        <!--  JQuery Bibliotheken -->
        <script src="js/menus.js"></script>
        <script src="js/datetime.js"></script> 
        <script src="js/Alert.js"></script>
        <!--  CSS Bibliotheken -->
        <link href="css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="css/jquery-ui-1.8.17.custom.css">
        <style type="text/css"></style>
    </head>

    <body> <!-- Definition des Bodybereiches -->
        <div class="mainDiv">
            <div id="uhr"></div>
        </div>
        <ul>
            <li class="dropdown">
                <a href="javascript:void(0)" class="treffer_0" onclick="myFunction_0()">Home</a>
                <div class="dropdown-inhalt_0" id="auswahl_0">
                    <a href="info.php">PHP-Info</a>
                    <a href="javascript:impressum()">Impressum</a>
                    <a href="index.php">Startseite</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="treffer_0" onclick="myFunction_1()">Daten abrufen</a>
                <div class="dropdown-inhalt_0" id="auswahl_1">
                    <a href="showGraphics.php">Grafik erstellen</a>
                    <a href="dataAll.php">alle Daten abrufen</a>
					<a href="dataTime.php">bestimmte Daten abrufen </a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="treffer_0" onclick="myFunction_2()">Adminbereich</a>
                <div class="dropdown-inhalt_0" id="auswahl_2">
                    <a href="dataDelete.php">Daten löschen</a>
                    <a href="dataRemove.php">Duplikate entfernen</a>
					<a href="findPiErrors.php">Meßfehler beseitigen</a>
					<a href="dataKorrigieren.php">Meßfehler korrigieren</a>
					
                </div>
            </li>
        </ul>
        <script>
            function impressum() {
                alert("Programmierer &  V.i.S.d.P: Thomas Kipp\nAnschrift:\nKlein - Buchholzer - Kirchweg 25\n30659 Hannover\nMobil:0152/37389041");
            }
        </script>
		    <center><h2>Statistik</h2>
        <p>Hier werden Aggregatsfunktionen und Statistikdaten angezeigt. Die Wahl der Steuerelemente hat Vorrang!</p>
        <div>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"> 
				<div>				
			    <?php
                require_once 'inc/anzeigen.php';
                echo auswahlStepMonth();			
                ?>
				<input type="radio" name="rad" id="dummy1" value="2017" />2017
                <input type="radio" name="rad" id="dummy2" value="2018" />2018
				<input type="radio" name="rad" id="dummy3" value="2019" />2019 
				<input type="radio" name="rad" id="dummy4" value="2020" checked />2020
				</div>				
                    <div>
                        <br>
                        <label>gemäß Steuerelemente anzeigen</label>
                        <input class="button3" type="submit" name="submit1" value="Submit" />
                    </div>
                </form>
            </center>
        </div>
<?php
require_once 'inc/autoloader.php';
spl_autoload_register('classAutoloader');
$DatabaseObject = new MySQLClass('root', '1918rott', 'mysql', '127.0.0.1', 'temperaturs');
$connection = $DatabaseObject->Verbinden();
if (!$connection) {
	print_r("MySQL-Aufbau ist gescheitert!<br>");
    die();
}
if(!empty($_REQUEST["submit1"])){
	//hier die Resultate abhängig von den Steuerelementen DropDown($_REQUEST["anzahlItems"] und Radiobuttons anzeigen
switch ($_REQUEST["anzahlItems"]) {
    case "02":
       $monat="Feb";
        break;
    case "03":
       $monat="März";
        break;
	case "04":
       $monat="April";
        break;
    case "05":
       $monat="Mai";
        break;
    case "06":
       $monat="Juni";
        break;
	case "07":
       $monat="Juli";
        break;
    case "08":
       $monat="Aug";
        break;
    case "09":
       $monat="Sept";
        break;
	case "10":
       $monat="Okt";
        break;
    case "11":
       $monat="Nov";
        break;
    case "12":
       $monat="Dez";
        break;
	default:
		$monat="Unknown";
		break;
}
switch ($_REQUEST["rad"]) {
    case "2017":
       $monat.="-2017";
        break;
    case "2018":
        $monat.="-2018";
        break;
    case "2019":
        $monat.="-2019";
        break;
		case "2020":
        $monat.="-2020";
        break;
	default:
		 $monat.="Unknown";
		break;
}
$sql = "SELECT datum,Temperatur_Celsius,id FROM temperaturs";
$arrayOfTemp=array();
$arrayOfValues=array();
$query1 = $DatabaseObject->Abfragen($connection, $sql);
$delimter1='/'.$_REQUEST["rad"].'/';
$delimter2='/'.$_REQUEST["anzahlItems"].'/';
foreach($query1 as $daten){
	if(preg_match($delimter1,$daten["datum"])&& preg_match($delimter2,$daten["datum"])&&!startsWith($daten["datum"],$_REQUEST["anzahlItems"])){
		//echo $daten["datum"].' '.$daten["Temperatur_Celsius"].'<br>';
		array_push($arrayOfTemp,$daten["Temperatur_Celsius"]);
		array_push($arrayOfValues,$daten["datum"]);
	}
}
$valueAll=count($arrayOfTemp);
if(count($arrayOfTemp)>0){
	$valueMin=min($arrayOfTemp);
	$valueMax=max($arrayOfTemp);
	$valueAvg=round(array_sum($arrayOfTemp) / count($arrayOfTemp),2);
	$valueCountMin=0;
	$valueCountMax=0;
	foreach($arrayOfTemp as $item){
		if($item == min($arrayOfTemp))
			$valueCountMin++;
	}
	foreach($arrayOfTemp as $item){
		if($item == max($arrayOfTemp))
			$valueCountMax++;
	}
}else{
?>
	<script>
    var alertWidth = 250;
    var alertHeight = 200;
    var xAlertStart = 650;
    var yAlertStart = 200;
    var alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
    var alertText = "<p class='pAlert'>Für dieses Datum sind keinerlei Meßwerte verfügbar. Bitte ein anderes Datum wählen!</p>";
    showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
    </script>
<?php
die();
}
		?>
	<br><br>
<table class="doFixed" border="1" cellpadding="5" cellspacing="5">
<tr>
<th>Anzahl aller Meßwerte</th>
<th>Minimaler Temperaturwert(<?=$monat?>)</th>
<th>Maximaler Temperaturwert(<?=$monat?>)</th>
<th>Durchschnittlicher Temperaturwert(<?=$monat?>)</th>
<th>Anzahl an minimalen Temperaturwerten(<?=$monat?>)</th>
<th>Anzahl an maximalen Temperaturwerten(<?=$monat?>)</th>
</tr>
<tr>
<td><?=$valueAll?></td>
<td><?=$valueMin?><span> &#8451;</span></td>
<td><?=$valueMax?><span> &#8451;</span></td>
<td><?=$valueAvg?><span> &#8451;</span></td>
<td><?=$valueCountMin?></td>
<td><?=$valueCountMax?></td>
</tr>
</table>
<br><br>
<?php
$startDatum=$arrayOfValues[0];
$index=count($arrayOfValues)-1;
$endDatum=$arrayOfValues[$index];
$sql="SELECT Temperatur_Celsius AS grad,COUNT(id) AS anzahl, datum FROM temperaturs WHERE STR_TO_DATE(datum, '%d.%m.%Y')>=STR_TO_DATE("."'".$startDatum."'".", '%d.%m.%Y') AND STR_TO_DATE(datum, '%d.%m.%Y')<=STR_TO_DATE("."'".$endDatum."'".", '%d.%m.%Y') GROUP BY grad;";
$query1 = $DatabaseObject->Abfragen($connection, $sql);
     foreach ($query1 as $daten) {  
            ?>
            <table class="doFixed"><tr>
                <thead>
                    <tr>
                        <td  bgcolor=#FFFFFF>Grad <span> &#8451;</span></td></td>
                        <td  bgcolor=#A9BCF5>absolute Häufigkeit</td>
						<td  bgcolor=#F5A9F2>relative Häufigkeit</td>
                    </tr>
                </thead>
				<?php
				$relativeH=round(($daten['anzahl']/$valueAll)*100,2);
				?>
                <?=

                "<td  bgcolor=#F2F5A9>" . $daten['grad'] . "</td><td  bgcolor=#A9BCF5>" . $daten['anzahl']. "</td><td  bgcolor=#F5A9F2>" . $relativeH . "%</td></tr></table>";
    }

}else{
	//hier Standardwerte anzeigen
	$sql = "SELECT COUNT(id) AS gesamt FROM temperaturs";
	$query1 = $DatabaseObject->Abfragen($connection, $sql);
	$valueAll=  $query1[0]['gesamt'];
	$sql="SELECT MIN(Temperatur_Celsius) AS minimal FROM temperaturs";
	$query2 = $DatabaseObject->Abfragen($connection, $sql);
	$valueMin= $query2[0]['minimal'];
	$sql="SELECT MAX(Temperatur_Celsius) AS maximal FROM temperaturs";
	$query3 = $DatabaseObject->Abfragen($connection, $sql);
	$valueMax= $query3[0]['maximal'];
	$sql="SELECT ROUND(AVG(Temperatur_Celsius),2) AS durchschnitt FROM temperaturs";
	$query4 = $DatabaseObject->Abfragen($connection, $sql);
	$valueAvg= $query4[0]['durchschnitt'];
	$sql="SELECT COUNT(Temperatur_Celsius) AS invers FROM temperaturs WHERE Temperatur_Celsius!=Luftfeuchtigkeit_Prozent";
	$query5 = $DatabaseObject->Abfragen($connection, $sql);
	$valueInvert= $query5[0]['invers'];
	//SubSelect
	$sql="SELECT COUNT(Temperatur_Celsius) AS countMin FROM temperaturs WHERE Temperatur_Celsius =
			(
				SELECT MIN(Temperatur_Celsius) FROM temperaturs
			) ";
	$query1 = $DatabaseObject->Abfragen($connection, $sql);
	$valueCountMin= $query1[0]['countMin'];
	$sql="SELECT COUNT(Temperatur_Celsius) AS countMax FROM temperaturs WHERE Temperatur_Celsius =
			(
				SELECT MAX(Temperatur_Celsius) FROM temperaturs
			) ";
	$query1 = $DatabaseObject->Abfragen($connection, $sql);
	$valueCountMax= $query1[0]['countMax'];
?>

<br><br>
<table class="doFixed" border="1" cellpadding="5" cellspacing="5">
<tr>
<th>Anzahl aller Meßwerte</th>
<th>Minimaler Temperaturwert</th>
<th>Maximaler Temperaturwert</th>
<th>Durchschnittlicher Temperaturwert</th>
<th>Anzahl an minimalen Temperaturwerten</th>
<th>Anzahl an maximalen Temperaturwerten</th>
<th>Anzahl inverser Meßwerte</th>
</tr>
<tr>
<td><?=$valueAll?></td>
<td><?=$valueMin?><span> &#8451;</span></td>
<td><?=$valueMax?><span> &#8451;</span></td>
<td><?=$valueAvg?><span> &#8451;</span></td>
<td><?=$valueCountMin?></td>
<td><?=$valueCountMax?></td>
<td><?=$valueInvert?></td>
</tr>
</table>
<br><br>
<?php
$sql="SELECT Temperatur_Celsius AS grad,COUNT(id) AS anzahl FROM temperaturs GROUP BY Grad HAVING COUNT(Grad)>=1";
$query1 = $DatabaseObject->Abfragen($connection, $sql);
     foreach ($query1 as $daten) {  
            ?>
            <table class="doFixed"><tr>
                <thead>
                    <tr>
                        <td  bgcolor=#FFFFFF>Grad <span> &#8451;</span></td></td>
                        <td  bgcolor=#A9BCF5>absolute Häufigkeit</td>
						<td  bgcolor=#F5A9F2>relative Häufigkeit</td>
                    </tr>
                </thead>
				<?php
				$relativeH=round(($daten['anzahl']/$valueAll)*100,2);
				?>
                <?=

                "<td  bgcolor=#F2F5A9>" . $daten['grad'] . "</td><td  bgcolor=#A9BCF5>" . $daten['anzahl']. "</td><td  bgcolor=#F5A9F2>" . $relativeH . "%</td></tr></table>";
    }
}

?>
</body>
</html>
<?php
function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}
?>











