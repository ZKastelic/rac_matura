<?php
session_start(); // Začne se nova seja
require_once('db.php'); // Ustvari povezavo z bazo
require_once('funkcije.php'); // Ustvari povezavo z datoteko, ki vsebuje funkcije

// Izračuna skupno ceno naročila, ki je v košarici
$sql = "SELECT SUM(cena * kolicina) AS skupna_cena FROM kosarica";
$rezultat = $db->query($sql);
$skupno = $rezultat->fetch_assoc()['skupna_cena'];

// Znesek zaokroži na 2 decimalni mesti
$znesek = round($skupno * 100);

// Poizvedba s katero pridobimo vse podatke o izdelkih v košarici
$sql = "SELECT * FROM kosarica";
$rezultat = $db->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">  <!-- Določi kodiranje znakov -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Določi širino in višino strani -->
    <title>Checkout</title> <!-- Določi naslov strani -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Povezava do Bootstrapa, omogoča njegovo uporabo-->
    <link rel="stylesheet" href="style.css"> <!-- Povezava do datoteke z dodatnim grafičnim oblikovanjem, omogoča njegovo uporabo-->
    <script src="https://kit.fontawesome.com/c33e8f16b9.js" crossorigin="anonymous"></script> <!-- Povezava do ikon, omogoča njihovo uporabo-->
    <script src="https://js.stripe.com/v3/"></script> <!-- Povezava do Stripe.js, omogoča njegovo uporabo-->
    <!-- dodatno grafično oblikujemo Stripe elemente, ki jih prikazujemo-->
    <style>
        .StripeElement {  /* Določimo obliko, velikost, padding, rob ter ozadje */
            box-sizing: border-box; 
            height: 40px;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background-color: white;
        }
        .StripeElement--focus { /*Dodatno grafično oblikujemo Stripe element, ki je fokusiran, spremenimo mu barvo roba, dodamo senco in odstranimo obrobo   */
            border-color:rgb(218, 235, 252);
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100"> <!-- Pove, da je stran uporablja način oblikovanja display flex ter da je minimalna višina strani 1 višina zaslona -->
    <?php echo Navbar(); ?> <!-- Kliče funkcijo Navbar, ki ustvari navigacijsko vrstico-->

    <div class="container py-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Blagajna</h2> <!-- pove ime, namen strani-->
                
                <div class="card mb-4"> <!-- Ustvari del strani, v obliki kartice, namenjen izpisu izdelkov, ki jih kupec kupuje-->
                    <div class="card-header siv">
                        <h5>Povzetek naročila</h5> <!-- V glavo kartice napiše njen namen -->
                    </div>
                    <div class="card-body svetlo-siv"> <!-- Ustvari telo kartice, namenjeno prikazu izdelkov, ki jih je kupec izbral -->
                        <table class="table"> <!-- Ustvari tabelo v kateri bodo prikazani izdelki -->
                            <thead> <!-- V glavi tabele izpiše naslove stolpcev, ki jih bo ta vsebovala, to so izdelek, kolicina tega izdelka, cena 1 kosa, in cena vseh kosov izdelka skupaj -->
                                <tr> <!-- Ustvari novo vrstico v tabeli -->
                                    <th>Izdelek</th>
                                    <th>Kolicina</th>
                                    <th>Cena</th>
                                    <th>Skupni znesek</th>
                                </tr>
                            </thead>
                            <tbody> <!-- Ustvari telo tabele, ki vsebuje podatke o izdelkih -->
                                <?php while ($user = $rezultat->fetch_assoc()): ?> <!-- V spremenljivko $user shrani rezultate poizvedbe v vrstici 16. To naredi v obliki tabele. -->
                                    <tr> <!-- Za vsak izdelek v tabeli kosarica ustvari novo vrstico, v katero izpiše podatke. Izpisovati neha, ko zmanjka rezultatov (vrstic, v tabeli kosarica) -->
                                        <td><?php echo $user['ime']; ?></td>  <!-- Izpiše ime izdelka ki ga prikazuje -->
                                        <td><?php echo $user['kolicina']; ?></td> <!-- Izpiše količino specifičnega izdelka v košarici -->
                                        <td><?php echo $user['cena']; ?> €</td> <!-- Izpiše ceno 1 kosa tega izdelka --> 
                                        <td><?php echo $user['cena'] * $user['kolicina']; ?> €</td> <!-- Izpiše ceno vseh vseh n-kosov izdelka skupaj (izdelek*količina) -->
                                    </tr>
                                <?php endwhile; ?> <!-- Konča zanko -->
                            </tbody>
                            <tfoot> <!-- Ustvari "nogo" tabele -->
                                <tr> <!-- Ustvari novo vrstico v kateri izpiše skupno ceno -->
                                    <th colspan="3">Skupno</th> 
                                    <th><?php echo $skupno; ?> €</th> <!-- Izpiše skupno ceno vseh izdelkov v košarici, izračunano v 9.vrstici -->
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="card"> <!-- Ustvari nov razdelek v obliki kartice, namenjen vnosu podatkov o bančni kartici-->
                    <div class="card-header siv"> <!-- Ustvari glavo tabele -->
                        <h5>Podatki za plačilo</h5> <!-- Naslovi tabelo -->
                    </div>
                    <div class="card-body svetlo-siv"> <!-- Ustvari telo tabele -->
                        <form id="payment-form" action="process_payment.php" method="POST"> <!-- Ustvari formo, s katero bomo z metodo post posredovali podatke v datoteko process_payment.php -->
                            <div class="mb-3">
                                <label for="card-element">Kartica:</label> <!-- Ustvari oznako za polje vpisa kartice -->
                                <div id="card-element" class="form-control"></div>
                                <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                            </div>
                            
                            <button id="submit-button" class="btn siv">Plačaj <?php echo $skupno; ?> €</button> <!-- Ustvari gumb, ki potrdi pošiljanje podatkov -->
                            <input type="hidden" name="znesek" value="<?php echo $znesek; ?>"> <!-- Ustvari skrito polje, ki vsebuje skupni znesek -->
                            <input type="hidden" name="ime" id="hidden-ime"> <!-- Ustvari skrito polje, ki vsebuje ime kupca. V to, in vsa najdaljna skrita polja, se bodo vpisali podatki iz tabele, ki se začne v vrstici 113 -->
                            <input type="hidden" name="naslov" id="hidden-naslov"> <!-- Ustvari skrito polje, ki vsebuje naslov kupca -->
                            <input type="hidden" name="mesto" id="hidden-mesto"> <!-- Ustvari skrito polje, ki vsebuje mesto, kjer kupec živi -->
                            <input type="hidden" name="postna_st" id="hidden-postna_st"> <!-- Ustvari skrito polje, ki vsebuje poštno številko kupca -->
                            <input type="hidden" name="email" id="hidden-email"> <!-- Ustvari skrito polje, ki vsebuje email kupca -->
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card"> <!-- Ustvari novo polje v obliki kartice -->
                    <div class="card-header siv">
                        <h5>Osebni podatki</h5> <!-- Naslov kartice -->
                    </div>
                    <div class="card-body svetlo-siv"> <!-- Ustvari telo kartice -->
                        <div class="mb-3"> <!-- Vsak vpis ima svoj prostor ustvarjen z div elementom -->
                            <label for="ime" class="form-label">Ime in priimek</label> <!-- _Ustvari oznako za vpis imena in priimka -->
                            <input type="text" class="form-control" id="ime" required> <!-- Ustvari polje za vpis imena in priimka, ki je obvezna, tako kot vsa nadaljna polja -->
                        </div>
                        <div class="mb-3">
                            <label for="naslov" class="form-label">Naslov</label> <!-- Ustvari oznako in polje za vpis naslova -->
                            <input type="text" class="form-control" id="naslov" required>
                        </div>
                        <div class="mb-3">
                            <label for="mesto" class="form-label">Mesto</label> <!-- Ustvari oznako in polje za vpis mesta -->
                            <input type="text" class="form-control" id="mesto" required>
                        </div>
                        <div class="mb-3">
                            <label for="postna_st" class="form-label">Poštna številka</label> <!-- Ustvari oznako in polje za vpis poštne številke -->
                            <input type="text" class="form-control" id="postna_st" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label> <!-- Ustvari oznako in polje za vpis emaila -->
                            <input type="email" class="form-control" id="email" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo footer(); ?> <!-- Pokliče funkcijo footer, ki ustvari nogo strani -->

    <script>
        // Inicializira se Stripe
        var stripe = Stripe('pk_test_51R84ZUQRvn51IJXjkWoDv8NIhQfUJTngl0AyI0sBM92AAcCRDbGcMFkMCiFj8TU5lx4gB5FkXai82Llkbe8m3SsI00wZo3UPR0'); // Javni ključ podan s strani Stripa
        var elements = stripe.elements(); // Ustvari elemente za Stripe

        // Ustvari element card za vnos podatkov o kartici
        var card = elements.create('card');
        card.mount('#card-element'); //Pripne kartico na DOM (document object model) element z ID-jem card-element

        //Spodnja koda je namenjena prikazu napak med vnosom podatkov o kartici
        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors'); // Ustvari spremenljivko, ki vsebuje element z ID-jem card-errors
            if (event.error) { // Če pride do napake, je event.error true
                displayError.textContent = event.error.message;  // Prikaz napake
            } else {
                displayError.textContent = ''; // Če ni napake, je sporočilo pranzno
            }
        });

        // Obravnava oddajo obrazca
        var form = document.getElementById('payment-form'); // Ustvari spremenljivko, ki vsebuje formo z ID-jem payment-form
        form.addEventListener('submit', function(event) { // Ko kupec potrdi oddajo se ustvari objekt event, ki vsebuje vse informacije o oddaji
            event.preventDefault(); // Prepreči privzeto obnašanje obrazca (osvežitev strani)

            // Obstrani gumb uporabljen za potrditev, da prepreči večkratno oddajo
            document.getElementById('submit-button').disabled = true;

            // Vpiše podatke iz obrazcev v skrita polja, da jih lahko pošljemo naprej
            document.getElementById('hidden-ime').value = document.getElementById('ime').value;
            document.getElementById('hidden-naslov').value = document.getElementById('naslov').value;
            document.getElementById('hidden-mesto').value = document.getElementById('mesto').value;
            document.getElementById('hidden-postna_st').value = document.getElementById('postna_st').value;
            document.getElementById('hidden-email').value = document.getElementById('email').value;

            // Ustvari plačilno metodo (kartico) in jo pošlje Stripe-u
            stripe.createPaymentMethod({
                type: 'card', // Tip metode je kartica
                card: card, // Ustvari kartico
                billing_details: {
                    name: document.getElementById('ime').value, // Vpiše ime kupca
                    email: document.getElementById('email').value // Vpiše email kupca
                }
            }).then(function(result) { // Potem ko je ustvarjena plačilna metoda se izvede funkcija
                if (result.error) {
                    // Če pride do napake, izpiše sporočilo o napaki
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                    document.getElementById('submit-button').disabled = false;
                } else {
                    // V spremenljivko hiddenInput se shranijo podatki o plačilnemu sredstvu, ki ga je ustvaril Stripe
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'id_placilne_metode'); 
                    hiddenInput.setAttribute('value', result.paymentMethod.id);
                    form.appendChild(hiddenInput); // Dodamo hiddenInput v formo, ki smo jo ustvarili prej
                    
                    form.submit(); // Pošlje formo z vsemi podatki naprej
                }
            });
        });
    </script>
</body>
</html>