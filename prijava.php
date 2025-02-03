<?php

    session_start();
    if(!empty($_POST)){
            
            require_once('db.php');

            $username=$_POST['username'];
            $geslo=$_POST['geslo'];

            $sql="SELECT geslo FROM rso_prijava WHERE username='$username' LIMIT 1";

            $rezultat=($db->query($sql));
              $user = $rezultat->fetch_assoc();
              $_SESSION['username']=$username;
              $_SESSION['geslo']=$geslo;
      
              if ($user['geslo'] == $geslo) {
                  header("Location: index.php");
              } else {
                  echo '<div class="alert alert-danger w-25 mx-auto text-center"> Napacno geslo, poskusite ponovno. </div>';
              }
          }
?>