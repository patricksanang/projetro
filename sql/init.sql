#-- initialistaion de la table groupe
INSERT INTO groupe VALUE(0 , 'Public');

#-- initialisation des contact
INSERT INTO contact VALUE( 0 , 'inconue' , 'inconue' , '' );

#-- initialisation des user
INSERT INTO user(nom, prenom, adressemail, motdepasse) VALUE ('admin', 'admin', 'admin@admin.com', 'admin');