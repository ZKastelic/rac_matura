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

$sql = "SELECT * FROM rso_prijava WHERE username = ?"; // Fixed SQL syntax
$stmt = $db->prepare($sql); // Prepare SQL query
$stmt->bind_param("s", $_SESSION['username']); // Bind username parameter
$stmt->execute(); // Execute SQL query
$u = $stmt->get_result(); // Get query result
$user = $u->fetch_assoc(); // Fetch user data

$id_kupca = $user['id']; // Predpostavimo, da je ID uporabnika shranjen v seji

// Preveri, če že obstaja kakšen zapis v tabeli pcbuild za trenutnega uporabnika
$sql = "SELECT id FROM pcbuild WHERE id_kupca = ? ORDER BY id DESC LIMIT 1";
$stmt_check = $db->prepare($sql);
$stmt_check->bind_param("i", $id_kupca);
$stmt_check->execute();
$rezultat = $stmt_check->get_result();

if ($rezultat->num_rows > 0) {
    // Posodobi že obstoječ zapis za trenutnega uporabnika
    $pc = $rezultat->fetch_assoc();
    $pc_id = $pc['id'];
    $sql = "UPDATE pcbuild SET $ime = ? WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $id, $pc_id);
} else {
    // Ustvari nov zapis za trenutnega uporabnika
    $sql = "INSERT INTO pcbuild ($ime, id_kupca) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ii", $id, $id_kupca);
}

// Izvede SQL stavek, ki je izbran zgoraj
$stmt->execute();
$stmt->close();

// Preusmeritev na glavno stran PC builderja, nato konča kodo
header("Location: pcbuilder.php?id=5");
exit;
?>