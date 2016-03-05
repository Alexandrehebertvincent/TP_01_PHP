<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo "1 ok";
	 var_dump($_POST);
	 var_dump($_FILES);
	if (isset($_POST['titre'], $_POST['resume'], $_FILES['monfichier'])) {
		if (($_POST['titre'] != "" AND $_POST['resume'] != "" AND $_FILES['monfichier']['error'] == 0)) {

			$titre = $_POST['titre'];
			$resume = $_POST['resume'];
			$target_dir = "uploads/"; // Ok, je comprends pas tout à fait, mais avec "../uploads/" ici, les images ne s'affichent pas à la page Index.php...
			$target_file = $target_dir . basename($_FILES["monfichier"]["name"]);

			if (move_uploaded_file($_FILES["monfichier"]['tmp_name'], "../" . $target_file)) { // ... mais sans le "../" ici, les images ne sont pas placées dans le dossier.
				 echo "Le fichier est valide, et a été téléchargé avec succès.";
			 } else {
				// echo "Attaque potentielle par téléchargement de fichiers.";
			 }

			// Paramètres de connexion à la BD.
			require("config.php");
			try {
				$req = $connBD->prepare('INSERT INTO films(Nom, Description, Image) VALUES(:nom, :description, :image)');
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