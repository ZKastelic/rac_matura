<?php
session_start(); // Začne sejo
session_unset(); // Počisti vse spremenljivke seje
header("Location: index.php"); // Preusmeri uporabnika na začetno stran
?>