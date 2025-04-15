<?php
session_start();
require_once('funkcije.php');
require_once('db.php');

use PHPMailer\PHPMailer\PHPMailer; // Uvoz PHPMailer razreda
require "vendor/autoload.php"; // Uvoz PHPMailer knjižnice

if (!isset($_SESSION['koda'])) {
    $_SESSION['toast_error'] = "Koda za potrditev ni na voljo.";
    header("Location: signup.php");
    exit();
}

$koda = $_SESSION['koda']; // Koda, ki je bila ustvarjena v signup.php se presese v $koda

// Pošiljanje emaila
$mail = new PHPMailer(true); // Ustvarimo nov PHPMailer objekt
$mail->CharSet = PHPMailer::CHARSET_UTF8; // Use the constant for setting the charset
$mail->isSMTP(); // Pove, da mail pošiljamo po SMTP (Simple Mail Transfer Protocol)
$mail->Host       = 'smtp.gmail.com'; // Pove naslov SMTP strežnika skozi katerega bomo pošiljali email
$mail->SMTPAuth   = true; // Omogoči SMTP avtentikacijo
$mail->Username   = 'shopotron7@gmail.com'; // Podamo uporabniško ime za SMTP strežnik
$mail->Password   = 'cpfw qnpm nvrk kxsu';  // In geslo zanj
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use the constant for TLS encryption
$mail->Port       = 587; // Pove na katera TCP vrata se naj poveže
$mail->setFrom('shopotron7@gmail.com'); // Nastavimo email naslov pošiljatelja
$mail->addAddress($_SESSION['email']); // Dodamo email naslov prejemnika, ki ga dobimo iz $_SESSION['email']
$mail->isHTML(true); // Potrdimo da je vsebina sporočila oblikovana v HTML
$mail->Subject = 'Sporocilo za potrditev registracije'; // Zadeva emaila
$mail->Body    = 'Pošiljamo vam kodo za potrditev registracije: <b>' . $koda . '</b>.<br>Prosimo, da jo vnesete v obrazec za potrditev na naši spletni strani.';
$mail->send(); // Pošljemo email

if (!empty($_POST)) { // Preverimo, ali je zgornji obrazec poslan
    $vpisanaKoda = $_POST['code']; // Koda, ki jo je uporabnik vnesel v obrazec
    
    if ($vpisanaKoda === $koda) { // Preverimo, če je vpisana koda enaka kot koda, ki smo jo poslali na email
        $ime = $_SESSION['ime'];
        $username = $_SESSION['username'];
        $geslo = $_SESSION['geslo'];
        $email = $_SESSION['email'];
        $spol = $_SESSION['spol'];

        $sql = "INSERT INTO rso_prijava (ime, username, geslo, email, spol) VALUES ('$ime', '$username', '$geslo', '$email', '$spol')";

        if ($db->query($sql)) { // Če je poizvedba uspešna
            $_SESSION['toast_success'] = "Uspešno ste se registrirali!";
            $_SESSION['username'] = $username;
            $_SESSION['geslo'] = $geslo;
            unset($_SESSION['ime'], $_SESSION['username'], $_SESSION['geslo'], $_SESSION['email'], $_SESSION['spol'], $_SESSION['koda']);
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['toast_error'] = "Napaka pri vnosu v bazo.";
            header("Location: confirm.php");
            exit();
        }
    } else {
        $_SESSION['toast_error'] = "Napačna koda. Poskusite znova.";
        header("Location: confirm.php");
        exit();
    }
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
        .card { /* Dodatno oblikuje kartice (inline css) */
            border: 1px solid #ced4da;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header { /* Dodatno oblikuje glavo kartice (inline css) */
            font-weight: bold;
        }
    </style>
    <title>Sign up</title> <!-- Naslov -->
</head>
<body class="d-flex flex-column min-vh-100">
    
<?php echo Navbar(); ?> <!-- Navigacijska vrstica -->

<div class="container py-5"> <!-- Glavni vsebinski del -->
    <div class="row justify-content-center"> <!-- Poravnava vsebine na sredino -->
        <div class="col-md-6">
            <div class="card"> <!-- Kartica za vnos kode, ki jo je uporabnik prejel na email -->
                <div class="card-header siv"> <!-- Glava kartice -->
                    Vpišite kodo, ki ste jo prejeli na email
                </div>
                <div class="card-body svetlo-siv"> <!-- Telo kartice -->
                    <form action="" method="post"> <!-- Obrazec za vnos kode -->
                        <div class="mb-3"> 
                            <label for="code" class="form-label">Koda</label> <!-- Oznaka in polje za vnos kode -->
                            <input type="text" class="form-control" name="code" id="code" placeholder="Vnesite kodo" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Potrdite</button> <!-- Gumb za potrditev -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo footer(); ?>
</body>
</html>