<?php
#tento soubor vkládám do každé stránky na webu, protože mi zajišťuje připojení k databázi

    #do proměnných si vložím umístění databáze, jméno uživatele, jeho heslo a název databaze
    $umisteni_databaze = 'localhost';
    $jmeno_databaze = 'pc_hry';
    $jmeno_uzivatele = 'root';
    $heslo_uzivatele = ''; #když bych nějaké heslo měl, vyplním
    
    $pripojeni_k_databazi = mysqli_connect($umisteni_databaze, $jmeno_uzivatele, $heslo_uzivatele, $jmeno_databaze);
    mysqli_query($pripojeni_k_databazi, "set names utf8");
    #set names utf8 nastavuji proto, aby se všechno z databáze přenášelo s kódováním utf8
?>