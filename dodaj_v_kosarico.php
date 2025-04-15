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

    // Spodnja poizvedba preveri, če izdelek, ki ga dodajamo v košarico že obstaja v košarici.
    $stmt = $db->prepare("SELECT ime FROM kosarica WHERE ime = ? LIMIT 1");
    //To stori tako, da onemogoči SQL injekcijo
    $stmt->bind_param("s", $ime);
    $stmt->execute();
    $rezultat = $stmt->get_result(); 
    $user = $rezultat->fetch_assoc(); // Rezultat poizvedbe shrani v $user, ki ima obliko asociativenega arraya (tabele)

    // Če v spremenljivki $user ni nič, to pomeni, da izdelek še ne obstaja v košarici in ga lahko dodamo.
    if($user == null){
        $stmt1 = $db->prepare("SELECT * FROM $tabela WHERE id = ? LIMIT 1");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $rezultat1 = $stmt1->get_result();
        $user1 = $rezultat1->fetch_assoc(); // V $user1 se shranijo vsi podatki za iskan izdelek iz tabele v kateri je shranjen in iz katere uporabnik dodaja izdelek v košarico
        $slika = $user1["slika1"]; // V $slika se shrani 1.slika izdelka, ki ga uporabnik dodaja v košarico
        $cena = $user1["cena"]; // V $cena se shrani cena izdelka, ki ga uporabnik dodaja v košarico
        $num = (int)$user1["tip"]; // V $num se shrani tip izdelka, ki ga uporabnik dodaja v košarico
        $stmt2 = $db->prepare("INSERT INTO kosarica (ime, slika, cena, kolicina, tabela) VALUES (?, ?, ?, ?, ?)"); // Stavek s katerim bomo v košarico vstavili nov izdelek
        $stmt2->bind_param("sbiis", $ime, $null, $cena, $kolicina, $tabela);
        $stmt2->send_long_data(1, $slika);
        $stmt2->execute(); // Stavek se izvede

        // Zmanjšaj količino izdelka v njegovi prvotni tabeli
        $stmt4 = $db->prepare("UPDATE $tabela SET zaloga = zaloga - ? WHERE id = ?");
        $stmt4->bind_param("ii", $kolicina, $id);
        $stmt4->execute();

        $_SESSION['toast_message'] = "Izdelek '$ime' je bil dodan v košarico."; // V spremenljivko v seji se shrani sporočilo, ki uporabniku pove da je izdelek dodal v košarico. Popup se uporabniku prikaže, ko je preusmerjen
        header("Location: prikaz.php?id=$id&num=$num"); // Uporabnik je preusmerjen na stran iz katere prihaja
        exit; // Konča kodo 

    }
    else{ // Če izdelek že obstaja v košarici, se njegova količina samo poveča
        $stmt1 = $db->prepare("SELECT * FROM $tabela WHERE id = ? LIMIT 1"); // Pridobi vse podatke o izdelku iz $tabele, ki ga uporabnik dodaja v košarico
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $rezultat1 = $stmt1->get_result(); // Izvede poizvedbo in shrani rezultat v $rezultat1
        $user1 = $rezultat1->fetch_assoc(); 
        $num = (int)$user1["tip"]; // V $num se shrani tip izdelka, ki ga uporabnik dodaja v košarico
        $stmt3 = $db->prepare("UPDATE kosarica SET kolicina = kolicina + ? WHERE ime = ?"); // Stavek, ki poveča količino izdelka v košarici za + $kolicina
        $stmt3->bind_param("is", $kolicina, $ime); 
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
