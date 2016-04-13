<?php
/**
 * Vérifie l'existance d'un nom d'utilisateur dans la bd et retourne 0 si le nom est inexistant et 1 si le nom
 * existe déjà.
 */
try {
    include ("config.php");
    $valide = 0;
    $req = $connBD->prepare('SELECT COUNT(Nom) AS Valide FROM users WHERE Nom=:nom');
    $req->execute(array("nom"=>$_POST['pseudo']));

    while ($donnees = $req->fetch()) {
        echo json_encode($donnees);
    }
} catch (PDOException $e) {
    exit("Erreur lors de l'exécution de la requête SQL :<br />\n" . $e->getMessage() . "<br />\nREQUËTE = SELECT");
}