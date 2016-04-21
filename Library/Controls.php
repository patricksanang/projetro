<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Library;

/**
 * Description of Controls
 * Classe contenant toutes les methodes de controles du controlleur
 * @author patrick
 */
class Controls {
    //put your code here
     /**
     * methode qui teste que le tableau des erreurs est vide
     */
    public function estVide($erreurs)
    {
        return $erreurs=="";
    }
    /**
     * methode de test pour le tableau d'erreurs
     */
    public function estVideTab($erreurs)
    {
             foreach($erreurs as $cle => $element)
        {
            if($element!='')
            {
                return false;
            }
        }
        return true;
   
    }
    /**
     * methode de validation du matricule
     */
    public function validationMatricule($matricule)
    {
        $matricule = htmlspecialchars($matricule);
        $message="";
        if (!preg_match("#^[0-9]{2}P[0-9]{3}$#", $matricule))
        {
            $message= 'le matricule: ' .$matricule . ' n\'est pas valide!';
        }
        return $message;
    }
    
    /**
     * methode permettant de valider un email
     */
    public function validationEmail($email)
    {
        $email = htmlspecialchars($email);
        $message="";
        if (!preg_match("#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]{2,}\.[a-zA-Z]{2,4}$#",$email))
        {
            $message= 'L\'adresse mail: ' .$email . ' n\'est pas valide !';
        }
        return $message;
    }
     
    /**
     * methode de validation d'un champ simple
     */
    public function validationChamp($champ)
    {
        $champ = htmlspecialchars($champ);
        $message='';
        if ($champ=='')
        {
            $message= 'Veuillez entrer quelque chose!';
        }
        return $message;
    }
    
    /**
     * methode de validation d'un mot de passe
     */
    public function validationMotdepasse($motdepasse)
    {
        if ($this->validationChamp($motdepasse)!='')
        {
            return 'Veuillez entrer un mot de passe valide!';
        }  else {
            return '';
        }
        
    }
    
    /**
     * methode de validation des nombres
     */
    public function validationNombre($nombre)
    {
        $nombre = htmlspecialchars($nombre);
        $message="";
        if (!preg_match("#^[0-9]*$#",$nombre))
        {
            $message= 'Veuillez entrer un nombre!';
        }
        return $message;
    }
    
    /**
     * methode de validation des numeros de telephone
     */
    public function validationNumTel($code, $tel)
    {
        $nombre = htmlspecialchars($tel);
        $message="";
        if (!preg_match('#'.$code.'[0-9]*$'.'#',$nombre)||(!preg_match('#^[0-9]*$#',$nombre)))
        {
            $message= 'Veuillez entrer un numéro de téléphone valide!';
        }
        return $message;
    }
}