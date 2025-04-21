<?php
session_start();
require_once('funkcije.php');
require_once('db.php');

// Preveri, če je uporabnik prijavljen
if (!isset($_SESSION['username'])) {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/c33e8f16b9.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style.css">
        <title>PC Builder</title>
    </head>
    <body class="d-flex flex-column min-vh-100">
        ' . Navbar() . '
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-header bg-danger text-white">
                            Dostop zavrnjen
                        </div>
                        <div class="card-body">
                            <p class="card-text">Za dostop do PC Builderja se morate prijaviti.</p>
                            <a href="login.php" class="btn btn-primary">Prijavite se</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ' . footer() . '
    </body>
    </html>';
    exit;
}

$sql = "SELECT * FROM rso_prijava WHERE username = ?"; // Fixed SQL syntax
$stmt = $db->prepare($sql); // Prepare SQL query
$stmt->bind_param("s", $_SESSION['username']); // Bind username parameter
$stmt->execute(); // Execute SQL query
$u = $stmt->get_result(); // Get query result
$user = $u->fetch_assoc(); // Fetch user data

$id_kupca = $user['id']; // Predpostavimo, da je ID uporabnika shranjen v seji

// Pridobi zadnji vnos iz tabele pcbuild za trenutnega uporabnika
$pc_sql = "SELECT * FROM pcbuild WHERE id_kupca = ? ORDER BY id DESC LIMIT 1";
$stmt = $db->prepare($pc_sql);
$stmt->bind_param("i", $id_kupca);
$stmt->execute();
$pc = $stmt->get_result();
$pc_user = $pc->fetch_assoc();

if (!$pc_user) {
    $sql = "INSERT INTO pcbuild (id_kupca) VALUES (?)"; // Ustvari nov vnos v tabeli pcbuild
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id_kupca); // Bind parameter
    $stmt->execute(); // Izvede poizvedbo
}

header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
$id_strani = $_GET['id'] ?? null; // Dobimo id strani iz URL-ja
$socket = $pc_user['socket'] ?? ''; // Initialize $socket with a value from $pc_user or empty string
$ddr = $pc_user['ddr'] ?? ''; // Initialize $ddr with a value from $pc_user or empty string

//CPU arhitektura = mobo Socket
$ddr5 = ['AM5', 'sTR5', 'LGA1700', 'LGA1851', 'LGA4677']; // Določimo kateri socketi podpirajo DDR5
$ddr4 = ['AM4', 'sTR4', 'LGA1200', 'LGA1700', 'LGA2066', 'LGA4677']; // Določimo kateri socketi podpirajo DDR4
$ddr3 = ['AM3', 'FM1', 'FM2', 'FM2+', 'G34', 'C32', 'LGA775', 'LGA1156', 'LGA1366', 'LGA1155', 'LGA2011']; // Določimo kateri socketi podpirajo DDR3

if ($socket !== '') { // Check if $socket is not empty
    if (in_array($socket, $ddr5)) {
        $ram_sql = "SELECT * FROM rso_ram WHERE generacija LIKE 'DDR5'";
    } elseif (in_array($socket, $ddr4)) {
        $ram_sql = "SELECT * FROM rso_ram WHERE generacija LIKE 'DDR4'";
    } elseif (in_array($socket, $ddr3)) {
        $ram_sql = "SELECT * FROM rso_ram WHERE generacija LIKE 'DDR3'";
    }
} else {
    $ram_sql = "SELECT * FROM rso_ram"; // Default query for all RAM models
}

if ($ddr !== '') { // Check if $ddr is not empty
    if ($ddr === 'DDR5') {
        $cpu_sql = "SELECT * FROM rso_cpu WHERE arhitektura IN ('" . implode("','", $ddr5) . "')";
        $mobo_sql = "SELECT * FROM rso_mobo WHERE socket IN ('" . implode("','", $ddr5) . "')";
    } elseif ($ddr === 'DDR4') {
        $cpu_sql = "SELECT * FROM rso_cpu WHERE arhitektura IN ('" . implode("','", $ddr4) . "')";
        $mobo_sql = "SELECT * FROM rso_mobo WHERE socket IN ('" . implode("','", $ddr4) . "')";
    } elseif ($ddr === 'DDR3') {
        $cpu_sql = "SELECT * FROM rso_cpu WHERE arhitektura IN ('" . implode("','", $ddr3) . "')";
        $mobo_sql = "SELECT * FROM rso_mobo WHERE socket IN ('" . implode("','", $ddr3) . "')";
    }
} else {
    $cpu_sql = "SELECT * FROM rso_cpu"; // Default query for all CPU models
    $mobo_sql = "SELECT * FROM rso_mobo"; // Default query for all motherboard models
}

$shramba_sql= "SELECT * FROM rso_storage"; // Izvedemo poizvedbo za vse shrambe
$gpu_sql= "SELECT * FROM rso_gpu"; // Izvedemo poizvedbo za vse gpu modele

$ram = $db->query($ram_sql); 
$mobo = $db->query($mobo_sql);
$cpu = $db->query($cpu_sql);
$shramba = $db->query($shramba_sql);
$gpu = $db->query($gpu_sql);

// Pridobi zadnji vnos iz tabele pcbuild
$id_cpu = $pc_user['id_CPU'] ?? null; // Pridobi id CPU iz zadnjega vnosa
$id_gpu = $pc_user['id_GPU'] ?? null; // Pridobi id GPU iz zadnjega vnosa
$id_mobo = $pc_user['id_mobo'] ?? null; // Pridobi id mobo iz zadnjega vnosa
$id_ram = $pc_user['id_ram'] ?? null; // Pridobi id ram iz zadnjega vnosa
$id_storage = $pc_user['id_storage'] ?? null; // Pridobi id storage iz zadnjega vnosa

// Preverimo katere komponente so že izbrane
$ima_cpu = !empty($id_cpu);
$ima_gpu = !empty($id_gpu);
$ima_mobo = !empty($id_mobo);
$ima_ram = !empty($id_ram);
$ima_storage = !empty($id_storage);

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
    <title>PC Builder</title>
</head>
<body class="d-flex flex-column min-vh-100">
    
<?php echo Navbar(); ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header siv"> <!-- Glava kartice -->
                    <a href="pcbuilder.php?id=5" class="list-group-item list-group-item-action">Komponente</a> <!-- Povezava do glavne strani -->
                </div>
                <div id="component-list" class="list-group list-group-flush svetlo-siv">
                    <?php if (!$ima_cpu){ ?> <!-- Če ni izbran še noben procesor -->
                    <a href="pcbuilder.php?id=1" class="list-group-item list-group-item-action <?php echo ($id_strani == 1) ? 'active bg-success text-white' : ''; ?>">Procesorji</a><!-- Povezava do strani za izbiro procesorjev -->
                    <?php }?>
                    <?php if (!$ima_gpu) { ?> <!-- Če ni izbrana še nobena grafična kartica -->
                    <a href="pcbuilder.php?id=2" class="list-group-item list-group-item-action <?php echo ($id_strani == 2) ? 'active bg-success text-white' : ''; ?>">Grafične kartice</a> <!-- Povezava do strani za izbiro grafičnih kartic -->
                    <?php } ?>
                    <?php if (!$ima_mobo){ ?> <!-- Če ni izbrana še nobena matična plošča -->
                    <a href="pcbuilder.php?id=3" class="list-group-item list-group-item-action <?php echo ($id_strani == 3) ? 'active bg-success text-white' : ''; ?>">Matične plošče</a> <!-- Povezava do strani za izbiro matičnih plošč -->
                    <?php } ?>
                    <?php if (!$ima_ram){ ?> <!-- Če ni izbran še noben ram -->
                    <a href="pcbuilder.php?id=4" class="list-group-item list-group-item-action <?php echo ($id_strani == 4) ? 'active bg-success text-white' : ''; ?>">RAM</a> <!-- Povezava do strani za izbiro RAM-a -->
                    <?php }?>
                    <?php if (!$ima_storage){ ?> <!-- Če ni izbrana še nobena shramba -->
                    <a href="pcbuilder.php?id=6" class="list-group-item list-group-item-action <?php echo ($id_strani == 6) ? 'active bg-success text-white' : ''; ?>">Shramba</a> <!-- Povezava do strani za izbiro shrambe -->
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                
                <div class="card-header siv">
                PC Builder <!-- Glava druge kartice -->
                </div>
                <div class="card-body svetlo-siv"> <!-- Telo kartice -->
                <table class="table">
                    <?php if ($id_strani == 5) { // Če je izbrana stran 5, prikažemo vse komponente
                    echo'
                    <thead>
                        <tr> <!-- Glava tabele -->
                            <th>Komponenta</th>
                            <th></th>
                            <th>Ime</th>
                            <th>Cena</th>
                            <th></th>
                        </tr>
                    </thead>';}
                    else{ // Če je izbrana katera koli druga stran, prikažemo samo komponente, ki so na voljo na tej strani
                    echo'
                    <thead>
                        <tr> <!-- Glava tabele -->
                            <th>Slika</th>
                            <th>Ime</th>
                            <th>Cena</th>
                            <th></th>
                        </tr>';}
                    ?>
                    <tbody>
                    <?php
                                        
                if ($id_strani == 5) { // Če je izbrana stran 5, prikažemo vse komponente
                    
                    if(!$ima_cpu){?> <!-- Če cpu še ni izbran, prikaže povezavo do opcij izbora -->
                    <tr>
                        <td colspan="5" class="text-center">
                            <a href="pcbuilder.php?id=1" class="btn btn-outline-success">Izberi CPU</a> <!-- Povezava do strani za izbiro CPU -->
                        </td>
                    </tr>
                    <?php
                    }

                    if($ima_cpu){ // Če je CPU izbran, prikažemo informacije o CPU
                        $sql = "SELECT * FROM rso_cpu WHERE id = ?"; // SQL poizvedba, ki izbere vse informacije o CPU-ju
                        $stmt = $db->prepare($sql);
                        if ($stmt) {
                            $stmt->bind_param("i", $id_cpu);
                            $stmt->execute();
                            $rezultat = $stmt->get_result();
                            $stmt->close();
                            
                            if ($rezultat && $rezultat->num_rows > 0) { // Preverimo ali je rezultat poizvedbe prazen, če ni potem se izvede spodnji del
                                $user = $rezultat->fetch_assoc();
                                echo "<tr>
                                        <td>CPU</td> <!-- Prikaz imena komponente -->
                                        <td>
                                            <a href='prikaz.php?id=" . $user['id'] . "&num=" . $user['tip'] . "' class='text-decoration-none text-body'> <!-- Povezava do strani za prikaz CPU-ja -->
                                                " . '<img alt="Product Image" class="img-fluid d-block mx-auto" style="width:70px" src="data:image/jpeg;base64,' . base64_encode($user['slika1']) . '"/>' . " <!-- Prikaz slike komponente -->
                                            </a>
                                        </td>
                                        <td>
                                            <a href='prikaz.php?id=" . $user['id'] . "&num=" . $user['tip'] . "' class='text-decoration-none text-body'> <!-- Povezava do strani za prikaz CPU-ja -->
                                                " . htmlspecialchars($user['ime']) . " <!-- Prikaz imena komponente -->
                                            </a>
                                        </td>
                                        <td>" . number_format($user['cena'], 2) . " €</td> <!-- Prikaz cene komponente -->
                                        <td>
                                            <a href='odstrani_iz_pcbuilderja.php?id=" . $pc_user['id'] . "&type=CPU' onclick=\"showToast('Odstranjeno: " . htmlspecialchars($user['ime']) . "')\"> <!-- Gumb za odstranitev CPU-ja in povezava do skripte, ki to izvede -->
                                                <button class='btn btn-danger'>Odstrani</button>
                                            </a>
                                        </td>
                                    </tr>";
                            }
                        }
                    }

                    if(!$ima_gpu){?> <!-- Če gpu še ni izbran, prikaže povezavo do opcij izbora -->
                    <tr>
                        <td colspan="5" class="text-center">
                            <a href="pcbuilder.php?id=2" class="btn btn-outline-success">Izberi GPU</a> <!-- Povezava do strani za izbiro GPU -->
                        </td>
                    </tr>
                    <?php
                    }
                    
                    if($ima_gpu){ // Če je GPU izbran, prikažemo informacije o GPU
                        $sql = "SELECT * FROM rso_gpu WHERE id = ?"; // SQL poizvedba
                        $stmt = $db->prepare($sql); 
                        if ($stmt) {
                            $stmt->bind_param("i", $id_gpu);
                            $stmt->execute();
                            $rezultat = $stmt->get_result();
                            $stmt->close();
                            
                            if ($rezultat && $rezultat->num_rows > 0) { // Preverimo ali je rezultat poizvedbe prazen, če ni potem se izvede spodnji del
                                $user = $rezultat->fetch_assoc();
                                echo "<tr>
                                        <td>GPU</td> <!-- Prikaz imena komponente --> 
                                        <td>
                                            <a href='prikaz.php?id=" . $user['id'] . "&num=" . $user['tip'] . "' class='text-decoration-none text-body'> <!-- Povezava do strani za prikaz GPU-ja -->
                                                " . '<img alt="Product Image" class="img-fluid d-block mx-auto" style="width:70px" src="data:image/jpeg;base64,' . base64_encode($user['slika1']) . '"/>' . " <!-- Prikaz slike komponente -->
                                            </a>
                                        </td>
                                        <td>
                                            <a href='prikaz.php?id=" . $user['id'] . "&num=" . $user['tip'] . "' class='text-decoration-none text-body'> <!-- Povezava do strani za prikaz GPU-ja -->
                                                " . htmlspecialchars($user['ime']) . " <!-- Prikaz imena komponente -->
                                            </a>
                                        </td>
                                        <td>" . number_format($user['cena'], 2) . " €</td> <!-- Prikaz cene komponente -->
                                        <td>
                                            <a href='odstrani_iz_pcbuilderja.php?id=" . $pc_user['id'] . "&type=GPU' onclick=\"showToast('Odstranjeno: " . htmlspecialchars($user['ime']) . "')\"> <!-- Gumb za odstranitev GPU-ja in povezava do skripte, ki to izvede -->
                                                <button class='btn btn-danger'>Odstrani</button>
                                            </a>
                                        </td>
                                    </tr>";
                            }
                        }
                    }
                    
                    if(!$ima_mobo){?> <!-- Če matična plošča še ni izbrana, prikaže povezavo do opcij izbora -->
                    <tr>
                        <td colspan="5" class="text-center">
                            <a href="pcbuilder.php?id=3" class="btn btn-outline-success">Izberi matično ploščo</a> <!-- Povezava do strani za izbiro matične plošče -->
                        </td>
                    </tr>
                    <?php
                    }

                    if($ima_mobo){ // Če je matična plošča izbrana, prikažemo informacije o matični plošči
                        $sql = "SELECT * FROM rso_mobo WHERE id = ?"; // SQL poizvedba
                        $stmt = $db->prepare($sql);
                        if ($stmt) {
                            $stmt->bind_param("i", $id_mobo); // Pridobi id mobo iz zadnjega vnosa
                            $stmt->execute();
                            $rezultat = $stmt->get_result();
                            $stmt->close();
                            
                            if ($rezultat && $rezultat->num_rows > 0) { // Preverimo ali je rezultat poizvedbe prazen, če ni potem se izvede spodnji del
                                $user = $rezultat->fetch_assoc();
                                echo "<tr>
                                        <td>MATIČNA PLOŠČA</td> <!-- Prikaz imena komponente -->
                                        <td>
                                            <a href='prikaz.php?id=" . $user['id'] . "&num=" . $user['tip'] . "' class='text-decoration-none text-body'> <!-- Povezava do strani za prikaz matične plošče -->
                                                " . '<img alt="Product Image" class="img-fluid d-block mx-auto" style="width:70px" src="data:image/jpeg;base64,' . base64_encode($user['slika1']) . '"/>' . " <!-- Prikaz slike komponente -->
                                            </a>
                                        </td>
                                        <td>
                                            <a href='prikaz.php?id=" . $user['id'] . "&num=" . $user['tip'] . "' class='text-decoration-none text-body'> <!-- Povezava do strani za prikaz matične plošče -->
                                                " . htmlspecialchars($user['ime']) . " <!-- Prikaz imena komponente -->
                                            </a>
                                        </td>
                                        <td>" . number_format($user['cena'], 2) . " €</td> <!-- Prikaz cene komponente -->
                                        <td>
                                            <a href='odstrani_iz_pcbuilderja.php?id=" . $pc_user['id'] . "&type=MOBO' onclick=\"showToast('Odstranjeno: " . htmlspecialchars($user['ime']) . "')\"> <!-- Gumb za odstranitev matične plošče in povezava do skripte, ki to izvede -->
                                                <button class='btn btn-danger'>Odstrani</button>
                                            </a>
                                        </td>
                                    </tr>";
                            }
                        }
                    }
                    
                    if(!$ima_ram){?> <!-- Če ram še ni izbran, prikaže povezavo do opcij izbora -->
                    <tr>
                        <td colspan="5" class="text-center">
                            <a href="pcbuilder.php?id=4" class="btn btn-outline-success">Izberi RAM</a> <!-- Povezava do strani za izbiro RAM-a -->
                        </td>
                    </tr>
                    <?php
                    }

                    if($ima_ram){ // Če je RAM izbran, prikažemo informacije o RAM-u
                        $sql = "SELECT * FROM rso_ram WHERE id = ?"; // SQL poizvedba
                        $stmt = $db->prepare($sql);
                        if ($stmt) {
                            $stmt->bind_param("i", $id_ram); // Pridobi id ram iz zadnjega vnosa
                            $stmt->execute();
                            $rezultat = $stmt->get_result();
                            $stmt->close();
                            
                            if ($rezultat && $rezultat->num_rows > 0) { // Preverimo ali je rezultat poizvedbe prazen, če ni potem se izvede spodnji del
                                $user = $rezultat->fetch_assoc();
                                echo "<tr>
                                        <td>RAM</td> <!-- Prikaz imena komponente -->
                                        <td>
                                            <a href='prikaz.php?id=" . $user['id'] . "&num=" . $user['tip'] . "' class='text-decoration-none text-body'> <!-- Povezava do strani za prikaz RAM-a -->
                                                " . '<img alt="Product Image" class="img-fluid d-block mx-auto" style="width:70px" src="data:image/jpeg;base64,' . base64_encode($user['slika1']) . '"/>' . " <!-- Prikaz slike komponente -->
                                            </a>
                                        </td>
                                        <td>
                                            <a href='prikaz.php?id=" . $user['id'] . "&num=" . $user['tip'] . "' class='text-decoration-none text-body'> <!-- Povezava do strani za prikaz RAM-a -->
                                                " . htmlspecialchars($user['ime']) . " <!-- Prikaz imena komponente -->
                                            </a>
                                        </td>
                                        <td>" . number_format($user['cena'], 2) . " €</td> <!-- Prikaz cene komponente -->
                                        <td>
                                            <a href='odstrani_iz_pcbuilderja.php?id=" . $pc_user['id'] . "&type=RAM' onclick=\"showToast('Odstranjeno: " . htmlspecialchars($user['ime']) . "')\"> <!-- Gumb za odstranitev RAM-a in povezava do skripte, ki to izvede -->
                                                <button class='btn btn-danger'>Odstrani</button>
                                            </a>
                                        </td>
                                    </tr>";
                            }
                        }
                    }
                    
                    if(!$ima_storage){?> <!-- Če shramba še ni izbrana, prikaže povezavo do opcij izbora -->
                    <tr>
                        <td colspan="5" class="text-center">
                            <a href="pcbuilder.php?id=6" class="btn btn-outline-success">Izberi shrambo</a> <!-- Povezava do strani za izbiro shrambe -->
                        </td>
                    </tr>
                    <?php
                    }

                    if($ima_storage){ // Če je shramba izbrana, prikažemo informacije o shrambe
                        $sql = "SELECT * FROM rso_storage WHERE id = ?"; // SQL poizvedba
                        $stmt = $db->prepare($sql);
                        if ($stmt) {
                            $stmt->bind_param("i", $id_storage); // Pridobi id storage iz zadnjega vnosa
                            $stmt->execute();
                            $rezultat = $stmt->get_result();
                            $stmt->close();
                            
                            if ($rezultat && $rezultat->num_rows > 0) { // Preverimo ali je rezultat poizvedbe prazen, če ni potem se izvede spodnji del
                                $user = $rezultat->fetch_assoc();
                                echo "<tr>
                                        <td>SHRAMBA</td> <!-- Prikaz imena komponente -->
                                        <td>
                                            <a href='prikaz.php?id=" . $user['id'] . "&num=" . $user['tip'] . "' class='text-decoration-none text-body'> <!-- Povezava do strani za prikaz shrambe -->
                                                " . '<img alt="Product Image" class="img-fluid d-block mx-auto" style="width:70px" src="data:image/jpeg;base64,' . base64_encode($user['slika1']) . '"/>' . " <!-- Prikaz slike komponente -->
                                            </a>
                                        </td>
                                        <td>
                                            <a href='prikaz.php?id=" . $user['id'] . "&num=" . $user['tip'] . "' class='text-decoration-none text-body'> <!-- Povezava do strani za prikaz shrambe -->
                                                " . htmlspecialchars($user['ime']) . " <!-- Prikaz imena komponente -->
                                            </a>
                                        </td>
                                        <td>" . number_format($user['cena'], 2) . " €</td> <!-- Prikaz cene komponente -->
                                        <td>
                                            <a href='odstrani_iz_pcbuilderja.php?id=" . $pc_user['id'] . "&type=STORAGE' onclick=\"showToast('Odstranjeno: " . htmlspecialchars($user['ime']) . "')\"> <!-- Gumb za odstranitev shrambe in povezava do skripte, ki to izvede -->
                                                <button class='btn btn-danger'>Odstrani</button>
                                            </a>
                                        </td>
                                    </tr>";
                            }
                        }
                    }
                }
                   
                if($id_strani !=5){  // Če id_strani ni 5, prikažemo vse komponente
                    if($id_strani == 1) {
                        $rezultat=$cpu; // Prikaz CPU-jev
                    } elseif ($id_strani == 2) {
                        $rezultat=$gpu; // Prikaz GPU-jev
                    } elseif ($id_strani == 3) {
                        $rezultat=$mobo; // Prikaz matičnih plošč
                    } elseif ($id_strani == 4) {
                        $rezultat=$ram; // Prikaz RAM-ov
                    } elseif ($id_strani == 6) {
                        $rezultat=$shramba; // Prikaz shrambe
                    }              
                    while ($user = $rezultat->fetch_assoc()): ?> <!-- Zanka za prikaz komponent -->
                        <tr>
                            <td>
                                <a href="prikaz.php?id=<?php echo $user['id']; ?>&num=<?php echo $user['tip']; ?>" class="text-decoration-none text-body"> <!-- Povezava do strani za prikaz komponente -->
                                    <?php echo '<img alt="Product Image" class="img-fluid d-block mx-auto" style="width:70px" src="data:image/jpeg;base64,' . base64_encode($user['slika1']) . '"/>'; ?> <!-- Prikaz slike komponente -->
                                </a>
                            </td>
                            <td>
                                <a href="prikaz.php?id=<?php echo $user['id']; ?>&num=<?php echo $user['tip']; ?>" class="text-decoration-none text-body"> <!-- Povezava do strani za prikaz komponente -->
                                    <?php echo htmlspecialchars($user['ime']); ?> <!-- Prikaz imena komponente -->
                                </a>
                            </td>
                            <td><?php echo number_format($user['cena'], 2); ?> €</td> <!-- Prikaz cene komponente -->
                            <td>
                                <a href="add_to_pcbuilder.php?id_strani=<?php echo $id_strani; ?>&id=<?php echo $user['id']; ?>" onclick="showToast('<?php echo htmlspecialchars($user['ime']); ?>')"> <!-- Povezava do skripte za dodajanje komponente v PC Builder -->
                                    <button class="btn btn-success">Dodaj</button> <!-- Gumb za dodajanje komponente -->
                                </a>
                            </td>
                            
                        </tr>
                    <?php endwhile; // Konec zanke za prikaz komponent
                }
                    ?>
                    </tbody>
                </table>
                    <div class="text-end"><b>Skupna cena:</b> <!-- Prikaz skupne cene -->
                        <?php echo skupnaCenaPcBuilda($db); ?> <!-- Funkcija za izračun skupne cene -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php echo footer(); ?>

</body>
</html>