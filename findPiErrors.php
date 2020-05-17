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
                    <a href="dataAll.php">alle Daten abrufen </a>
                    <a href="dataTime.php">bestimmte Daten abrufen</a>
					<a href="dataAggregate.php">Aggregate abrufen</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="treffer_0" onclick="myFunction_2()">Adminbereich</a>
                <div class="dropdown-inhalt_0" id="auswahl_2">
                    <a href="dataDelete.php">Daten löschen</a>
                    <a href="dataRemove.php">Duplikate entfernen</a>
					<a href="dataKorrigieren.php">Meßfehler korrigieren</a>
					
                </div>
            </li>
        </ul>
        <script>
            function impressum() {
                alert("Programmierer &  V.i.S.d.P: Thomas Kipp\nAnschrift:\nKlein - Buchholzer - Kirchweg 25\n30659 Hannover\nMobil:0152/37389041");
            }
        </script>
    <center><h2>Bereinigung</h2>
        <p>Hier haben Sie die Möglichkeit, Messfehler zu beseitigen</p>
		<label><font color="black">Wählen Sie Monat und Jahr, betätigen Sie den Submittbutton und Ihnen wird mitgeteilt, ob und ggf. welcher Messfehler(ID) entfernt wurde</font></label><br><br>
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
                    <label>gemäß Steuerelemente beseitigen</label>
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
if (!empty($_REQUEST["submit1"])) {
    $sql = "SELECT datum,Temperatur_Celsius FROM temperaturs";
    $arrayOfTemp = array();
    $arrayOfDatum = array();
    $query1 = $DatabaseObject->Abfragen($connection, $sql);
    $delimter1 = '/' . $_REQUEST["rad"] . '/';
    $delimter2 = '/' . $_REQUEST["anzahlItems"] . '/';
    foreach ($query1 as $daten) {
        if (preg_match($delimter1, $daten["datum"]) && preg_match($delimter2, $daten["datum"]) && !startsWith($daten["datum"], $_REQUEST["anzahlItems"])) {
            array_push($arrayOfTemp, $daten["Temperatur_Celsius"]);
            array_push($arrayOfDatum, $daten["datum"]);
        }
    }
    if (empty($arrayOfTemp) || count($arrayOfTemp) < 4) {
        ?>
        <script>
            var alertWidth = 250;
            var alertHeight = 200;
            var xAlertStart = 650;
            var yAlertStart = 200;
            var alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
            var alertText = "<p class='pAlert'>Für dieses Datum sind keine verwertbaren Meßwerte verfügbar. Bitte ein anderes Datum wählen!</p>";
            showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
        </script>
        <?php
        die();
    }
    $minValueTemp = min($arrayOfTemp);
    $arrayOfTempCopy = $arrayOfTemp;
    sort($arrayOfTempCopy); // aufsteigend sortieren
    $arrayOfTempCopy = array_slice($arrayOfTempCopy, 0, 3); // die ersten zwei Werte des sortierten Arrays auslesen
    if ($arrayOfTempCopy[0] == $arrayOfTempCopy[1]) {
        $boolValueDouble = true;
        $arrayOfDoubleValues = array();
        for ($i = 0; $i < count($arrayOfTempCopy); $i++) {
            if ($arrayOfTempCopy[0] == $arrayOfTempCopy[$i])
                array_push($arrayOfDoubleValues, $arrayOfTempCopy[$i]);
            else
                break;
        }
    } else
        $boolValueDouble = false;
    if (!$boolValueDouble) {
        if ($arrayOfTempCopy[1] - $arrayOfTempCopy[0] >= 2) {
            $hatMessfehler = true;
            $value2BeDeleted = $arrayOfTempCopy[0];
        } else
            $hatMessfehler = false;
    }else {
        if (count($arrayOfDoubleValues) == 2) {
            $hatMessfehler = true;
            $value2BeDeleted = $arrayOfDoubleValues[0];
        } else
            $hatMessfehler = false;
    }
    if ($hatMessfehler) {
        $startDatum = $arrayOfDatum[0];
        $index = count($arrayOfDatum) - 1;
        $endDatum = $arrayOfDatum[$index];
        $sql = "SELECT id FROM temperaturs WHERE Temperatur_Celsius=$value2BeDeleted AND STR_TO_DATE(datum, '%d.%m.%Y')>=STR_TO_DATE(" . "'" . $startDatum . "'" . ", '%d.%m.%Y') AND STR_TO_DATE(datum, '%d.%m.%Y')<=STR_TO_DATE(" . "'" . $endDatum . "'" . ", '%d.%m.%Y') ORDER BY datum ASC;";
        $query1 = $DatabaseObject->Abfragen($connection, $sql);
        foreach ($query1 as $item) {
            $id2BeDeleted = $item['id'];
            break;
        }
        $sql = "DELETE FROM temperaturs WHERE Temperatur_Celsius=$value2BeDeleted AND STR_TO_DATE(datum, '%d.%m.%Y')>=STR_TO_DATE(" . "'" . $startDatum . "'" . ", '%d.%m.%Y') AND STR_TO_DATE(datum, '%d.%m.%Y')<=STR_TO_DATE(" . "'" . $endDatum . "'" . ", '%d.%m.%Y');";
        $query1 = $DatabaseObject->Abfragen($connection, $sql);
        if ($query1)
            $boolSucces = true;
        else
            $boolSucces = false;
    } else {
        ?>
        <script>
            var alertWidth = 250;
            var alertHeight = 200;
            var xAlertStart = 650;
            var yAlertStart = 200;
            var alertTitle = "<p class='pTitle'><b>! Information !</b></p>";
            var alertText = "<p class='pAlert'>Für dieses Datum wurden keine Meßfehler gefunden!</p>";
            showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
        </script>
        <?php
        die();
    }
    if (!empty($boolSucces) && $boolSucces) {
        if (!empty($id2BeDeleted)) {
            ?>
            <script>
                var daten = "<?php echo $id2BeDeleted; ?>";
                var alertWidth = 250;
                var alertHeight = 200;
                var xAlertStart = 650;
                var yAlertStart = 200;
                var alertTitle = "<p class='pTitle'><b>! Information !</b></p>";
                var alertText = "<p class='pAlert'>Der oder die Meßfehler mit der StartID:" + daten + " wurde(n) beseitigt!</p>";
                showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
            </script>
            <?php
            die();
        }
    } else {
        ?>
        <script>
            var daten = "<?php echo $id2BeDeleted ?>";
            var alertWidth = 250;
            var alertHeight = 200;
            var xAlertStart = 650;
            var yAlertStart = 200;
            var alertTitle = "<p class='pTitle'><b>! Error !</b></p>";
            var alertText = "<p class='pAlert'>Datenbankfehler! Der Meßfehler mit der ID:" + daten + " konnte nicht beseitigt werden!</p>";
            showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
        </script>
        <?php
        die();
    }
}
?>
</body>
</html>

<?php

function startsWith($haystack, $needle) {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}
?>











