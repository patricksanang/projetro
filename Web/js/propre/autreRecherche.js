function verifAutreRecherche()
{
	var inputs = document.getElementsByTagName('input'),
	inputsLength = inputs.length;
	for (var i = 0 ; i < inputsLength ; i++) {
		if (inputs[i].type == 'radio' && inputs[i].checked) {
				//alert('La case cochée est la n°'+ inputs[i].value);
				if((inputs[i].value=="ce")||(inputs[i].value=="de"))
				{
					document.getElementById('inputNomUA').style.display="none";
					document.getElementById('labelNomUA').style.display="none";
					document.getElementById('inputOrganisme').style.display="block";
					document.getElementById('inputNom').style.display="block";
					document.getElementById('labelOrganisme').style.display="block";
					document.getElementById('labelNom').style.display="block";
					document.getElementById('inputReference').style.display="block";
					document.getElementById('labelReference').style.display="block";
			
				}else if((inputs[i].value=="cs")||(inputs[i].value=="ds"))
				{
					document.getElementById('inputOrganisme').style.display="none";
					document.getElementById('inputNom').style.display="none";
					document.getElementById('labelOrganisme').style.display="none";
					document.getElementById('labelNom').style.display="none";
					document.getElementById('inputNomUA').style.display="block";
					document.getElementById('labelNomUA').style.display="block";
					document.getElementById('inputReference').style.display="block";
					document.getElementById('labelReference').style.display="block";
				}else if(inputs[i].value=="reaffectation")
				{
					document.getElementById('inputNomUA').style.display="block";
					document.getElementById('labelNomUA').style.display="block";
					document.getElementById('inputReference').style.display="none";
					document.getElementById('labelReference').style.display="none";
				}
		}
	}
}

function check() {
}