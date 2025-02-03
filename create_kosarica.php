<?php
require_once('db.php');

    $sql="create table kosarica(
        id INT auto_increment primary key,
        ime VARCHAR(200),
        slika VARCHAR(50),
        cena INT,
        zaloga INT,
        kolicina INT
        
    );";

    if($db->query($sql))
        echo("Tabela kosarica je bila uspesno ustvarjena.<br>");
    else
        echo("Napaka pri ustvarjanju tabele.<br>");

?>