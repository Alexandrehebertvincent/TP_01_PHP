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

function GetErreur($noErreur){
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
	}
}