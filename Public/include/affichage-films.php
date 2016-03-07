
<?php 
	require("config.php");
	include_once("fonctions.php");
	$films = null;
	try {
		$req = $connBD->prepare('SELECT * FROM films');
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

<?php if (count($films) > 0 && $films[0] != NULL) { ?>
	<table>
		<?php foreach ($films as $film){ ?>
			<tr>
				<?php if ($_SESSION['utilisateur']['Acces'] == "admin"){ ?>
					<td>
						<a href="include/supprimer.php?filmid=<?php echo $film['Id']; ?>" class="button file-upload-btn btn-auto btn-red">Supprimer</a>
					</td>
					<td>
						<a href="modifier-film.php?filmid=<?php echo $film['Id']; ?>" class="button file-upload-btn btn-auto btn-orange">Modifier</a>
					</td>
				<?php } ?>
				<td>
					<a href="include/film.php?filmid=<?php echo $film['Id']; ?>" class="button file-upload-btn btn-auto">Fiche du film</a>
				</td>
				<td>
					<?php echo $film['Nom']; ?>
				</td>
				<td>
					<img src="<?php echo $film['Image']; ?>" height='350'width='350' alt='Image du film'>
				</td>
			</tr>
		<?php GetErreur(8, count($films));} ?>
	</table>
<?php }else{GetErreur(7);} ?>
