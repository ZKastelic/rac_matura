<?php
session_start();
require_once('funkcije.php');

if (isset($_SESSION['toast_success'])) {
    echo '<div class="toast align-items-center text-bg-success border-0 show position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">' . htmlspecialchars($_SESSION['toast_success']) . '</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
          </div>';
    unset($_SESSION['toast_success']);
}
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
    <title>Shopotron - Home</title>
</head>
<body class="d-flex flex-column min-vh-100">

<?php echo Navbar(); ?>


<div class="container-fluid text-white text-center py-5" style="background: url('slike/banner.jpg') no-repeat center center; background-size: cover;">
    <h1 class="display-4">Dobrodošli v Shopotron</h1> <!-- Pozdrav uporabnika na spletno stran -->
    <p class="lead">Trgovino za vse vaše računalniške potrebe</p> <!-- Kratek opis trgovine -->
    <a href="search.php?num=5" class="btn btn-success">Začnite z nakupovanjem</a> <!-- Gumb za začetek nakupovanja, povezava do strani, kjer lahko uporabnik izbera računalnike -->
</div>

<div class="container my-5">
    <background image="slike/bannner.jpg" class="img-fluid rounded mb-4" alt="Banner">
    <h2 class="text-center mb-4">Naši najbolj prodajani izdelki</h2> <!-- Naslov sekcije -->
    
    <div class="row justify-content-center">
        <?php
        $ze_obstaja_num = []; // Tabela v kateri bodo shranjena števila, ki so bila že izbrana (3 različne kategorije, s 3 različnimi izdelki)
        $ze_obstaja_id = []; // Tabela v kateri bodo shranjeni id-ji, ki so bili že izbrani
        for ($i = 0; $i < 3; $i++) { // Zanka, ki se ponovi 3-krat, da izbere 3 različne kategorije
            do { // Generira naključno število med 1 in 6, dokler ne najde takega, ki še ni bilo izbrano
                $num = rand(1, 6); // Naključno število med 1 in 6
            } while (in_array($num, $ze_obstaja_num)); // Ensure the number is unique
            $ze_obstaja_num[] = $num; // Doda število v tabelo, če je unikatno

            $id = 1;
            
            
            switch ($num) {
                case 1: $tabela = "rso_cpu"; break; // Izbere rso_cpu tabelo, če je število 1
                case 2: $tabela = "rso_gpu"; break; // Izbere rso_gpu tabelo, če je število 2
                case 3: $tabela = "rso_mobo"; break; // Izbere rso_mobo tabelo, če je število 3
                case 4: $tabela = "rso_ram"; break; // Izbere rso_ram tabelo, če je število 4
                case 5: $tabela = "rso_rac"; break; // Izbere rso_rac tabelo, če je število 5
                case 6: $tabela = "rso_storage"; break; // Izbere rso_storage tabelo, če je število 6
            }
            $sql = "SELECT * FROM $tabela WHERE id = ?"; // SQL poizvedba, ki izbere vse podatke iz tabele, kjer je id enak naključno generiranemu id-ju
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i", $id); // V poizvedbo pripne id
            $stmt->execute(); // Izvrši poizvedbo
            $rezultat = $stmt->get_result();
            $user = $rezultat->fetch_assoc(); // Podatke shrani v spremenljivko $user
            echo '
            <div class="col-md-4 mb-4"> <!-- Ustvari nov stolpec za izdelek -->
                <a href="prikaz.php?id=' . $id . '&num=' . $num . '" class="text-decoration-none text-dark"> <!-- Povezava do strani z izdelkom -->
                    <div class="card h-100" style="max-height: 350px;"> <!-- Kartica izdelka, ki ga prikazujemo -->
                        <img alt="Product Image" class="img-fluid d-block mx-auto" style="max-height: 150px; object-fit: contain;" src="data:image/jpg;base64,' . base64_encode($user['slika1']) . '"/> <!-- Prikaz slike izdelka -->
                        <div class="card-body text-center">
                            <h5 class="card-title text-truncate">' . htmlspecialchars($user['ime']) . '</h5> <!-- Prikaz imena izdelka -->
                            <p class="card-text">$' . htmlspecialchars($user['cena']) . '</p> <!-- Prikaz cene izdelka -->
                        </div>
                    </div>
                </a>
            </div>';
        }
        ?>
    </div>
</div>

<div class="container my-5">
    <div class="row align-items-center"> <!-- Ustvari nov vrstico, ki bo vsebovala sliko in besedilo -->
        <div class="col-md-12 text-center"> 
            <h2>O Shopotronu</h2> <!-- Naslov sekcije -->
            <p>Shopotron je sodobna spletna računalniška trgovina, ki združuje strast do tehnologije z vrhunsko uporabniško izkušnjo. Ponaša se z bogato ponudbo najnovejše računalniške opreme, komponent in dodatkov priznanih blagovnih znamk. Ne glede na to, ali sestavljate zmogljiv gaming računalnik,
                nadgrajujete svoj delovni sistem ali iščete zanesljivo opremo za vsakodnevno uporabo – Shopotron je pravi naslov za vas. Kar Shopotron resnično loči od drugih, je predanost kakovosti, ugodnim cenam in hitri dostavi. Poleg tega je uporabniška podpora vedno na voljo za prijazno pomoč in strokovno svetovanje.
                Nakupovanje je hitro, enostavno in varno – popolno za sodobne uporabnike, ki cenijo čas in učinkovitost. Shopotron ni le trgovina – je skupnost tehnoloških navdušencev, ki verjamejo v moč dobrega hardvera. Pridružite se tisočem zadovoljnih strank in odkrijte, zakaj je Shopotron ena najbolj zaupanja vrednih spletnih destinacij za računalniške navdušence.</p>
        </div>  <!-- Kratek opis trgovine -->
    </div>
</div>

<?php echo footer(); ?>

</body>
</html>