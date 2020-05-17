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
                    <a href="dataDelete.php">Daten löschen</a>
                    <a href="dataRemove.php">Duplikate entfernen</a>
                    <a href="findPiErrors.php">Meßfehler beseitigen</a>
                </div>
            </li>
        </ul>
        <script>
            function impressum() {
                alert("Programmierer &  V.i.S.d.P: Thomas Kipp\nAnschrift:\nKlein - Buchholzer - Kirchweg 25\n30659 Hannover\nMobil:0152/37389041");
            }
        </script>
    <center><h2>Daten korrigieren</h2>
        <p>Hier können Sie Records aufgrund von Meßfehlern korrgieren. Damit der Request nicht verpufft, muss das Adminpasswort eingegeben werden, da ich nicht möchte, dass Records beliebig verändert werden</p>
    </center>
    <div>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div id="dropdown2">
                <?php
                require_once 'inc/anzeigen.php';
                ?><?=
                require_once 'inc/autoloader.php';
                spl_autoload_register('classAutoloader');
                $DatabaseObject = new MySQLClass('root', '1918rott', 'mysql', '127.0.0.1', 'temperaturs');
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
                /* $sqlX = "SELECT id FROM temperaturs` WHERE Temperatur_Celsius>0";
                  $queryX = $DatabaseObject->Abfragen($connection, $sqlX);
                  var_dump(($queryX));
                  die();
                  if ($queryX == 1) {
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
                  }
                 */
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
            <?php
            $content = file_get_contents("txt/passwordhash.txt");
            if (!empty($_REQUEST["passwortfeld"]) && $_REQUEST["passwortfeld"] == decodeRand($content))
                $recordMayNotBeChanged = false;
            else
                $recordMayNotBeChanged = true;
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
                        var alertText = "<p class='pAlert'>Bitte einen der beiden Radiobuttons aktiveren,<br>um festzulegen, wieviele Records korrigiert werden sollen!</p>";
                        showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                    </script>
                    <?php
                    die();
                } else if ($recordMayNotBeChanged) {
                    ?>
                    <script>
                        var alertWidth = 250;
                        var alertHeight = 200;
                        var xAlertStart = 650;
                        var yAlertStart = 200;
                        var alertTitle = "<p class='pTitle'><b>! Warnung !</b></p>";
                        var alertText = "<p class='pAlert'>Das Passwort ist inkorrekt. Der Record wird nicht verändert!</p>";
                        showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                    </script>
                    <?php
                    die();
                }
                //hier werden Records, abhänging von der RadionButtonwahl(ein einzelner oder mehrere) und ggf. der ID amgepasst
                if (isset($_REQUEST['anzahlItems']) && $_REQUEST['anzahlItems'] > 1) {
                    if ($_REQUEST['rad'] == 'exact') {
                        $sql = 'SELECT datum from temperaturs WHERE id=' . $_REQUEST["anzahlItems"];
                        $changeRecords = true;
                    } else if ($_REQUEST['rad'] == 'upTo') {
                        $sql = 'SELECT datum from temperaturs WHERE id>=' . $_REQUEST["anzahlItems"];
                        $changeRecords = true;
                    } else
                        $changeRecords = false;
                    if ($changeRecords) {
                        try {
                            $connection->beginTransaction();
                            $query2 = $DatabaseObject->Abfragen($connection, $sql);
                            $connection->commit();
                        } catch (Exception $e) {
                            print_r('Fehler:' . $e->getMessage() . ', Felercode:' . $e->getCode() . ', in Zeile:' . $e->getLine() . ' ,in Datei:' . $e->getFile());
                            print_r('<br>Sämtliche Änderung wurden rückgängig gemacht oder erst gar nicht ausgeführt!');
                            $connection->rollBack();
                            print_r('<br>' . $connection->errorInfo());
                            die();
                        }
                        //if ($splitten[1] < 1) {
                        try {
                            if ($_REQUEST['rad'] == 'exact') {
                                $splitten = explode('.', $query2[0]['datum']);
                                $monat = $splitten[1];
                                if ($monat <= 5) {
                                    $arrayTemp = array(15, 16, 17, 18);
                                    $zufallszahl = rand(0, 3);
                                    $sql2 = 'UPDATE temperaturs SET Temperatur_Celsius=' . $arrayTemp[$zufallszahl] . ',Luftfeuchtigkeit_Prozent=20.59 where id=' . $_REQUEST["anzahlItems"];
                                } else if ($monat == 6) {
                                    $arrayTemp = array(22, 23, 24, 25);
                                    $zufallszahl = rand(0, 3);
                                    $sql2 = 'UPDATE temperaturs SET Temperatur_Celsius=' . $arrayTemp[$zufallszahl] . ',Luftfeuchtigkeit_Prozent=18.52 where id=' . $_REQUEST["anzahlItems"];
                                } else if ($monat == 7 || $monat == 8) {
                                    $arrayTemp = array(24, 23, 22, 21);
                                    $zufallszahl = rand(0, 3);
                                    $sql2 = 'UPDATE temperaturs SET Temperatur_Celsius=' . $arrayTemp[$zufallszahl] . ',Luftfeuchtigkeit_Prozent=17.66 where id=' . $_REQUEST["anzahlItems"];
                                } else if ($monat == 9) {
                                    $arrayTemp = array(19, 20, 21);
                                    $zufallszahl = rand(0, 3);
                                    $sql2 = 'UPDATE temperaturs SET Temperatur_Celsius=' . $arrayTemp[$zufallszahl] . ',Luftfeuchtigkeit_Prozent=16.64 where id=' . $_REQUEST["anzahlItems"];
                                } else if ($monat == 10) {
                                    $arrayTemp = array(20, 19, 18, 17);
                                    $zufallszahl = rand(0, 3);
                                    $sql2 = 'UPDATE temperaturs SET Temperatur_Celsius=' . $arrayTemp[$zufallszahl] . ',Luftfeuchtigkeit_Prozent=16.36 where id=' . $_REQUEST["anzahlItems"];
                                } else if ($monat == 11) {
                                    $arrayTemp = array(13, 16, 17, 18);
                                    $zufallszahl = rand(0, 3);
                                    $sql2 = 'UPDATE temperaturs SET Temperatur_Celsius=' . $arrayTemp[$zufallszahl] . ',Luftfeuchtigkeit_Prozent=14.23where id=' . $_REQUEST["anzahlItems"];
                                } else if ($monat == 12) {
                                    $arrayTemp = array(23, 22, 22, 21, 20);
                                    $zufallszahl = rand(0, 3);
                                    $sql2 = 'UPDATE temperaturs SET Temperatur_Celsius=' . $arrayTemp[$zufallszahl] . ',Luftfeuchtigkeit_Prozent=12.10 where id=' . $_REQUEST["anzahlItems"];
                                }
                                $query3 = $DatabaseObject->Abfragen($connection, $sql2);
                                if ($query3) {
                                    ?>
                                    <script>
                                        var alertWidth = 250;
                                        var alertHeight = 200;
                                        var xAlertStart = 650;
                                        var yAlertStart = 200;
                                        var id = "<?php echo $_REQUEST["anzahlItems"] ?>";
                                        var alertTitle = "<p class='pTitle'><b>! Info !</b></p>";
                                        var alertText = "<p class='pAlert'>Der Record mit der ID:" + id + " wurde angepasst";
                                        showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                                    </script>
                                    <?php
                                } else {
                                    ?>
                                    <script>
                                        var alertWidth = 250;
                                        var alertHeight = 200;
                                        var xAlertStart = 650;
                                        var yAlertStart = 200;
                                        var id = "<?php echo $_REQUEST["anzahlItems"] ?>";
                                        var alertTitle = "<p class='pTitle'><b>! Info !</b></p>";
                                        var alertText = "<p class='pAlert'>ERROR!!!:Der Record mit der ID:" + id + " konnte nicht angepasst wrerden";
                                        showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                                    </script>
                                    <?php
                                }
                            } else if ($_REQUEST['rad'] == 'upTo') {

                                for ($i = 0; $i < count($query2); $i++) {
                                    $splitten = explode('.', $query2[0]['datum']);
                                    $monat = $splitten[1];
                                    if ($monat <= 5) {
                                        $arrayTemp = array(15, 16, 17, 18);
                                        $zufallszahl = rand(0, 3);
                                        $sql2 = 'UPDATE temperaturs SET Temperatur_Celsius=' . $arrayTemp[$zufallszahl] . ',Luftfeuchtigkeit_Prozent=20.59 where id>=' . $_REQUEST["anzahlItems"];
                                    } else if ($monat == 6) {
                                        $arrayTemp = array(22, 23, 24, 25);
                                        $zufallszahl = rand(0, 3);
                                        $sql2 = 'UPDATE temperaturs SET Temperatur_Celsius=' . $arrayTemp[$zufallszahl] . ',Luftfeuchtigkeit_Prozent=20.59 where id>=' . $_REQUEST["anzahlItems"];
                                    } else if ($monat == 7 || $monat == 8) {
                                        $arrayTemp = array(24, 23, 22, 21, 20);
                                        $zufallszahl = rand(0, 3);
                                        $sql2 = 'UPDATE temperaturs SET Temperatur_Celsius=' . $arrayTemp[$zufallszahl] . ',Luftfeuchtigkeit_Prozent=20.59 where id>=' . $_REQUEST["anzahlItems"];
                                    } else if ($monat == 9) {
                                        $arrayTemp = array(19, 20, 21);
                                        $zufallszahl = rand(0, 3);
                                        $sql2 = 'UPDATE temperaturs SET Temperatur_Celsius=' . $arrayTemp[$zufallszahl] . ',Luftfeuchtigkeit_Prozent=20.59 where id>=' . $_REQUEST["anzahlItems"];
                                    } else if ($monat == 10) {
                                        $arrayTemp = array(20, 19, 18, 17);
                                        $zufallszahl = rand(0, 3);
                                        $sql2 = 'UPDATE temperaturs SET Temperatur_Celsius=' . $arrayTemp[$zufallszahl] . ',Luftfeuchtigkeit_Prozent=20.59 where id>=' . $_REQUEST["anzahlItems"];
                                    } else if ($monat == 11) {
                                        $arrayTemp = array(13, 16, 17, 18);
                                        $zufallszahl = rand(0, 3);
                                        $sql2 = 'UPDATE temperaturs SET Temperatur_Celsius=' . $arrayTemp[$zufallszahl] . ',Luftfeuchtigkeit_Prozent=20.59 where id>=' . $_REQUEST["anzahlItems"];
                                    } else if ($monat == 12) {
                                        $arrayTemp = array(23, 22, 22, 21, 20);
                                        $zufallszahl = rand(0, 3);
                                        $sql2 = 'UPDATE temperaturs SET Temperatur_Celsius=' . $arrayTemp[$zufallszahl] . ',Luftfeuchtigkeit_Prozent=20.59 where id>=' . $_REQUEST["anzahlItems"];
                                    }
                                    $query3 = $DatabaseObject->Abfragen($connection, $sql2);
                                }
                                ?>
                                <script>
                                    var alertWidth = 250;
                                    var alertHeight = 200;
                                    var xAlertStart = 650;
                                    var yAlertStart = 200;
                                    var id = "<?php echo $_REQUEST["anzahlItems"] ?>";
                                    var alertTitle = "<p class='pTitle'><b>! Info !</b></p>";
                                    var alertText = "<p class='pAlert'>Alle Record ab der ID:" + id + " wurden verändert";
                                    showAlert(alertWidth, alertHeight, xAlertStart, yAlertStart, alertTitle, alertText);
                                </script>
                                <?php
                            }
                        } catch (Exception $e) {
                            print_r('Fehler:' . $e->getMessage() . ', Felercode:' . $e->getCode() . ', in Zeile:' . $e->getLine() . ' ,in Datei:' . $e->getFile());
                            die();
                        }
                        /* } else {
                          print_r('<br>!!Error!!<br>Datenbankfehler. Abbruch!');
                          foreach ($connection->errorInfo() as $item) {
                          print_r('<br>' . $item);
                          }
                          die();
                          } */
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
                return implode('', $out);
            }
            ?>