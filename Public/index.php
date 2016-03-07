<?php
// Vérification
include ("include/verification-connexion.php");

// Vérification s'il y a un message.
if ($_SERVER["REQUEST_METHOD"] == "GET"){
	if (isset($_GET["message"])){
		include_once("include/fonctions.php");
		if ($_GET["message"] != ""){
			GetErreur($_GET["message"]);
		}
	}
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Partage de films | Panama</title>
	<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic|Lato:400,100,300,700,900:latin' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
    <link rel="icon" href="favicon.ico" />
</head>
<body>
    <!-- Menu -->
    <?php if ($_SESSION['utilisateur']['Acces'] == 'admin') {
		include ("navbar-top-admin.php"); 
	}
	else {
		include ("navbar-top.php"); 
	}
	?>
	<header id="accueil-banner">
		<h1> Accueil <i class="fa fa-home"></i></h1>
		<img src="http://thefilmstage.com/wp-content/uploads/2015/09/the_revenant_header-620x330.png">
		<span id="header-fleche"></span>
	</header>
	<div id="page">
		<?php require("include/affichage-films.php"); ?>
	</div>
	<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		$(window).scroll(function(){
			$("#accueil-banner>img").css("top",$(window).scrollTop()+"px");
		});
	});
</script>
</body>
</html>	