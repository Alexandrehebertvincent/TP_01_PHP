var xhr;
var indexVignette;
var timer;
var aVignettes;
var imgVignettes;
var grandeImage;
var aGrandeImage;
var liVignettes;
var btnsSupprimer;

window.addEventListener("load", fonctionXhr, false);

function init() {
	
	indexVignette = 0;
	
	aVignettes = document.getElementsByClassName("aVignette");
	imgVignettes = document.getElementsByClassName("imgVignette");
	grandeImage = document.getElementById("grande-image-visionneuse");
	aGrandeImage = document.getElementById("aGrandeImage");
	liVignettes = document.getElementsByClassName("liVignette");
	btnsSupprimer = document.getElementsByClassName("button file-upload-btn btn-auto btn-red");
	
	grandeImage.addEventListener("mouseover", arretDefilement, false)
	grandeImage.addEventListener("mouseout", DemarrerTimer, false)
	
	demarrerDefilement();
	DemarrerTimer();
	
	for (var i = 0; i < imgVignettes.length; i++) {
		liVignettes[i].addEventListener("click", choisirImage, false);
	}
	
	for (var i = 0; i < btnsSupprimer.length; i++) {
		btnsSupprimer[i].addEventListener("click", ConfirmationSupprimer, false);
	}
}

function DemarrerTimer() {
	//prochaineImage();
	if (null == timer) {
		arretDefilement();
	}
	timer = setInterval(demarrerDefilement, 2500);
}

function demarrerDefilement() {
	for (var i = 0; i < lesFilms.length; i++) {
		liVignettes[i].id = "";
	}
	grandeImage.src = imgVignettes[indexVignette]["src"];
	aGrandeImage.href = aVignettes[indexVignette]["lien"];
	liVignettes[indexVignette].id = "enEvidence";
	
	indexVignette += 1;
	if (indexVignette >= imgVignettes.length) {
		indexVignette = 0;
		liVignettes[imgVignettes.length - 2].id = "";
	}
	else {
		if (indexVignette == 1) {
			liVignettes[imgVignettes.length - 1].id = "";
		}
		else {
			liVignettes[indexVignette - 2].id = "";
		}
	}
}

function arretDefilement() {
	clearInterval(timer);
}

function choisirImage(e)  {
	grandeImage.src = e.target.src;
	aGrandeImage.href = "film.php?filmid=" + lesFilms[e.target.index]["Id"];
	indexVignette = e.target.index;
	
	for (var i = 0; i < lesFilms.length; i++) {
		liVignettes[i].id = "";
	}
	
	liVignettes[e.target.index].id = "enEvidence";
	
	arretDefilement();
	DemarrerTimer();
}

function ConfirmationSupprimer(e) {
	var hrefDuBtnSupprimer = e.target.href
	var posSigneEgal = hrefDuBtnSupprimer.lastIndexOf("=")
	var filmId = hrefDuBtnSupprimer.substring(posSigneEgal+1, hrefDuBtnSupprimer.length);
	
	// alert(btnsSupprimer.length);
	
	// e.preventDefault();
	
	// for(var i = 0; i < btnsSupprimer.length; i++) {
		// alert( lesFilms[i].Id + " et " + filmId);
		// if (lesFilms[i].Id == filmId) {
			// titreFilm = lesFilms[i].Nom;
		// }
	// }
	
	alert(e.titreFilm);
		
	response = confirm("Voulez-vous vraiment supprimer le film " + e.target.titreFilm + " ?");
	if (response != true) {
		e.preventDefault();
	}

}

function fonctionXhr(e) {
	// Annuler la requête précédente s'il y a lieu car une nouvelle requête est
	// lancée à chaque keyup et on ne veut pas les résultats du keyup précédent
	if(xhr) {
		xhr.abort();
	}
			
	// Création de l'objet XMLHttpRequest.
	xhr = new XMLHttpRequest();

	// Fonction JavaScript à exécuter lorsque l'état de la requête HTTP change.
	xhr.addEventListener('readystatechange',fonctionXhrCallBack,false);
	
	// URL pour la requête HTTP avec AJAX (inclut le paramètre).
	//var URL = 'serveur-ajax-json-get-like.php?recherche=' + encodeURIComponent($('recherche').value.trim());
	var URL = "include/visionneuse.php";
	
	// Préparation de la requête HTTP-GET en mode asynchrone (true).
	xhr.open('GET', URL, true);
	
	// Envoie de la requête au serveur en lui passant null (aucun contenu);
	// lorsque la requête changera d'état; la fonction "afficherInfoMembreMembreAJAX_callback" sera appelée.
	xhr.send(null);
}

function fonctionXhrCallBack(e) {
	if (xhr.readyState == 4) {
		var erreur = false;
		//var lesFilms;
		if (xhr.status != 200) {
			var msgErreur = 'Erreur (code=' + xhr.status + '): La requête HTTP n\'a pu être complétée.';
			$('msg-erreur').textContent = msgErreur;
			erreur = true;
		}
		else {
			try { 
				lesFilms = JSON.parse(xhr.responseText);;
			} catch (e) {
				alert('ERREUR: La réponse AJAX n\'est pas une expression JSON valide.');
				erreur = true;
			}
			if (!erreur) {
				 for (var i = 0; i < lesFilms.length; i++) {
					var liVignette = document.createElement("li");
					liVignette.className = "liVignette";
					var divVignette = document.createElement("div");
					divVignette.className = "divVignette";
					var aVignette = document.createElement("a");
					aVignette.className = "aVignette";
					aVignette.lien = "film.php?filmid=" + lesFilms[i]["Id"];
					var imgVignette = document.createElement("img");
					imgVignette.className = "imgVignette";
					imgVignette.src = lesFilms[i]["Image"];
					imgVignette.index = i;
					
					aVignette.appendChild(imgVignette);
					divVignette.appendChild(aVignette);
					liVignette.appendChild(divVignette);
					
					document.getElementById("ul-visionneuse").appendChild(liVignette);
				 }
			}
		}
		init();
	}
}