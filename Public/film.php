<?php
// Vérification
include ("include/verification-connexion.php");
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
        }
        $connBD = NULL;
    }
    catch (PDOException $e) {
        exit( "Erreur lors de l'exécution de la requête SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQUÊTE = SELECT");
    }
    if ($film == null){
        header("LOCATION:index.php?message=9");
    }
}
else{
    header("LOCATION:index.php");
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche de film | <?php echo $film['Nom']; ?></title>
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic|Lato:400,100,300,700,900:latin' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
    <link rel="icon" href="favicon.ico" />
</head>
<body>
    <?php
        if ($_SESSION['utilisateur']['Acces'] == 'admin') {
            include("include/navbar-top-admin.php");
        }
        else {
            include("include/navbar-top.php");
        }
    ?>
    <section id="contenu">
        <header id="accueil-banner">
            <span id="fleche-gauche"></span>
            <h1 id="film-titre"><?php echo $film['Nom']; ?></h1>
            <img src="<?php echo $film['Image']; ?>" style="right: 10%;">
            <span id="header-fleche"></span>
            <span id="fleche-out"></span>
        </header>
        <div id="page">
            <p class="film-desc">
                    <?php echo $film['Description']; ?>
            </p>
    </div>
    </section>
    <?php include "include/footer.php"; ?>
</body>
</html>
