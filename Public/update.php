<?php
// Pour modifier un film

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['titre'], $_POST['resume'], $_FILES['monfichier'])) {
		echo "condition 1: OK! \n";
		if (($_POST['titre'] != "" AND $_POST['resume'] != "" AND $_FILES['monfichier']['error'] == 0)) {
			echo "condition 2: OK! \n";

			$titre = $_POST['titre'];
			$resume = $_POST['resume'];
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["monfichier"]["name"]);

			if (move_uploaded_file($_FILES["monfichier"]['tmp_name'], $target_file)) {
				 echo "Le fichier est valide, et a �t� t�l�charg� avec succ�s.";
			 } else {
				// echo "Attaque potentielle par t�l�chargement de fichiers.";
			 }

			print_r($_FILES);

			// Param�tres de connexion � la BD.
			require("config.php");
			try {
				$req = $connBD->prepare('UPDATE films SET Nom=:nom, Description=:description, Image:image) WHERE Id=:id);
				$req->execute(array(
					'nom' => $titre,
					'description' => $resume,
					'image' => $target_file,
					'id'=> $_GET['filmid']));

			} catch (PDOException $e) {
				exit("Erreur lors de l'ex�cution de la requ�te SQL :<br />\n" . $e->getMessage() . "<br />\nREQU�TE = INSERT");
			}

			// echo "Voici tout ce qui se trouve dans la base de donn�es: ";
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
				// exit("Erreur lors de l'ex�cution de la requ�te SQL :<br />\n" . $e->getMessage() . "<br />\nREQU�TE = SELECT");
			// }
			
			header('Location: index.php');
		}
	}
}
?>
<p>
	<a href="index.php">index.php</a>
</p>