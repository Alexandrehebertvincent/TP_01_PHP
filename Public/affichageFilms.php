<?php 

require("config.php");
			
echo "Voici tout ce qui se trouve dans la base de données: ";
			try {

				$req = $connBD->prepare('SELECT * FROM films');
				$req->execute();

				// echo '<p>';
				// while ($donnees = $req->fetch()) {
					// echo '<li>' . "Id: " . $donnees['Id'] . ", " . "Nom: " . $donnees['Nom'] . ", " . "Description: " . $donnees['Description'] . ", " . "Image: " . $donnees['Image'] . ' </li>';
				// }
				// echo '</p>';
				
				// while ($donnees = $req->fetch()) {
					// echo "$donnees['Id']";
				// }
				
				echo ' <table style="width:60%">';

				// <a href="film.php?film=[ID du film]"


				while ($donnees = $req->fetch()) {
					echo "<tr>";
					// Si l'utilisateur est connecté en tant qu'admin, il voit un bouton pour supprimer le film
					 if ($_SESSION['utilisateur']['Acces'] == "admin"){
						 echo "<td>";
						 echo '<a href="supprimer.php?filmid=' . $donnees['Id'] . '">Supprimer </a>';
						 echo "</td>";
					 }
					 echo "<td>";
					echo '<a href="film.php?filmid='.$donnees['Id'].'">Fiche du film</a>';
					echo "</td>";
					echo "<td>";
					echo $donnees['Nom'];
					echo "</td>";
					echo "<td>";
					echo '<img src="' . $donnees['Image'] . "\" height='400'width='400' alt='Image du film'>";
					echo "</td>";
					echo "</tr>";
				}
				echo '</tr>
				</table>  ';

				$req->closeCursor();
				$connBD = null;
			} catch (PDOException $e) {
				exit("Erreur lors de l'ex�cution de la requ�te SQL :<br />\n" . $e->getMessage() . "<br />\nREQU�TE = SELECT");
			}
			?>