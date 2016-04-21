<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Library;

/**
 * Description of Upload
 * classe permettant de gerer les uploads de fichiers
 * @author patrick
 */
class Upload {
    //put your code here
    
    /**
     * methode generale d'upload
     */
    public function uploaderGeneral($cheminDossierReception, $nomFichier)
    {
        //echo $cheminDossierReception;
        //var_dump($_FILES['fichier']);
        // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
        if (isset($_FILES['fichier']) AND $_FILES['fichier']['error']== 0)
        {
            // Testons si le fichier n'est pas trop gros
            
            try{
            if ($_FILES['fichier']['size'] <= 1000000)
            {
                // Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['fichier']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('csv');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                    // On peut valider le fichier et le stocker définitivement
                    //var_dump($cheminDossierReception.'\\'.$nomFichier);
                    move_uploaded_file($_FILES['fichier']['tmp_name'], $cheminDossierReception.'\\'.$nomFichier);
                   return true;
                }
                else
                {
                    return false;
                }
            } 
           }catch(Exception $e)
           {
             return false;
           }
        }
    }
    
}
