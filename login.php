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
    <title>Log in</title>
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
        <div class="col-sm-4 py-5 my-5 border border-dark-subtle rounded-3 siv">
            <h3>Vpisite se v svoj racun</h3>
          <form action="prijava.php" method="post">
          <div class="form-floating my-3">
                <input type="text" class="form-control" name="username" placeholder="Username">
                <label for="username">Uporabnisko ime</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" name="geslo" placeholder="Geslo">
                <label for="geslo">Geslo</label>
            </div>
            <!--
            <div class="form-check my-3">
              <label for="form-check-label"></label>
              <input type="checkbox" class="form-check-input " name="remember-me">Zapomni se me
            </div> -->
            <button type="submit" class="btn srednje-siv mt-3">Vpisi se</button>
          </form>

          <hr>
          <p class="pt-3">Se nimas racuna?</p>
          <button class="btn srednje-siv">
          <a href="signup.php" class="text-body text-decoration-none">Prijavi se</a>
          </button>
        </div>
        <div class="col-sm-4"></div>

    </div>


    <footer class="container-fluid siv border-top border-dar text-center pt-4 pb-0 mb-0 fixed-bottom">
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