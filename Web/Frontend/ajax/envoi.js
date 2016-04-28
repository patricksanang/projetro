/*$(document).ready(function() {
    $('#preference_form').on('submit', function(e) {
        e.preventDefault(); // J'emp�che le comportement par d�faut du navigateur, c-�-d de soumettre le formulaire
		alert('tototo');
        var $this = $(this); // L'objet jQuery du formulaire
		var budget = $('#budget').val();
		var temps = $('#temps').val();
        
		if(!(budget!='' && temps!='')) {
            alert('Le champ matricule est obligatoire');
        } else {
            // Envoi de la requ�te HTTP en mode asynchrone
			alert('Nous entrons bien');
            $.ajax({
                url: 'controleur/tonFichierICI.php?type=connexion',
                type: 'POST', // La m�thode indiqu�e dans le formulaire (get ou post)
                data: $this.serialize(), // Je s�rialise les donn�es (j'envoie toutes les valeurs pr�sentes dans le formulaire)
                success: function(valeurRetour) { // Je r�cup�re la r�ponse du fichier PHP
					if(valeurRetour=='1')
						document.location.replace('');
                    
					else
						alert('Echec de l operation ');

                }
            });
        }
    });
});*/
