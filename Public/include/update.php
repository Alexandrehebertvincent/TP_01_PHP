<?php
// Pour modifier un film

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['titre'], $_POST['resume'], $_FILES['image'])) {
		var_dump($_POST);
		var_dump($_FILES);
		if (($_POST['titre'] != "" AND $_POST['resume'] != "" AND $_FILES['image']['error'] == 0)) {		

			$titre = $_POST['titre'];
			$resume = $_POST['resume'];
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			
			if (move_uploaded_file($_FILES["image"]['tmp_name'], "../" . $target_file)) {
				 echo "Le fichier est valide, et a �t� t�l�charg� avec succ�s.";
			 } else {
				// echo "Attaque potentielle par t�l�chargement de fichiers.";
			 }

			// Param�tres de connexion � la BD.
			require("config.php");
			try {
					$req = $connBD->prepare('UPDATE films SET Nom=:nom, Description=:description, Image=:image WHERE Id=:filmid');
					$req->execute(array(
					'nom' => $titre,
					'description' => $resume,
					'filmid' => $_POST['filmid'],
					'image' =>$target_file));
			} catch (PDOException $e) {
				exit("Erreur lors de l'ex�cution de la requ�te SQL :<br />\n" . $e->getMessage() . "<br />\nREQU�TE = UPDATE");
			}
			
			$req->closeCursor();
			$connBD = null;
			
			//header('Location: ../index.php');
		}
	}
}
echo "C'est pas normal que tu puisse lire �a! ;) Ya une erreur..";
?>