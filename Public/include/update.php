<?php

// Pour modifier un film
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['titre'], $_POST['resume'], $_FILES['image'])) {
		if ($_POST['titre'] != "" AND $_POST['resume'] != "") {

			$titre = $_POST['titre'];
			$resume = $_POST['resume'];

			if ($_FILES['image']['error'] == 0){
				$target_dir = "uploads/";
				$target_file = $target_dir . basename($_FILES["image"]["name"]);

				// Si une nouvelle image est demandée
				if ($_FILES["image"]["name"] != ""){
					include_once ("fonctions.php");
					unlink("../".ObtenirCheminImageFilm($_POST["filmid"]));
					move_uploaded_file($_FILES["image"]['tmp_name'], "../" . $target_file);

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
				}
			}else{
				// Param�tres de connexion � la BD.
				require("config.php");
				try {
					$req = $connBD->prepare('UPDATE films SET Nom=:nom, Description=:description WHERE Id=:filmid');
					$req->execute(array(
						'nom' => $titre,
						'description' => $resume,
						'filmid' => $_POST['filmid']));
				} catch (PDOException $e) {
					exit("Erreur lors de l'ex�cution de la requ�te SQL :<br />\n" . $e->getMessage() . "<br />\nREQU�TE = UPDATE");
				}
			}
			$req->closeCursor();
			$connBD = null;

			header("LOCATION:../index.php?message=5");
			
			//header('Location: ../index.php');
		} else{
			header("LOCATION:../index.php?message=6");
		}
	} else{
		header("LOCATION:../index.php?message=6");
	}
}
?>