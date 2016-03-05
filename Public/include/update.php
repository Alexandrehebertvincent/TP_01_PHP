<?php
// Pour modifier un film

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// echo "condition 1 ok!! ";
	// var_dump($_POST);
	// if (isset($_POST['titre'], $_POST['resume'], $_POST['image'])) {
		// echo "condition 2 ok!! ";
		// if (($_POST['titre'] != "" AND $_POST['resume'] != "" and $_POST['image'] =! "")) {
			// echo "condition 3 ok!! ";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	 echo "condition 1 ok!! ";
	 var_dump($_POST);
	 var_dump($_FILES);
	if (isset($_POST['titre'], $_POST['resume'], $_FILES['laimage'])) {
		echo "condition 2: OK! \n";
		if (($_POST['titre'] != "" AND $_POST['resume'] != "" AND $_FILES['laimage']['error'] == 0)) {
			echo "condition 3: OK! \n";

			// if (move_uploaded_file($_FILES["image"]['tmp_name'], $target_file)) {
				 // echo "Le fichier est valide, et a été téléchargé avec succès.";
			 // } else {
				// // echo "Attaque potentielle par téléchargement de fichiers.";
			 // }

			$titre = $_POST['titre'];
			$resume = $_POST['resume'];
			$target_dir = "uploads/";
			$target_file = $target_dir . basename($_POST["image"]["name"]);
			
			echo $target_file;

			// Paramètres de connexion à la BD.
			require("config.php");
			try {
					$req = $connBD->prepare('UPDATE films SET Nom=:nom, Description=:description, Image=:image WHERE Id=:filmid');
					$req->execute(array(
					'nom' => $titre,
					'description' => $resume,
					'filmid' => $_POST['filmid'],
					'image' =>$target_file));

			} catch (PDOException $e) {
				exit("##Erreur lors de l'exécution de la requête SQL :<br />\n" . $e->getMessage() . "<br />\nREQUÊTE = UPDATE");
			}
			
			$req->closeCursor();
			$connBD = null;
			
			//header('Location: ../index.php');
		}
	}
}
echo "C'est pas normal que tu puisse lire ça! ;) Ya une erreur..";
?>