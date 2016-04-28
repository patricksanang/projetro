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
function DecocheTout(ref) {
	var form = ref;
 
	while (form.parentNode && form.nodeName.toLowerCase() != 'form'){ 
		form = form.parentNode; 
	}
 
	var elements = form.getElementsByTagName('input');
 
	for (var i = 0; i < elements.length; i++) {
		if (elements[i].type == 'checkbox') {
			elements[i].checked = ref.checked;
		}
	}
}