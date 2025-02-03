<?php
session_start();
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
    <title>Dodaj rac</title>
</head>
<body>
    
<nav class="navbar navbar-expand-sm temno-siv text-light text-opacity-50 my-0 py-0 fs-6">
        <div class="col d-flex justify-content-center">Samo danes 15% popusta na vse</div>
        <div class="col d-flex justify-content-center"><a href="https://x.com/home" class="link-underline link-underline-opacity-0 link-secondary"><i class="fa-brands fa-x-twitter m-2"></i></a>
        <a href="https://www.facebook.com/" class="link-underline link-underline-opacity-0 link-secondary"><i class="fa-brands fa-facebook m-2" href=""></i></a>
        <a href="https://www.instagram.com/" class="link-underline link-underline-opacity-0 link-secondary"><i class="fa-brands fa-instagram m-2"></i></a></div>
</nav>
    
    <nav class="navbar navbar-expand-sm siv">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"></a>
          <img src="slike/logo-seminarska.png" class="img-fluid" alt="Logo" style="width:100px;">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav flex-row flex-wrap col-3">
              <li class="nav-item">
                <a class="nav-link text-dark" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark" href="search_rac.php">Racunalniki</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Komponente</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="search_gpu.php">GPU</a></li>
                  <li><a class="dropdown-item" href="search_cpu.php">CPU</a></li>
                  <li><a class="dropdown-item" href="search_ram.php">RAM</a></li>
                  <li><a class="dropdown-item" href="search_mobo.php">Maticne plosce</a></li>
                </ul>
              </li>
            </ul>
            <div class="col-6">
              <form class="d-flex" method="get" action="iskanje.php">
                <input class="form-control me-1" type="text" placeholder="Iskalnik" name="search">
                  <button class="btn btn-secondary srednje-siv text-dark me-3 border-none" style="border: none;" type="submit">Search</button>
              </form>
            </div>
            <ul class="navbar-nav flex-row flex-wrap ms-auto col-3">
              
            <li class="nav-item me-3">

            <?php
                require_once('db.php');
                if(isset($_SESSION['username'])){
                $username=$_SESSION['username'];
                $sql = "SELECT ime FROM rso_prijava WHERE username = '$username' limit 1";
                $rezultat=($db->query($sql));
                $user=$rezultat->fetch_assoc();
                echo '<p class="text-center mt-2">Pozdravljen '."$user[ime]".'</p>';
                echo '<li class="nav-item">
                <a class="nav-link text-dark px-2" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>
                </li>';

                }
                else{
                echo '<a class="nav-link text-dark" href="login.php">Login/Signup</a>';}
                
              ?>

            </li>
              <li class="nav-item px-2">
                <a class="nav-link text-dark" href="shopping_cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
              </li>
            <?php
              if(isset($_SESSION['username'])){
                    
                $username=$_SESSION['username'];
                $geslo=$_SESSION['geslo'];
                $sql = "SELECT ime FROM rso_prijava WHERE username = '$username' limit 1";
                $rezultat=($db->query($sql));
                $user=$rezultat->fetch_assoc();
                if($username == 'zkas' and $geslo =='pass'){
                  echo'<li class="nav-item">
                      <div class="dropdown">
                        <button type="button" class="btn dropdown-toggle srednje-siv" style="border: none;" data-bs-toggle="dropdown">
                          Dodaj izdelke
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="dodaj_ram.php">Dodaj RAM</a></li>
                          <li><a class="dropdown-item" href="dodaj_cpu.php">Dodaj CPU</a></li>
                          <li><a class="dropdown-item" href="dodaj_mobo.php">Dodaj mobo</a></li>
                          <li><a class="dropdown-item" href="dodaj_gpu.php">Dodaj GPU</a></li>
                          <li><a class="dropdown-item" href="dodaj_rac.php">Dodaj Racunalnik</a></li>
                        </ul>
                      </div>
                    </li>';
                }
              }
            ?>
            </ul>
            <hr>
            
            </div>
          </div>
        </div>
    </nav>

    <div class="row w-100">
        <div class="col-sm-4"></div>
        <div class="col-sm-4 py-5 mt-5 border border-dark-subtle rounded-3 siv">
            <h3 class="pb-3">Dodaj dodaten Racunalnik</h3>
          <form action="" method="post">
            <div class="form-floating my-3">
                <input type="text" class="form-control" name="ime" placeholder="Ime">
                <label for="ime">Ime racunalnika</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="slika1" placeholder="slika1">
                <label for="slika1">Lokacija slike 1 (slike/imeslike.filetype)</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="slika2" placeholder="slika2">
                <label for="slika2">Lokacija slike 2 (slike/imeslike.filetype)</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="slika3" placeholder="slika3">
                <label for="slika3">Lokacija slike 3 (slike/imeslike.filetype)</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="cpu" placeholder="cpu">
                <label for="cpu">Ime procesorja</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="mobo" placeholder="mobo">
                <label for="mobo">Ime maticne plosce</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="gpu" placeholder="gpu">
                <label for="gpu">Ime /graficne kartice</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="ram" placeholder="ram">
                <label for="ram">Ime RAMA</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="shramba" placeholder="shramba">
                <label for="shramba">Ime shrambe</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="cena" placeholder="cena">
                <label for="cena">Cena racunalnika v EUR</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="zaloga" placeholder="zaloga">
                <label for="zaloga">Stevilo izdelkov na zalogi</label>
            </div>
            <div class="form mb-3">
              <label for="opis" class="form-label">Opis Racunalnika: </label>
              <textarea class="form-control" rows="3" id="opis" name="opis"></textarea>
            </div>
            <button type="submit" class="btn btn-info mt-3"> Dodaj</button>
          </form>
          
        </div>
        <div class="col-sm-4"></div>

    </div>
<?php

if(!empty($_POST)){
    require_once('db.php');

    $ime=$_POST['ime'];
    $slika1=$_POST['slika1'];
    $slika2=$_POST['slika2'];
    $slika3=$_POST['slika3'];
    $cpu=$_POST['cpu'];
    $mobo=$_POST['mobo'];
    $gpu=$_POST['gpu'];
    $ram=$_POST['ram'];
    $shramba=$_POST['shramba'];
    $cena=$_POST['cena'];
    $zaloga=$_POST['zaloga'];
    $opis=$_POST['opis'];

$sql="insert into rso_rac (ime, slika1, slika2, slika3, cpu, mobo, gpu, ram, shramba, cena, zaloga, opis) values ('$ime','$slika1','$slika2','$slika3','$cpu','$mobo','$gpu','$ram','$shramba','$cena','$zaloga','$opis')";

if($db->query($sql)){
  echo"<div class='alert alert-success'> vnos uspesen </div>";
}
else    
echo"<div class='alert alert-danger'> napaka </div>";
}
?>


    <footer class="container-fluid siv border-top border-dark p-3 text-center pt-4 pb-0 mb-0 mt-5">
        <div class="row siv">
          <div class="col-sm-3"></div>
          <div class="col-sm-3"><img src="slike/logo-seminarska.png" style="max-height: 70px;"></div>
          <div class="col-sm-3 d-flex align-items-center"><p class="text-center"><i class="fa-regular fa-copyright"></i> 11.2024 - 12.2024, Shopotron</p></div>
          <div class="col-sm-3"></div>
        </div>
        <div class="row">
          <div class="col-sm-3"></div>
          <div class="col-sm-6"><hr></div>
          <div class="col-sm-3"></div>
      
      
        </div>
      
        <div class="row siv">
          <div class="col-sm-4"><h6>Contact us</h6></div>
          <div class="col-sm-4 text-center"><h6>Poslovalnica</h6>
            <ul class="text-center list-group-flush siv">
              <li class="list-group-item siv">Solski center Novo mesto</li>
              <li class="list-group-item siv">8000 Novo mesto</li>
              <li class="list-group-item siv">Slovenija</li>
            </ul>
          </div>
          <div class="col-sm-4">
            <img src="slike/mastercard.png" class="img-fluid" style="max-height: 70px;">
            <img src="slike/visa.png" class="img-fluid"style="max-height: 70px;">
            <img src="slike/flik.png" class="img-fluid"style="max-height: 70px;">
          </div>
        </div>
      </footer>

</body>
</html>