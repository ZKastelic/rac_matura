<?php
require_once('db.php');
$tableExists = $db->query("SHOW TABLES LIKE 'kosarica'"); // Preveri, če tabela košarica že obstaja

if ($tableExists->num_rows == 0) {
    // Ustvari tabelo kosarica, če zgornja poizvedba ne vrne nič vrstic
    $sql = "create table kosarica(
            id INT auto_increment primary key,
            ime VARCHAR(200),
            slika VARCHAR(50),
            cena INT,
            zaloga INT,
            kolicina INT
    );";

    if ($db->query($sql)) {
        echo "Tabela kosarica je bila uspesno ustvarjena.<br>"; //Pove da je bila tabela uspešno ustvarjena
    } else {
        echo "Napaka pri ustvarjanju tabele: " . $db->error . "<br>"; //Pove da je prišlo do napake pri ustvarjanju tabele
    }
}
    // Ustvari piškotek, ki traja 1 dan
    $cookie_name = "kosarica"; //ime piškotka
    $cookie_value = "kosarica"; //vrednost piškotka
    setcookie($cookie_name, $cookie_value, time() + (86400), "/"); //Ustvari piškotek, tranjanje piškotka, 86400 = 1 dan
    ?>
