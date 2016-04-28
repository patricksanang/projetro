$(document).ready(function() {
    $('#preference_form').on('submit', function(e) {
        e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
		alert('tototo');
        var $this = $(this); // L'objet jQuery du formulaire
		var budget = $('#budget').val();
		var temps = $('#temps').val();
        
		if(!(budget!='' && temps!='')) {
            alert('Le champ matricule est obligatoire');
        } else {
            // Envoi de la requête HTTP en mode asynchrone
			alert('Nous entrons bien');
            $.ajax({
                url: 'controleur/tonFichierICI.php?type=connexion',
                type: 'POST', // La méthode indiquée dans le formulaire (get ou post)
                data: $this.serialize(), // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
                success: function(valeurRetour) { // Je récupère la réponse du fichier PHP
					if(valeurRetour=='1')
						document.location.replace('');
                    
					else
						alert('Echec de l operation ');

                }
            });
        }
    });
});