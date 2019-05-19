<script type="text/javascript">
    function Link2Update(PrimaryKey, Link)
    {
        alert('Der Datensatz mit dem Primärschlüssel ' + PrimaryKey + ' wird zum Updaten detailliert angezeigt');
        window.location.href = "update.php?url=" + PrimaryKey + "&link=" + Link;
    }
</script>
<?php
if (!empty($_REQUEST["search0"])) {
    include_once 'inc/verbinden.php';
    $treffer = $dbh->query($sql); // obejektorientierte Abfrage definieren
    $treffer1 = $dbh->query($sql1);
    foreach ($treffer1 as $daten) {
        print "<br><b><font size='5'><font color='#FA5858'>Es wurden " . $daten['anzahl'] . " Datensätze gefunden</b></font size></font><br><br>";
    }
//print "<br><b><font size='5'><font color='#ff00ff'>Es wurden ".$treffer->rowCount()." Datensätze gefunden</b></font size></font><br><br>";
    if ($treffer) { //sofern Datensätze vorhanden
        /* eruiere den */
        $findMe = DIRECTORY_SEPARATOR;
        //finde letztes Vorkommen. $ScriptName stammt von der aufrufenden Datei
        $pos = strrpos($ScriptName, $findMe);
        //schneide String ab. Da der DIRECTORY_SEPERATOR ebenfalls verschwinden soll, wird $pos um eins erhöht
        $RenderBack = substr($ScriptName, $pos + 1);
        foreach ($treffer as $daten) {   //Datensätze in Tabellenform auslesen
            if (!isset($daten['bew_id'])) {
                print_r('++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++<br>');
                print_r('Programmierfehler. Das Übergabe-Query ruft den Primärschlüssel nicht auf.<br>Script angehalten!<br>');
                print_r('++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++');
                die();
            } else
                $id = $daten['bew_id'];
            ?>
            <table class="doFixed"><tr>
                <thead>
                    <tr>
                        <td  bgcolor=#F2F5A9>Datum</td>
                        <td  bgcolor=#A9BCF5>Firma</td>
                        <td  bgcolor=#A9F5BC>Rechtform</td>
                        <td  bgcolor=#F5A9F2>Stadt</td>
                        <td  bgcolor=#A9F5BC>Plz</td>
                        <td  bgcolor=#FA58D0>Strasse</td>
                        <td  bgcolor=#BE81F7>Ansprechperson</td>
                        <td  bgcolor=yellow>E-Mail</td>
                        <td  bgcolor=#FAAC58>Feedback</td>
                        <td  bgcolor=#01DF01>Bemerkung</td>
                    </tr>
                </thead>
                <?=
                "<td  bgcolor=#F2F5A9>" . $daten['datum'] . "</td><td  bgcolor=#A9BCF5>" . $daten['firma'] . "</td><td  bgcolor=#A9F5BC>" . $daten['art'] . "</td>
                    <td  bgcolor=#F5A9F2>" . $daten['stadt'] . "</td><td bgcolor=#A9F5BC>" . $daten['plz'] . "</td><td  bgcolor=#FA58D0>" . $daten['strasse_nr'] . "</td>
                    <td  bgcolor=#BE81F7>" . $daten['ansprech_person'] . "</td><td  bgcolor=yellow>" . $daten['email'] . "</td>
                    <td  bgcolor=#FAAC58>" . $daten['feedback'] . "</td><td bgcolor=#01DF01>" . $daten['bemerkung'] . '</td>' .
                "<td><input type='button' name='button' value='Updaten' onclick=\"Link2Update('$id','$RenderBack')\">" . '</td></tr></table>';
            }
        } else
            echo "<p>Keine Datensätze vorhanden</p>"; //sofern keine Datensätze vorhanden
    }
    ?>