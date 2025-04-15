<?php
session_start();
require_once('funkcije.php');
require_once('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/c33e8f16b9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Shopotron</title>
</head>
<body class="d-flex flex-column min-vh-100">
    
<?php echo Navbar(); ?>

<?php
if (isset($_SESSION['toast_message'])) { //Preveri, če je v $_SESSION shranjena spremenljivka toast_message. Če je, ga prikaže ter nato odstrani spremenljivko
    echo toast($_SESSION['toast_message']);
    unset($_SESSION['toast_message']);
}
?>

<div class="container-xs m-3 py-3">
    <div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-6">
      <div class="row pb-5">
        <div class="col-sm-6">
          
<?php
$id = $_GET['id'] ?? null; //Dobi spremeljivko id preko URL- in jo shrani v $id
$num = $_GET['num'] ?? null; //Dobi spremeljivko num preko URL- in jo shrani v $num

// Potrdi, če obstajata $id in $num ter preveri, če sta števili
if (!$id || !$num || !is_numeric($id) || !is_numeric($num)) { 
    echo "<div class='alert alert-danger'>Napaka: Manjkajoči ali neveljavni parametri.</div>"; //Če nista števili ali sta null izpiše napako
    exit; //konča izvajanje skripte
}

// Pridobi ime tabele iz katere bo kasnje prikazoval izdelke iz tabele rso_vrsta
$sql1 = "SELECT ime FROM rso_vrsta WHERE id = ? LIMIT 1";
$stmt1 = $db->prepare($sql1);
$stmt1->bind_param("i", $num);
$stmt1->execute();
$rezultat1 = $stmt1->get_result();
$user1 = $rezultat1->fetch_assoc();

if ($user1) { //Če je zgornja poizvedba uspešna, potem se izvede spodnja koda
    $tabela = "rso_" . $user1['ime']; //V spremenljivko $tabela shrani ime tabele iz katere bo prikazoval izdelke

    // Iz tabele $tabela pridobi izdelek kjer je id enak $id
    $sql = "SELECT * FROM $tabela WHERE id = ? LIMIT 1";
    $stmt2 = $db->prepare($sql);
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $rezultat = $stmt2->get_result();
    $user = $rezultat->fetch_assoc();

    if ($user) { //Če je bila zgornja poizvedba uspešna ($user ni prazen)
        echo carousel($user['id'], $tabela); //prikaže, kar dobi iz funkcije carousel (v dateteki funkcije.php) ter vanjo vstavi id izdelka, ki ga prikazujemo in ime tabele iz katere priakzujemo izdelke
        echo"              
        </div>
        <div class='col-sm-6'>
          <h3>$user[ime]</h3> <!-- Izpiše ime izdelka ki ga prikazujemo -->
          <hr>
          <table>";
        
        if($num==1){ //Če prikazujemo procesorje se izpišejo št. jeder, hitrost procesorja in mikroarhitektura
        echo"
            <tr>
              <td class='col-sm-3 fw-bold pe-3'>Stevilo jeder</td>
              <td class='col-sm-9'>$user[jedra]</td> 
            </tr>
            <tr>
              <td class='col-sm-3 fw-bold pe-3'>Hitrost procesorja</td>
              <td class='col-sm-9'>$user[hitrost] GHz</td>
            </tr>
            <tr>
              <td class='col-sm-3 fw-bold pe-3'>Mikroarhitektura</td>
              <td class='col-sm-9'>$user[arhitektura]</td>
            </tr>
            ";}

        if($num==2){ //Če prikazujemo grafične kartice se izpišejo chipset, količina VRAM-a in hitrost grafične kartice
            echo"
            <tr>
              <td class='col-sm-3 fw-bold pe-3'>Podnozje</td>
              <td class='col-sm-9'>$user[chipset] </td>
            </tr>
            
            <tr>
              <td class='col-sm-3 fw-bold pe-3'>Kolicina VRAM-a</td>
              <td class='col-sm-9'>$user[vram] GB</td>
            </tr>
            <tr>
              <td class='col-sm-3 fw-bold pe-3'>Hitrost</td>
              <td class='col-sm-9'>$user[hitrost] MHz</td>
            </tr>
                ";}
        
        if($num==3){ //Če prikazujemo matične plošče se izpišejo socket, velikost in podnožje matične plošče
            echo"
                <tr>
                    <td class='col-sm-3 fw-bold pe-3'>Socket maticne plosce</td>
                    <td class='col-sm-9'>$user[socket]</td>
                </tr>
                <tr>
                    <td class='col-sm-3 fw-bold pe-3'>Velikost maticne plosce</td>
                    <td class='col-sm-9'>$user[velikost]</td>
                </tr>
                <tr>
                    <td class='col-sm-3 fw-bold pe-3'>Podnozje maticne plosce</td>
                    <td class='col-sm-9'>$user[chipset]</td>
                </tr>
                ";}

        if($num==4){ //Če prikazujemo RAM se izpišejo kapaciteta, hitrost in generacija RAM-a
            echo"
                <tr>
                    <td class='col-sm-3 fw-bold pe-3'>Kapaciteta RAM-a</td>
                    <td class='col-sm-9'>$user[kapaciteta] GB</td>
                </tr>
                <tr>
                    <td class='col-sm-3 fw-bold pe-3'>Hitrost RAM-a</td>
                    <td class='col-sm-9'>$user[hitrost] GHz</td>
                </tr>
                <tr>
                    <td class='col-sm-3 fw-bold pe-3'>Generacija RAM-a</td>
                    <td class='col-sm-9'>$user[generacija]</td>
                </tr>
                ";}

        if($num==5){ //Če prikazujemo cele računalnike se izpišejo tip CPU-ja, matične plošče, grafične kartice in RAM-a
          echo"
              <tr>
                  <td class='col-sm-3 fw-bold pe-3'>CPU</td>
                  <td class='col-sm-9'>$user[cpu]</td>
              </tr>
              <tr>
                  <td class='col-sm-3 fw-bold pe-3'>Matična plošča</td>
                  <td class='col-sm-9'>$user[mobo]</td>
              </tr>
              <tr>
                  <td class='col-sm-3 fw-bold pe-3'>Grafična kartica</td>
                  <td class='col-sm-9'>$user[gpu]</td>
              </tr>
              <tr>
                  <td class='col-sm-3 fw-bold pe-3'>RAM</td>
                  <td class='col-sm-9'>$user[ram]</td>
              </tr>
              <tr>
                  <td class='col-sm-3 fw-bold pe-3'>Shramba</td>
                  <td class='col-sm-9'>$user[shramba]</td>
              </tr>
              ";}
                
        if($num==6){ //Če prikazujemo shrambe se izpišejo kapaciteta in tip shrambe
            echo"
                <tr>
                    <td class='col-sm-3 fw-bold pe-3'>Kapaciteta</td>
                    <td class='col-sm-9'>$user[kapaciteta] GB</td>
                </tr>
                <tr>
                    <td class='col-sm-3 fw-bold pe-3'>Tip shrambe</td>
                    <td class='col-sm-9'>$user[tip_shrambe]</td>
                </tr>
                ";}

        

        echo"
          </table>
        </div>
      </div>
      <div class='row p-3 pt-5'>
        <div class='col'>$user[opis]</p></div> <!-- Izpiše opis izdelka ki ga prikazujemo -->
      </div>
    </div>
    <div class='col-sm-2 p-5 my-5 border border-dark-subtle rounded-3 svetlo-siv h-100'>
      <p class='fw-bold lead fs-2'>$user[cena] EUR</p> <!-- Izpiše ceno izdelka ki ga prikazujemo -->
      <p>Cena vklucuje DDV</p>";
      if($user['zaloga']>=1){ //Preveri, če je izdelek na voljo, če je prikaže značko "Na voljo" in gumb "Dodaj v košarico"
          echo"<p class='py-2 fs-4'><i class='fa-solid fa-circle-check'></i> Je navoljo</p>
          <form method='post' action='dodaj_v_kosarico.php'>
          <input type='hidden' name='id' value='$id'> <!-- Podatki, ki jih prejme dodaj_v_kosarico.php (id, ime izdelka in njegova kolicina ter tabela iz katere prihaja) -->
          <input type='hidden' name='ime' value='$user[ime]'>
          <input type='hidden' name='tabela' value='$tabela'>
          <select class='form-select mb-3 w-25' name='kolicina'>
          <option value='1'>1</option> <!-- Omogoči izbiro količine izdelka, ki ga dodajamo -->
          <option value='2'>2</option>
          <option value='3'>3</option>
          <option value='4'>4</option>
          <option value='5'>5</option>
        </select>
        <button class='btn siv btn-outline-dark text-dark' type='submit'>Dodaj v kosarico</button>";
      }
      else echo"<p class='py-2 fs-4'><i class='fa-solid fa-circle-xmark'></i> Ni navoljo</p>";
      echo"
      </form>
    </div>
    <div class='col-sm-2'></div>
</div>
</div>
";
    } else {
    echo "<div class='alert alert-danger'>Izdelek ni bil najden.</div>"; //Če izdelek ni bil najden izpiše napako
    }
} else {
    echo "<div class='alert alert-danger'>Tabela ni bila najdena.</div>"; //Če tabela ni bila najdena izpiše napako
}
?>

<?php echo footer();?>
</body>
</html>