<?php
require_once('db.php');

    $sql="create table kosarica(
        id INT auto_increment primary key,
<<<<<<< HEAD
        ime VARCHAR(200),
        slika VARCHAR(50),
        cena INT,
        zaloga INT,
        kolicina INT
=======
>>>>>>> 5a6f74d2a55295b45e95714847eea4434beb1bb0
        
    );";

    if($db->query($sql))
        echo("Tabela kosarica je bila uspesno ustvarjena.<br>");
    else
        echo("Napaka pri ustvarjanju tabele.<br>");

?>