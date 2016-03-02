

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche de film | <?php echo $film['Nom']; ?></title>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
    <link rel="icon" href="favicon.ico" />
</head>
<body>
<!-- Menu -->
<?php include ("navbar-top.php"); ?>

<?php
// Vérification
include ("verification-connexion.php");
$film = NULL;
if (isset($_GET['filmid'])){
    // Inclure le fichier de connexion.
    require("config.php");
    //echo "<a href='index.php'>Retour à la liste des films</a>";
    try {
        $req = $connBD->prepare('SELECT * FROM films WHERE Id =:id');
        $req->execute(array("id"=>$_GET['filmid']));

        while ($donnees = $req->fetch()) {
            $film = $donnees;
            echo "<h1>";
            echo $donnees['Nom'];
            echo "</h1>";
            //echo '<img src="' . $donnees['Image'] . "\" alt='Image du film' >";
            echo '<img src="' . $donnees['Image'] . "\" height='450'width='450' alt='Image du film'>";
            echo "<p>";
            echo $donnees['Description'];
            echo "</p>";
        }
        $connBD = NULL;
    }
    catch (PDOException $e) {
        exit( "Erreur lors de l'exécution de la requête SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQUÊTE = SELECT");
    }
}
else{
    header("LOCATION:index.php");
}

?>

</body>
</html>
