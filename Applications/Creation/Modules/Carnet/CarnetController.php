<?php

namespace Applications\Creation\Modules\Carnet;

use Library\BackController;
use Library\HTTPRequest;
use Library\Controls;
use Library\Config;
use Library\Entities\Groupe;
use Library\Entities\ContactHasGroupe;
use Library\Entities\Contact;
use Library\Entities\Numero;
use Library\Fichier;
use Library\Upload;
use Library\Utilities;

/**
 * classe permettant de creer les differents elements:
 * 1. un contact
 * 2. un groupe
 */
class CarnetController extends BackController {

    /**
     * methode permettant de creer un groupe
     */
    public function executeIndex(HTTPRequest $http) {

        $manager = $this->managers->getManagerOf('Groupe');
        $groups = $manager->find();
        $this->page()->addvar('groups', $groups);
        $this->page()->getGeneratedPage();
    }

    /**
     * methode permettant d'enregistrer un groupe
     */
    public function executeCreergroupe(HTTPRequest $http) {
        $control = new \Library\Controls();
        $erreur = $control->validationChamp($http->postData('groupe'));

        if ($control->estVide($erreur)) {
            //on peut proceder a la suite
           //
           //  echo 'on entre!';
            //on hydrate un bean qui va se charger de recuperer les infos et de faire la verification

            $manager = $this->managers->getManagerOf('Groupe');
            $group = new Groupe();

            $group['nom'] = $http->postData('groupe');
           // $group['idUser'] = 1;
            /*//var_dump($group);
            //var_dump($manager);*/
            $manager->create($group);
            // on se redirige
            $_SESSION['success_message']="Groupe crée avec succès!";
            $this->app()->httpResponse()->redirect('creation/carnet/index');
        }
        $this->page()->addvar('error_message', $erreur);
        $this->page()->getGeneratedPage();
    }

    /**
     * methode permettant d'enregistrer un contact
     */
    public function executeCreercontact(HTTPRequest $http) {

        $control = new \Library\Controls();
        $erreur = array();

        try{

            if($http->postExists('create')){
                $this->managers->beginTransaction();

                $manager = $this->managers->getManagerOf('Contact');
                $numeroManager = $this->managers->getManagerOf('Numero');
                $groupeManager = $this->managers->getManagerOf('Groupe');
                $contactHasGroupeManager = $this->managers->getManagerOf('ContactHasGroupe');

                //on cree le contact
                $contact = new Contact();
                $contact['nom'] = $http->postData('nom');
                $erreur[] = $control->validationChamp($contact['nom']);
                $contact['prenom'] = $http->postData('prenom');
                $contact['email'] = $http->postData('email');
                $id = $manager->create($contact);

                ////Utilities::print_s("creation de contact ok");

                //on enregister les numeros
                $numeros = $http->postData('numero');
                foreach($numeros as $numero){
                    if(strlen($numero) > 0){
                        $num = new Numero();
                        $num['idContact'] = $id;
                        $num['numero'] = $numero;
                        $numeroManager->create($num);
                    }
                }

                ////Utilities::print_s("creation de numeros ok");
                

                //on cree le groupe
                if($http->postExists('inputAutreGroupe') && strlen($http->postData('inputAutreGroupe'))){
                    $groupe = new Groupe();
                    $groupe['nom'] = $http->postData('inputAutreGroupe');
                    $groupeManager->create($groupe);
                }else{
                    $groupe = $groupeManager->get($http->postData('groupeContact'));
                    if($groupe['id'] <= 0){
                        throw new \Exception('groupe invalide ' . $http->postData('groupeContact'));
                    }
                }

                //on sauvegarder le groupe
                $contactHasGroupe = new ContactHasGroupe();
                $contactHasGroupe['contact'] = $contact;
                $contactHasGroupe['groupe'] = $groupe;

                $contactHasGroupeManager->create($contactHasGroupe);
                ////Utilities::print_s("lien entre contact et groupe  ok");

                $_SESSION['success_message']="Contact cree avec succes!";
                $this->managers->commit();

                $this->app()->httpResponse()->redirect('test/contact/');

            }
        }catch(\Exception $e){
            $this->managers->roolBack();
            $erreur[] = $e->getMessage();
        }


        $resultErreur = '';
        foreach ($erreur as $r) {
            $resultErreur = $resultErreur . PHP_EOL . $r;
        }
        $manager = $this->managers->getManagerOf('Groupe');
        $groups = $manager->find();
        $this->page()->addvar('groups', $groups);

        $this->page()->addvar('error_message', $resultErreur);
        $this->page()->getGeneratedPage();
    }

    /**
     * methode permettant l'uploade de contacts
     */
    public function executeUploadercontacts(HTTPRequest $http) {
        $fichier = new Fichier();
        //on uploade le fichier
        $config=new Config($this->app());
        $nombre=count($fichier->listeFichierRepertoire($config->get('cheminDossierReception')));
        $nombre++;
        $upload = new Upload();
        $resultUpload = $upload->uploaderGeneral($config->get('cheminDossierReception'), $config->get('nomFichier').$nombre.'.csv');
        $erreur = '';
        ////Utilities::print_table("<hr>");
        //puis on enregistre les elements dans la bd
        if ($resultUpload) {
            //echo 'on arrice ic';
            $forme = array();
            $forme[] = 'nom';
            //$forme[] = 'prenom';
            //$forme[] = 'email';
            $forme[] = 'numero1';
            $forme[] = 'numero2';
            $forme[] = 'numero3';
            $result = $fichier->traiteFichier($config->get('cheminDossierReception').'\\'.$config->get('nomFichier').$nombre.'.csv', $forme);
            //on passe a la validation tous les champs de tous les contacts
            ////var_dump($result);
            
            $flag = false;
            $tabContacts = array();
            foreach ($result as $elem) {
                //
                ////var_dump($elem);
                if (!$this->validationContact($elem)) {
				echo 'echec validation';
                    $flag = true;
                    break;
                }
                $contactTo=array();
                $contactTo['nom']=$elem['nom'];
                //$contactTo['prenom']=$elem['prenom'];
                //$contactTo['email']=$elem['email'];
                $contactTo['numero1']=$elem['numero1'];
                if(isset($elem['numero2']))
                {
                    $contactTo['numero2']=$elem['numero2'];
                }
                if(isset($elem['numero3']))
                {
                    $contactTo['numero3']=$elem['numero3'];
                }
                ////var_dump($http->postData('groupeUploadContact'));
                if($http->postExists('groupeUploadContact'))
                {
                    $contactTo['groupe']=$http->postData('groupeUploadContact');
                }else
                {
                    $contactTo['autre_groupe']=$http->postData('inputAutreUploadGroupe');
                    //on enregistre le nouveau groupe
                }
                Utilities::print_table($contactTo);
                
                if(!$this->saveContact($contactTo, $http))
                {
					echo 'echec save';
				 $flag=true;
                    break;
                }
            
            }
            if ($flag) {
                //y'a un contact invalide
                $erreur = 'Il y\'a des contacts invalides dans le fichier, Veuillez ressayer!';
            } else {
                //puis on passe au mapping dans la base de données
                //
                //success
                //echo 'success !';
                $_SESSION['success_message']="Upload effectue avec succes!";
                $this->app()->httpResponse()->redirect('test/contact/');
                
            }
        } else {
            $erreur = 'Erreur lors de l\'upload du fichier';
        }
        $manager = $this->managers->getManagerOf('Groupe');
        $groups = $manager->find();
        $this->page()->addvar('groups', $groups);
        $this->page()->addvar('error_message', $erreur);
        $this->page()->getGeneratedPage();
    }

    /**
     * methode de validation d'un contact
     */
    private function validationContact($contact) {
        $controls = new Controls();
        $erreurs = array();
        if (isset($contact['nom'])) {
            $erreurs[] = $controls->validationChamp($contact['nom']);
            ////var_dump($erreurs);
        } else if (isset($contact['prenom'])) {
            //$erreurs[]=$controls->validationChamp($contact['prenom'])
            ////var_dump($erreurs);
        } else if (isset($contact['email'])) {
            //$erreurs[]=$controls->validationEmail($contact['email']);
            ////var_dump($erreurs);
        } else if (isset($contact['numero1'])) {
            $erreurs[]=$controls->validationNombre($contact['numero1']);
            ////var_dump($erreurs);
        } else if (isset($contact['numero2'])) {
            //$erreurs[]=$controls->validationNombre($contact['numero2']);
            ////var_dump($erreurs);
        } else if (isset($contact['numero3'])) {
            //$erreurs[]=$controls->validationNombre($contact['numero3']);
            ////var_dump($erreurs);
        }
        ////var_dump($erreurs);
        return $controls->estVideTab($erreurs);
    }

    /**
     * methode d'enregistrement d'un contact
     */
    private function saveContact($contactTo, HTTPRequest $http) {

        if(strpos(strtoupper($contactTo['nom']), 'NOM')!==false)
        {
            echo 'ta grosse tete';
            return true;
        }
        
        $control = new \Library\Controls();
        $erreur = array();

        try{

                $this->managers->beginTransaction();

                $manager = $this->managers->getManagerOf('Contact');
                $numeroManager = $this->managers->getManagerOf('Numero');
                $groupeManager = $this->managers->getManagerOf('Groupe');
                $contactHasGroupeManager = $this->managers->getManagerOf('ContactHasGroupe');

                //on cree le contact
                $contact = new Contact();
                $contact['nom'] = $contactTo['nom'];
                $erreur[] = $control->validationChamp($contact['nom']);
                $contact['prenom'] = '';
                $contact['email'] = '';
				//var_dump($contact);
				//var_dump($erreur);
                $id = $manager->create($contact);
                $contact['id']=$id;
                //Utilities::print_s("creation de contact ok");
                ////var_dump($contact);
                //on enregister les numeros
                $numeros = array();
                $numeros[] = $contactTo['numero1'];
                if(isset($contactTo['numero2']))
                {
                    $numeros[]=$contactTo['numero2'];
                }
                if(isset($contactTo['numero3']))
                {
                    $numeros[]=$contactTo['numero3'];
                }
                foreach($numeros as $numero){
                    if(strlen($numero) > 0){
                        $num = new Numero();
                        $num['idContact'] = $id;
                        $num['numero'] = $numero;
                        $numeroManager->create($num);
                    }
                }
//var_dump($contactTo);
				
                //Utilities::print_s("creation de numeros ok");
                
                //on cree le groupe
                if(isset($contactTo['autre_groupe']))
                {
                    if(strlen($contactTo['autre_groupe'])<= 0)
                        throw new \Exception('veuillez spécifier le nom du groupe');
                    $groupe = new Groupe();
                    $groupe['nom'] = $contactTo['autre_groupe'];
                    $groupeManager->create($groupe);
                    
                }else if(isset($contactTo['groupe']))
                {
                    $groupe = $groupeManager->getName($contactTo['groupe']);
                    if($groupe['id'] <= 0){
                        throw new \Exception('groupe invalide ' . $contactTo['groupe']);
                    }
                }else{
                    throw new \Exception('veuillez specifier le groupe');
                }

                //on sauvegarder le groupe
                $contactHasGroupe = new ContactHasGroupe();
                $contactHasGroupe['contact'] = $contact;
                $contactHasGroupe['groupe'] = $groupe;

                
				//Utilities::print_s("creation ");
				//var_dump($contactHasGroupeManager->create($contactHasGroupe));
                $this->managers->commit();
                return true;
                
                //$this->app()->httpResponse()->redirect('home/contacts/');

        
            
        }catch(\Exception $e){
            $this->managers->roolBack();
            $erreur[] = $e->getMessage();
            Utilities::print_table($erreur);
            return false;
        }
    }

}
