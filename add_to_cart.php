<?php

function checkAvailability($id){
    #preveri koliko je maksimalno stevilo izdelkov, ki jih lahko dolocen kupec kupi, lahko izpise max
    #nad add to cart gumbom, za pod 10 napise malo zaloge, za zadnjih 5 kosov napise tocno stevilko zaloge
    #ce je izdelkov vec kot 10 napise se dovolj izdelkov

    $sql1 = "SELECT zaloga FROM rso_cpu WHERE id= '$i' limit 1";
      $rezultat1=($db->query($sql1));
      $user1=$rezultat1->fetch_assoc();


    return
}


function addToCart($id, $ime, $slika, $cena, $zaloga, $kolicina){
#doda v shopping cart izdelek ob pritisku gumba add to cart, ce je kupec izbral
#vec izdelkov izpise error

}

?>


