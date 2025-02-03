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
    <title>Iskanje</title>
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
<div class="col-sm-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam obcaecati maxime nihil dolorum perferendis odio dolores hic enim illo architecto laudantium sit quibusdam, quidem quod totam delectus. Laborum, harum explicabo!</div>
<div class="col-sm-6 border border dark p-5">
  <?php
    $a=0;
    $search=$_GET['search'];
    $sql = "SELECT COUNT(*) FROM rso_gpu WHERE ime LIKE '%$search%'";
    $rezultat=($db->query($sql));
    $user=$rezultat->fetch_assoc()["COUNT(*)"];
    if($user>=1){
        for($i=1; $i<$user+1; $i++){
            
        $sql1 = "SELECT slika1,ime FROM rso_gpu WHERE id= '$i' limit 1";
        $rezultat1=($db->query($sql1));
        $user1=$rezultat1->fetch_assoc();
        echo"<a href='prikaz_gpu.php?id=$i' class='text-decoration-none text-body'>
        <div class='row box my-3 py-3 border border-dark rounded'>
        <div class='col-sm-4'>
        <img src='$user1[slika1]' class='rounded' height='50'> 
        </div>
        <div class='col-sm-8'>$user1[ime]</div>
        </div>
        </a>
        ";
        }
        $a++;
    }

    $sql = "SELECT COUNT(*) FROM rso_cpu WHERE ime LIKE '%$search%'";
    $rezultat=($db->query($sql));
    $user=$rezultat->fetch_assoc()["COUNT(*)"];
    if($user>=1){
        for($i=1; $i<$user+1; $i++){
            
        $sql1 = "SELECT slika1,ime FROM rso_cpu WHERE id= '$i' limit 1";
        $rezultat1=($db->query($sql1));
        $user1=$rezultat1->fetch_assoc();
        echo"<a href='prikaz_gpu.php?id=$i' class='text-decoration-none text-body'>
        <div class='row box my-3 py-3 border border-dark rounded'>
        <div class='col-sm-4'>
        <img src='$user1[slika1]' class='rounded' height='50'> 
        </div>
        <div class='col-sm-8'>$user1[ime]</div>
        </div>
        </a>
        ";
        }
        $a++;
    }

    $sql = "SELECT COUNT(*) FROM rso_ram WHERE ime LIKE '%$search%'";
    $rezultat=($db->query($sql));
    $user=$rezultat->fetch_assoc()["COUNT(*)"];
    if($user>=1){
        for($i=1; $i<$user+1; $i++){
            
        $sql1 = "SELECT slika1,ime FROM rso_ram WHERE id= '$i' limit 1";
        $rezultat1=($db->query($sql1));
        $user1=$rezultat1->fetch_assoc();
        echo"<a href='prikaz_gpu.php?id=$i' class='text-decoration-none text-body'>
        <div class='row box my-3 py-3 border border-dark rounded'>
        <div class='col-sm-4'>
        <img src='$user1[slika1]' class='rounded' height='50'> 
        </div>
        <div class='col-sm-8'>$user1[ime]</div>
        </div>
        </a>
        ";
        }
        $a++;
    }

    $sql = "SELECT COUNT(*) FROM rso_mobo WHERE ime LIKE '%$search%'";
    $rezultat=($db->query($sql));
    $user=$rezultat->fetch_assoc()["COUNT(*)"];
    if($user>=1){
        for($i=1; $i<$user+1; $i++){
            
        $sql1 = "SELECT slika1,ime FROM rso_mobo WHERE id= '$i' limit 1";
        $rezultat1=($db->query($sql1));
        $user1=$rezultat1->fetch_assoc();
        echo"<a href='prikaz_gpu.php?id=$i' class='text-decoration-none text-body'>
        <div class='row box my-3 py-3 border border-dark rounded'>
        <div class='col-sm-4'>
        <img src='$user1[slika1]' class='rounded' height='50'> 
        </div>
        <div class='col-sm-8'>$user1[ime]</div>
        </div>
        </a>
        ";
        }
        $a++;
    }

    $sql = "SELECT COUNT(*) FROM rso_rac WHERE ime LIKE '%$search%'";
    $rezultat=($db->query($sql));
    $user=$rezultat->fetch_assoc()["COUNT(*)"];
    if($user>=1){
        for($i=1; $i<$user+1; $i++){
            
        $sql1 = "SELECT slika1,ime FROM rso_rac WHERE id= '$i' limit 1";
        $rezultat1=($db->query($sql1));
        $user1=$rezultat1->fetch_assoc();
        echo"<a href='prikaz_gpu.php?id=$i' class='text-decoration-none text-body'>
        <div class='row box my-3 py-3 border border-dark rounded'>
        <div class='col-sm-4'>
        <img src='$user1[slika1]' class='rounded' height='50'> 
        </div>
        <div class='col-sm-8'>$user1[ime]</div>
        </div>
        </a>
        ";
        }
        $a++;
    }
    if($a==0){
        echo"Vase iskanje ne ustraza nobenemu izdelku";
    }
  ?>
</div>
<div class="col-sm-3">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aspernatur quidem et quisquam, dolore ab illum necessitatibus sit, distinctio quos, a quam fugiat dolorum animi. Facere cupiditate debitis fugit mollitia totam.</div>



</div>


<footer class="container-fluid siv border-top border-dark text-center pt-4 pb-0 mb-0 fixed-bottom">
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