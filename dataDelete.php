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
        <script src="js/menus.js"></script>
        <script src="js/datetime.js"></script>
        <script src="js/Alert.js"></script>
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body> <!-- Definition des Bodybereiches -->
        <div class="mainDiv">
            <div id="uhr"></div>
        </div>
        <img src="counter.php" title="Pic1" alt="Picture1">
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
                    <a href="dataTime.php">bestimmte Daten abrufen </a>
                </div>
            </li>
            <li class="dropdown">
                <a href="javascript:void(0)" class="treffer_0" onclick="myFunction_2()">Adminbereich</a>
                <div class="dropdown-inhalt_0" id="auswahl_2">
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
        <p>Hier können Sie Records löschen. In der Onlineversion verpufft der Request allerdings , da ich nicht möchte, dass von jedem x-beliebigen Vollhorst die Records meiner Datenbank zerstört werden.</p>
    </center>
    <div>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div id="dropdown2">
                <?php
                require_once 'inc/anzeigen.php';
                ?><?=
                auswahlStepId(1, 1, 10);
                require_once 'inc/autoloader.php';
                spl_autoload_register('classAutoloader');
                $DatabaseObject = new MySQLClass('root', '', 'mysql', '192.168.1.10', 'temperatur');
                $connection = $DatabaseObject->Verbinden();
                if (!$connection) {
                    print_r("MySQL-Aufbau ist gescheitert!<br>");
                    die();
                }
                $sql = "SELECT max(id) AS max FROM temperaturs";
                $query1 = $DatabaseObject->Abfragen($connection, $sql);
                if (is_array($query1))
                    $maxId = $query1[0]['max'];
                else {
                    print_r('!!Error!!<br>Datenbankfehler. Abbruch!');
                    die();
                }
                ?>
            </div>
            <div id="textbox">
                <label>Ab Id:</label>
                <input type="text" name="startId" size="30" maxlength="30" placeholder="Maximal bis zur ID  <?= $maxId ?>">
            </div>
            <input class="button3" id="submitDropDown1" type="submit" name="submit1" value="Submit">
            <input class="button2" id="submitDropDown2" type="submit" name="submit2" value="DropDown">
            <div id="radioButton">
                <input type="radio" name="rad" id="dummy1" value="exact">genau die Id
                <br><input type="radio" name="rad" id="dummy2" value="upTo">ab Id
            </div>
            <?php
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
                $projectIsOnline = false;
            else
                $projectIsOnline = true;
            //Alle Eventualitäten nach dem DropDown-Request verarbeiten
            if (!empty($_REQUEST['submit2'])) {
                if (empty($_REQUEST['startId'])) {
                    ?>
                    <script>
                        var alertWidth = 250;
                        var alertHeight = 200;
                        var xAlertStart = 650;
                        var yAlertStart = 200;
                        var alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                        var alertText = "<p class='pAlert'>Warum erzeugen Sie unnötigen Traffic?<br>Bitte die Start-Id in die Textbox eingeben!</p>";
                        showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                    </script>
                    <?php
                    die();
                } else {
                    ?>
                    <div id="dropdown2">
                        <?= auswahlStepId(1, $_REQUEST['startId'], $_REQUEST['startId'] + 100);
                        ?>
                    </div>
                </form>
                <?php
            }
            if (!empty($_REQUEST['startId'])) {
                if ($_REQUEST['startId'] > $maxId) {
                    ?>
                    <script>
                        var alertWidth = 250;
                        var alertHeight = 200;
                        var xAlertStart = 650;
                        var yAlertStart = 200;
                        var alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                        var alertText = "<p class='pAlert'>Bitte nicht höher als die maximal zulässige Id eingeben.<br> Der Placeholder teilt ihnen mit, bis zu welcher Id Sie löschen können.</p>";
                        showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                    </script>
                    <?php
                }
                die();
            }
        }
        //Alle Eventualitäten nach dem Submit-Request verarbeiten
        if (!empty($_REQUEST['submit1'])) {
            if (empty($_REQUEST['rad'])) {
                ?>
                <script>
                    var alertWidth = 250;
                    var alertHeight = 200;
                    var xAlertStart = 650;
                    var yAlertStart = 200;
                    var alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                    var alertText = "<p class='pAlert'>Bitte einen der beiden Radiobuttons aktiveren,<br>um festzulegen, wieviele Records gelöscht werden sollen!</p>";
                    showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                </script>
                <?php
                die();
            } else if ($projectIsOnline) {
                ?>
                <script>
                    var alertWidth = 250;
                    var alertHeight = 200;
                    var xAlertStart = 650;
                    var yAlertStart = 200;
                    var alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                    var alertText = "<p class='pAlert'>Online ist diese Option nicht verfügbar(s. Beschreibung)</p>";
                    showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                </script>
                <?php
                die();
            }
            //hier werden Records, abhänging von der RadionButtonwahl(ein einzelner oder mehrere) und ggf. der ID gelöscht
            if (isset($_REQUEST['anzahlItems']) && $_REQUEST['anzahlItems'] > 1) {
                if ($_REQUEST['rad'] == 'exact') {
                    $sql = 'DELETE FROM temperaturs WHERE id=' . $_REQUEST["anzahlItems"];
                    $connection->beginTransaction();
                    $query2 = $DatabaseObject->Abfragen($connection, $sql);
                    if ($query2) {
                        ?>
                        <script>
                            var alertWidth = 250;
                            var alertHeight = 200;
                            var xAlertStart = 650;
                            var yAlertStart = 200;
                            var id = "<?php echo $_REQUEST["anzahlItems"] ?>";
                            var alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                            var alertText = "<p class='pAlert'>Der Record mit der ID:" + id + " wurde gelöscht";
                            showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                        </script>
                        <?php
                    } else {
                        print_r('!!Error!!<br>Datenbankfehler. Abbruch!');
                        die();
                    }
                } else if ($_REQUEST['rad'] == 'upTo') {
                    
                }
            } else {
                ?>
                <script>
                    alertWidth = 250;
                    alertHeight = 200;
                    xAlertStart = 650;
                    yAlertStart = 200;
                    alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                    alertText = "<p class='pAlert'>Bitte einen beliebigen Wert aus der DropDownbox größer als eins wählen.</p>";
                    showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                </script>
                <?php
                die();
            }
        }
        ?>

