<?php
require_once('db.php'); // Zagotovi povezavo do podatkovne baze

    // Ustvarjanje tabele rso_ram, namenjena shranjevanju ram-ov, vsebuje id, ime izdelka, 3 slike, kapaciteto, hitrost, generacijo in ceno rama ter opis izdelka ter tip, ki pove katera tabela je
    // tip je uporabljen, da se enolično določi katera tabela je uporabljena pri kasnejših operacijah, iskanjih
    $sql="CREATE TABLE rso_ram ( 
        id INT auto_increment primary key,
        ime VARCHAR(200),
        slika1 MEDIUMBLOB,
        slika2 MEDIUMBLOB,
        slika3 MEDIUMBLOB,
        kapaciteta VARCHAR(20),
        hitrost VARCHAR(20),
        generacija VARCHAR(20),
        cena INT,
        zaloga INT,
        opis VARCHAR (5000),
        tip INT DEFAULT '4' REFERENCES rso_vrsta(id)
    );";
    //tukaj in v vseh spodnjih interacijah spodnja koda pove, če je bila tabela uspešno ustvarjena ali ne ter na podlagi tega izpiše sporočilo
    if($db->query($sql))
        echo("Tabela rso_ram je bila uspesno ustvarjena.<br>");
    else
        echo("Napaka pri ustvarjanju tabele.<br>");


        // Ustvarjanje tabele rso_gpu, namenjena shranjevanju grafičnih kartic, vsebuje id, ime, 3 slike izdelka, chipset, kolicino vrama, hitrost gpu-ja, ceno, zalogo, opis izdelka in tip
        $sql="CREATE TABLE rso_gpu (
            id INT auto_increment primary key,
            ime VARCHAR(200),
            slika1 MEDIUMBLOB,
            slika2 MEDIUMBLOB,
            slika3 MEDIUMBLOB,
            chipset VARCHAR(40),
            vram VARCHAR(20),
            hitrost VARCHAR(20),
            cena INT,
            zaloga INT,
            opis VARCHAR (5000),
            tip INT DEFAULT '2' REFERENCES rso_vrsta(id)
        );";

    if($db->query($sql))
        echo("Tabela rso_gpu je bila uspesno ustvarjena.<br>");
    else
        echo("Napaka pri ustvarjanju tabele.<br>");


        // Ustvarjanje tabele rso_mobo, namenjene shranjevanju matičnih plošč, vsebuje id, ime, 3 slike izdelka, izbran socket, velikost, chipset matične plošče, ceno, zalogo in opis izdelka ter tip
        $sql="CREATE TABLE rso_mobo (
            id INT auto_increment primary key,
            ime VARCHAR(200),
            slika1 MEDIUMBLOB,
            slika2 MEDIUMBLOB,
            slika3 MEDIUMBLOB,
            socket VARCHAR(20),
            velikost VARCHAR(20),
            chipset VARCHAR(20),
            cena INT,
            zaloga INT,
            opis VARCHAR (5000),
            tip INT DEFAULT '3' REFERENCES rso_vrsta(id)
        );";

    if($db->query($sql))
        echo("Tabela rso_mobo je bila uspesno ustvarjena.<br>");
    else
        echo("Napaka pri ustvarjanju tabele.<br>");

    
        // Ustvarjanje tabele rso_cpu, namenjena shranjevanju procesorjev, vsebuje id, ime, 3 slike izdelka, število jeder cpu-ja, hitrost , arhitekturo, ceno, zalogo in opis procesorja ter tip
        $sql="CREATE TABLE rso_cpu (
            id INT auto_increment primary key,
            ime VARCHAR(200),
            slika1 MEDIUMBLOB,
            slika2 MEDIUMBLOB,
            slika3 MEDIUMBLOB,
            jedra INT,
            hitrost VARCHAR(20),
            arhitektura VARCHAR(20),
            cena INT,
            zaloga INT,
            opis VARCHAR (5000),
            tip INT DEFAULT '1' REFERENCES rso_vrsta(id)
        );";

    if($db->query($sql))
        echo("Tabela rso_cpu je bila uspesno ustvarjena.<br>");
    else
        echo("Napaka pri ustvarjanju tabele.<br>");

        // Ustvarjanje tabele rso_storage, namenjena shranjevanju shrambe, vsebuje id, ime, 3 slike izdelka, kapaciteto, tip shrambe, ceno, zalogo in opis izdelka ter tip
        $sql="CREATE TABLE rso_storage (
            id INT auto_increment primary key,
            ime VARCHAR(200),
            slika1 MEDIUMBLOB,
            slika2 MEDIUMBLOB,
            slika3 MEDIUMBLOB,
            kapaciteta INT,
            tip_shrambe VARCHAR(20),
            cena INT,
            zaloga INT,
            opis VARCHAR (5000),
            tip INT DEFAULT '6' REFERENCES rso_vrsta(id)
        );";

    if($db->query($sql))
        echo("Tabela rso_cpu je bila uspesno ustvarjena.<br>");
    else
        echo("Napaka pri ustvarjanju tabele.<br>");

    
        // Ustvarjanje tabele rso_rac, namenjena shranjevanju ze izdelanih računalnikov, vsebuje id, ime, 3 slike izdelka, cpu, mobo, gpu, ram, shrambo, ki je v računalniku ter njegovo ceno, zalogo in opis ter tip
        $sql="CREATE TABLE rso_rac (
            id INT auto_increment primary key,
            ime VARCHAR(200),
            slika1 MEDIUMBLOB,
            slika2 MEDIUMBLOB,
            slika3 MEDIUMBLOB,
            cpu VARCHAR (30),
            mobo VARCHAR(30),
            gpu VARCHAR(30),
            ram VARCHAR(30),
            shramba VARCHAR(30),
            cena INT,
            zaloga INT,
            opis VARCHAR (5000),
            tip INT DEFAULT '5' REFERENCES rso_vrsta(id)
        );";

    if($db->query($sql))
        echo("Tabela rso_rac je bila uspesno ustvarjena.<br>");
    else
        echo("Napaka pri ustvarjanju tabele.<br>");

        $sql="CREATE TABLE rso_vrsta (
            id INT auto_increment primary key,
            ime VARCHAR(50)
        );";

    if($db->query($sql))
        echo("Tabela rso_vrsta je bila uspesno ustvarjena.<br>");
    else
        echo("Napaka pri ustvarjanju tabele.<br>");

        // Ustvarjanje tabele rso_prijava, namenjena shranjevanju uporabnikov po prijavi, vsebuje id, ime, uporabniško ime uporabnika, njegovo geslo, email in spol
        $sql="CREATE TABLE rso_prijava (
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

        // Ustvarjanje tabele narocila, namenjena shranjevanju naročil pred pošiljanjem, vsebuje id, ime, email, naslov, mesto, poštno številko kupca, skupni znesek naročila, datum in status naročila
        $sql="CREATE TABLE narocila (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ime VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            naslov VARCHAR(255) NOT NULL,
            mesto VARCHAR(100) NOT NULL,
            postna_st VARCHAR(20) NOT NULL,
            skupni_znesek DECIMAL(10,2) NOT NULL,
            datum_narocila DATETIME NOT NULL,
            status VARCHAR(50) DEFAULT 'pending'
        );";
        
        if($db->query($sql))
            echo("Tabela narocila je bila uspesno ustvarjena.<br>");
        else
            echo("Napaka pri ustvarjanju tabele.<br>");
        
            // Ustvarjanje tabele izdelki, namenjena shranjevanju izdelkov, ki so v naročilu, vsebuje id izdelka, id naročila in ime, kolicino ter ceno izdelka
            $sql="CREATE TABLE izdelki (
            id INT AUTO_INCREMENT PRIMARY KEY AUTO_INCREMENT,
            id_narocila INT NOT NULL,
            ime_izdelka VARCHAR(200) NOT NULL,
            kolicina INT NOT NULL,
            cena DECIMAL(10,2) NOT NULL,
            FOREIGN KEY (id_narocila) REFERENCES narocila(id) 
            );";
            
            if($db->query($sql))
                echo("Tabela narocila je bila uspesno ustvarjena.<br>");
            else
                echo("Napaka pri ustvarjanju tabele.<br>");
                // Ustvarjanje tabele pcbuild, namenjena shranjevanju izdelkov, ki jih uporabnik dodaja v PC builderju, vsebuje id izdelka, id cpu-ja, gpu-ja, matične plošče, rama in shrambe, ki jih je uporabnik izbral
                $sql="CREATE TABLE pcbuild(
                        id INT PRIMARY KEY AUTO_INCREMENT,
                        id_CPU INT DEFAULT 0,
                        id_GPU INT DEFAULT 0,
                        id_mobo INT DEFAULT 0,
                        id_ram INT DEFAULT 0,
                        id_storage INT DEFAULT 0,
                        id_kupca INT
                        FOREIGN KEY (id_kupca) REFERENCES rso_prijava(id) 
                        );";
                    
            if($db->query($sql))
                echo("Tabela narocila je bila uspesno ustvarjena.<br>");
            else
                echo("Napaka pri ustvarjanju tabele.<br>");
?>