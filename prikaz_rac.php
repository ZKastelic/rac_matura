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
    <title>Prikaz rac</title>
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

<div class="container-xs m-3 py-3">
    <div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-6">
      <div class="row pb-5">
        <div class="col-sm-6">
          
                <?php
              $id=$_GET['id'];
              $sql = "SELECT * FROM rso_rac WHERE id=$id limit 1";
              $rezultat=($db->query($sql));
              $user=$rezultat->fetch_assoc();
              echo"<div id='4090-fe' class='carousel slide' data-bs-ride='carousel'>
              <div class='carousel-indicators'>
              <button type='button' data-bs-target='#4090-fe' data-bs-slide-to='0' class='active'></button>
              <button type='button' data-bs-target='#4090-fe' data-bs-slide-to='1'></button>
              <button type='button' data-bs-target='#4090-fe' data-bs-slide-to='2'></button>
              </div>
              <div class='carousel-inner svetlo-siv'>
              <div class='carousel-item active rounded'>
                  <img src='$user[slika1]' class='img-fluid d-block mx-auto'>
              </div>
              <div class='carousel-item'>
                  <img src='$user[slika2]' class='img-fluid d-block mx-auto'>
              </div>
              <div class='carousel-item'>
                  <img src='$user[slika3]' class='img-fluid d-block mx-auto'>
              </div>
              </div>
              <button class='carousel-control-prev w-60' type='button' data-bs-target='#4090-fe' data-bs-slide='prev'>
              <span class='carousel-control-prev-icon'></span>
              </button>
              <button class='carousel-control-next w-60' type='button' data-bs-target='#4090-fe' data-bs-slide='next'>
              <span class='carousel-control-next-icon'></span>
              </button>
              </div>
              
        </div>
        <div class='col-sm-6'>
          <h3>$user[ime]</h3>
          <hr>
          <table>
            <tr>
              <td class='col-sm-3 fw-bold'>Ime procesorja</td>
              <td class='col-sm-9'>$user[cpu]</td>
            </tr>
            <tr>
              <td class='col-sm-3 fw-bold'>Ime maticne plosce</td>
              <td class='col-sm-9'>$user[mobo]</td>
            </tr>
            <tr>
              <td class='col-sm-3 fw-bold'>Ime graficne kartice</td>
              <td class='col-sm-9'>$user[gpu]</td>
            </tr>
            <tr>
              <td class='col-sm-3 fw-bold'>Ime RAMA</td>
              <td class='col-sm-9'>$user[ram]</td>
            </tr>
            <tr>
              <td class='col-sm-3 fw-bold'>Ime shrambe</td>
              <td class='col-sm-9'>$user[shramba]</td>
            </tr>
          </table>
        </div>
      </div>
      <div class='row p-3 pt-5'>
        <div class='col'><p>$user[opis]</p>
        </div>
      </div>
    </div>
    <div class='col-sm-2 p-5 my-5 border border-dark-subtle rounded-3 svetlo-siv h-100'>
      <p class='fw-bold lead fs-2'>$user[cena] EUR</p>
      <p>Cena vklucuje DDV</p>";
      if($user['zaloga']>=1)echo"<p class='py-2 fs-4'><i class='fa-solid fa-circle-check'></i> Je navoljo</p>";
      else echo"<p class='py-2 fs-4'><i class='fa-solid fa-circle-xmark'></i> Ni navoljo</p>";
      echo"<form action='#' method='post'>
          <select class='form-select mb-3 w-25'>
          <option value='1'>1</option>
          <option value='2'>2</option>
          <option value='3'>3</option>
          <option value='4'>4</option>
          <option value='5'>5</option>
        </select>
        <button class='btn btn-secondary btn-outline-dark text-dark' type='submit'>Dodaj v kosarico</button>
      </form>
    </div>
    <div class='col-sm-2'></div>
</div>
</div>
";
?>


<footer class="container-fluid siv border-top border-dark p-3 text-center py-4 pb-0 mb-0">
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