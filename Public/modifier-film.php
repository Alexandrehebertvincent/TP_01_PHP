<?php

// Vérification connexion
include ("include/verification-connexion.php");
include ("include/fonctions.php");

echo "Connecté en tant que: " . $_SESSION['utilisateur']['Nom'] . " (" . $_SESSION['utilisateur']['Acces'] . ")";

		if (isset($_GET['filmid']) AND $_GET['filmid'] != "" AND VerifierIdFilmExistant($_GET['filmid'])) {
			
		
			require("include/config.php");
		
		try {
			$req = $connBD->prepare('SELECT * FROM films WHERE Id=:id');
				$req->execute(array(
				'id'=> $_GET['filmid'] ));
		
			$donnees = $req->fetch();

		}
		catch (PDOException $e) {
                exit( "Erreur lors de l'exécution de la requête SQL :<br />\n" .  $e -> getMessage() . "<br />\nREQUÊTE = SELECT");
            }
		}
		else {
			var_dump( VerifierIdFilmExistant($_GET['filmid']));
			echo "Une erreur s'est produite. Vérifiez le 'Id' du film à modifier...";
			$erreur = true;
		}
		
		$req->closeCursor();
				$connBD = null;
        ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier film <?php echo $donnees['nom']; ?></title>
	<link rel="stylesheet" type="text/css" href="css/styleIndex.css" media="all" />
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
    <link rel="icon" href="favicon.ico" />
</head>
<body>

    <!-- Menu -->
    <?php include ("navbar-top.php"); ?>
	<h1> Modifier un film | <?php echo $donnees['Nom']; ?></h1>
	<div id="page">
	<?php if (!isset($erreur)) { ?>
        <div id="blocAlign">
                <form method="post" id="frmajout" action="include/update.php" enctype="multipart/form-data>
					<p>
						<label for="titreFilm">Titre du film: </label>
						<input type="text" name="titre" id="titre" size="42" value="<?php echo $donnees['Nom'] ?>"> . 
					</p>
					<p>
						<label for="description">Description: </label>
						<textarea name="resume" id="resume" form="frmajout" cols="40" rows="9"> <?php echo $donnees['Description']; ?></textarea>
					</p>
					<p>
						<label for="image">Image: </label>
						<input type="file" name="laimage" id="laimage" />
					</p>
					<p>
						<input id="submit" type="submit" value="Mettre à jour le film - NE FONCTIONNE PAS ENCORE D: "/>
					</p>
					<input type="hidden" name="filmid" id="hiddenField" value=" <?php echo $donnees['Id'] ?>" />
					
				<div class="file-upload">
					<button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add Image</button>

					<div class="image-upload-wrap">
						<input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" />
					<div class="drag-text">
					  <h3>Drag and drop a file or select add Image</h3>
				</div>
				  </div>
				  <div class="file-upload-content">
					<img class="file-upload-image" src="#" alt="your image" />
					<div class="image-title-wrap">
					  <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
					</div>
				  </div>
				</div>
					
					
                </form>
			</div>
			<img src="' . $donnees['Image'] . '" height="400" width="400" alt="Image du film">
			
	<?php } ?>
	</div>
	
	<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script>
	function readURL(input) {
  if (input.files && input.files[0]) {

    var reader = new FileReader();

    reader.onload = function(e) {
      $('.image-upload-wrap').hide();

      $('.file-upload-image').attr('src', e.target.result);
      $('.file-upload-content').show();

      $('.image-title').html(input.files[0].name);
    };

    reader.readAsDataURL(input.files[0]);

  } else {
    removeUpload();
  }
}

function removeUpload() {
  $('.file-upload-input').replaceWith($('.file-upload-input').clone());
  $('.file-upload-content').hide();
  $('.image-upload-wrap').show();
}
$('.image-upload-wrap').bind('dragover', function () {
		$('.image-upload-wrap').addClass('image-dropping');
	});
	$('.image-upload-wrap').bind('dragleave', function () {
		$('.image-upload-wrap').removeClass('image-dropping');
});
</script>
	
</body>
</html>	