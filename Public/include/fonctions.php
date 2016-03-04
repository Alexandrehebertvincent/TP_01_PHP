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