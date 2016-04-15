window.addEventListener('load',init,false);

var noDiapo = 0;
var arrImgDesc = new Array(
	"Le bateau.",
	"Vue de l'hélicoptère.",
	"Quelle belle montagne!.",
	"Voici un joli petit port.",
	"Un glacier. Cela était absolument époustouflant!",
	"Un train qui passe à travers les montagnes.",
	"La vue à bord du train."
);

function init()
{	
	var phpVars = new Array();
	
	document.getElementById("btnPrec").addEventListener('click',afficherDiapo,false);
	document.getElementById("btnSuiv").addEventListener('click',afficherDiapo,false);
	
	 var phpVars = new Array();
    <?php foreach($vars as $var) {
        echo 'phpVars.push("' . $var . '");';
    };
    ?>
	
	alert(phpVars);
}

function afficherDiapo(e)
{
	var direction = (e.target.id === "btnSuiv") ? 1 : -1;
	
	noDiapo = noDiapo + direction;
	
	if(noDiapo < 0 )
	{
		noDiapo = arrImgDesc.length-1;
	}
	
	if(noDiapo === arrImgDesc.length)
	{
		noDiapo = 0;
	}
	
	//document.getElementById("imgvisionneuse").src = "images/diapo" + noDiapo + ".jpg";
	document.getElementById("imgText").textContent = arrImgDesc[noDiapo];
	document.getElementById("imgvisionneuse").alt = arrImgDesc[noDiapo];
}