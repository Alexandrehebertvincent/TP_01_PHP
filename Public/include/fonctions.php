<?php

function VerifierIdFilmExistant($filmid) {
	include("config.php");
	
	$req = $connBD->prepare('SELECT COUNT(*) AS filmTrouve FROM films WHERE Id=:filmid');
	$req->execute(array(
	'filmid'=>$filmid));
	$connBD = null;
	
	if ($req->fetch()['filmTrouve'] > 0)
	{
		return true;
	}
	return false;
}

function VerifierIdUserExistant($userid) {
	include("config.php");
	
	$req = $connBD->prepare('SELECT COUNT(*) AS userTrouve FROM users WHERE Id=:userid');
	$req->execute(array(
	'userid'=>$userid));
	$connBD = null;
	
	if ($req->fetch()['userTrouve'] > 0)
	{
		return true;
	}
	return false;
}

function VerifierPseudoUserExistant($pseudo) {
	include("config.php");
	
	$req = $connBD->prepare('SELECT COUNT(*) AS userTrouve FROM users WHERE Nom=:pseudo');
	$req->execute(array(
	'pseudo'=>$pseudo));
	$connBD = null;
	
	if ($req->fetch()['userTrouve'] > 0)
	{
		return true;
	}
	return false;
}

function ObtenirCheminImageFilm($filmid){
	include("config.php");

	$req = $connBD->prepare('SELECT * FROM films WHERE Id=:filmid');
	$req->execute(array(
		'filmid'=>$filmid));
	$connBD = null;

	$donnees = $req->fetch();

	return $donnees["Image"];
}

function GetErreur($noErreur, $infoSupplementaire = 0){
	switch ($noErreur){
		// Déconnexion
		case 1:
			echo '<div class="error error-vert"><h3>Utilisateur déconnecté avec succès!</h3></div>';
			break;

		// Remplir tous les champs
		case 2:
			echo '<div class="error error-orange"><h3>Vous devez remplir tous les champs du formulaire!</h3></div>';
			break;

		// Informations ne concordent pas
		case 3:
			echo '<div class="error error-red"><h3>Le pseudo et le mot de passe ne concorde pas!</h3></div>';
			break;
		// Utilisateur existant
		case 4:
			echo '<div class="error error-orange"><h3>Cet utilisateur existe déjà!</h3></div>';
			break;

		// Modifications effectuées avec succès
		case 5:
			echo '<div class="message message-vert message-important"><h3>Modifications effectuées avec succès!</h3></div>';
			break;

		// Erreur lors de la modification
		case 6:
			echo '<div class="message message-red"><h3>Il est malheureusement arrivé quelque chose lors de la modification... Veuillez réésayer.</h3></div>';
			break;

		// Si aucun film n'est dans la BD
		case 7:
			echo '<div class="message message-orange"><h3>Il n\'y a pas encore de film dans la collection!</h3></div>';
			break;

		// Obtenir le nombre de film dans la bd
		// Si aucun film n'est dans la BD
		case 8:
			echo '<div class="message message-vert"><h3>La collection comporte '.($infoSupplementaire > 1 ? $infoSupplementaire . " films": $infoSupplementaire . " film").'. Bonne visite!</h3></div>';
			break;
		default:
			break;
	}
}