<?php

$gfx_file = "img/tacho.png"; /* Zählerbild definieren */
$digits = 4; /* legt die Anzahl der Anzeigestellen fest */
$filename = "./count.txt";  /* txt.-Datei definieren --Schreibrechte müssen vorliegen!! */
list($counter) = file($filename); /* liefert ein Feld mit allen Zeilen der Datei */
$counter++;
$fh = fopen($filename, "w");    /* Zähler wird in die Datei zurück geschrieben */
if ($fh) {
    fwrite($fh, $counter);
    fclose($fh);
}
list($gfx_width, $gfx_height, $gfx_type) = getimagesize($gfx_file); /* Zählerbild laden und Ausgabe konvertieren */
$digit_width = round($gfx_width / 10);

switch ($gfx_type) /* Erzeugen des Zählerbildes, je nach Typ */ {
    case 1 :
        $gfx = imagecreatefromgif($gfx_file);
        break;
    case 2 :
        $gfx = imagecreatefromjpeg($gfx_file);
        break;
    case 3 :
        $gfx = imagecreatefrompng($gfx_file);
        break;
}
$counter_width = $digits * $digit_width; /* Ausgabe formatieren */
$im = imagecreate($counter_width, $gfx_height); /* Ausgabe erzeugen */
if ($im && $gfx) { /* prüfen,ob Bild geladen und erzeugt */
    $counter = str_pad($counter, $digits, "0", STR_PAD_LEFT); /* links mit Nullen füllen und jedes Zeichen einzeln darstellen */
    for ($i = 0; $i <= $digits; $i++) { /* Eckpunkte berechnen */
        $x = $counter_width - (($digit_width * $i));
        $y = 0;                                               /* Eckpunkt Höhe ist immer 0 */
        $src_x = (substr($counter, 0 - $i, 1)) * $digit_width;    /* Eckpunkt Breite als Vielfaches der Breite an sich. Teil des strings rauskopieren */
        $src_y = 0;
        imagecopy($im, $gfx, $x, $y, $src_x, $src_y, $digit_width, $gfx_height);
    }
    header("Content-type:image/png");
    imagepng($im);   /* umrechnen und an den Browser senden */
    imagedestroy($im);
    imagedestroy($gfx);
}
?>