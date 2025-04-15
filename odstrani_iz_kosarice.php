<?php
session_start();
require_once('db.php');
require_once('funkcije.php');

// Zagotovimo, da je preko URL-ja posredovan ID izdelka
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Napaka: Manjkajoči ID.');
}

$id = (int)$_GET['id']; // ID izdelka, ki ga želimo odstraniti shranimo v spremenljivko $id

// Dobimo podatke o izdelku iz košarice
$stmt = $db->prepare("SELECT * FROM kosarica WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$rezultat = $stmt->get_result();
$user = $rezultat->fetch_assoc();
$stmt->close();

// Preverimo, če je izdelek v košarici, če ne pošljemo napako ter prekinemo skripto
if (!$user) {
    die('Napaka: Izdelek ni najden v košarici.');
}

$tabela = $user['tabela']; // Ime tabele, ki jo bomo posodobili
$ime = $user['ime']; // Ime izdelka, ki ga bomo posodobili
$kolicina = (int)$user['kolicina']; // Količina izdelka, ki ga bomo odstranili

// Posodobimo zalogo izdelka v ustrezni tabeli, tako da dodamo izdelke, ki so bili prej v košarici
$stmt1 = $db->prepare("UPDATE $tabela SET zaloga = zaloga + ? WHERE ime = ?");
if (!$stmt1) {
    die('Napaka pri pripravi SQL poizvedbe: ' . $db->error); // Preverimo, če je prišlo do napake pri pripravi poizvedbe
}
$stmt1->bind_param("is", $kolicina, $ime);
$stmt1->execute();
$stmt1->close();

// Odstani izdelek iz košarice
$stmt2 = $db->prepare("DELETE FROM kosarica WHERE id = ? LIMIT 1");
$stmt2->bind_param("i", $id);
$stmt2->execute();
$stmt2->close();

// Preusmeri uporabnika nazaj na stran s košarico ter konča skripto
header("Location: shopping_cart.php");
exit;
?>