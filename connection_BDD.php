<?php
try
{
$bdd = new PDO('mysql:host=monUserFTP.mysql.db;dbname=gotopmod1;charset=utf8', 'maBDD', 'motDePasse');
}
catch (Exception $e)
{

	die('Erreur : ' . $e->getMessage());
}
?>