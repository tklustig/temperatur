<?php

function classAutoloader($class) {
    $path = "inc/$class.php";
    if (file_exists($path)) {
        require $path;
    } else {
        print_r("Klasse exisitert nicht");
        die();
    }
}
?>



