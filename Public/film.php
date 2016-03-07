<?php
// Vérification
include ("include/verification-connexion.php");

if ($_SESSION['utilisateur']['Acces'] == 'admin') {
		include ("navbar-top-admin.php"); 
	}
	else {
		include ("navbar-top.php"); 
	} 
	
	
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche de film | <?php echo $film['Nom']; ?></title>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
    <link rel="icon" href="favicon.ico" />
</head>
<body>
<?php 
$film = NULL;
// //echo '<img src=" . $donnees['Image'] . "\" height='450'width='450' alt='Image du film'>";
if (isset($_GET['filmid'])){
    // Inclure le fichier de connexion.
    require("include/config.php");
    //echo "<a href='index.php'>Retour à la liste des films</a>";
    try {
        $req = $connBD->prepare('SELECT * FROM films WHERE Id =:id');
        $req->execute(array("id"=>$_GET['filmid']));

        while ($donnees = $req->fetch()) {
            $film = $donnees;
            echo "
			<h1>
            " . $donnees['Nom'] . "
            </h1>
           <img src=\"" . $donnees['Image'] . "\" alt='Image du film' height='450'width='450'>
            <p>
            " . $donnees['Description'] . "
            </p>";
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
