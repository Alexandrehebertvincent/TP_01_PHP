
<?php 
require("config.php");
			try {
				$req = $connBD->prepare('SELECT * FROM films');
				$req->execute();
				
				echo ' <table style="width:60%">';
				while ($donnees = $req->fetch()) {
					echo "<tr>";
					// Si l'utilisateur est connecté en tant qu'admin, il voit un bouton pour supprimer le film et un autre pour modifier
					 if ($_SESSION['utilisateur']['Acces'] == "admin"){
						 echo "<td>";
						 echo '<a href="include/supprimer.php?filmid=' . $donnees['Id'] . ' class="button" "><button>Supprimer</button></a>';
						 echo "</td>";
						 echo "<td>";
						 echo '<a href="modifier-film.php?filmid=' . $donnees['Id'] . ' class="button" "><button>Modifier</button></a>';
						 echo "</td>";
					 }
					 echo "<td>";
					echo '<a href="film.php?filmid='.$donnees['Id'].'">Fiche du film</a>';
					echo "</td>";
					echo "<td>";
					echo $donnees['Nom'];
					echo "</td>";
					echo "<td>";
					echo '<img src="' . $donnees['Image'] . "\" height='350'width='350' alt='Image du film'>";
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