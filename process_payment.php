<?php
session_start();
require_once('db.php');
require_once('funkcije.php');
require_once('vendor/autoload.php');

// Api Stripe skriti ključ
\Stripe\Stripe::setApiKey('sk_test_51R84ZUQRvn51IJXjoNQNiyaUkb93yPGGljp69VuiIsXvrKywhi3LhGC0rMq1NVFft7mNunPIpr22L3z73GUXJeoO00wSUappVD');

// Če pride do napake, jo zapiši v datoteko debug.log
file_put_contents('debug.log', print_r($_POST, true), FILE_APPEND);

// Pridobi podatke iz obrazca poslanega iz checkout.php
$znesek = $_POST['znesek'];
$id_placilne_metode = $_POST['id_placilne_metode'];
$ime = $_POST['ime'];
$email = $_POST['email'];
$naslov = $_POST['naslov'];
$mesto = $_POST['mesto'];
$postna_st = $_POST['postna_st'];

try {
    // Ustvari Stripe kupca
    $customer = \Stripe\Customer::create([
        'name' => $ime, // Ime kupca
        'email' => $email, // Email kupca
        'payment_method' => $id_placilne_metode, // ID plačilne metode
        'address' => [ // Naslov kupca
            'line1' => $naslov, // Naslov
            'city' => $mesto, // Mesto
            'postal_code' => $postna_st, // Poštna številka
            'country' => 'SI', // Država je Slovenija
        ],
    ]);

    // Ustvari plačilni namen
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $znesek, // Znesek v centih
        'currency' => 'eur', // Valuta
        'customer' => $customer->id, // ID kupca
        'payment_method' => $id_placilne_metode, // ID plačilne metode
        'confirmation_method' => 'manual', // Potrditev plačila
        'confirm' => true, // Potrdi plačilo
        'description' => 'Nakup iz trgovine', // Opis plačila
        'return_url' => 'https://shopotron.store/payment_success.php', // URL za preusmeritev po uspešnem plačilu
    ]);

    if ($paymentIntent->status == 'succeeded') { // Preveri, če je plačilo uspešno
        // Shrani naročilo v bazo
        $id_narocila = shraniNarocilo($db, $ime, $email, $naslov, $mesto, $postna_st);
        $_SESSION['email_narocila'] = $email;
        
        // Počisti košarico
        $db->query("TRUNCATE TABLE kosarica");
        
        // Preusmeritev na payment_success.php stran
        $_SESSION['id_narocila'] = $id_narocila;
        $_SESSION['success_message'] = "Plačilo uspešno! Vaše naročilo je bilo oddano.";
        header("Location: payment_success.php");
        exit;
    } else {
        // Plačilo ni bilo uspešno, preveri stanje
        header("Location: " . $paymentIntent->next_action->redirect_to_url->url);
        exit;
    }
} catch (\Stripe\Exception\CardException $e) { // Preveri, če je prišlo do napake pri kartici
    file_put_contents('debug.log', "CardException: " . $e->getMessage() . PHP_EOL, FILE_APPEND);
    // Card was declined
    $_SESSION['error_message'] = "Plačilo neuspešno: " . $e->getError()->message;
    header("Location: checkout.php");
    exit;
} catch (Exception $e) { // Preveri, če je prišlo do splošne napake
    file_put_contents('debug.log', "Exception: " . $e->getMessage() . PHP_EOL, FILE_APPEND);
    // Other error
    $_SESSION['error_message'] = "Plačilo neuspešno: prišlo je do napake.";
    header("Location: checkout.php");
    exit;
}
