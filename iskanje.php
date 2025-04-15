<?php
session_start();
require_once('funkcije.php');
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
    <title>Iskanje</title>
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    
<?php echo Navbar(); ?>

<div class="container my-5">
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-8">
            <div class="card shadow-sm">
                <div class="card-header text-center svetlo-siv">
                    <h4 class="mb-0">Rezultati Iskanja</h4> <!-- Naslov strani -->
                </div>
                <div class="card-body p-4"> <!-- Ustvari kartico -->
                    <?php
                    $a = 0;
                    $poizvedba = $_GET['search']; // Iskalni niz, ki ga uporabnik vnese v iskalno polje, dobi preko $_GET
                    $tabele = ['rso_gpu', 'rso_cpu', 'rso_ram', 'rso_mobo', 'rso_rac']; // Tabele v katerih iščemo

                    foreach ($tabele as $tabela) {
                        izpišiRezultate($db, $tabela, $poizvedba, $a); // Za vsako tabelo pokliči funkcijo, ki izpiše rezultate
                    }

                    if ($a == 0) {
                        echo "Vaša poizvedba ne ustraza nobenemu izdelku"; // Če ni rezultatov, izpiši sporočilo
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
        </div>
    </div>
</div>

<?php echo footer(); ?>
</body>
</html>