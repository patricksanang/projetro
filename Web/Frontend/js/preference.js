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

$("#modal_block1, #modal_block2, #modal_block3, #modal_block4, #modal_block5").each(function(){
	var self = $(this);
	self.find("input:checkbox").change(function () {
		console.log("yoipi");
		var n = self.find("input:checkbox:checked").length;
		if( n == 2){
			self.find("input:checkbox:not(:checked)").attr("disabled", true);//prop("disable", true );
			$('.modal_footer').append("<div class='alert alert-warning'><strong>Warning!</strong></div> ");

		}
		else if( n < 2){
			self.find("input:checkbox").attr("disabled", false);//.prop("disable", false );
		}
		
	});
});