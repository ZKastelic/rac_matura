<?php
require_once 'db.php';
require_once 'funkcije.php';
session_start(); // Začne sejo

$id = $_GET['id'] ?? null; //Dobimo ID izdelka, ki ga odstranjujemo iz URL-ja
$tip_komponente = $_GET['type'] ?? null; // Dobimo tip komponente, ki jo odstranjujemo iz URL-ja

if (!$id) { // Preverimo, če je ID podan
    die("Napaka: ID ni podan."); // Če ni, prikažemo napako
}

// Dobimo podatke o elementu, ki ga odstranjujemo
$sql = "SELECT * FROM pcbuild WHERE id = ?"; // Pripravimo SQL poizvedbo
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $id); // Pripnemo ID poizvedbi
$stmt->execute();
$rezultat = $stmt->get_result();
$user = $rezultat->fetch_assoc();
$stmt->close();

if (!$user) {
    die("Napaka: PC build z ID $id ne obstaja."); // Preverimo, če je izdelek obstaja
}

//Ugotovimo, kater atribut bomo odstranili, glede na tip komponente
$odstranitev = null;
if ($tip_komponente) {
    // Glede na tip komponente določimo id, ki ga bomo odstranili
    switch ($tip_komponente) {
        case 'CPU': $odstranitev = 'id_CPU'; break;
        case 'GPU': $odstranitev = 'id_GPU'; break;
        case 'MOBO': $odstranitev = 'id_mobo'; break;
        case 'RAM': $odstranitev = 'id_ram'; break;
        case 'STORAGE': $odstranitev = 'id_storage'; break;
    }
} else {
    // Če tip komponente ni podan, preverimo vse atribute
    foreach (['id_CPU', 'id_GPU', 'id_mobo', 'id_ram', 'id_storage'] as $polje) {
        if ($user[$polje] > 0) {
            $odstranitev = $polje;
            break;
        }
    }
}

if (!$odstranitev) {
    die("Napaka: Ne morem ugotoviti, katero komponento odstraniti."); // Če ne najdemo nobenega atributa, prikažemo napako
}

// Posodobimo vrednost atributa, ki ga odstranjujemo na 0
$sql = "UPDATE pcbuild SET $odstranitev = 0 WHERE id = ?"; // Pripravimo SQL poizvedbo
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $id); // Pripnemo ID poizvedbi

if (!$stmt->execute()) { // Izvedemo poizvedbo
    die("Napaka pri posodabljanju: " . $stmt->error); // Če pride do napake, prikažemo napako
}

$stmt->close(); // Zapremo poizvedbo
header("Cache-Control: no-cache, must-revalidate"); // Preprečimo predpomnjenje
header("Location: pcbuilder.php?id=5"); // Preusmerimo uporabnika na glavno stran pcbuilderja
exit(); // Izhod iz skripte
