<?php
// Vérification
include ("include/verification-connexion.php");

if (isset($_SESSION["messages"])) {
    include_once("include/fonctions.php");
    foreach ($_SESSION["messages"] as $mess) {
        GetErreur($mess);
    }
    $_SESSION["messages"] = array();
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
		include("include/navbar-top-admin.php");
	}
	else {
		include("include/navbar-top.php");
	}
	?>
    <section id="contenu">
        <header id="accueil-banner">
            <span id="fleche-gauche"></span>
            <h1><span class="gras">PAN</span><i class="fa fa-video-camera"></i><br><small>Venez voir.</small></h1>
            <img src="http://thefilmstage.com/wp-content/uploads/2015/09/the_revenant_header-620x330.png">
            <span id="header-fleche"></span>
            <span id="fleche-out"></span>
        </header>
        <div id="page">
		
		<!-- Visionneuse -->
		<div id="id="visionneuse">
			<div>
				<img id="imgvisionneuse" src="images/diapo0.jpg" alt="Le bateau"  />
				<p id="imgText">Le bateau.</p>
			</div>
			<div id="boutons">
				<button id="btnPrec">Précédent</button>
				<button id="btnSuiv">Suivant</button>
			</div>
		</div>
		
		<ul id="liste-vignettes">
			<li><img id="imgli1" src="" height="60" width="80" /></li>
			<li><img id="imgli2" src="" height="60" width="80" /></li>
			<li><img id="imgli3" src="" height="60" width="80" /></li>
			<li><img id="imgli4" src="" height="60" width="80" /></li>
			<li><img id="imgli5" src="" height="60" width="80" /></li>
			
			<!-- <li id="img2">Image 2</li>
			<li id="img3">Image 3</li>
			<li id="img4">Image 4</li>
			<li id="img5">Image 5</li> -->
		</ul>
    </div>
	
			
		<!-- Affichage des films --> 
        <?php require("include/affichage-films.php"); ?>
			
			
			
        </div>
    </section>
    <?php include "include/footer.php"; ?>
	<script src="js/visionneuse-tp.js"></script>
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