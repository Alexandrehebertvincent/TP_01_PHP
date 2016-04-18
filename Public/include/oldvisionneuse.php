
<?php
	require("config.php");
	include_once("fonctions.php");

	$films = null;
	try {
		$req = $connBD->prepare('SELECT * FROM films ORDER BY Id DESC LIMIT 6');
		$req->execute();
		while ($donnees = $req->fetch()) {
			$films[] = $donnees;
		}
		$req->closeCursor();
		$connBD = null;
	} catch (PDOException $e) {
		exit("Erreur lors de l'exécution de la requête SQL :<br />\n" . $e->getMessage() . "<br />\nREQUËTE = SELECT");
	}
?>

<div>
<ul id="liste-vignettes">
<?php if (count($films) > 0 && $films[0] != NULL) { ?>
	<?php foreach ($films as $film){ ?>
		<!-- <div class="film-div">
			<a class="lien-film" href="film.php?filmid=<?php echo $film['Id']; ?>"><div class="film-section-image" style="background-image: url(<?php echo $film['Image']; ?>);"></div></a>
			<h3><?php echo $film['Nom']; ?></h3>
			<div class="film-section-bouton">
				<?php if ($_SESSION['utilisateur']['Acces'] == "admin"){ ?>
					<a href="include/supprimer.php?filmid=<?php echo $film['Id']; ?>" class="button file-upload-btn btn-auto btn-red">Supprimer</a>
					<a href="modifier-film.php?filmid=<?php echo $film['Id']; ?>" class="button file-upload-btn btn-auto btn-orange">Modifier</a>
				<?php } ?>
				<a href="film.php?filmid=<?php echo $film['Id']; ?>" class="button file-upload-btn btn-auto">Fiche du film</a>
			</div>
		</div> -->
			<li class="vignette-visionneuse" dataImage="<?php echo $film['Image']; ?>">
				<div class="aaa">
					<div class="img-blur" style="background-image: url(<?php echo $film['Image']; ?>);"> </div>
					<img class="image-vignette" src=<?php echo $film['Image']; ?> filmId="<?echo $film['Id'] ?>" />
				</div>
			</li>
	<?php } ?>
<?php }else{GetErreur(7);} ?>
</ul>
</div>
