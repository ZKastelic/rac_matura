<?php
    define('DB_URL','127.0.0.1');  //url baze
    define('DB_NAME','rac_matura'); //ime baze
    define('DB_PASS','GJ6hWDKjpJN2kFmw'); //geslo za dostop do baze
    define ('DB_DB','rac_matura'); //ime baze znotraj povezave

    $db=new mysqli(DB_URL,DB_NAME, DB_PASS, DB_DB);
?>