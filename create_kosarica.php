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
            kolicina INT,
            id_kupca INT,
            FOREIGN KEY (id_kupca) REFERENCES rso_prijava(id)
    );";

    if ($db->query($sql)) {
        echo "Tabela kosarica je bila uspesno ustvarjena.<br>"; //Pove da je bila tabela uspešno ustvarjena
    } else {
        echo "Napaka pri ustvarjanju tabele: " . $db->error . "<br>"; //Pove da je prišlo do napake pri ustvarjanju tabele
    }
}

// Ensure the shopping cart is associated with the logged-in user
$id_kupca = $_SESSION['user_id']; // Predpostavimo, da je ID uporabnika shranjen v seji
$cookie_name = "kosarica"; //ime piškotka
$cookie_value = "kosarica_$id_kupca"; // Unique value for each user
setcookie($cookie_name, $cookie_value, time() + (86400), "/"); //Ustvari piškotek, tranjanje piškotka, 86400 = 1 dan
?>
