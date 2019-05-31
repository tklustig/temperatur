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
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="treffer_0" onclick="myFunction_1()">Daten abrufen</a>
                <div class="dropdown-inhalt_0" id="auswahl_1">
                    <a href="showGraphics.php">Grafik erstellen</a>
                    <a href="dataAll.php">alle Daten abrufen </a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="treffer_0" onclick="myFunction_2()">Adminbereich</a>
                <div class="dropdown-inhalt_0" id="auswahl_2">
                    <a href="dataDelete.php">Daten löschen</a>
                    <a href="dataRemove.php">Duplikate entfernen</a>
                </div>
            </li>
        </ul>
        <script>
            function impressum() {
                alert("Programmierer &  V.i.S.d.P: Thomas Kipp\nAnschrift:\nKlein - Buchholzer - Kirchweg 25\n30659 Hannover\nMobil:0152/37389041");
            }
        </script>
    <center><h2>Daten gemäß Datum</h2>
        <p>Hier werden nach dem Push auf den Submittbutton Records ab dem gewählten Datum angezeigt.</p>
        <div>
            <center>
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div>
                        <input class="feld" type=text name="date0" id="date" placeholder="Datum:" value="<?php
                        if (!empty($_REQUEST['date0'])) {
                            echo $_REQUEST['date0'];
                        }
                        ?>">
                    </div>                  
                    <div>
                        <br>
                        <label>gemäß Datum anzeigen</label>
                        <input class="button3" type="submit" name="submit1" value="Submit">
                    </div>
                </form>
            </center>
        </div>
        <?php
        if (!empty($_REQUEST['submit1'])) {
            if (empty($_REQUEST['date0'])) {
                ?>
                <script>
                    alertWidth = 250;
                    alertHeight = 200;
                    xAlertStart = 650;
                    yAlertStart = 200;
                    alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                    alertText = "<p class='pAlert'>Warum erzeugen Sie unnötigen Traffic?<br>Bitte ein Datum wählen, bevor Sie einen Request abfeuern!</p>";
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
                $DatabaseObject = new MySQLClass('root', '', 'mysql', '192.168.1.10', 'temperatur');
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
                        //Sofern der Wert gefunden wurde, weise ihn der Session zu und verlasse die Schleife
                        if ($strDatum == $query1[$i]['datum']) {
                            $datum = $query1[$i]['datum'];
                            break;
                            //andernfalls setze die Session auf 1
                        } else
                            $datum = 1;
                    }
                } else {
                    print_r("Fehler bei der Datenbankabfrage!");
                    die();
                }
                //Sofern der Wert nicht gefunden wurde, benachrichtige den User
                if ($datum == 1) {
                    ?>
                    <script>
                        alertWidth = 300;
                        alertHeight = 150;
                        xAlertStart = 650;
                        yAlertStart = 200;
                        alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                        alertText = "<p class='pAlert'>Das angeforderte Datum konnte nicht gefunden werden. Suchen sie ggf. erneut mit einem anderen Datum!</p>";
                        showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                    </script>
                    <?php
                } else {
                    require_once 'inc/anzeigen.php';
                    $sql = "SELECT id,datum,uhrzeit,Temperatur_Celsius,Luftfeuchtigkeit_Prozent,created_at FROM temperaturs WHERE datum='$datum' LIMIT 49";
                    $query2 = $DatabaseObject->Abfragen($connection, $sql);
                    if (is_array($query2))
                        anzeigen($query2);
                    else {
                        print_r('!!Error!!<br>Datenbankfehler. Abbruch!');
                        die();
                    }
                }
            }
        }
        ?>

