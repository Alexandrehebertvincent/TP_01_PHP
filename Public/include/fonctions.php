<?php

/**
 * @param $filmid -> Vérifier l'existence d'un film.
 * @return bool -> Vrai s'il existe.
 */
function VerifierIdFilmExistant($filmid) {
	include("config.php");
	$req = $connBD->prepare('SELECT COUNT(*) AS filmTrouve FROM films WHERE Id=:filmid');
	$req->execute(array(
	'filmid'=>$filmid));
	$connBD = null;
	return $req->fetch()['filmTrouve'] > 0 ? true : false;
}

/**
 * @param $userid -> Obtenir les informations d'un utilisateur selon son id.
 * @return bool -> False si l'id n'existe pas.
 */
function GetUserSelonId($userid){
	include("config.php");
	$req = $connBD->prepare('SELECT * FROM users WHERE Id=:userid');
	$req->execute(array(
		'userid'=>$userid));
	$connBD = null;
	$donnees = $req->fetch();
	return $donnees == null ? false : $donnees;
}

/**
 * @param $userid -> Id à vérifier dans la base de données.
 * @return bool -> Vrai si l'id existe déjà.
 */
function VerifierIdUserExistant($userid) {
	include("config.php");
	$req = $connBD->prepare('SELECT COUNT(*) AS userTrouve FROM users WHERE Id=:userid');
	$req->execute(array(
	'userid'=>$userid));
	$connBD = null;
	return $req->fetch()['userTrouve'] > 0 ? true : false;
}

/**
 * @param $pseudo -> Pseudo à vérifier dans la base de données.
 * @return bool -> Vrai si le pseudo existe déjà.
 */
function VerifierPseudoUserExistant($pseudo) {
	include("config.php");
	$req = $connBD->prepare('SELECT COUNT(*) AS userTrouve FROM users WHERE Nom=:pseudo');
	$req->execute(array(
	'pseudo'=>$pseudo));
	$connBD = null;
	return $req->fetch()['userTrouve'] > 0 ? true : false;
}

/**
 * @param $filmid -> Identifiant du film dont on veut obtenir le chemin de l'image.
 * @return mixed -> Valeur du chemain.
 */
function ObtenirCheminImageFilm($filmid){
	include("config.php");
	$req = $connBD->prepare('SELECT * FROM films WHERE Id=:filmid');
	$req->execute(array('filmid'=>$filmid));
	$connBD = null;
	$donnees = $req->fetch();
	return $donnees["Image"];
}

/**
 * @param $texte -> Texte à approuver.
 * @return bool
 */
function VerifierContreInjection($texte){
	$valide = true;
	$motsNonValides = array("<script>", "</script>", "<style>", "</style>", "<html>", "</html>", "<body>", "</body>", "$.", "<!--", "-->");
	foreach ($motsNonValides as $mot){
		if (strpos($texte, $mot) || $texte == $mot){
			$valide = false;
		}
	}
	return $valide;
}

/**
 * @param $noErreur -> Le numéro associé à l'erreur ou au message.
 * @param int $infoSupplementaire -> Information supplémentaire à propos de l'erreur ou du message.
 */
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

		// Aucun film trouvé.
		case 9:
			echo '<div class="message message-orange"><h3>Aucun film correspondant n\'a été trouvé.</h3></div>';
			break;

		// Suppresion OK
		case 10:
			echo '<div class="message message-vert"><h3>La supression à été effectué avec succès!</h3></div>';
			break;

		// Suppression film ""
		case 11:
			echo '<div class="message message-orange"><h3>Impossible de supprimer. un film non identifié. Veuillez réessayer.</h3></div>';
			break;

		// Création film OK
		case 12:
			echo '<div class="message message-vert"><h3>La création du film est un succès!</h3></div>';
			break;

		// Suppression user OK
		case 13:
			echo '<div class="message message-vert"><h3>L\'utilisateur à été supprimé avec succès.</h3></div>';
			break;

		// Champs vide
		case 14:
			echo '<div class="message message-orange"><h3>Aucun champ du formulaire ne peut être vide.</h3></div>';
			break;

		// Erreur lors de l'affichage d'un usager.
		case 15:
			echo '<div class="message message-orange"><h3>Il s\'est produite une erreur lors de l\'enregistrement de l\'utilisateur. Veuillez réésayer...</h3></div>';
			break;

		// Injection
		case 16:
			echo '<div class="message message-red"><h3>Veuillez s\'il vous plaît ne pas injecter de code html/javascript dans les champs d\'entrée.</h3></div>';
			break;
		default:
			break;
	}
}