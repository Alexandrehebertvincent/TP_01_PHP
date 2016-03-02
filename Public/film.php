<?php
// Vérification
include ("verificationConnexion.php");

if (isset($_GET['filmid'])){
	// Inclure le fichier de connexion.
     require("config.php");
	echo "<a href='index.php'>Retour à la liste des films</a>";
	 try {
		 
	 $req = $connBD->prepare('SELECT * FROM films WHERE Id =:id');
      $req->execute(array("id"=>$_GET['filmid']));
	  
	  while ($donnees = $req->fetch()) {
		  echo "<h1>";
		  echo $donnees['Nom'];
		  echo "</h1>";
		  //echo '<img src="' . $donnees['Image'] . "\" alt='Image du film' >";
		  echo '<img src="' . $donnees['Image'] . "\" height='450'width='450' alt='Image du film'>";
		  echo "<p>";
		  echo $donnees['Description'];
		  echo "</p>";
	  }
	  }
	  catch (PDOException $e) {
                exit( "Erreur lors de l'exécution de la requête SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQUÊTE = SELECT");
            }
	  }		
	else{
		header("LOCATION:index.php");
}
?>