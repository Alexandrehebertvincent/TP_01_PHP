
<?php 
require("config.php");

// Champs de recherche:

echo '<div class="input-recherche">
	<label for="recherche" class="lbl-recherche">Recherche:</label>
	<input type="text" id="recherche" name="recherche" class="input-recherche" placeholder="Entrez votre recherche...">
</div>
<hr>';

try {
	$req = $connBD->prepare('SELECT * FROM users ORDER BY Acces, Nom');
	$req->execute();

	echo ' <table id="user-table" style="width:60%">';
	while ($donnees = $req->fetch()) {
	echo "<tr>";
	// Si l'utilisateur est connecté en tant qu'admin, il voit un bouton pour supprimer le film et un autre pour modifier
	if ($_SESSION['utilisateur']['Acces'] == "admin"){
	echo "<td>";
	echo '<a nomuser="'.$donnees['Nom'].'" href="include/supprimer-utilisateur.php?userid=' . $donnees['Id'] . '" class="button file-upload-btn btn-auto btn-red">Supprimer</a>';
	echo "</td>";
	echo "<td>";
	echo '<a href="modifier-utilisateur.php?userid=' . $donnees['Id'] . '" class="button file-upload-btn btn-auto btn-orange">Modifier</a>';
	echo "</td>";
	}
	echo "<td>";
	echo "Nom d'utilisateur: " . $donnees['Nom'];
	echo "</td>";
	echo "<td>";
	echo "Type d'utilisateur: " . $donnees['Acces'];
	echo "</td>";
	echo "</tr>";
	}
	echo '
	</table>  ';

	$req->closeCursor();
	$connBD = null;
} catch (PDOException $e) {
	exit("Erreur lors de l'ex�cution de la requ�te SQL :<br />\n" . $e->getMessage() . "<br />\nREQU�TE = SELECT");
}