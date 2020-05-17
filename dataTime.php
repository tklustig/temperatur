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
        <script src="js/jquery-1.7.1.min.js"></script>
        <script src="js/jquery-ui-1.8.17.custom.min.js"></script>
        <script src="js/menus.js"></script>
        <script src="js/datetime.js"></script> 
        <script src="js/Alert.js"></script>
        <!--  CSS Bibliotheken -->
        <link href="css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="css/jquery-ui-1.8.17.custom.css">
        <style type="text/css"></style>
    </head>
    <body> <!-- Definition des Bodybereiches -->
        <script>
            $(document).ready(function () {
                $('#date').datepicker({
                    showOn: 'button',
                    buttonImage: 'calendar.png',
                    buttonImageOnly: true,
                    numberOfMonths: 2,
                    showButtonPanel: true,
                    autoSize: true,
                    monthNames: ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"],
                    dateFormat: 'dd-mm-yy'
                });
            });
        </script>
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
					<a href="dataAggregate.php">Aggregate abrufen</a>
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
    <center>
	<h2>Daten gemäß Datum</h2>
        <p>Hier werden nach dem Push auf den Submittbutton Records für das gewählte Datum angezeigt.</p>
        <div>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div>
                        <input class="feld" type=text name="date0" id="date" placeholder="Datum:" value="<?php
                        if (!empty($_REQUEST['date0'])) 
                            echo $_REQUEST['date0'];
                        ?>">
                    </div> 
					<br>					
                    <div>                     
                        <label>gemäß Datum anzeigen</label>
                        <input class="button3" type="submit" name="submit1" value="Submit">
                    </div>
					<br>
                </form>
		</div>		
    </center>
        <?php
        if (!empty($_REQUEST['submit1'])) {
            if (empty($_REQUEST['date0'])) {
                ?>
                <script>
                    var alertWidth = 250;
                    var alertHeight = 200;
                    var xAlertStart = 650;
                    var yAlertStart = 200;
                    var alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                    var alertText = "<p class='pAlert'>Warum erzeugen Sie unnötigen Traffic?<br>Bitte ein Datum wählen, bevor Sie einen Request abfeuern!</p>";
                    showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                </script>
                <?php
                die();
            } else {
                $strDatum = "";
                //splitte das Datumfeld anhand des Trenners(-) in ein Array
                $arrayOfDate = explode('-', $_REQUEST['date0']);
                //iteriere über das Array und setze den Datumstring so zusammen, dass die Datenbank ihn erkennt
                for ($i = 0; $i < count($arrayOfDate); $i++) {
                    if ($i != count($arrayOfDate) - 1)
                        $strDatum .= $arrayOfDate[$i] . '.';
                    else
                        $strDatum .= $arrayOfDate[$i];
                }
                //jetzt enthalt die Variable strDatum das Datum so, wie ihn die Datenbank mitunter enthält. Initialisere Datenbankabfrage
                require_once 'inc/autoloader.php';
                spl_autoload_register('classAutoloader');
                $DatabaseObject = new MySQLClass('root', '1918rott', 'mysql', '127.0.0.1', 'temperaturs');
                $connection = $DatabaseObject->Verbinden();
                if (!$connection) {
                    print_r("MySQL-Aufbau ist gescheitert!<br>");
                    die();
                }
                $sql = "SELECT datum FROM temperaturs;";
                $query1 = $DatabaseObject->Abfragen($connection, $sql);
                if (is_array($query1)) {
                    //Iteriere über das Array(query1) und überprüfe, ob strDatum in der Datenbank enthalten ist
                    for ($i = 0; $i < count($query1); $i++) {
                        //Sofern der Wert gefunden wurde, weise ihn der Variablen zu und verlasse die Schleife. Das offenbart eine Schwäche von PHP: Den Datentypenmismatch
                        if ($strDatum == $query1[$i]['datum']) {
                            $datum = $query1[$i]['datum'];
                            break;
                            //andernfalls setze die Variable auf false	
                        } else
                            $datum = false;
                    }
                } else {
                    print_r("Fehler bei der Datenbankabfrage!");
                    die();
                }
                //Sofern der Wert nicht gefunden wurde, benachrichtige den User
                if (!$datum) {
                    ?>
                    <script>
                        var alertWidth = 300;
                        var alertHeight = 150;
                        var xAlertStart = 650;
                        var yAlertStart = 200;
                        var alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                        var alertText = "<p class='pAlert'>Das angeforderte Datum konnte nicht gefunden werden. Suchen sie ggf. erneut mit einem anderen Datum!</p>";
                        showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                    </script>
                    <?php
                } else {
                    require_once 'inc/anzeigen.php';
                    $sql = "SELECT id,datum,uhrzeit,Temperatur_Celsius,ROUND(611.2 * EXP((17.62*Luftfeuchtigkeit_Prozent)/(243.12+Luftfeuchtigkeit_Prozent))/100,2) AS Luftfeuchtigkeit_Prozent,created_at FROM temperaturs WHERE datum='$datum' LIMIT 49";
                    $query2 = $DatabaseObject->Abfragen($connection, $sql);
                    if (is_array($query2))
                        anzeigen($query2);
                    else {
                        print_r('!!Error!!<br>Datenbankfehler. Abbruch!');
                        foreach ($connection->errorInfo() as $item) {
                            print_r('<br>' . $item);
                        }
                        die();
                    }
                }
            }
        }
        ?>
	</body>
</html>

