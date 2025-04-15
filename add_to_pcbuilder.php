<?php
require_once 'db.php';
require_once 'funkcije.php';
session_start();

// Iz stani pcbuilder.php dobi podatek o tem, kater tip komponente dodajamo, ter kater id v tabeli (rso_...) ima ta komponenta
$id_strani=$_GET['id_strani']; 
$id=$_GET['id'];

// Pove v kateri atribut tabele pcbuild dodajamo id komponente
switch ($id_strani) {
    case 1: $ime = 'id_CPU'; break; // dodajamo CPU
    case 2: $ime = 'id_GPU'; break; // dodajamo GPU
    case 3: $ime = 'id_mobo'; break; // dodajamo matično ploščo
    case 4: $ime = 'id_ram'; break; // dodajamo RAM
    case 6: $ime = 'id_storage'; break; // dodajamo shrambo
}

// Preveri, če že obstaja kakšen zapis v tabeli pcbuild
$sql = "SELECT id FROM pcbuild ORDER BY id DESC LIMIT 1";
$rezultat = $db->query($sql);

if ($rezultat->num_rows > 0) {
    //Posodobi že obstoječ zapis, to naredi z pripravljanjem sql stavka, da se izognemo SQL injekciji
    $pc = $rezultat->fetch_assoc();
    $pc_id = $pc['id'];
    $sql = "UPDATE pcbuild SET $ime = ? WHERE id = ?"; // sql stavek za posodabljanje tabele pcbuild
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $id, $pc_id);
} else {
    // Ustvari nov zapis, to naredi z pripravljanjem sql stavka, da se izognemo SQL injekciji
    $sql = "INSERT INTO pcbuild ($ime) VALUES (?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
}

// Izvede SQL stavek, ki je izbran zgoraj
$stmt->execute();
$stmt->close();

// Preusmeritev na glavno stran PC builderja, nato konča kodo
header("Location: pcbuilder.php?id=5");
exit;
?>