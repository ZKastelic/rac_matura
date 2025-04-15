<?php
require_once('db.php');

function pozdrav() { // Omogoča izpis pozdrava uporabnika, uporabljena v Navbar()
    if (isset($_SESSION["username"])) { // Preveri ali je uporabnik prijavljen, tako, da preveri ali obstaja spremenljivka $_SESSION["username"] (spremenljivke so vanjo shranjene, če se uporabnik prijavi)
        global $db; // Uporabi globalno spremenljivko $db, ki vsebuje povezavo do baze podatkov
        $username = $_SESSION["username"]; // Pridobi uporabniško ime iz seje in ga shrani v spremenljivko $username
        $sql = "SELECT ime FROM rso_prijava WHERE username = '" . $username . "' LIMIT 1"; // Pripravi SQL poizvedbo, ki pridobi ime uporabnika iz tabele rso_prijava, kjer se ujema z uporabniškim imenom
        $rezultat = $db->query($sql);
        $user = $rezultat ? $rezultat->fetch_assoc() : null; // V spremenljivko $user shrani rezultat poizvedbe, če je uspešna, sicer nastavi na null

        if ($user) { // Če je uporabnik najden, izpiše pozdrav
            return "<p class='text-center mt-2'>Pozdravljen " . htmlspecialchars($user["ime"]) . "</p> <!-- Izpiše pozdravljen in ime uporablnika -->
                    <li class='nav-item'>
                        <a class='nav-link text-dark px-2' href='logout.php'><i class='fa-solid fa-right-from-bracket'></i></a>
                    </li>";
        } else { // Če uporabnik ni najden, izpiše napako
            return "<p class='text-center mt-2'>Napaka: Uporabnik ni najden.</p>";
        }
    } else { // Če uporabnik ni prijavljen, izpiše povezavo do prijave/registracije, ki jo uporabnik lahko uporabi za prijavo ali registracijo
        return "<a class='nav-link text-dark' href='login.php'>Login/Signup</a>";
    }
}

function adminVidi() { // Omogoča izpis povezave do dodajanja izdelkov, če je uporabnik administrator
    if (isset($_SESSION["username"]) && isset($_SESSION["geslo"])) { // Preveri ali je uporabnik prijavljen z uporabniškim imenom in geslom
        global $db; // Uporabi globalno spremenljivko $db, ki vsebuje povezavo do baze podatkov
        $username = $_SESSION["username"]; // Pridobi uporabniško ime iz seje in ga shrani v spremenljivko $username
        $geslo = $_SESSION["geslo"]; // Pridobi geslo iz seje in ga shrani v spremenljivko $geslo
        if ($username == "zkas" && $geslo == "pass") { // Preveri ali je uporabnik administrator (uporabniško ime "zkas" in geslo "pass")
            return '
            <li class="nav-item px-2">
                <a class=" btn nav-link text-dar link-underline-opacity-0 temno-siv" href="dodaj.php?id=0">Dodaj izdelke</a> <!-- Če je to res, prikaže gumb, ki omogoča preusmeritev na stran za dodajanje artiklov -->
            </li>
        ';
        }
    }
    return '';
}

function Navbar() { // Omogoča izpis navigacijske vrstice z povezavami in iskalnikom
    return '
        <nav class="navbar navbar-expand-sm temno-siv text-light text-opacity-50 my-0 py-0 fs-6"> <!-- Uporabi bootstrap class navbar, da inicializira navbar, čisto zgornja vrstica na vsaki strani -->
            <div class="col d-flex justify-content-center">Sledite nam na naših družabnih omrežjih</div> 
            <div class="col d-flex justify-content-center">
                <a href="https://x.com/home" class="link-underline link-underline-opacity-0 link-secondary"> <!-- Prikaže povezavo na kateri je X račun podjetja -->
                    <i class="fa-brands fa-x-twitter m-2"></i> <!-- Prikaže ikono X-a -->
                </a>
                <a href="https://www.facebook.com/" class="link-underline link-underline-opacity-0 link-secondary"> <!-- Prikaže povezavo na kateri je Facebook račun podjetja -->
                    <i class="fa-brands fa-facebook m-2"></i> <!-- Prikaže ikono Facebooka -->
                </a>
                <a href="https://www.instagram.com/" class="link-underline link-underline-opacity-0 link-secondary"> <!-- Prikaže povezavo na kateri je Instagram račun podjetja -->
                    <i class="fa-brands fa-instagram m-2"></i> <!-- Prikaže ikono Instagrama -->
                </a>
            </div>
        </nav>

        <nav class="navbar navbar-expand-sm siv"> <!-- Uporabi bootstrap class navbar, da inicializira navbar -->
            <div class="container-fluid">
                <a class="navbar-brand" href="#"></a>
                <img src="slike/logo-seminarska.png" class="img-fluid" alt="Logo" style="width:100px;"> <!-- Prikaže logo Shopotrona -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar"> <!-- Uporabi bootstrap class navbar-toggler, da inicializira gumb za krmiljenje prikaza menija, omogoča prepogibanje/zlaganje menija -->
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar"> <!-- Uporabi bootstrap class collapse navbar-collapse, da inicializira razširljiv meni -->
                    <ul class="navbar-nav flex-row flex-wrap col-3"> 
                        <li class="nav-item"> 
                            <a class="nav-link text-dark" href="index.php">Home</a> <!-- Uporabi bootstrap class nav-item, da prikaže gumb, ki uporabnika pošlje na index.php  -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="search.php?num=5">Računalniki</a> <!-- Uporabi bootstrap class nav-item, da prikaže gumb, ki uporabnika pošlje na search.php z idjem 5, do strani ki prikazuje računalnike  -->
                        </li>
                        <li class="nav-item dropdown"> <!-- Uporabi bootstrap class nav-item dropdown, da omogoči ustvarjanje dropdown menija -->
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Komponente</a> <!-- Uporabi bootstrap class nav-item, da prikaže gumb, ki prikaže možne izbire povezav na različne strani -->
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="search.php?num=1">CPU</a></li> <!-- Uporabi bootstrap class dropdown-item, da prikaže gumb, ki uporabnika pošlje na search.php z idjem 1, do strani ki prikazuje CPUje  -->
                                <li><a class="dropdown-item" href="search.php?num=2">GPU</a></li> <!-- Uporabi bootstrap class dropdown-item, da prikaže gumb, ki uporabnika pošlje na search.php z idjem 2, do strani ki prikazuje GPUje  -->
                                <li><a class="dropdown-item" href="search.php?num=3">Maticne plosce</a></li> <!-- Uporabi bootstrap class dropdown-item, da prikaže gumb, ki uporabnika pošlje na search.php z idjem 3, do strani ki prikazuje matične plošče  -->
                                <li><a class="dropdown-item" href="search.php?num=4">RAM</a></li> <!-- Uporabi bootstrap class dropdown-item, da prikaže gumb, ki uporabnika pošlje na search.php z idjem 4, do strani ki prikazuje RAM  -->
                                <li><a class="dropdown-item" href="search.php?num=6">Shramba</a></li> <!-- Uporabi bootstrap class dropdown-item, da prikaže gumb, ki uporabnika pošlje na search.php z idjem 6, do strani ki prikazuje shrambe  -->
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="pcbuilder.php?id=5">PC Builder</a> <!-- Uporabi bootstrap class nav-item, da prikaže gumb, ki uporabnika pošlje na pcbuilder.php z idjem 5, do glavnega dela strani -->
                        </li>
                    </ul>
                    <div class="col-6">
                        <form class="d-flex" method="get" action="iskanje.php"> <!-- Ustvari formo s katero uporablja iskalnik za iskanje -->
                            <input class="form-control me-1" type="text" placeholder="Iskalnik" name="search"> <!-- Omogoča vnos besedila v polje za iskanje -->
                            <button class="btn temno-siv text-white  me-3 border-none" style="border: none;" type="submit">Search</button>  <!-- Omogoča potrditev iskanja z gumbom -->
                        </form>
                    </div>
                    <ul class="navbar-nav flex-row flex-wrap ms-auto col-3"> <!-- Prikaže polje v katerem se po prijavi prikaže pozdrav uporabnika z uporabo funkcije pozdrav() -->
                        <li class="nav-item me-3">
                            ' . pozdrav() . '
                        </li>
                        <li class="nav-item px-2"> <!-- Uporabi bootstrap class nav-item, da prikaže gumb, ki uporabnika pošlje na shopping_cart.php  -->
                            <a class="nav-link text-dark" href="shopping_cart.php"><i class="fa-solid fa-cart-shopping"></i></a> <!-- Prikaže ikono nakupovalne košarice -->
                        </li>
                        ' . adminVidi() . ' <!-- Uporabi funkcijo adminVidi(), ki prikaže gumb za dodajanje artiklov, če je uporabnik administrator -->
                    </ul>
                    <hr>
                </div>
            </div>
        </nav>
    ';
}


function footer() {
  return'
  <footer class="container-fluid siv border-top border-dark text-center pt-4 pb-0 mb-0 mt-auto"> <!-- Uporabi bootstrap class footer, da začne nogo spletne strani -->
  <div class="row siv">
    <div class="col-sm-3"></div>
    <div class="col-sm-3"><img src="slike/logo-seminarska.png" style="max-height: 70px;"></div> <!-- Prikaže logo podajetja -->
    <div class="col-sm-3 d-flex align-items-center"><p class="text-center"><i class="fa-regular fa-copyright"></i> 2025, Shopotron</p></div> <!-- Prikaže copyright -->
    <div class="col-sm-3"></div>
  </div>
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6"><hr></div>
    <div class="col-sm-3"></div>
  </div>

  <div class="row siv">
    <div class="col-sm-4"><h6>Kontaktni podatki</h6> 
        <ul class="text-center list-group-flush siv">
            <li class="list-group-item siv">Email: shopotron7@gmail.com</li>
            <li class="list-group-item siv">Tel:031 031 031</li>
        </ul>
    </div>
    <div class="col-sm-4 text-center"><h6>Poslovalnica</h6> <!-- Prikaže lokacijo namišljene prodajalne izdelkov -->
      <ul class="text-center list-group-flush siv">
        <li class="list-group-item siv">Šolski center Novo mesto</li>
        <li class="list-group-item siv">8000 Novo mesto</li>
        <li class="list-group-item siv">Slovenija</li>
      </ul>
    </div>
    <div class="col-sm-4"> <!-- Prikaže plačilne metode, ki jih podjetje sprejema -->
      <img src="slike/mastercard.png" class="img-fluid" style="max-height: 70px;">
      <img src="slike/visa.png" class="img-fluid"style="max-height: 70px;">
    </div>
  </div>
</footer>
  ';
}

function carousel($id, $tabela) {
    // Ustvari enkraten id za vsak carousel
    
    return '
        <div id="id" class="carousel slide" data-bs-ride="carousel"> <!-- Uporabi bootstrap class carousel, da inicializira kroženje slik na spletni strani -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#id" data-bs-slide-to="0" class="active"></button> <!-- Prikaže gumb, ki omogoča preklapljanje med slikami -->
                <button type="button" data-bs-target="#id" data-bs-slide-to="1"></button> <!-- Prikaže gumb, ki omogoča preklapljanje med slikami -->
                <button type="button" data-bs-target="#id" data-bs-slide-to="2"></button> <!-- Prikaže gumb, ki omogoča preklapljanje med slikami -->
            </div>
            <div class="carousel-inner svetlo-siv">
                <div class="carousel-item active rounded"> <!-- Uporabi bootstrap class carousel-item, da prikaže sliko v carouselu, to stori z klicem funkcije prikaziSliko() -->
                '.prikaziSliko($id, $tabela, 'slika1').'
                </div>
                <div class="carousel-item"> <!-- Uporabi bootstrap class carousel-item, da prikaže sliko v carouselu, to stori z klicem funkcije prikaziSliko() -->
                    '.prikaziSliko($id, $tabela, 'slika2').'
                </div>
                <div class="carousel-item"> <!-- Uporabi bootstrap class carousel-item, da prikaže sliko v carouselu, to stori z klicem funkcije prikaziSliko() -->
                    '.prikaziSliko($id, $tabela, 'slika2').' 
                </div>
            </div>
            <button class="carousel-control-prev w-60" type="button" data-bs-target="#id" data-bs-slide="prev"> <!-- Prikaže gumb, ki omogoča preklapljanje med slikami -->
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next w-60" type="button" data-bs-target="#id" data-bs-slide="next"> <!-- Prikaže gumb, ki omogoča preklapljanje med slikami -->
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    ';
}

function addCPU(){ // Ustvari funkcijo, ki omogoča dodajanje CPU-jev v bazo
    if(!empty($_POST)){
        require_once('db.php');
        global $db;
      
        $ime = $_POST['ime']; // Pridobi ime iz obrazca na strani dodaj.php
        $jedra = (int)$_POST['jedra'];
        $hitrost = (double)$_POST['hitrost'];
        $arhitektura = $_POST['arhitektura'];
        $cena = (int)$_POST['cena'];
        $zaloga = (int)$_POST['zaloga'];
        $opis = $_POST['opis'];
        
        $dovoljeneKoncnice = ['jpeg', 'jpg', 'png']; // Dovoljeni tipi datotek

        // Preveri ali so bile slike naložene
        if($_FILES['slika1']['size'] > 0 && $_FILES['slika2']['size'] > 0 && $_FILES['slika3']['size'] > 0) {
            // Preverjanje tipa datotek
            foreach (['slika1', 'slika2', 'slika3'] as $slike) {
                $koncnica = strtolower(pathinfo($_FILES[$slike]['name'], PATHINFO_EXTENSION));
                if (!in_array($koncnica, $dovoljeneKoncnice)) {
                    echo "<div class='alert alert-danger'>Datoteka za $slike mora biti tipa .jpeg, .jpg ali .png.</div>";
                    return;
                }
            }

            // Prebere sliko z ustreznim preverjanjem napak
            $slika1 = null;
            $slika2 = null;
            $slika3 = null;
            
            if (is_uploaded_file($_FILES['slika1']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika1 = file_get_contents($_FILES['slika1']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika1
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem prve slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            if (is_uploaded_file($_FILES['slika2']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika2 = file_get_contents($_FILES['slika2']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika2
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem druge slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            if (is_uploaded_file($_FILES['slika3']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika3 = file_get_contents($_FILES['slika3']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika3
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem tretje slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            // Uporabi pripravljeno izjavo za vstavljanje podatkov v rso_cpu tabelo
            $stmt = $db->prepare("INSERT INTO rso_cpu (ime, slika1, slika2, slika3, jedra, hitrost, arhitektura, cena, zaloga, opis) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            // Pripne parametre
            $stmt->bind_param("ssssissiis", $ime, $slika1, $slika2, $slika3, $jedra, $hitrost, $arhitektura, $cena, $zaloga, $opis);
            
            if($stmt->execute()) { // Izvrši poizvedbo
                echo "<div class='alert alert-success'>Vnos uspešen</div>"; // Prikaže sporočilo o uspehu
            } else {
                echo "<div class='alert alert-danger'>Napaka pri vnosu: " . $stmt->error . "</div>"; // Prikaže napako, če vnos ni uspel
            }
            $stmt->close(); // Zapre pripravljeno izjavo
        } else {
            echo "<div class='alert alert-danger'>Manjkajo slike</div>"; // Prikaže napako, če manjkajo slike
        }
    }
}

function addGPU(){ // Ustvari funkcijo, ki omogoča dodajanje GPU-jev v bazo
    if(!empty($_POST)){
        require_once('db.php');
        global $db;
      
        $ime = $_POST['ime'];
        $chipset = $_POST['chipset'];
        $vram = (int)$_POST['vram'];
        $hitrost = (int)$_POST['hitrost'];
        $cena = (int)$_POST['cena'];
        $zaloga = (int)$_POST['zaloga'];
        $opis = $_POST['opis'];
        
        $dovoljeneKoncnice = ['jpeg', 'jpg', 'png']; // Dovoljeni tipi datotek

        // Preveri ali so bile slike naložene
        if($_FILES['slika1']['size'] > 0 && $_FILES['slika2']['size'] > 0 && $_FILES['slika3']['size'] > 0) {
            // Preverjanje tipa datotek
            foreach (['slika1', 'slika2', 'slika3'] as $slike) {
                $koncnica = strtolower(pathinfo($_FILES[$slike]['name'], PATHINFO_EXTENSION));
                if (!in_array($koncnica, $dovoljeneKoncnice)) {
                    echo "<div class='alert alert-danger'>Datoteka za $slike mora biti tipa .jpeg, .jpg ali .png.</div>";
                    return;
                }
            }
            // Preberi sliko z ustreznim preverjanjem napak
            $slika1 = null;
            $slika2 = null;
            $slika3 = null;
            
            // Vsako datoteko obravnava posamezno z ustreznim preverjanjem napak
            if (is_uploaded_file($_FILES['slika1']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika1 = file_get_contents($_FILES['slika1']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika1
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem prve slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            if (is_uploaded_file($_FILES['slika2']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika2 = file_get_contents($_FILES['slika2']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika2
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem druge slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            if (is_uploaded_file($_FILES['slika3']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika3 = file_get_contents($_FILES['slika3']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika3
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem tretje slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            // Uporabi pripravljeno izjavo za vstavljanje podatkov v rso_gpu tabelo
            $stmt = $db->prepare("INSERT INTO rso_gpu (ime, slika1, slika2, slika3, chipset, vram, hitrost, cena, zaloga, opis) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            // Pripne parametre
            $stmt->bind_param("sssssiiiss", $ime, $slika1, $slika2, $slika3, $chipset, $vram, $hitrost, $cena, $zaloga, $opis);
            
            if($stmt->execute()) { // Izvrši poizvedbo
                echo "<div class='alert alert-success'>Vnos uspešen</div>"; // Prikaže sporočilo o uspehu
            } else {
                echo "<div class='alert alert-danger'>Napaka pri vnosu: " . $stmt->error . "</div>"; // Prikaže napako, če vnos ni uspel
            }
            $stmt->close(); // Zapre pripravljeno izjavo
        } else {
            echo "<div class='alert alert-danger'>Manjkajo slike</div>"; // Prikaže napako, če manjkajo slike
        }
    }
}

function addMobo(){ // Ustvari funkcijo, ki omogoča dodajanje matičnih plošč v bazo
    if(!empty($_POST)){
        require_once('db.php');
        global $db;
    
        $ime = $_POST['ime']; // Pridobi ime iz obrazca na strani dodaj.php
        $socket = $_POST['socket']; // Pridobi socket iz obrazca na strani dodaj.php
        $velikost = $_POST['velikost']; // Pridobi velikost iz obrazca na strani dodaj.php
        $chipset = $_POST['chipset']; // Pridobi chipset iz obrazca na strani dodaj.php
        $cena = (int)$_POST['cena']; // Pridobi ceno iz obrazca na strani dodaj.php
        $zaloga = (int)$_POST['zaloga']; // Pridobi zalogo iz obrazca na strani dodaj.php
        $opis = $_POST['opis']; // Pridobi opis iz obrazca na strani dodaj.php
    
        $dovoljeneKoncnice = ['jpeg', 'jpg', 'png']; // Dovoljeni tipi datotek

        // Preveri ali so bile slike naložene
        if($_FILES['slika1']['size'] > 0 && $_FILES['slika2']['size'] > 0 && $_FILES['slika3']['size'] > 0) {
            // Preverjanje tipa datotek
            foreach (['slika1', 'slika2', 'slika3'] as $slike) {
                $koncnica = strtolower(pathinfo($_FILES[$slike]['name'], PATHINFO_EXTENSION));
                if (!in_array($koncnica, $dovoljeneKoncnice)) {
                    echo "<div class='alert alert-danger'>Datoteka za $slike mora biti tipa .jpeg, .jpg ali .png.</div>";
                    return;
                }
            }
            // Preberi sliko z ustreznim preverjanjem napak
            $slika1 = null;
            $slika2 = null;
            $slika3 = null;
            
            // Vsako datoteko obravnava posamezno z ustreznim preverjanjem napak
            if (is_uploaded_file($_FILES['slika1']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika1 = file_get_contents($_FILES['slika1']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika1
            } else { 
                echo "<div class='alert alert-danger'>Problem z nalaganjem prve slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            if (is_uploaded_file($_FILES['slika2']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika2 = file_get_contents($_FILES['slika2']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika2
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem druge slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            if (is_uploaded_file($_FILES['slika3']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika3 = file_get_contents($_FILES['slika3']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika3
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem tretje slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            // Uporabi pripravljeno izjavo za vstavljanje podatkov v rso_mobo tabelo
            $stmt = $db->prepare("INSERT INTO rso_mobo (ime, slika1, slika2, slika3, socket, velikost, chipset, cena, zaloga, opis) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            // Pripne parametre
            $stmt->bind_param("ssssssssis", $ime, $slika1, $slika2, $slika3, $socket, $velikost, $chipset, $cena, $zaloga, $opis);
            
            if($stmt->execute()) { // Izvrši poizvedbo
                echo "<div class='alert alert-success'>Vnos uspešen</div>"; // Prikaže sporočilo o uspehu
            } else {
                echo "<div class='alert alert-danger'>Napaka pri vnosu: " . $stmt->error . "</div>"; // Prikaže napako, če vnos ni uspel
            }
            $stmt->close(); // Zapre pripravljeno izjavo
        } else { 
            echo "<div class='alert alert-danger'>Manjkajo slike</div>"; // Prikaže napako, če manjkajo slike
        }
    }
}

function addRAM(){
    if(!empty($_POST)){
        require_once('db.php');
        global $db;
    
        $ime = $_POST['ime']; // Pridobi ime iz obrazca na strani dodaj.php
        $kapaciteta = (int)$_POST['kapaciteta']; // Pridobi kapaciteto iz obrazca na strani dodaj.php
        $hitrost = (int)$_POST['hitrost']; // Pridobi hitrost iz obrazca na strani dodaj.php
        $generacija = $_POST['generacija']; // Pridobi generacijo iz obrazca na strani dodaj.php
        $cena = (int)$_POST['cena']; // Pridobi ceno iz obrazca na strani dodaj.php
        $zaloga = (int)$_POST['zaloga']; // Pridobi zalogo iz obrazca na strani dodaj.php
        $opis = $_POST['opis']; // Pridobi opis iz obrazca na strani dodaj.php
        $dovoljeneKoncnice = ['jpeg', 'jpg', 'png']; // Dovoljeni tipi datotek

        // Preveri ali so bile slike naložene
        if($_FILES['slika1']['size'] > 0 && $_FILES['slika2']['size'] > 0 && $_FILES['slika3']['size'] > 0) {
            // Preverjanje tipa datotek
            foreach (['slika1', 'slika2', 'slika3'] as $slike) {
                $koncnica = strtolower(pathinfo($_FILES[$slike]['name'], PATHINFO_EXTENSION));
                if (!in_array($koncnica, $dovoljeneKoncnice)) {
                    echo "<div class='alert alert-danger'>Datoteka za $slike mora biti tipa .jpeg, .jpg ali .png.</div>";
                    return;
                }
            }   
            // Preberi sliko z ustreznim preverjanjem napak
            $slika1 = null;
            $slika2 = null;
            $slika3 = null;
            
            // Vsako datoteko obravnava posamezno z ustreznim preverjanjem napak
            if (is_uploaded_file($_FILES['slika1']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika1 = file_get_contents($_FILES['slika1']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika1
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem prve slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            if (is_uploaded_file($_FILES['slika2']['tmp_name'])) {  // Preveri ali je bila datoteka naložena
                $slika2 = file_get_contents($_FILES['slika2']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika2
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem druge slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            if (is_uploaded_file($_FILES['slika3']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika3 = file_get_contents($_FILES['slika3']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika3
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem tretje slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            // Uporabi pripravljeno izjavo za vstavljanje podatkov v rso_ram tabelo
            $stmt = $db->prepare("INSERT INTO rso_ram (ime, slika1, slika2, slika3, kapaciteta, hitrost, generacija, cena, zaloga, opis) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            // Pripne parametre
            $stmt->bind_param("ssssiissis", $ime, $slika1, $slika2, $slika3, $kapaciteta, $hitrost, $generacija, $cena, $zaloga, $opis);
            
            if($stmt->execute()) { // Izvrši poizvedbo
                echo "<div class='alert alert-success'>Vnos uspešen</div>"; // Prikaže sporočilo o uspehu
            } else {
                echo "<div class='alert alert-danger'>Napaka pri vnosu: " . $stmt->error . "</div>"; // Prikaže napako, če vnos ni uspel
            }
            $stmt->close(); // Zapre pripravljeno izjavo
        } else {
            echo "<div class='alert alert-danger'>Manjkajo slike</div>"; // Prikaže napako, če manjkajo slike
        }
    }
}

function addShramba(){
    if(!empty($_POST)){
        require_once('db.php');
        global $db;
    
        $ime = $_POST['ime']; // Pridobi ime iz obrazca na strani dodaj.php
        $kapaciteta = (int)$_POST['kapaciteta']; // Pridobi kapaciteto iz obrazca na strani dodaj.php
        $tip_shrambe = $_POST['tip_shrambe']; // Pridobi tip shrambe iz obrazca na strani dodaj.php
        $cena = (int)$_POST['cena']; // Pridobi ceno iz obrazca na strani dodaj.php
        $zaloga = (int)$_POST['zaloga']; // Pridobi zalogo iz obrazca na strani dodaj.php
        $opis = $_POST['opis']; // Pridobi opis iz obrazca na strani dodaj.php
        $dovoljeneKoncnice = ['jpeg', 'jpg', 'png']; // Dovoljeni tipi datotek

        // Preveri ali so bile slike naložene
        if($_FILES['slika1']['size'] > 0 && $_FILES['slika2']['size'] > 0 && $_FILES['slika3']['size'] > 0) {
            // Preverjanje tipa datotek
            foreach (['slika1', 'slika2', 'slika3'] as $slike) {
                $koncnica = strtolower(pathinfo($_FILES[$slike]['name'], PATHINFO_EXTENSION));
                if (!in_array($koncnica, $dovoljeneKoncnice)) {
                    echo "<div class='alert alert-danger'>Datoteka za $slike mora biti tipa .jpeg, .jpg ali .png.</div>";
                    return;
                }
            }
            // Preberi sliko z ustreznim preverjanjem napak
            $slika1 = null;
            $slika2 = null;
            $slika3 = null;
            
            // Vsako datoteko obravnava posamezno z ustreznim preverjanjem napak
            if (is_uploaded_file($_FILES['slika1']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika1 = file_get_contents($_FILES['slika1']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika1
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem prve slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            if (is_uploaded_file($_FILES['slika2']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika2 = file_get_contents($_FILES['slika2']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika2
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem druge slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            if (is_uploaded_file($_FILES['slika3']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika3 = file_get_contents($_FILES['slika3']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika3
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem tretje slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            // Uporabi pripravljeno izjavo za vstavljanje podatkov v rso_storage tabelo
            $stmt = $db->prepare("INSERT INTO rso_storage (ime, slika1, slika2, slika3, kapaciteta, tip_shrambe, cena, zaloga, opis) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            // Pripne parametre
            $stmt->bind_param("ssssissis", $ime, $slika1, $slika2, $slika3, $kapaciteta, $tip_shrambe, $cena, $zaloga, $opis);
            
            if($stmt->execute()) {
                echo "<div class='alert alert-success'>Vnos uspešen</div>"; // Prikaže sporočilo o uspehu
            } else {
                echo "<div class='alert alert-danger'>Napaka pri vnosu: " . $stmt->error . "</div>"; // Prikaže napako, če vnos ni uspel
            }
            $stmt->close(); // Zapre pripravljeno izjavo
        } else {
            echo "<div class='alert alert-danger'>Manjkajo slike</div>"; // Prikaže napako, če manjkajo slike
        }
    }
}

function addRac(){
    if(!empty($_POST)){
        require_once('db.php');
        global $db;
    
        $ime = $_POST['ime']; // Pridobi ime iz obrazca na strani dodaj.php
        $cpu = $_POST['cpu']; // Pridobi CPU iz obrazca na strani dodaj.php
        $mobo = $_POST['mobo']; // Pridobi matično ploščo iz obrazca na strani dodaj.php
        $gpu = $_POST['gpu']; // Pridobi GPU iz obrazca na strani dodaj.php
        $ram = $_POST['ram']; // Pridobi RAM iz obrazca na strani dodaj.php
        $shramba = $_POST['shramba']; // Pridobi shrambo iz obrazca na strani dodaj.php
        $cena = (int)$_POST['cena']; // Pridobi ceno iz obrazca na strani dodaj.php
        $zaloga = (int)$_POST['zaloga']; // Pridobi zalogo iz obrazca na strani dodaj.php
        $opis = $_POST['opis']; // Pridobi opis iz obrazca na strani dodaj.php
        $dovoljeneKoncnice = ['jpeg', 'jpg', 'png']; // Dovoljeni tipi datotek

        // Preveri ali so bile slike naložene
        if($_FILES['slika1']['size'] > 0 && $_FILES['slika2']['size'] > 0 && $_FILES['slika3']['size'] > 0) {
            // Preverjanje tipa datotek
            foreach (['slika1', 'slika2', 'slika3'] as $slike) {
                $koncnica = strtolower(pathinfo($_FILES[$slike]['name'], PATHINFO_EXTENSION));
                if (!in_array($koncnica, $dovoljeneKoncnice)) {
                    echo "<div class='alert alert-danger'>Datoteka za $slike mora biti tipa .jpeg, .jpg ali .png.</div>";
                    return;
                }
            }
            // Preberi sliko z ustreznim preverjanjem napak
            $slika1 = null;
            $slika2 = null;
            $slika3 = null;
            
            // Vsako datoteko obravnava posamezno z ustreznim preverjanjem napak
            if (is_uploaded_file($_FILES['slika1']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika1 = file_get_contents($_FILES['slika1']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika1
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem prve slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            if (is_uploaded_file($_FILES['slika2']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika2 = file_get_contents($_FILES['slika2']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika2
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem druge slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            if (is_uploaded_file($_FILES['slika3']['tmp_name'])) { // Preveri ali je bila datoteka naložena
                $slika3 = file_get_contents($_FILES['slika3']['tmp_name']); // Prebere sliko in jo shrani v spremenljivko $slika3
            } else {
                echo "<div class='alert alert-danger'>Problem z nalaganjem tretje slike</div>"; // Prikaže napako, če slika ni bila naložena
                return;
            }
            
            // Uporabi pripravljeno izjavo za vstavljanje podatkov v rso_rac tabelo
            $stmt = $db->prepare("INSERT INTO rso_rac (ime, slika1, slika2, slika3, cpu, mobo, gpu, ram, shramba, cena, zaloga, opis) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            // Pripne parametre
            $stmt->bind_param("ssssssssssis", $ime, $slika1, $slika2, $slika3, $cpu, $mobo, $gpu, $ram, $shramba, $cena, $zaloga, $opis);
            
            if($stmt->execute()) { // Izvrši poizvedbo
                echo "<div class='alert alert-success'>Vnos uspešen</div>"; // Prikaže sporočilo o uspehu
            } else {
                echo "<div class='alert alert-danger'>Napaka pri vnosu: " . $stmt->error . "</div>"; // Prikaže napako, če vnos ni uspel
            }
            $stmt->close(); // Zapre pripravljeno izjavo
        } else {
            echo "<div class='alert alert-danger'>Manjkajo slike</div>"; // Prikaže napako, če manjkajo slike
        }
    }
}

function prikaziSliko($id, $tabela, $slika){
    global $db; // Uporabi globalno spremenljivko $db, da pridobi dostop do baze podatkov
    
        // Preveri ali je tabela veljavna in ali je ID večji od 0
        $tabele = ['rso_cpu', 'rso_gpu', 'rso_mobo', 'rso_ram', 'rso_storage', 'rso_rac']; // Ensure 'rso_storage' is included
        $nums = ['slika1', 'slika2', 'slika3'];
        
        if(in_array($tabela, $tabele) && in_array($slika, $nums) && $id > 0) { // Preveri ali je tabela veljavna in ali je ID večji od 0, poizvedba je tukaj direktna
            $sql = "SELECT * FROM $tabela WHERE id = $id LIMIT 1"; // SQL poizvedba
            $rezultat = ($db->query($sql)); // Izvrši poizvedbo in shrani rezultat v spremenljivko $rezultat
            $user = $rezultat->fetch_assoc(); // V spremenljivko $user shrani rezultat poizvedbe
            return '<img alt="Product Image" class="img-fluid d-block mx-auto" src="data:image/jpeg;base64,'.base64_encode( $user[$slika] ).'"/>'; // Prikaže sliko iz baze podatkov
        }
}

function toast($besedilo){
    return ' <!-- Bootstrap toast -->
    <div class="toast align-items-center text-white bg-success border-0 show position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true"> 
        <div class="d-flex">
            <div class="toast-body">
                ' . htmlspecialchars($besedilo) . ' <!-- Prikaže sporočilo, ki je shranjeno v spremenljivko $besedilo -->
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button> <!-- Prikaže gumb za zapiranje toasta -->
        </div>
    </div>';
}

function ustvariKodo(){
    return bin2hex(random_bytes(16)); // Ustvari naključno kodo dolžine 32 znakov, namenjeno potrditvi identitete uporabnikovega email računa ob prijavi
}

function skupnaCenaPcBuilda($db) {
    $pc_sql = "SELECT * FROM pcbuild ORDER BY id DESC LIMIT 1"; // SQL poizvedba, s katero dobimo zadnji vnos iz tabele pcbuild
    $pc = $db->query($pc_sql);
    
    if (!$pc || $pc->num_rows == 0) { // Če ni rezultatov, torej ni nič v tabeli pcbuild
        return 0;
    }
    
    $pc_build = $pc->fetch_assoc(); 
    $skupna_cena = 0; // Inicializiraj skupno ceno na 0
    
    // Omogoči povezavo med ID-ji in imeni tabel
    $tabele = [
        'id_CPU' => 'rso_cpu',
        'id_GPU' => 'rso_gpu',
        'id_mobo' => 'rso_mobo',
        'id_ram' => 'rso_ram',
        'id_storage' => 'rso_storage'
    ];
    
    // Izračuna ceno za vsak izdelek v tabeli pcbuild
    foreach ($tabele as $polja => $table) { 
        $id_komponente = $pc_build[$polja]; // Pridobi ID komponente iz tabele pcbuild
        
        if (!empty($id_komponente)) {
            // Get component price
            $sql = "SELECT cena FROM $table WHERE id = ?"; // SQL poizvedba, ki pridobi ceno komponente iz ustrezne tabele
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i", $id_komponente);
            $stmt->execute();
            $rezultat = $stmt->get_result();
            
            if ($rezultat && $rezultat->num_rows > 0) { // Preveri ali je rezultat poizvedbe veljaven
                $komponenta = $rezultat->fetch_assoc(); // Pridobi ceno komponente iz rezultata poizvedbe
                $skupna_cena += $komponenta['cena']; // Doda ceno komponente k skupni ceni
            }
            
            $stmt->close(); // Zapre pripravljeno izjavo
        }
    }
    
    return number_format($skupna_cena, 2); // Vrne skupno ceno v obliki z dvema decimalnima mestoma
}

function izpišiRezultate($db, $tabela, $poizvedba, &$a) { 
    $sql = "SELECT id, slika1, ime FROM $tabela WHERE ime LIKE ?"; // SQL poizvedba s placeholderjem
    $stmt = $db->prepare($sql); // Pripravi poizvedbo
    $likePoizvedba = '%' . $poizvedba . '%'; // Dodaj wildcard znake za LIKE
    $stmt->bind_param("s", $likePoizvedba); // Pripni parameter
    $stmt->execute(); // Izvrši poizvedbo
    $rezultat = $stmt->get_result(); // Pridobi rezultat

    if ($rezultat->num_rows > 0) { // Izpisuje rezultate, če ti obstajajo (Št. vrstic je več kot 0)
        while ($user = $rezultat->fetch_assoc()) {
            echo "<a href='prikaz_gpu.php?id={$user['id']}' class='text-decoration-none text-body'> <!-- Omogoči preusmeritev na izdelek, če uporabnik klikne na izdelek -->
            <div class='row box my-3 py-3 border border-dark rounded'>
            <div class='col-sm-4'> 
            <img alt='Product Image' class='img-fluid d-block mx-auto' style='height:70px' src='data:image/jpeg;base64,".base64_encode( $user['slika1'] )."'/> <!-- Prikaz slike izdelka -->
            </div>
            <div class='col-sm-8'>{$user['ime']}</div> <!-- Prikaz imena izdelka -->
            </div>
            </a>";
        }
        $a++;
    }
    $stmt->close(); // Zapri pripravljeno izjavo
}

function shraniNarocilo($db, $ime, $email, $naslov, $mesto, $postna_st) {
    // Ustvari poizvedbo za shranjevanje naročila
    $stmt = $db->prepare("INSERT INTO narocila (ime, email, naslov, mesto, postna_st, skupni_znesek, datum_narocila) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    
    // Izračunaj skupni znesek naročila
    $result = $db->query("SELECT SUM(cena * kolicina) AS skupno FROM kosarica");
    $skupno = $result->fetch_assoc()['skupno'];
    
    $stmt->bind_param("sssssd", $ime, $email, $naslov, $mesto, $postna_st, $skupno);
    $stmt->execute();
    $id_narocila = $db->insert_id;
    
    // Shrani izdelke v naročilo
    $izdelki = $db->query("SELECT * FROM kosarica");
    $stmt2 = $db->prepare("INSERT INTO izdelki (id_narocila, ime_izdelka, kolicina, cena) VALUES (?, ?, ?, ?)");
    
    while ($izdelek = $izdelki->fetch_assoc()) {
        $stmt2->bind_param("isid", $id_narocila, $izdelek['ime'], $izdelek['kolicina'], $izdelek['cena']);
        $stmt2->execute();
    }
    // Vrne ID naročila
    return $id_narocila;
}
?>
