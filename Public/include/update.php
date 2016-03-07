<?php

session_start();

include_once("fonctions.php");

// Pour modifier un film
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['titre'], $_POST['resume'], $_FILES['image'])) {
		if ($_POST['titre'] != "" AND $_POST['resume'] != "") {
			if (VerifierContreInjection($_POST['resume']) == true) {
				$titre = $_POST['titre'];
				$resume = $_POST['resume'];
				// Si l'image doit être changée
				if ($_FILES['image']['error'] == 0) {
					$target_dir = "uploads/";
					$target_file = $target_dir . basename($_FILES["image"]["name"]);
					// Si une nouvelle image est demandée
					if ($_FILES["image"]["name"] != "") {
						// Suppression de l'ancienne image.
						unlink("../" . ObtenirCheminImageFilm($_POST["filmid"]));
						move_uploaded_file($_FILES["image"]['tmp_name'], "../" . $target_file);
						// Paramètres de connexion à la BD.
						require("config.php");
						try {
							$req = $connBD->prepare('UPDATE films SET Nom=:nom, Description=:description, Image=:image WHERE Id=:filmid');
							$req->execute(array(
								'nom' => $titre,
								'description' => $resume,
								'filmid' => $_POST['filmid'],
								'image' => $target_file));
						} catch (PDOException $e) {
							exit("Erreur lors de l'exécution de la requête SQL :<br />\n" . $e->getMessage() . "<br />\nREQUËTE = UPDATE");
						}
					}
				} else {
					// Paramètres de connexion à la BD.
					require("config.php");
					try {
						$req = $connBD->prepare('UPDATE films SET Nom=:nom, Description=:description WHERE Id=:filmid');
						$req->execute(array(
							'nom' => $titre,
							'description' => $resume,
							'filmid' => $_POST['filmid']));
					} catch (PDOException $e) {
						exit("Erreur lors de l'exécution de la requête SQL :<br />\n" . $e->getMessage() . "<br />\nREQUËTE = UPDATE");
					}
				}
				$req->closeCursor();
				$connBD = null;
				$_SESSION["messages"][] = 5;
			}else {
				$_SESSION["messages"][] = 16;
			}
		} else{
			$_SESSION["messages"][] = 6;
		}
	} else{
		$_SESSION["messages"][] = 6;
	}
}
header("LOCATION:../index.php");