function active_preference(){
	var budget = $('#budget').val();
	var temps = $('#temps').val();
	if(budget!='' && temps!='')
		{
			alert("Disons bonjours");
			//$("preference_block").style="display:block;";
			document.getElementById("preference_block").style="display:block;";
			
		}
	else
		alert("Veillez d'abord remplir les champs ci-contre");
}
function active_modal(){
	document.getElementById("modal_block").style="display:block;";
}