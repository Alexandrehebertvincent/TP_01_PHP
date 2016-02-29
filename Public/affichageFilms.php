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

				while ($donnees = $req->fetch()) {
					echo "<tr>";
					echo "<td>";
					echo $donnees['Id'];
					echo "</td>";
					echo "<td>";
					echo $donnees['Nom'];
					echo "</td>";
					echo "<td>";
					echo $donnees['Description'];
					echo "</td>";
					echo "<td>";
					echo $donnees['Image'];
					echo "</td>";
					echo "</tr>";
				}
				echo '</tr>
				</table>  ';
				
				

				$req->closeCursor();
				$connBD = null;
			} catch (PDOException $e) {
				exit("Erreur lors de l'exécution de la requête SQL :<br />\n" . $e->getMessage() . "<br />\nREQUÊTE = SELECT");
			}
			?>