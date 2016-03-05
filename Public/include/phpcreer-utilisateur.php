<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo "1 ok";
	 var_dump($_POST);
	if (isset($_POST['Nom'], $_POST['resume'], $_FILES['monfichier'])) {
		if (($_POST['titre'] != "" AND $_POST['resume'] != "" AND $_FILES['monfichier']['error'] == 0)) {

			// Paramètres de connexion à la BD.
			require("config.php");
			try {
				$req = $connBD->prepare('INSERT INTO users(Nom, Mot_de_Passe) VALUES(:nom, :description, :image)');
				$req->execute(array(
					'nom' => $titre,
					'description' => $resume,
					'image' => $target_file));
			} catch (PDOException $e) {
				exit("Erreur lors de l'exécution de la requête SQL :<br />\n" . $e->getMessage() . "<br />\nREQUÊTE = INSERT");
			}
			$req->closeCursor();
				$connBD = null;
			header('Location: ../index.php');
		}
	}
}
?>