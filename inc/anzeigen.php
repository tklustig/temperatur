<?php

function anzeigen($objArrayOfRecords) {
    if (!emtpy($objArrayOfRecords)) {
        foreach ($objArrayOfRecords as $daten) {   //Datensätze in Tabellenform auslesen    
            ?>
            <table class="doFixed"><tr>
                <thead>
                    <tr>
                        <td  bgcolor=#F2F5A9>ID</td>
                        <td  bgcolor=#A9BCF5>Datum</td>
                        <td  bgcolor=#A9F5BC>Uhzeit</td>
                        <td  bgcolor=#F5A9F2>Temperatur(in Celsius)</td>
                        <td  bgcolor=#A9F5BC>Luftfeuchtigkeit(%)</td>
                        <td  bgcolor=#FA58D0>angelegt am</td>
                    </tr>
                </thead>
                <?=

                "<td  bgcolor=#F2F5A9>" . $daten['id'] . "</td><td  bgcolor=#A9BCF5>" . $daten['datum'] . "</td><td  bgcolor=#A9F5BC>" . $daten['uhrzeit'] . "</td>
            <td  bgcolor=#F5A9F2>" . $daten['Temperatur_Celsius'] . "</td><td bgcolor=#A9F5BC>" . $daten['Luftfeuchtigkeit_Prozent'] . "</td><td  bgcolor=#FA58D0>" . $daten['created_at'] . "</td></tr></table>";
            }
        } else
            echo "<p>Keine Datensätze vorhanden</p>"; //sofern keine Datensätze vorhanden
    }
    ?>

