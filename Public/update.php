<?php
// Pour modifier un film

//print_r($_POST);
var_dump($_POST['filmid']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['titre'], $_POST['resume'])) {
		echo "condition 1: OK! \n";
		if (($_POST['titre'] != "" AND $_POST['resume'] != "")) {
			echo "condition 2: OK! \n";

			$titre = $_POST['titre'];
			$resume = $_POST['resume'];
			
			var_dump($_POST);

			// Paramètres de connexion à la BD.
			require("config.php");
			try {
				var_dump($connBD);
				// $req = $connBD->prepare('UPDATE films SET Nom=:nom, Description=:description WHERE Id=:ìd');
				// $req->execute(array(
					// 'nom' => $titre,
					// 'description' => $resume,
					// 'id' => $_POST['filmid']));
					
					$req = $connBD->prepare('UPDATE films SET Nom=:nom, Description=:description WHERE Id=:filmid');
				$req->execute(array(
					'nom' => $titre,
					'description' => $resume,
					'filmid' => $_POST['filmid']));
					
						// try {
				// $req = $connBD->prepare('UPDATE jeux_video SET prix = :prix, console = :console WHERE nom = :nom');
				// $req->execute(array(
					// 'prix' => $prix,
					// 'console' => $console,
					// 'nom' => $nom));

			} catch (PDOException $e) {
				exit("##Erreur lors de l'exécution de la requête SQL :<br />\n" . $e->getMessage() . "<br />\nREQUÊTE = UPDATE");
			}
			
			$connBD = null;
			

			// echo "Voici tout ce qui se trouve dans la base de données: ";
			// try {

				// $req = $connBD->prepare('SELECT * FROM films');
				// $req->execute();

				// echo '<ul>';
				// while ($donnees = $req->fetch()) {
					// echo '<li>' . "Id: " . $donnees['Id'] . ", " . "Nom: " . $donnees['Nom'] . ", " . "Description: " . $donnees['Description'] . ", " . "Image: " . $donnees['Image'] . ' </li>';
				// }
				// echo '</ul>';

				// $req->closeCursor();
				// $connBD = null;
			// } catch (PDOException $e) {
				// exit("Erreur lors de l'exécution de la requête SQL :<br />\n" . $e->getMessage() . "<br />\nREQUÊTE = SELECT");
			// }
			
			
			
			// header('Location: index.php');
		}
		else {
			echo 'conditon 2 pas ok...';
		}
	}
}
else {
			echo 'conditon 2 pas ok...';
		}
?>
<p>
	<a href="index.php">index.php</a>
</p>