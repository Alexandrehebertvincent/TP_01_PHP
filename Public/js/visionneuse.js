window.addEventListener("load", init, false);
var vignettes;
var grandeImage;
var timer;

function init() {
	vignettes = document.getElementsByClassName("image-vignette");
	grandeImage = document.getElementById("grande-image-visionneuse");
	//timer = 

	for(var i = 0; i < vignettes.length; i++) {
		vignettes[i].addEventListener("mouseover", teste, false);
	}
	grandeImage.addEventListener("click", lienPageFilm, false);
}

function demarrerTimeout() {
	
}

function teste(e) {
	grandeImage.src = e.target.src;
}

function lienPageFilm(e) {
	//document.location.href = e.target
}