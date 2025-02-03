<?php
    require_once('db.php');

    $sql="create table izdelki (
        id INT auto_increment primary key,
        tip_izdelka VARCHAR(50),
    );";

    if($db->query($sql))
        echo("Tabela zidelki je bila uspesno ustvarjena.<br>");
    else
        echo("Napaka pri ustvarjanju tabele.<br>");

    $sql="create table rso_ram (
        id INT auto_increment primary key,
        ime VARCHAR(200),
        slika1 VARCHAR(50),
        slika2 VARCHAR(50),
        slika3 VARCHAR(50),
        kapaciteta VARCHAR(20),
        hitrost VARCHAR(20),
        generacija VARCHAR(20),
        cena INT,
        zaloga INT,
        opis VARCHAR (5000)
    );";

    if($db->query($sql))
        echo("Tabela rso_ram je bila uspesno ustvarjena.<br>");
    else
        echo("Napaka pri ustvarjanju tabele.<br>");



        $sql="create table rso_gpu (
            id INT auto_increment primary key,
            ime VARCHAR(200),
            slika1 VARCHAR(50),
            slika2 VARCHAR(50),
            slika3 VARCHAR(50),
            chipset VARCHAR(40),
            vram VARCHAR(20),
            hitrost VARCHAR(20),
            cena INT,
            zaloga INT,
            opis VARCHAR (5000)
        );";

    if($db->query($sql))
        echo("Tabela rso_gpu je bila uspesno ustvarjena.<br>");
    else
        echo("Napaka pri ustvarjanju tabele.<br>");



        $sql="create table rso_mobo (
            id INT auto_increment primary key,
            ime VARCHAR(200),
            slika1 VARCHAR(50),
            slika2 VARCHAR(50),
            slika3 VARCHAR(50),
            socket VARCHAR(20),
            velikost VARCHAR(20),
            chipset VARCHAR(20),
            cena INT,
            zaloga INT,
            opis VARCHAR (5000)
        );";

    if($db->query($sql))
        echo("Tabela rso_mobo je bila uspesno ustvarjena.<br>");
    else
        echo("Napaka pri ustvarjanju tabele.<br>");

    
    
        $sql="create table rso_cpu (
            id INT auto_increment primary key,
            ime VARCHAR(200),
            slika1 VARCHAR(50),
            slika2 VARCHAR(50),
            slika3 VARCHAR(50),
            jedra INT,
            hitrost VARCHAR(20),
            arhitektura VARCHAR(20),
            cena INT,
            zaloga INT,
            opis VARCHAR (5000)
        );";

    if($db->query($sql))
        echo("Tabela rso_cpu je bila uspesno ustvarjena.<br>");
    else
        echo("Napaka pri ustvarjanju tabele.<br>");



        $sql="create table rso_rac (
            id INT auto_increment primary key,
            ime VARCHAR(200),
            slika1 VARCHAR(50),
            slika2 VARCHAR(50),
            slika3 VARCHAR(50),
            cpu VARCHAR (30),
            mobo VARCHAR(30),
            gpu VARCHAR(30),
            ram VARCHAR(30),
            shramba VARCHAR(30),
            cena INT,
            zaloga INT,
            opis VARCHAR (5000)
        );";

    if($db->query($sql))
        echo("Tabela rso_rac je bila uspesno ustvarjena.<br>");
    else
        echo("Napaka pri ustvarjanju tabele.<br>");



    

?>