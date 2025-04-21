<?php
session_start();
require_once('db.php');
require_once('funkcije.php');

if(!isset($_COOKIE['kosarica'])){  // Preveri, če obstaja piškotek kosarica, ki pove, da je košarica že ustvarjena
    require_once('create_kosarica.php'); //Če tega piškotka ni, se tabela ustvari
}
    // Iz datoteke prikaz.php dobimo id komponente iz kosarice, podatek o tabeli iz katere izhaja, o imenu izdelka in količini izdelkov, ki jih hoče kupiti uporabnik
    $id = $_POST['id'];
    $tabela = $_POST['tabela'];
    $ime = $_POST['ime'];
    $kolicina = $_POST['kolicina'];

    $sql = "SELECT * FROM rso_prijava WHERE username = ?"; // Fixed SQL syntax
    $stmt = $db->prepare($sql); // Prepare SQL query
    $stmt->bind_param("s", $_SESSION['username']); // Bind username parameter
    $stmt->execute(); // Execute SQL query
    $u = $stmt->get_result(); // Get query result
    $user = $u->fetch_assoc(); // Fetch user data

    $id_kupca = $user['id']; // Predpostavimo, da je ID uporabnika shranjen v seji

    // Spodnja poizvedba preveri, če izdelek, ki ga dodajamo v košarico že obstaja v košarici za istega kupca.
    $stmt = $db->prepare("SELECT ime FROM kosarica WHERE ime = ? AND id_kupca = ? LIMIT 1");
    $stmt->bind_param("si", $ime, $id_kupca);
    $stmt->execute();
    $rezultat = $stmt->get_result(); 
    $user = $rezultat->fetch_assoc(); // Rezultat poizvedbe shrani v $user, ki ima obliko asociativenega arraya (tabele)

    // Če v spremenljivki $user ni nič, to pomeni, da izdelek še ne obstaja v košarici in ga lahko dodamo.
    if($user == null ){
        $query = "SELECT * FROM $tabela WHERE id = ? LIMIT 1";
        $stmt1 = $db->prepare($query);
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $rezultat1 = $stmt1->get_result();
        $user1 = $rezultat1->fetch_assoc(); // V $user1 se shranijo vsi podatki za iskan izdelek iz tabele v kateri je shranjen in iz katere uporabnik dodaja izdelek v košarico
        $slika = $user1["slika1"]; // V $slika se shrani 1.slika izdelka, ki ga uporabnik dodaja v košarico
        $cena = $user1["cena"]; // V $cena se shrani cena izdelka, ki ga uporabnik dodaja v košarico
        $num = (int)$user1["tip"]; // V $num se shrani tip izdelka, ki ga uporabnik dodaja v košarico
        $stmt2 = $db->prepare("INSERT INTO kosarica (ime, slika, cena, kolicina, tabela, id_kupca) VALUES (?, ?, ?, ?, ?, ?)"); // Fixed query to match column count
        $stmt2->bind_param("sbdiss", $ime, $null, $cena, $kolicina, $tabela, $id_kupca);
        $stmt2->send_long_data(1, $slika);
        $stmt2->execute(); // Izvede poizvedbo

        // Zmanjšaj količino izdelka v njegovi prvotni tabeli
        $stmt4 = $db->prepare("UPDATE $tabela SET zaloga = zaloga - ? WHERE id = ?");
        $stmt4->bind_param("ii", $kolicina, $id);
        $stmt4->execute();

        $_SESSION['toast_message'] = "Izdelek '$ime' je bil dodan v košarico."; // V spremenljivko v seji se shrani sporočilo, ki uporabniku pove da je izdelek dodal v košarico. Popup se uporabniku prikaže, ko je preusmerjen
        header("Location: prikaz.php?id=$id&num=$num"); // Uporabnik je preusmerjen na stran iz katere prihaja
        exit; // Konča kodo 

    }
    else{ // Če izdelek že obstaja v košarici za istega kupca, se njegova količina samo poveča
        $stmt1 = $db->prepare("SELECT * FROM $tabela WHERE id = ? LIMIT 1");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $rezultat1 = $stmt1->get_result(); // Izvede poizvedbo in shrani rezultat v $rezultat1
        $user1 = $rezultat1->fetch_assoc(); 
        $num = (int)$user1["tip"]; // V $num se shrani tip izdelka, ki ga uporabnik dodaja v košarico
        $stmt3 = $db->prepare("UPDATE kosarica SET kolicina = kolicina + ? WHERE ime = ? AND id_kupca = ?"); // Stavek, ki poveča količino izdelka v košarici za + $kolicina
        $stmt3->bind_param("isi", $kolicina, $ime, $id_kupca); 
        $stmt3->execute(); // Izvede poizvedbo

        // Zmanjšaj količino izdelka v njegovi prvotni tabeli
        $stmt4 = $db->prepare("UPDATE $tabela SET zaloga = zaloga - ? WHERE id = ?");
        $stmt4->bind_param("ii", $kolicina, $id);
        $stmt4->execute();

        $_SESSION['toast_message'] = "Količina izdelka '$ime' v košarici je bila posodobljena."; // V spremenljivko v seji se shrani sporočilo, ki uporabniku pove da je izdelek dodal v košarico. Popup se uporabniku prikaže, ko je preusmerjen.
        header("Location: prikaz.php?id=$id&num=$num"); // Uporabnik je preusmerjen na stran iz katere prihaja
        exit; // Konča kodo
    }    
?>
