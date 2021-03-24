<?php
// Info de connexion
$dbServ = "localhost";
$dbName = "facebookcfpt";
$dbUser = "root";
$dbPwd = "";

// Connexion à la bdd par un PDO
$bdd = new PDO("mysql:host=$dbServ;dbname=$dbName", $dbUser, $dbPwd);

// Selectionner tout dans la bdd
$medias = $bdd->query('SELECT * FROM `media`');

// Ajouter dans la bdd
$insertMedia = $bdd->prepare('INSERT INTO `media` (`typeMedia`, `nomMedia`, `creationDate`, `nomMediaGenere`) VALUES (?, ?, ?, ?);');

// Supprimer dans la bdd
$deleteMedia = $bdd->prepare('DELETE FROM `media` WHERE idMedia = ?;');

// Modification dans la bdd
$modifMedia = $bdd->prepare('UPDATE `media` SET typeMedia = ?, `nomMedia` = ?, nomMediaGenere = ?, modificationDate = ? WHERE `idMedia` = ?;');


/*$selectOnlyName = $bdd->prepare("SELECT nomMediaGenere FROM media WHERE idMedia = ?;");
$selectOnlyType = $bdd->prepare("SELECT typeMedia FROM media WHERE idMedia = ?;");*/
?>