<?php

// comparer Taille max ET  

// include header
include("./inc/header.inc.php");

// Initialisation des variables
$post = filter_input(INPUT_POST, 'postEcrit');
$submit = filter_input(INPUT_POST, 'submit');

// tailles des images
$taille_maxi = 3000000;
$taille = filesize($_FILES['avatar']['tmp_name']);

// Si on clique sur le boutton submit
if ($submit) {
	// image est égal au fichier selectionné dans le form
	$image = $_FILES['image']['name'];
	
	// Vérifie si le nom du media existe déjà
	foreach ($nomMedia as $n) {
		if($n["nomMedia"] != $image){
			$nomMediaDejaExistant = false;
		}
		else{
			$nomMediaDejaExistant = true;
		}
	}

	// Verification des extensions
	// code image
	if (substr($image, -3) == "png" || substr($image, -3) == "jpg" || substr($image, -3) == "PNG" || substr($image, -3) == "JPG" || substr($image, -3) == "peg" || substr($image, -3) == "PEG" && $taille > $taille_maxi) {
		// définir le type du média
		$typeMedia = "image";
		// Fichier image
		$uploaddir = './img/';
		// Chemin dans le quel l'image s'installe
		$uploadfile = $uploaddir . basename($image);
		// Si tout marche, on prend le nom de l'image et on le met dans la bdd
		if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile) && $nomMediaDejaExistant == false) {
			$insertImage->execute(array($typeMedia, $image, date('Y-m-d H:i:s')));
			header("Location: facebook.php");
		}
	}
	// code vidéo ??????????????????
	else {
		// Sinon le média n'est pas accepter
		echo "le média n'est pas accepté.";
	}
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Facebook Theme Demo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
	<link href="assets/css/facebook.css" rel="stylesheet">
</head>

<body>

	<div class="wrapper">
		<div class="box">
			<div class="row row-offcanvas row-offcanvas-left">

				<!-- main right col -->
				<div class="column col-sm-10 col-xs-11" id="main">

					<!-- top nav -->
					<div class="navbar navbar-blue navbar-static-top">
						<div class="navbar-header">
							<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a href="http://usebootstrap.com/theme/facebook" class="navbar-brand logo">b</a>
						</div>
						<nav class="collapse navbar-collapse" role="navigation">
							<form class="navbar-form navbar-left">
								<div class="input-group input-group-sm" style="max-width:360px;">
									<input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
									<div class="input-group-btn">
										<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
									</div>
								</div>
							</form>
							<ul class="nav navbar-nav">
								<li>
									<a href="facebook.php"><i class="glyphicon glyphicon-home"></i> Home</a>
								</li>
								<li>
									<a href="post.php" role="button"><i class="glyphicon glyphicon-plus"></i> Post</a>
								</li>
							</ul>
							<ul class="nav navbar-nav navbar-right">
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i></a>
									<ul class="dropdown-menu">
										<li><a href="">More</a></li>
										<li><a href="">More</a></li>
										<li><a href="">More</a></li>
										<li><a href="">More</a></li>
										<li><a href="">More</a></li>
									</ul>
								</li>
							</ul>
						</nav>
					</div>
					<!-- /top nav -->

					<div class="padding">
						<div class="full col-sm-9">

							<!-- content -->
							<div class="row">

								<!-- main col left -->
								<div class="col-sm-5">

									<div class="panel panel-default">
										<div class="panel-thumbnail"><img src="assets/img/bg_5.jpg" class="img-responsive"></div>
										<div class="panel-body">
											<p class="lead">Urbanization</p>
											<p>45 Followers, 13 Posts</p>

											<p>
												<img src="assets/img/uFp_tsTJboUY7kue5XAsGAs28.png" height="28px" width="28px">
											</p>
										</div>
									</div>

								</div>
								<!-- main col right -->
								<div class="col-sm-7">

									<div class="panel panel-default">
										<div class="panel-heading">
											<h4>Welcome !</h4>
										</div>
									</div>


									<?php
									// Affiche toutes les images
									foreach ($images as $i) {
										echo "<div class=\"panel panel-default\">";
										echo "	<div class=\"panel-thumbnail\"><img src=\"./img/" . $i["nomMedia"] . "\" class=\"img-responsive\"></div>";
										echo "</div>";	
									}
									?>

								</div>

								
							</div>
							
					</div><!-- /padding -->
				</div>
				<!-- /main -->

			</div>
		</div>
	</div>

	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('[data-toggle=offcanvas]').click(function() {
				$(this).toggleClass('visible-xs text-center');
				$(this).find('i').toggleClass('glyphicon-chevron-right glyphicon-chevron-left');
				$('.row-offcanvas').toggleClass('active');
				$('#lg-menu').toggleClass('hidden-xs').toggleClass('visible-xs');
				$('#xs-menu').toggleClass('visible-xs').toggleClass('hidden-xs');
				$('#btnShow').toggle();
			});
		});
	</script>
</body>

</html>