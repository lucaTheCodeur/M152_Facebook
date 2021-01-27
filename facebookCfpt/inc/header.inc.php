<?php
// Info de connexion
$dbServ = "localhost";
$dbName = "facebookcfpt";
$dbUser = "root";
$dbPwd = "";

// Connexion à la bdd par un PDO
$bdd = new PDO("mysql:host=$dbServ;dbname=$dbName", $dbUser, $dbPwd);

// prends les noms des média
$nomMedia = $bdd->query('SELECT * FROM `media`');

// Selectionner tout dans la bdd
$images = $bdd->query('SELECT * FROM `media` WHERE typeMedia = "image"');

// Ajouter dans la bdd
$insertImage = $bdd->prepare('INSERT INTO `media` (`typeMedia`, `nomMedia`, `creationDate`) VALUES (?, ?, ?);');

// Supprimer dans la bdd
$deleteImage = $bdd->prepare('DELETE FROM `media` WHERE idMedia = ? AND typeMedia = "image";');

// Modification dans la bdd
$modifImage = $bdd->prepare('UPDATE `media` SET `nomMedia` = ?, modificationDate = ? WHERE `idMedia` = ? AND typeMedia = "image";');

?>