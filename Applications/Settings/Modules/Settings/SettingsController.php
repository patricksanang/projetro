<?php
namespace Applications\Settings\Modules\Settings;
use Library\BackController;
use Library\HTTPRequest;
use Library\Entities\User;
use Library\Controls;
use Library\Config;
use Library\Api;
class SettingsController extends BackController{
	public function executeIndex(HTTPRequest $http){
            $config=new Config($this->app());
            //cheminDossierReception
            $this->page()->addVar('cheminDossierReception', $config->get('cheminDossierReception'));
            //nomFichier
            $this->page()->addVar('nomFichier', $config->get('nomFichier'));
            //usernameAPI
            $this->page()->addVar('usernameAPI', $config->get('usernameAPI'));
            //passwordAPI
            $this->page()->addVar('passwordAPI', $config->get('passwordAPI'));
            //senderAPI
            $this->page()->addVar('senderAPI', $config->get('senderAPI'));
            
            $this->page()->getGeneratedPage();
        }
        public function executeVerification(HTTPRequest $http){
            $config=new Config($this->app());
            $flag=false;
            if(($http->postExists('cheminDossierReception'))&&($http->postData('cheminDossierReception')!=''))
            {
                //alors on le change
                $config->set('cheminDossierReception', $http->postData('cheminDossierReception'));
            }
            if(($http->postExists('nomFichier'))&&($http->postData('nomFichier')!=''))
            {
                $config->set('nomFichier', $http->postData('nomFichier'));
            }
            if(($http->postExists('usernameAPI'))&&($http->postData('usernameAPI')))
            {
                $config->set('usernameAPI', $http->postData('usernameAPI')); 
            }
            if(($http->postExists('passwordAPIOld'))&&($http->postData('passwordAPIOld')!=''))
            {
                //on verifie que c'est le meme que l'ancien
                if($config->get('passwordAPI')==$http->postData('passwordAPIOld'))
                {
                    //on continue
                    $config->set('passwordAPI', $http->postData('passwordAPINew'));
                }else
                {
                    $flag=true;
                    //on renvoit un message d'erreur
                    $erreur='Mot de passe incorrect, veuillez recommencer!';
                }
            }
            if(($http->postExists('senderAPI'))&&($http->postData('senderAPI')!=''))
            {
                $config->set('senderAPI', $http->postData('senderAPI'));
            }
            if($flag)
            {
                //cheminDossierReception
            $this->page()->addVar('cheminDossierReception', $config->get('cheminDossierReception'));
            //nomFichier
            $this->page()->addVar('nomFichier', $config->get('nomFichier'));
            //usernameAPI
            $this->page()->addVar('usernameAPI', $config->get('usernameAPI'));
            //passwordAPI
            $this->page()->addVar('passwordAPI', $config->get('passwordAPI'));
            //senderAPI
            $this->page()->addVar('senderAPI', $config->get('senderAPI'));
            
                $this->page()->addVar('error_message', $erreur);
                $this->page()->getGeneratedPage();
            }
                $_SESSION['success_message']="Modifications effectuées!";
                $this->app()->httpResponse()->redirect('home/');
            
            
        }
	
}