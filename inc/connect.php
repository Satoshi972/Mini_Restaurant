<?php
//gestion de la conection a la bdd
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=shop;charset=utf8', 'root', '');//Je cible ma base
}
catch (Exception $e) //s'il y a une erreur alors il l'affiche
{
        die('Erreur : ' . $e->getMessage());
}
//doc sql : https://sql.sh/cours/jointures
?>