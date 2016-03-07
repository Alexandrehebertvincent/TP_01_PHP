<?php
// Vérification
include ("include/verification-connexion.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un film | Panama</title>
	<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic|Lato:400,100,300,700,900:latin' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/style.css" media="all" />
    <link rel="icon" href="favicon.ico" />
</head>
<body>

    <!-- Menu -->
    <?php 
		include ("navbar-top-admin.php"); 
		echo "Connecté en tant que: " . $_SESSION['utilisateur']['Nom'] . " (" . $_SESSION['utilisateur']['Acces'] . ")";
	?>
	<header id="banner-ajout-film">
		<h1>Ajouter un film</h1>
		<img src="http://btckstorage.blob.core.windows.net/site761/Film%20Club/filmreelLEFT.png">
	</header>
	<div id="page">
			<div id="blocAlign">
                <form method="post" id="frmajout" action="include/upload.php" enctype="multipart/form-data">
					<p>
						<label for="titreFilm">Titre du film: </label>
						<input type="text" name="titre" id="titre" size="42"/>
					</p>
					<p>
						<label for="description">Description: </label>
						<textarea  name="resume" id="resume" form="frmajout" cols="40" rows="9"></textarea>
					</p>
					<div class="file-upload">
						<button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Ajouter une image</button>
						<div class="image-upload-wrap">
							<input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" name="monfichier" id="image"/>
							<div class="drag-text">
								<h3>Déposer une image ici ou parcourir</h3>
							</div>
						</div>
						<div class="file-upload-content">
							<img class="file-upload-image" src="#" alt="your image" />
							<div class="image-title-wrap">
								<button type="button" onclick="removeUpload()" class="remove-image">Enlever <span class="image-title">cette image</span></button>
							</div>
						</div>
					</div>
					<p>
						<input class="file-upload-btn btn-auto" id="submit" type="submit" value="Ajouter le film"/>
					</p>
                </form>
			</div>
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