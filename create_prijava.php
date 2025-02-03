<?php
    require_once('db.php');

    $sql="create table rso_prijava (
        id INT auto_increment primary key,
        ime VARCHAR(50),
        username VARCHAR(50),
        geslo VARCHAR(50),
        email VARCHAR(50),
        spol VARCHAR(1)
    );";

    if($db->query($sql))
        echo("Tabela rso_prijava je bila uspesno ustvarjena.");
    else
        echo("Napaka pri ustvarjanju tabele.");
?>