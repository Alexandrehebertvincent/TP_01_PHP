
<?php
require("config.php");

try {
    $req = $connBD->prepare('SELECT * FROM users WHERE Nom LIKE :nom ORDER BY Acces,Nom');
    $req->execute(array("nom"=>"%".$_POST['pseudo']."%"));
    $result = array();
    while ($donnees = $req->fetch()) {
        $result[] = $donnees;
    }
    echo json_encode($result);

    $req->closeCursor();
    $connBD = null;
} catch (PDOException $e) {
    exit("Erreur lors de l'ex�cution de la requ�te SQL :<br />\n" . $e->getMessage() . "<br />\nREQU�TE = SELECT");
}