<?php
    session_start();
    if(!empty($_POST)){ // Preveri, če spremenljivka $_POST ni prazna
            
            require_once('db.php');

            $username=$_POST['username']; // Uporabniško ime
            $geslo=$_POST['geslo']; // Geslo

            $sql="SELECT geslo FROM rso_prijava WHERE username='$username' LIMIT 1"; // SQL poizvedba za iskanje gesla

            $rezultat=($db->query($sql)); // Izvedi SQL poizvedbo
            $user = $rezultat->fetch_assoc();
            
            if ($user && $user['geslo'] == $geslo) { // Preveri, če je uporabnik najden in geslo pravilno
                $_SESSION['username']=$username; // Shrani uporabniško ime v sejo
                $_SESSION['geslo']=$geslo; // Shrani geslo v sejo
                header("Location: index.php"); // Preusmeri na index.php
            } else {
                $_SESSION['error'] = 'Napacno uporabniško ime ali geslo, poskusite ponovno.'; // Shrani sporočilo o napaki v sejo
                header("Location: login.php"); // Preusmeri na login.php
                exit();
            }
          }
?>