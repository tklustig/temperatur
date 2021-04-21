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
                    <a href="dataAggregate.php">Aggregate abrufen</a>
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
                alert("Programmierer &  V.i.S.d.P: Thomas Kipp\nAnschrift:\nDebberoder Str.61\n30659 Hannover\nMobil:0152/37301327");
            }
        </script>
    <center><h2>Daten löschen</h2>
        <p>Hier können Sie Records löschen. Damit der Request nicht verpufft, muss das Adminpasswort eingegeben werden, da ich nicht möchte, dass von jedem x-beliebigen Vollhorst die Records meiner Datenbank zerstört werden.</p>
    </center>
    <div>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div id="dropdown2">
                <?php
                require_once 'inc/anzeigen.php';
                ?><?=
                auswahlStepId(1, 1, 100);
                require_once 'inc/connect.php';
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
                    print_r('<br>!!Error!!<br>Datenbankfehler. Abbruch!');
                    foreach ($connection->errorInfo() as $item) {
                        print_r('<br>' . $item);
                    }
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
            <label>Passwort</label>
            <input type="password" name="passwortfeld" size="12" maxlength="12" />
        </form>
        <?php
        $content = file_get_contents("txt/passwordhash.txt");
        $encoding = decodeRand($content);
        if (!empty($_REQUEST['passwortfeld']))
            $erg = $encoding == $_REQUEST["passwortfeld"] ? TRUE : FALSE;
        if (!empty($_REQUEST["passwortfeld"]) && $_REQUEST["passwortfeld"] == $encoding)
        //if (!empty($_REQUEST["passwortfeld"]) && password_verify('1918rott', $content))
            $recordMayNotBeDeleted = false;
        else
            $recordMayNotBeDeleted = true;
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
                        var alertText = "<p class='pAlert'>Bitte nicht höher als die maximal zulässige Id eingeben.<br> Der Placeholder teilt Ihnen mit, bis zu welcher Id Sie löschen können.</p>";
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
                    <?php
                }
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
            } else if ($recordMayNotBeDeleted) {
                ?>
                <script>
                    var alertWidth = 250;
                    var alertHeight = 200;
                    var xAlertStart = 650;
                    var yAlertStart = 200;
                    var alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                    var alertText = "<p class='pAlert'>Das Passwort ist inkorrekt. Der Record wird nicht gelöscht!</p>";
                    showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                </script>
                <?php
                die();
            }
            //hier werden Records, abhänging von der RadionButtonwahl(ein einzelner oder mehrere) und ggf. der ID gelöscht
            if (isset($_REQUEST['anzahlItems']) && $_REQUEST['anzahlItems'] > 1) {
                if ($_REQUEST['rad'] == 'exact') {
                    $sql = 'DELETE FROM temperaturs WHERE id=' . $_REQUEST["anzahlItems"];
                    $deleteRecords = true;
                } else if ($_REQUEST['rad'] == 'upTo') {
                    $sql = 'DELETE FROM temperaturs WHERE id >=' . $_REQUEST["anzahlItems"];
                    $deleteRecords = true;
                } else
                    $deleteRecords = false;
                if ($deleteRecords) {
                    try {
                        $connection->beginTransaction();
                        $query2 = $DatabaseObject->Abfragen($connection, $sql);
                        $connection->commit();
                    } catch (Exception $e) {
                        print_r('Fehler:' . $e->getMessage() . ', Felercode:' . $e->getCode() . ', in Zeile:' . $e->getLine() . ' ,in Datei:' . $e->getFile());
                        print_r('<br>Sämtliche Löschvorgänge wurden rückgängig gemacht oder erst gar nicht ausgeführt!');
                        $connection->rollBack();
                        print_r('<br>' . $connection->errorInfo());
                        die();
                    }
                    if ($query2 && $_REQUEST["anzahlItems"] <= $maxId) {
                        if ($_REQUEST['rad'] == 'exact') {
                            ?>
                            <script>
                                var alertWidth = 250;
                                var alertHeight = 200;
                                var xAlertStart = 650;
                                var yAlertStart = 200;
                                var id = "<?php echo $_REQUEST["anzahlItems"] ?>";
                                var alertTitle = "<p class='pTitle'><b>! Info !</b></p>";
                                var alertText = "<p class='pAlert'>Der Record mit der ID:" + id + " wurde gelöscht";
                                showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                            </script>
                            <?php
                        } else if ($_REQUEST['rad'] == 'upTo') {
                            ?>
                            <script>
                                var alertWidth = 250;
                                var alertHeight = 200;
                                var xAlertStart = 650;
                                var yAlertStart = 200;
                                var id = "<?php echo $_REQUEST["anzahlItems"] ?>";
                                var alertTitle = "<p class='pTitle'><b>! Info !</b></p>";
                                var alertText = "<p class='pAlert'>Alle Record ab der ID:" + id + " wurden gelöscht";
                                showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                            </script>
                            <?php
                        }
                    } else {
                        print_r('<br>!!Error!!<br>Datenbankfehler. Abbruch!');
                        foreach ($connection->errorInfo() as $item) {
                            print_r('<br>' . $item);
                        }
                        die();
                    }
                }
            } else {
                ?>
                <script>
                    alertWidth = 250;
                    alertHeight = 200;
                    xAlertStart = 650;
                    yAlertStart = 200;
                    alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                    alertText = "<p class='pAlert'>Bitte einen Wert aus der DropDownbox größer als eins und kleiner als Maximal wählen.</p>";
                    showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                </script>
                <?php
                die();
            }
        }
        ?>
        <?php

        function decodeRand($str, $seed = 1234567) {
            mt_srand($seed);
            $blocks = explode('-', $str);
            $out = array();
            foreach ($blocks as $block) {
                $ord = (intval($block) - mt_rand(350, 16000)) / 3;
                $out[] = chr($ord);
            }
            mt_srand();
            $giveBack = implode('', $out);
            return $giveBack;
        }
        ?>
        <?php
        if ($DatabaseObject != null)
            $DatabaseObject->closeConnection($connection);
        ?>