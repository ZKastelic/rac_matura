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
    <title>Shopotron</title>
</head>
<body class="d-flex flex-column min-vh-100">
    
<?php echo Navbar(); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header text-dark siv py-3">
                    <h2 class="mb-0 text-center">Izdelki, ki so na voljo</h2> <!-- Naslov strani -->
                </div>
                <div class="card-body">
                    <?php
                    $num=$_GET['num']; //Dobi spremeljivko num preko URL- in jo shrani v $num
                    $sql = "SELECT ime FROM rso_vrsta WHERE id=$num limit 1"; // Pridobi ime tabele iz katere bo kasneje prikazoval izdelke iz tabele rso_vrsta
                    $rezultat=($db->query($sql)); 
                    $user=$rezultat->fetch_assoc();
                    $tabela="rso_".$user['ime']; //V spremenljivko $tabela shrani ime tabele iz katere bo prikazoval izdelke

                    $sql = "SELECT COUNT(*) FROM $tabela"; // Prešteje število izdelkov v tabeli
                    $rezultat=($db->query($sql));
                    $user=$rezultat->fetch_assoc()["COUNT(*)"];
                    for ($i = 1; $i < $user + 1; $i++) { // Za vsak izdelek v tabeli izvede spodnjo kodo
                        $sql1 = "SELECT * FROM $tabela WHERE id = $i LIMIT 1"; // Iz tabele $tabela pridobi izdelek kjer je id enak $i
                        $rezultat1 = ($db->query($sql1));
                        $user1 = $rezultat1 ? $rezultat1->fetch_assoc() : null; // Preveri, če je rezultat veljaven

                        if ($user1) { // Preveri, če je $user1 veljaven, preden dostopa do njegovih podatkov
                            echo "<a href='prikaz.php?id=$i&num=$num' class='text-decoration-none text-body'> 
                            <div class='row box my-3 py-3 border border-dark rounded'>
                            <div class='col-sm-4'>
                            <img style='width:30%' src='data:image/jpg;base64," . base64_encode($user1['slika1']) . "'/> <!-- Prikaz slike izdelka -->
                            </div>
                            <div class='col-sm-8'>
                              <div>" . htmlspecialchars($user1['ime']) . "</div> <!-- Prikaz imena izdelka -->
                              <div class='text-muted'>Cena: " . number_format((float)$user1['cena'], 2) . " €</div> <!-- Prikaz cene izdelka -->
                              <div class='text-muted'>Količina: " . htmlspecialchars($user1['zaloga']) . "</div> <!-- Prikaz zaloge izdelka -->
                            </div>
                            </div>
                            </a>";
                        } else {
                            echo "<div class='alert alert-warning'>Izdelek z ID-jem $i ni na voljo.</div>"; // Prikaže opozorilo, če izdelek ne obstaja
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo footer(); ?>
</body>
</html>