<?php
// Pour modifier un film

//print_r($_POST);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['titre'], $_POST['resume'], $_FILES['monfichier'])) {
		echo "condition 1: OK! \n";
		if (($_POST['titre'] != "" AND $_POST['resume'] != "")) {
			echo "condition 2: OK! \n";

			$titre = $_POST['titre'];
			$resume = $_POST['resume'];
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["monfichier"]["name"]);
			
			var_dump($_POST);

			if (move_uploaded_file($_FILES["monfichier"]['tmp_name'], $target_file)) {
				 echo "Le fichier est valide, et a été téléchargé avec succès.";
			 } else {
				// echo "Attaque potentielle par téléchargement de fichiers.";
			 }

			// Paramètres de connexion à la BD.
			require("config.php");
			try {
				var_dump($connBD);
				$req = $connBD->prepare('UPDATE films SET Nom = :nom, Description= :description, Image=:image WHERE Id=:ìd');
				$req->execute(array(
					'nom' => $titre,
					'description' => $resume,
					'id' => $_POST['filmid']));

			} catch (PDOException $e) {
				exit("Erreur lors de l'exécution de la requête SQL :<br />\n" . $e->getMessage() . "<br />\nREQUÊTE = INSERT");
			}

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