var visionneuse = document.getElementById("visionneuse");
var lesFilms = document.getElementsByClassName("film-section-image");
var lesLiens = document.getElementsByClassName("lien-film");

for (var i = 0; i < lesFilms.length; i++) {
	if (lesFilms[i].style["background-image"].split("\"")[1] != undefined) {
		var lien = document.createElement("a");
		lien.href = lesLiens[i].href;
		lien.className = "lien-visionneuse";
		//lien.style.borderStyle = "solid";
		var nouvImg = document.createElement("img");
		nouvImg.src = lesFilms[i].style["background-image"].split("\"")[1];
		//nouvImg.width = "60px";
		//nouvImg.height = "80px";
		nouvImg.style.width = "80px";
		nouvImg.style.height = "100px";
		lien.appendChild(nouvImg);
		visionneuse.appendChild(lien);
	}
	ajouterEventsListener();
}

function ajouterEventsListener() {
	var lesImagesVisionneuse = document.getElementsByClassName("lien-visionneuse");
	for (var i = 0; i < lesImagesVisionneuse.length; i++) {
		lesImagesVisionneuse[i].addEventListener("mouseover", bordersBleu, false);
		lesImagesVisionneuse[i].addEventListener("mouseout", enleverBorders, false);
	}
}

function bordersBleu(e) {
	var size = "120";
	var size2 = "96"
	e.target.style.height = size + "px";
	e.target.style.width = size2 + "px";
}

function enleverBorders(e) {
	e.target.borderColor = "white";
	e.target.style.height = "100px";
	e.target.style.width = "80px";
}