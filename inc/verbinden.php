<?php

function databaseConnect($user, $pw, $databasetyp, $hostname, $databasename) {
    try {
        $dbh = new PDO("$databasetyp:host=$hostname;dbname=$databasename;charset=utf8", $user, $pw, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); // DB-Aufbau objektorientiert
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br>";
        ?>
        <p><font size='5' font color='red'>ERROR! Logindaten inkorrekt !!</font></p>
        <p><font size='4'>Mitunter sind die Zugangsparameter im Code inkorrekt. Bitte informieren Sie mich über die Messagebox!</font></p>
        <?php

        die();
    }
    return $dbh;
}
?>