<?php
session_start();
require_once('funkcije.php');
require_once('db.php');
require_once('vendor/autoload.php');

// Preveri, če je bilo naročilo uspešno oddano
if (!isset($_SESSION['id_narocila'])) {
    header("Location: index.php");
    exit;
}

$id_narocila = $_SESSION['id_narocila']; // ID naročila
$success_message = $_SESSION['success_message'] ?? "Hvala vam za vaše naročilo!"; // Sporočilo o uspehu
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uspešno plačilo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/c33e8f16b9.js" crossorigin="anonymous"></script>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php echo Navbar();
    
    use PHPMailer\PHPMailer\PHPMailer; // Uporabi PHPMailer
    require "vendor/autoload.php";
    $mail = new PHPMailer(true); // Ustvari nov PHPMailer objekt
    
    $mail->CharSet = 'UTF-8';                      // Omogočimo UTF-8 znake
    $mail->isSMTP();                                            // Povemo, da bomo uporabljali SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Povemo, da bomo uporabljali Gmail SMTP strežnik
    $mail->SMTPAuth   = true;                                   // Omogočimo SMTP avtentikacijo
    $mail->Username   = 'shopotron7@gmail.com';                     // Uporabniško ime (email)
    $mail->Password   = 'cpfw qnpm nvrk kxsu';                               // Geslo za Gmail SMTP strežnik
    $mail->SMTPSecure = 'tls';         // Omogočimo TLS varnostno povezavo
    $mail->Port       = 587;                                    // TCP vrata za Gmail SMTP strežnik
    // Pošiljatelj in prejemnik
    $mail->setFrom('shopotron7@gmail.com');
    $mail->addAddress($_SESSION['email_narocila']); 
    // Vsebina
    $mail->isHTML(true);                                  // Določimo, da bomo pošiljali vsebino v HTML formatu
    $mail->Subject = 'Sporočilo za potrditev nakupa'; // Zadeva emaila
    $mail->Body    = 'Pošiljamo vam potrdilo nakupa št.: <b>'.$_SESSION['id_narocila'].'</b>.<br> Hvala da ste izbrali našo trgovino!'; // Vsebina emaila
    $mail->send(); // Pošlji email
    
    
    ?>

    <div class="container py-5 text-center">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-header siv">
                <h2 class="mb-0">Uspešno plačilo</h2> <!-- Naslov strani in glava kartice -->
            </div>
            <div class="card-body svetlo-siv">
                <h1 class="card-title text-success mb-4">
                    <i class="fa-solid fa-circle-check"></i> Plačilo uspešno <!-- Prikaz da je bilo plačilo uspešno -->
                </h1>
                <h4 class="card-subtitle mb-4"><?php echo $success_message; ?></h4> <!-- Sporočilo o uspehu -->
                <p class="card-text mb-4">Vaša številka naročila je: <strong>#<?php echo $id_narocila; ?></strong></p> <!-- Prikaz številke naročila, pridobljen preko URL-ja -->
                <p class="card-text">Poslali smo vam mail s potrdilom naročila </p> <!-- Obvestilo o pošiljanju maila -->
                <div class="mt-4">
                    <a href="index.php" class="btn btn-success">Nadaljuj z nakupovanjem</a> <!-- Gumb za nadaljevanje nakupovanja -->
                </div>
            </div>
        </div>
    </div>

    <?php echo footer(); ?>
</body>
</html>
<?php
// Počisti spremenljivke seje
unset($_SESSION['id_narocila']); 
unset($_SESSION['success_message']);
?>