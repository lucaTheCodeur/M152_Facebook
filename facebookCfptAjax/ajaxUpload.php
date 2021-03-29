<?php
session_start();

// Faire en sorte d'éviter l'écrasement de fichier en mettant un nom apart dans la bdd et en l'ajoutant à $newFilePath

// include header
include("./inc/header.inc.php");

// Suppresion d'un media
$sup = filter_input(INPUT_GET, 'sup', FILTER_SANITIZE_STRING);

// Edition d'un media
$edit = filter_input(INPUT_POST, 'editOuNon', FILTER_SANITIZE_NUMBER_INT);

// Initialisation des variables
$post = filter_input(INPUT_POST, 'postEcrit');
$submit = filter_input(INPUT_POST, 'submit');

// tailles des images
$taille_maxi = 3000000;
//$taille = filesize($_FILES['image']['tmp_name']);

// tableau avec les images à retourner en json
$files_arr = array();

// Si on clique sur le boutton submit
if (isset($_FILES['files']) && !empty($_FILES['files'])) {
	// Verification des extensions
	// Code image, video et audio
	// Nombre de fichier total
	//$total = count($_FILES['image']['tmp_name']);

	foreach ($_FILES["files"]["tmp_name"] as $i => $tmp_name) {
		// Image est égal au fichier selectionné dans le form
		$image = $_FILES['files']['name'][$i];

		// images
		if (substr($image, -3) == "png" || substr($image, -3) == "jpg" || substr($image, -3) == "PNG" || substr($image, -3) == "JPG" || substr($image, -3) == "peg" || substr($image, -3) == "PEG" && $taille > $taille_maxi) {

			// Définir le type du média
			$typeMedia = "image";
			// Fichier image
			$uploaddir = 'img/';

			$tmpFilePath = $_FILES['files']['tmp_name'][$i];

			// Si le fichier n'est pas vide
			if ($tmpFilePath != "") {

				// nom media genéré aléatoirement
				$nomMediaGenere = rand(0, 10000000) . rand(0, 10000000) . rand(0, 10000000) . $image;

				// Nouveau chemin
				$newFilePath = $uploaddir . $nomMediaGenere;

				// Si tout marche, on prend le nom de l'image et on le met dans la bdd
				if (move_uploaded_file($tmpFilePath, $newFilePath)) {
					$bdd->beginTransaction();
					if ($edit == null) {
						$insertMedia->execute(array($typeMedia, $image,  date('Y-m-d H:i:s'), $nomMediaGenere));
                        array_push($files_arr, $newFilePath);
					} else {
						/*// supprime l'ancienne image
						$selectOnlyName->execute(array($edit));
						$selectOnlyType->execute(array($edit));
						$ResultName = $selectOnlyName->fetchAll();
						$ResultType = $selectOnlyType->fetchAll();

						if ($ResultType == "image")
							unlink("./img/" . $ResultName);
						if ($ResultType == "video")
							unlink("./video/" . $ResultName);
						if ($ResultType == "audio")
							unlink("./audio/" . $ResultName);
						*/

						// update l'ancienne image pour la nouvelle
						$modifMedia->execute(array($typeMedia, $image, $nomMediaGenere, date('Y-m-d H:i:s'), $edit));
						unlink($uploaddir . $_SESSION["prevName"]);
                        array_push($files_arr, $newFilePath);
					}
					$bdd->commit();
					//header("Location: facebook.php");
				}
			}
		} else {
			// Sinon le média n'est pas accepter
			//echo "le média n'est pas accepté.";
		}
		// Video
		// Verification des extensions
		if (substr($image, -3) == "mp4") {

			// Définir le type du média
			$typeMedia = "video";
			// Fichier vidéo
			$uploaddir = './video/';

			$tmpFilePath = $_FILES['files']['tmp_name'][$i];

			// Si le fichier n'est pas vide
			if ($tmpFilePath != "") {

				// nom media genéré aléatoirement
				$nomMediaGenere = rand(0, 10000000) . rand(0, 10000000) . rand(0, 10000000) . $image;

				// Nouveau chemin
				$newFilePath = $uploaddir . $nomMediaGenere;

				// Si tout marche, on prend le nom de l'image et on le met dans la bdd
				if (move_uploaded_file($tmpFilePath, $newFilePath)) {
					$bdd->beginTransaction();
					if ($edit == null) {
						$insertMedia->execute(array($typeMedia, $image,  date('Y-m-d H:i:s'), $nomMediaGenere));
                        array_push($files_arr, $newFilePath);
					} else {
						$modifMedia->execute(array($typeMedia, $image, $nomMediaGenere, date('Y-m-d H:i:s'), $edit));
						unlink($uploaddir . $_SESSION["prevName"]);
                        array_push($files_arr, $newFilePath);
					}
					$bdd->commit();
					//header("Location: facebook.php");
				}
			}
		} else {
			// Sinon la vidéo n'est pas en mp4 ou gif
			//echo "source en mp4.";
		}
		// Audio
		// Verification des extensions
		if (substr($image, -3) == "wav" || substr($image, -3) == "mp3") {

			// Définir le type du média
			$typeMedia = "audio";
			// Fichier vidéo
			$uploaddir = './audio/';

			$tmpFilePath = $_FILES['files']['tmp_name'][$i];

			// Si le fichier n'est pas vide
			if ($tmpFilePath != "") {

				// nom media genéré aléatoirement
				$nomMediaGenere = rand(0, 10000000) . rand(0, 10000000) . rand(0, 10000000) . $image;

				// Nouveau chemin
				$newFilePath = $uploaddir . $nomMediaGenere;

				// Si tout marche, on prend le nom de l'image et on le met dans la bdd
				if (move_uploaded_file($tmpFilePath, $newFilePath)) {
					$bdd->beginTransaction();
					if ($edit == null) {
						$insertMedia->execute(array($typeMedia, $image,  date('Y-m-d H:i:s'), $nomMediaGenere));
                        array_push($files_arr, $newFilePath);
					} else {
						$modifMedia->execute(array($typeMedia, $image, $nomMediaGenere, date('Y-m-d H:i:s'), $edit));
						unlink($uploaddir . $_SESSION["prevName"]);
                        array_push($files_arr, $newFilePath);
					}
					$bdd->commit();
					//header("Location: facebook.php");
				}
			}
		} else {
			// Sinon la vidéo n'est pas en mp4 ou gif
			//echo "source en wav ou mp3.";
		}
	}
	//print_r($files_arr);
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json");	
	echo json_encode($files_arr);
}
