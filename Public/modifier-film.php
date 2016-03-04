<?php
// Vérification
include ("verification-connexion.php");
		if (isset($_GET['filmid']) AND $_GET['filmid'] != "") {
		echo "Connecté en tant que: " . $_SESSION['utilisateur']['Nom'] . " (" . $_SESSION['utilisateur']['Acces'] . ")";
		
			require("config.php");
		
		try {
			$req = $connBD->prepare('SELECT * FROM films WHERE Id=:id');
				$req->execute(array(
				'id'=> $_GET['filmid'] ));
				
				// $req = $connBD->prepare('UPDATE films SET Nom=:nom, Description=:description, Image:image WHERE Id=:id');
				// $req->execute(array(
					// 'nom' => $titre,
					// 'description' => $resume,
					// 'image' => $target_file,
					// 'id'=> $_GET['filmid']));
					
					$donnees = $req->fetch();

            echo '
			<div id="blocAlign">
                <form method="post" id="frmajout" action="update.php">
					<p>
						<label for="titreFilm">Titre du film: </label>
						<input type="text" name="titre" id="titre" size="42" value="' . $donnees['Nom'] . '"> . 
					</p>
					<p>
						<label for="description">Description: </label>
						<textarea name="resume" id="resume" form="frmajout" cols="40" rows="9">' . $donnees['Description'] . '</textarea>
					</p>
					<p>
						<label for="image">Image: </label>
						<input type="file" name="monfichier" id="monfichier" />
					</p>
					<input type="hidden" name="filmid" id="hiddenField" value="' . $donnees['Id'] . '" />
						
					<p>
						<input id="submit" type="submit" value="Mettre à jour le film - NE FONCTIONNE PAS ENCORE D: "/>
					</p>
                </form>
			</div>
			<img src="' . $donnees['Image'] . '" height="400" width="400" alt="Image du film">
		';
		}
		catch (PDOException $e) {
                exit( "Erreur lors de l'exécution de la requête SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQUÊTE = SELECT");
            }
		}
        ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier film <?php echo $film['Nom']; ?></title>
	<link rel="stylesheet" type="text/css" href="css/styleIndex.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
    <link rel="icon" href="favicon.ico" />
</head>
<body>

    <!-- Menu -->
    <?php include ("navbar-top.php"); ?>
	<h1> Modifier le film | <?php echo $_GET['nom']; ?></h1>
	<div id="page">
        <div id="blocAlign">
                <form method="post" id="frmajout" action="update.php">
					<p>
						<label for="titreFilm">Titre du film: </label>
						<input type="text" name="titre" id="titre" size="42" value="' . $donnees['Nom'] . '"> . 
					</p>
					<p>
						<label for="description">Description: </label>
						<textarea name="resume" id="resume" form="frmajout" cols="40" rows="9"> <?php echo $donnees['Description']; ?></textarea>
					</p>
					<p>
						<label for="image">Image: </label>
						<input type="file" name="monfichier" id="monfichier" />
					</p>
					<input type="hidden" name="filmid" id="hiddenField" value="' . $donnees['Id'] . '" />
						
					<p>
						<input id="submit" type="submit" value="Mettre à jour le film - NE FONCTIONNE PAS ENCORE D: "/>
					</p>
                </form>
			</div>
			<img src="' . $donnees['Image'] . '" height="400" width="400" alt="Image du film">
		';
	</div>
</body>
</html>	