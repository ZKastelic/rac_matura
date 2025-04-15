<?php
session_start();
require_once('funkcije.php');
$error = $_SESSION['error'] ?? null; // Preveri, če obstaja sporočilo o napaki
unset($_SESSION['error']); // Odstrani sporočilo o napaki iz seje
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
    <title>Log in</title>
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
</head>
<body class="d-flex flex-column min-vh-100">
    
<?php echo Navbar(); ?>

<?php if ($error): ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo $error; ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <script>
        const toastElList = [].slice.call(document.querySelectorAll(".toast"));
        const toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl);
        });
        toastList.forEach(toast => toast.show());
    </script>
<?php endif; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header siv"> <!-- Naslov strani -->
                    Prijava 
                </div>
                <div class="card-body svetlo-siv">
                    <form action="prijava.php" method="post"> <!-- Obrazec za prijavo -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Uporabniško ime</label> <!-- Oznaka in prostor za vpis uporabniškega imena, ki je obvezno -->
                            <input type="text" class="form-control" name="username" id="username" placeholder="Vnesite uporabniško ime" required>
                        </div>
                        <div class="mb-3">
                            <label for="geslo" class="form-label">Geslo</label> <!-- Oznaka in prostor za vpis gesla, ki je obvezno -->
                            <input type="password" class="form-control" name="geslo" id="geslo" placeholder="Vnesite geslo" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Prijava</button> <!-- Gumb za potrditev prijave -->
                    </form>
                    <hr>
                    <p class="text-center">Še nimate računa? <a href="signup.php">Registrirajte se</a></p> <!-- Povezava do strani za registracijo, če uporabnik še ni registriran -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo Footer(); ?>

</body>
</html>