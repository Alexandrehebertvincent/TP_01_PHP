<?php
// Pour modifier un film

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	echo "condition 1 ok!! ";
	var_dump($_POST);
	if (isset($_POST['titre'], $_POST['resume'], $_POST['image'])) {
		echo "condition 2 ok!! ";
		if (($_POST['titre'] != "" AND $_POST['resume'] != "" and $_POST['image'] =! "")) {
			echo "condition 3 ok!! ";

			// if (move_uploaded_file($_FILES["image"]['tmp_name'], $target_file)) {
				 // echo "Le fichier est valide, et a �t� t�l�charg� avec succ�s.";
			 // } else {
				// // echo "Attaque potentielle par t�l�chargement de fichiers.";
			 // }

			$titre = $_POST['titre'];
			$resume = $_POST['resume'];
			$target_dir = "../uploads/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);

			// Param�tres de connexion � la BD.
			require("config.php");
			try {
					$req = $connBD->prepare('UPDATE films SET Nom=:nom, Description=:description, Image=:image WHERE Id=:filmid');
					$req->execute(array(
					'nom' => $titre,
					'description' => $resume,
					'filmid' => $_POST['filmid'],
					'image' => $target_dir));

			} catch (PDOException $e) {
				exit("##Erreur lors de l'ex�cution de la requ�te SQL :<br />\n" . $e->getMessage() . "<br />\nREQU�TE = UPDATE");
			}
			
			$connBD = null;
			
			header('Location: ../index.php');
		}
	}
}
echo "C'est pas normal que tu puisse lire �a! ;) Ya une erreur..";
?>