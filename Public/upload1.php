
<?php 
	if (isset($_POST['titre'], $_POST['resume'], $_FILES['monfichier'])) {
		echo "condition 1: OK! \n";
		if (($_POST['titre'] != "" AND $_POST['resume'] != "" AND  $_FILES['monfichier']['error'] == 0)) {
			echo "condition 2: OK! \n";
			
			$titre = $_POST['titre'];
			$resume = $_POST['resume'];
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["monfichier"]["name"]);
				
			// Paramètres de connexion à la BD.
			require ("config.php");
			// Création d'une connexion à la BD.
			try {
				$connBD = new PDO("mysql:host=$dbHote; dbname=$dbNom", $dbUtilisateur, $dbMotPasse, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				// Pour lancer les exceptions lorsqu'il y des erreurs PDO.
				$connBD -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			} catch (PDOException $e) {
				exit( "Erreur lors de la connexion à la BD :<br />\n" .  $e->getMessage() );
			}
			
			try {
					$req = $connBD->prepare('INSERT INTO films(id, nom, description, image) 
							VALUES(:id, :nom, :description, :image)');
					$req->execute(array(
						'id' => "",
						'nom' => $titre,
						'description' => $resume,
						'image' => $target_file ));
						
				} catch (PDOException $e) {
					exit( "Erreur lors de l'exécution de la requête SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQUÊTE = INSERT");
			}
			
			echo "Voici tout ce qui se trouve dans la base de données: ";
			try {
				
				$req = $connBD->prepare('SELECT * FROM films');
				$req->execute();

				echo '<ul>';
				while ($donnees = $req->fetch())
				{
					echo '<li>' . "Id: " . $donnees['Id'] . ", " . "Nom: " .  $donnees['Nom'] . ", " . "Description: " .  $donnees['Description'] . ", " . "Image: " .  $donnees['Image'] . ' </li>';
				}
				echo '</ul>';
				
				$req->closeCursor();
				$connBD = null;
			} catch (PDOException $e) {
				exit( "Erreur lors de l'exécution de la requête SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQUÊTE = SELECT" );
			}

		}
	}
?>
<p>
	<a href="index.php">index.php</a>
</p>