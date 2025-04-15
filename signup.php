<?php
session_start();
require_once('funkcije.php');

if (!empty($_POST)) { // Preveri, če so podatki poslani
    $_SESSION['ime'] = $_POST['ime']; // Shranimo ime v sejo
    $_SESSION['username'] = $_POST['username']; // Shranimo uporabniško ime v sejo
    $_SESSION['geslo'] = $_POST['geslo']; // Shranimo geslo v sejo
    $_SESSION['email'] = $_POST['email']; // Shranimo email v sejo
    $_SESSION['spol'] = $_POST['spol']; // Shranimo spol v sejo
    $koda = ustvariKodo(); // Ustvarimo kodo, uporabljeno za potrditev registracije
    $_SESSION['koda'] = $koda; // Shranimo kodo v sejo
    header("Location: confirm.php"); // Preusmerimo uporabnika na potrditev registracije
    exit; // Preprečimo nadaljnje izvajanje skripte
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
    <style>
        .card {
            border: 1px solid #ced4da;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            font-weight: bold;
        }
    </style>
    <title>Sign up</title>
</head>
<body class="d-flex flex-column min-vh-100">
    
<?php echo Navbar(); ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header siv">
                    Registracija <!-- Naslov strani -->
                </div>
                <div class="card-body svetlo-siv">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="ime" class="form-label">Ime</label> <!-- Oznaka in polje za vnos imena -->
                            <input type="text" class="form-control" name="ime" id="ime" placeholder="Vnesite ime" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Uporabniško ime</label> <!-- Oznaka in polje za vnos uporabniškega imena, ki si ga je izbral uporabnik -->
                            <input type="text" class="form-control" name="username" id="username" placeholder="Vnesite uporabniško ime" required>
                        </div>
                        <div class="mb-3">
                            <label for="geslo" class="form-label">Geslo</label> <!-- Oznaka in polje za vnos gesla, ki si ga je uporabnik izbral -->
                            <input type="password" class="form-control" name="geslo" id="geslo" placeholder="Vnesite geslo" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label> <!-- Oznaka in polje za vnos emaila uporabnika -->
                            <input type="email" class="form-control" name="email" id="email" placeholder="Vnesite email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Spol</label> <!-- Oznaka za izbiro spola -->
                            <div>
                                <input class="form-check-input" type="radio" name="spol" id="m" value="m" required> <!-- Izbira med moškim in ženskim spolom -->
                                <label class="form-check-label" for="m">Moški</label>
                            </div>
                            <div>
                                <input class="form-check-input" type="radio" name="spol" id="f" value="f" required>
                                <label class="form-check-label" for="f">Ženski</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Registriraj se</button> <!-- Gumb za pošiljanje obrazca (za registracijo) -->
                    </form>
                    <hr>
                    <p class="text-center">Že imate račun? <a href="login.php">Prijavite se</a></p> <!-- Povezava do prijave, če uporabnik že ima račun -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo footer(); ?>

</body>
</html>