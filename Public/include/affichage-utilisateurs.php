
<?php 
require("config.php");
			try {
				$req = $connBD->prepare('SELECT * FROM users');
				$req->execute();
				
				echo ' <table style="width:60%">';
				while ($donnees = $req->fetch()) {
					echo "<tr>";
						// Si l'utilisateur est connecté en tant qu'admin, il voit un bouton pour supprimer le film et un autre pour modifier
					 if ($_SESSION['utilisateur']['Acces'] == "admin"){
						 echo "<td>";
						 echo '<a href="include/supprimer-utilisateur.php?userid=' . $donnees['Id'] . '" class="button file-upload-btn btn-auto">Supprimer</a>';
						 echo "</td>";
						 echo "<td>";
						 echo '<a href="modifier-utilisateur.php?userid=' . $donnees['Id'] . '" class="button file-upload-btn btn-auto">Modifier</a>';
						 echo "</td>";
					 }
					echo "<td>";
					echo "Id:";
					echo $donnees['Id'];
					echo "</td>";
					echo "<td>";
					echo "Nom d'utilisateur: " . $donnees['Nom'];
					echo "</td>";
					echo "<td>";
					echo "Type d'utilisateur: " . $donnees['Acces'];
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