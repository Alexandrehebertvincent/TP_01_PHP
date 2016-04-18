window.addEventListener("load", init, false);
//var vignettes;
var balisesImgVignettes
var grandeImage;
var timer;
var indexGrandeImage = 1;

function init() {
	vignettes = document.getElementsByClassName("vignette-visionneuse");
	balisesImgVignettes = document.getElementsByClassName("image-vignette")
	grandeImage = document.getElementById("grande-image-visionneuse");

	for(var i = 0; i < vignettes.length; i++) {
		//vignettes[i].addEventListener("mouseover", survolerVignette, false);
		balisesImgVignettes[i].addEventListener("click", survolerVignetteImg, false);
		balisesImgVignettes[i].addEventListener("mouseover", grossirVignette, false);
		//vignettes[i].addEventListener("mouseout", demarrerTimeout, false);
		balisesImgVignettes[i].addEventListener("mouseout", demarrerTimeout, false);
	}
	grandeImage.addEventListener("click", lienPageFilm, false);
	grandeImage.src = balisesImgVignettes[0].src;
	demarrerTimeout();
}

function demarrerTimeout() {
	timer = window.setInterval(prochaineImage, 1000);
}

function arreterTimeout() {
	window.clearInterval(timer);
}

function prochaineImage(e) {
	grandeImage.src = balisesImgVignettes[indexGrandeImage].src;
	indexGrandeImage += 1;
	if (indexGrandeImage >= balisesImgVignettes.length) {
		indexGrandeImage = 0;
	}
}

function survolerVignette(e) {
	arreterTimeout();
	grandeImage.src = e.target.children[1].src;
	console.log(e.target.children[1]);
}

function survolerVignetteImg(e) {
	arreterTimeout();
	grandeImage.src = e.target.src
}

function lienPageFilm(e) {
	//document.location.href = e.target
}