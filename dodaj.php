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
    <title>Dodaj Izdelke</title> <!-- Naslov zavihka strani -->
</head>
<body class="d-flex flex-column min-vh-100">
    
<?php echo Navbar(); ?>

<div class="container my-5">
    <div class="row">
        <!-- Gumbi za izbiranje kategorij -->
        <div class="col-12 mb-4 text-center">
            <button class="btn siv mx-2" onclick="window.location.href='dodaj.php?id=1'">Dodaj CPU</button>  <!-- Gumb, ki omogoči dodajanje procesorjev, ob pritisku preusmeri na dodaj.php z id-jem 1 -->
            <button class="btn siv mx-2" onclick="window.location.href='dodaj.php?id=2'">Dodaj GPU</button> <!-- Gumb, ki omogoči dodajanje procesorjev, ob pritisku preusmeri na dodaj.php z id-jem 2 -->
            <button class="btn siv mx-2" onclick="window.location.href='dodaj.php?id=3'">Dodaj Mobo</button> <!-- Gumb, ki omogoči dodajanje procesorjev, ob pritisku preusmeri na dodaj.php z id-jem 3 -->
            <button class="btn siv mx-2" onclick="window.location.href='dodaj.php?id=4'">Dodaj RAM</button> <!-- Gumb, ki omogoči dodajanje procesorjev, ob pritisku preusmeri na dodaj.php z id-jem 4 -->
            <button class="btn siv mx-2" onclick="window.location.href='dodaj.php?id=6'">Dodaj Shrambo</button> <!-- Gumb, ki omogoči dodajanje procesorjev, ob pritisku preusmeri na dodaj.php z id-jem 6 -->
            <button class="btn siv mx-2" onclick="window.location.href='dodaj.php?id=5'">Dodaj Racunalnik</button> <!-- Gumb, ki omogoči dodajanje procesorjev, ob pritisku preusmeri na dodaj.php z id-jem 5 -->
        </div>
    </div>

    <div class="row">
        <?php
        $id = $_GET['id'] ?? null; // V $id se shrani vrednost id-ja posredovanega iz URL-ja (ko pritisnemo zgornji gumb), če ta ne obstaja, se shrani null

        if ($id == 1) { // Če želimo dodajati procesorje
            echo '
            <div class="col-md-6 offset-md-3">
                <div class="card"> <!-- Inicializiramo kartico -->
                    <div class="card-header siv text-center"> <!-- Oblikujemo glavo kartice -->
                        <h5>Dodaj CPU</h5>
                    </div>
                    <div class="card-body svetlo-siv"> <!-- Oblikujemo telo kartice -->
                        <form action="" method="post" enctype="multipart/form-data"> <!-- Začnemo formo s katero bomo dobili podatke za ustvarjenje zapisa v tabeli rso_cpu -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="ime" placeholder="Ime" required> <!-- Ustvarimo oznako in polje za dodajanje imena izdelka -->
                                <label for="ime">Ime izdelka</label>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload1" class="form-label">Slika 1</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 1. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload1" name="slika1" required>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload2" class="form-label">Slika 2</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 2. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload2" name="slika2" required>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload3" class="form-label">Slika 3</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 3. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload3" name="slika3" required>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="jedra" placeholder="Jedra" required> <!-- Ustvarimo oznako in polje za dodajanje stevila jedr procesorja -->
                                <label for="jedra">Število jeder</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="hitrost" placeholder="Hitrost" required> <!-- Ustvarimo oznako in polje za dodajanje stevila jedr procesorja -->
                                <label for="hitrost">Hitrost CPU-ja (GHz)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="arhitektura" placeholder="Arhitektura" required> <!-- Ustvarimo oznako in polje za dodajanje arhitekture procesorja -->
                                <label for="arhitektura">Ime mikroarhitekture</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="cena" placeholder="Cena" required> <!-- Ustvarimo oznako in polje za dodajanje cene izdelka -->
                                <label for="cena">Cena CPU-ja (EUR)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="zaloga" placeholder="Zaloga" required> <!-- Ustvarimo oznako in polje za dodajanje kolicine izdelkov na zalogi -->
                                <label for="zaloga">Število izdelkov na zalogi</label>
                            </div>
                            <div class="form mb-3">
                                <label for="opis" class="form-label">Opis CPU-ja</label> <!-- Ustvarimo oznako in polje za dodajanje opisa izdelka, ki ga dodajamo -->
                                <textarea class="form-control" rows="3" id="opis" name="opis" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Dodaj CPU</button> <!-- Gumb za potrditev oddaje -->
                        </form>
                    </div>
                </div>
            </div>';
            addCPU(); // Klic funkcije, ki doda CPU v bazo
        }

        if ($id == 2) { // Če želimo dodajati grafične kartice
            echo '
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header siv text-center">
                        <h5>Dodaj GPU</h5>
                    </div>
                    <div class="card-body svetlo-siv">
                        <form action="" method="post" enctype="multipart/form-data"> <!-- Začnemo formo s katero bomo dobili podatke za ustvarjenje zapisa v tabeli rso_gpu -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="ime" placeholder="Ime" required> <!-- Ustvarimo oznako in polje za dodajanje imena izdelka -->
                                <label for="ime">Ime izdelka</label>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload1" class="form-label">Slika 1</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 1. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload1" name="slika1" required>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload2" class="form-label">Slika 2</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 2. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload2" name="slika2" required>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload3" class="form-label">Slika 3</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 3. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload3" name="slika3" required>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="chipset" placeholder="Chipset" required> <!-- Ustvarimo oznako in polje za dodajanje imena čipa GPU-ja -->
                                <label for="chipset">Ime podnožja</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="vram" placeholder="VRAM" required> <!-- Ustvarimo oznako in polje za dodajanje velikosti VRAM-a -->
                                <label for="vram">Količina VRAM-a (GB)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="hitrost" placeholder="Hitrost" required> <!-- Ustvarimo oznako in polje za dodajanje hitrosti GPU-ja -->
                                <label for="hitrost">Hitrost GPU-ja (MHz)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="cena" placeholder="Cena" required> <!-- Ustvarimo oznako in polje za dodajanje cene izdelka -->
                                <label for="cena">Cena GPU-ja (EUR)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="zaloga" placeholder="Zaloga" required> <!-- Ustvarimo oznako in polje za dodajanje kolicine izdelkov na zalogi -->
                                <label for="zaloga">Število izdelkov na zalogi</label>
                            </div>
                            <div class="form mb-3">
                                <label for="opis" class="form-label">Opis GPU-ja</label> <!-- Ustvarimo oznako in polje za dodajanje opisa izdelka, ki ga dodajamo -->
                                <textarea class="form-control" rows="3" id="opis" name="opis" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Dodaj GPU</button> <!-- Gumb za potrditev oddaje -->
                        </form>
                    </div>
                </div>
            </div>';
            addGPU(); // Klic funkcije, ki doda GPU v bazo
        }

        if ($id == 3) { // Če želimo dodajati matične plošče
            echo '
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header siv text-center">
                        <h5>Dodaj Mobo</h5>
                    </div>
                    <div class="card-body svetlo-siv"> 
                        <form action="" method="post" enctype="multipart/form-data"> <!-- Začnemo formo s katero bomo dobili podatke za ustvarjenje zapisa v tabeli rso_mobo -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="ime" placeholder="Ime" required> <!-- Ustvarimo oznako in polje za dodajanje imena izdelka -->
                                <label for="ime">Ime matične plošče</label>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload1" class="form-label">Slika 1</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 1. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload1" name="slika1" required>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload2" class="form-label">Slika 2</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 2. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload2" name="slika2" required>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload3" class="form-label">Slika 3</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 3. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload3" name="slika3" required>
                            </div>
                            <div class="form my-3">
                                <label for="socket" class="form-label">Izberi čip matične plošče:</label> <!-- Ustvarimo oznako in omogočimo izbiro čipa matične plošče, te lahko izberemo iz spustnega seznama -->
                                <select class="form-select" name="socket" id="socket" required>
                                    <option value="sTR5">sTR5</option> <!-- Na spustnem seznamu omogoča izbero sTR5 -->
                                    <option value="AM5">AM5</option> <!-- Na spustnem seznamu omogoča izbero AM5 -->
                                    <option value="LGA1700">LGA1700</option> <!-- Na spustnem seznamu omogoča izbero LGA1700 -->
                                    <option value="LGA1851">LGA1851</option> <!-- Na spustnem seznamu omogoča izbero LGA1851 -->
                                    <option value="LGA4677">LGA4677</option> <!-- Na spustnem seznamu omogoča izbero LGA4677 -->
                                    <option value="AM4">AM4</option> <!-- Na spustnem seznamu omogoča izbero AM4 -->
                                    <option value="sTR4">sTR4</option> <!-- Na spustnem seznamu omogoča izbero sTR4 -->
                                    <option value="LGA1200">LGA1200</option> <!-- Na spustnem seznamu omogoča izbero LGA1200 -->
                                    <option value="LGA2066">LGA2066</option> <!-- Na spustnem seznamu omogoča izbero LGA2066 -->
                                    <option value="LGA4677">LGA4677</option> <!-- Na spustnem seznamu omogoča izbero LGA4677 -->
                                    <option value="AM3">AM3</option> <!-- Na spustnem seznamu omogoča izbero AM3 -->
                                    <option value="FM1">FM1</option> <!-- Na spustnem seznamu omogoča izbero FM1 -->
                                    <option value="FM2">FM2</option> <!-- Na spustnem seznamu omogoča izbero FM2 -->
                                    <option value="FM2+">FM2+</option> <!-- Na spustnem seznamu omogoča izbero FM2+ -->
                                    <option value="LGA775">LGA775</option> <!-- Na spustnem seznamu omogoča izbero LGA775 -->
                                    <option value="LGA1156">LGA1156</option> <!-- Na spustnem seznamu omogoča izbero LGA1156 -->
                                </select>
                            </div>
                            <div class="form my-3">
                                <label for="velikost" class="form-label">Izberi velikost matične plošče:</label> <!-- Ustvarimo oznako in omogočimo izbiro velikosti matične plošče, te lahko izberemo iz spustnega seznama -->
                                <select class="form-select" name="velikost" id="velikost" required>
                                    <option value="ATX">ATX</option> <!-- Na spustnem seznamu omogoča izbero ATX -->
                                    <option value="Micro ATX">Micro ATX</option> <!-- Na spustnem seznamu omogoča izbero Micro ATX -->
                                    <option value="Mini ITX">Mini ITX</option> <!-- Na spustnem seznamu omogoča izbero Mini ITX -->
                                </select>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="chipset" placeholder="Chipset" required> <!-- Ustvarimo oznako in polje za dodajanje imena čipa matične plošče -->
                                <label for="chipset">Vrsta podnožja matične plošče</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="cena" placeholder="Cena" required> <!-- Ustvarimo oznako in polje za dodajanje cene izdelka -->
                                <label for="cena">Cena matične plošče (EUR)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="zaloga" placeholder="Zaloga" required> <!-- Ustvarimo oznako in polje za dodajanje kolicine izdelkov na zalogi -->
                                <label for="zaloga">Število izdelkov na zalogi</label>
                            </div>
                            <div class="form mb-3">
                                <label for="opis" class="form-label">Opis matične plošče</label> <!-- Ustvarimo oznako in polje za dodajanje opisa izdelka, ki ga dodajamo -->
                                <textarea class="form-control" rows="3" id="opis" name="opis" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Dodaj Mobo</button> <!-- Gumb za potrditev oddaje -->
                        </form>
                    </div>
                </div>
            </div>';
            addMobo(); // Klic funkcije, ki doda Mobo v bazo
        }

        if ($id == 4) { // Če želimo dodajati RAM
            echo '
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header siv text-center">
                        <h5>Dodaj RAM</h5>
                    </div>
                    <div class="card-body svetlo-siv">
                        <form action="" method="post" enctype="multipart/form-data"> <!-- Začnemo formo s katero bomo dobili podatke za ustvarjenje zapisa v tabeli rso_ram -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="ime" placeholder="Ime" required> <!-- Ustvarimo oznako in polje za dodajanje imena izdelka -->
                                <label for="ime">Ime RAM-a</label>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload1" class="form-label">Slika 1</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 1. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload1" name="slika1" required>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload2" class="form-label">Slika 2</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 2. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload2" name="slika2" required>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload3" class="form-label">Slika 3</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 3. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload3" name="slika3" required>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="kapaciteta" placeholder="Kapaciteta" required> <!-- Ustvarimo oznako in polje za dodajanje kapacitete RAM-a -->
                                <label for="kapaciteta">Kapaciteta RAM-a (GB)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="hitrost" placeholder="Hitrost" required> <!-- Ustvarimo oznako in polje za dodajanje hitrosti RAM-a -->
                                <label for="hitrost">Hitrost RAM-a (MHz)</label>
                            </div>
                            <div class="form my-3">
                                <label for="generacija" class="form-label">Generacija RAM-a:</label> <!-- Ustvarimo oznako in omogočimo izbiro generacije RAM-a, te lahko izberemo iz spustnega seznama -->
                                <select class="form-select" name="generacija" id="generacija" required>
                                    <option value="DDR2">DDR2</option> <!-- Na spustnem seznamu omogoči izbero DDR2 -->
                                    <option value="DDR3">DDR3</option> <!-- Na spustnem seznamu omogoči izbero DDR3 -->
                                    <option value="DDR4">DDR4</option> <!-- Na spustnem seznamu omogoči izbero DDR4 -->
                                    <option value="DDR5">DDR5</option> <!-- Na spustnem seznamu omogoči izbero DDR5 -->
                                </select>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="cena" placeholder="Cena" required> <!-- Ustvarimo oznako in polje za dodajanje cene izdelka -->
                                <label for="cena">Cena RAM-a (EUR)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="zaloga" placeholder="Zaloga" required> <!-- Ustvarimo oznako in polje za dodajanje kolicine izdelkov na zalogi -->
                                <label for="zaloga">Število izdelkov na zalogi</label>
                            </div>
                            <div class="form mb-3">
                                <label for="opis" class="form-label">Opis RAM-a</label> <!-- Ustvarimo oznako in polje za dodajanje opisa izdelka, ki ga dodajamo -->
                                <textarea class="form-control" rows="3" id="opis" name="opis" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Dodaj RAM</button> <!-- Gumb za potrditev oddaje -->
                        </form>
                    </div>
                </div>
            </div>';
            addRAM(); // Klic funkcije, ki doda RAM v bazo
        }

        if ($id == 6) { // Če želimo dodajati shrambe
            echo '
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header siv text-center">
                        <h5>Dodaj Shrambo</h5>
                    </div>
                    <div class="card-body svetlo-siv">
                        <form action="" method="post" enctype="multipart/form-data"> <!-- Začnemo formo s katero bomo dobili podatke za ustvarjenje zapisa v tabeli rso_storage -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="ime" placeholder="Ime" required> <!-- Ustvarimo oznako in polje za dodajanje imena izdelka -->
                                <label for="ime">Ime shrambe</label>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload1" class="form-label">Slika 1</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 1. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload1" name="slika1" required>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload2" class="form-label">Slika 2</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 2. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload2" name="slika2" required>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload3" class="form-label">Slika 3</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 3. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload3" name="slika3" required>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="kapaciteta" placeholder="Kapaciteta" required> <!-- Ustvarimo oznako in polje za dodajanje kapacitete shrambe -->
                                <label for="kapaciteta">Kapaciteta shrambe (GB)</label>
                            </div>
                            <div class="form my-3">
                                <label for="tip_shrambe" class="form-label">Tip shrambe:</label> <!-- Ustvarimo oznako in omogočimo izbiro tipa shrambe, te lahko izberemo iz spustnega seznama -->
                                <select class="form-select" name="tip_shrambe" id="tip_shrambe" required>
                                    <option value="HDD">HDD</option> <!-- Na spustnem seznamu omogoči izbero HDD -->
                                    <option value="SSD">SSD</option> <!-- Na spustnem seznamu omogoči izbero SSD -->
                                    <option value="M.2">M.2 NVME</option> <!-- Na spustnem seznamu omogoči izbero M.2 NVME -->
                                </select>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="cena" placeholder="Cena" required> <!-- Ustvarimo oznako in polje za dodajanje cene izdelka -->
                                <label for="cena">Cena shrambe (EUR)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="zaloga" placeholder="Zaloga" required> <!-- Ustvarimo oznako in polje za dodajanje kolicine izdelkov na zalogi -->
                                <label for="zaloga">Število izdelkov na zalogi</label>
                            </div>
                            <div class="form mb-3">
                                <label for="opis" class="form-label">Opis shrambe</label> <!-- Ustvarimo oznako in polje za dodajanje opisa izdelka, ki ga dodajamo -->
                                <textarea class="form-control" rows="3" id="opis" name="opis" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Dodaj Shrambo</button> <!-- Gumb za potrditev oddaje -->
                        </form>
                    </div>
                </div>
            </div>';
            addShramba(); // Klic funkcije, ki doda shrambo v bazo
        }

        if ($id == 5) { // Če želimo dodajati računalnike
            echo '
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header siv text-center">
                        <h5>Dodaj Racunalnik</h5>
                    </div>
                    <div class="card-body svetlo-siv">
                        <form action="" method="post" enctype="multipart/form-data"> <!-- Začnemo formo s katero bomo dobili podatke za ustvarjenje zapisa v tabeli rso_rac -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="ime" placeholder="Ime" required> <!-- Ustvarimo oznako in polje za dodajanje imena izdelka -->
                                <label for="ime">Ime računalnika</label>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload1" class="form-label">Slika 1</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 1. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload1" name="slika1" required>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload2" class="form-label">Slika 2</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 2. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload2" name="slika2" required>
                            </div>
                            <div class="mb-3">
                                <label for="imageUpload3" class="form-label">Slika 3</label> <!-- Ustvarimo oznako in omogočimo izbiro datoteke za dodajanje 3. slike izdelka -->
                                <input type="file" class="form-control" id="imageUpload3" name="slika3" required>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="cpu" placeholder="CPU" required> <!-- Ustvarimo oznako in polje za dodajanje imena procesorja -->
                                <label for="cpu">Ime procesorja</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="mobo" placeholder="Mobo" required> <!-- Ustvarimo oznako in polje za dodajanje imena matične plošče -->
                                <label for="mobo">Ime matične plošče</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="gpu" placeholder="GPU" required> <!-- Ustvarimo oznako in polje za dodajanje imena grafične kartice -->
                                <label for="gpu">Ime grafične kartice</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="ram" placeholder="RAM" required> <!-- Ustvarimo oznako in polje za dodajanje imena RAM-a -->
                                <label for="ram">Ime RAM-a</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="shramba" placeholder="Shramba" required> <!-- Ustvarimo oznako in polje za dodajanje imena shrambe -->
                                <label for="shramba">Ime shrambe</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="cena" placeholder="Cena" required> <!-- Ustvarimo oznako in polje za dodajanje cene izdelka -->
                                <label for="cena">Cena računalnika (EUR)</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="zaloga" placeholder="Zaloga" required> <!-- Ustvarimo oznako in polje za dodajanje kolicine izdelkov na zalogi -->
                                <label for="zaloga">Število izdelkov na zalogi</label>
                            </div>
                            <div class="form mb-3">
                                <label for="opis" class="form-label">Opis računalnika</label> <!-- Ustvarimo oznako in polje za dodajanje opisa izdelka, ki ga dodajamo -->
                                <textarea class="form-control" rows="3" id="opis" name="opis" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Dodaj Racunalnik</button> <!-- Gumb za potrditev oddaje -->
                        </form>
                    </div>
                </div>
            </div>';
            addRac(); // Klic funkcije, ki doda računalnik v bazo
        }
        ?>
    </div>
</div>

<?php echo footer(); ?>
</body>
</html>