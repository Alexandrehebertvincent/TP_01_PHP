
<?php
require("config.php");
include_once("fonctions.php");

$listeFilms = null;
$listeFilms = "[\n";
try {
	$req = $connBD->prepare('SELECT * FROM films ORDER BY Id DESC LIMIT 4');
	$req->execute();
	$req -> setFetchMode(PDO::FETCH_OBJ);

	while ($donnees = $req->fetch()) {
		$idFilm = $donnees -> Id;
		$imageFilm = $donnees -> Image;
		$listeFilms .= "{\n";
		$listeFilms .= "\t\"Id\": \"$idFilm\",\n";
		$listeFilms .= "\t\"Image\": \"$imageFilm\"\n";
		$listeFilms .= "},\n";
	}

	$listeFilms .= "]";

	$posVirguleFin = strrpos($listeFilms,",");
	//on enlève la dernière virgule
	$listeFilms = substr_replace($listeFilms, "", $posVirguleFin, 1);

	echo $listeFilms;

	//echo "{'nbre: '1', 'couleur': 'rouge'}";


	// $lstPersonnes = "[\n";
	// while($info = $prepReq -> fetch())
	// {
	// // Récupération des informations sur le membre.
	// $prenom = $info -> MemPrenom;
	// $nom = $info -> MemNom;
	// $courriel = $info -> MemCourriel;

	// // Production de l'expression JSON à retourner.
	// $lstPersonnes .= "\t{\n";
	// $lstPersonnes .= "\t\t\"prenom\": \"$prenom\",\n";
	// $lstPersonnes .= "\t\t\"nom\": \"$nom\",\n";
	// $lstPersonnes .= "\t\t\"courriel\": \"$courriel\"\n";
	// $lstPersonnes .= "\t},\n";
	// }
	// $lstPersonnes .= "]";



	// echo json_encode($tabFilms);


} catch (PDOException $e) {
	exit("Erreur lors de l'exécution de la requête SQL :<br />\n" . $e->getMessage() . "<br />\nREQUËTE = SELECT");
}
//$req->closeCursor();
//	$connBD = null;
?>