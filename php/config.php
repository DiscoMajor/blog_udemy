<?php

try{
    $bdd = new PDO('mysql:localhost;dbname=blog;charset=utf8', 'root', ''
        );
} catch (Exception $e) {
    exit('Erreur: '.$e->getMessage());
}