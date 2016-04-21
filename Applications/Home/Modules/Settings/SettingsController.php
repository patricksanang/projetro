<?php
namespace Applications\Accueil\Modules\Settings;
use Library\BackController;
use Library\HTTPRequest;
use Library\Controls;

class SettingsController extends BackController{
	//permet l'authentification de l'utilisateur pour regarder le so
	//si ce dernier est deja connecter et qui'l demander
	//une nouvelle authentification, on le rediriger vers
	//la page d'acceuil
    public function executeSettings(HTTPRequest $http){
            $this->page()->addVar('message' , 'open login');
            /*var_dump($http);
            var_dump($http->postData('login'));*/
            //on commence par le test
            $control=new \Library\Controls();
            $erreur=$control->validationChamp($http->postData('username'));
           //on controle le password
            if(!$control->estVide($erreur))
            {
                $erreur=$erreur.PHP_EOL.$control->validationChamp($http->postData('password'));
            }else
            {
                $erreur=$control->validationChamp($http->postData('password'));
            }
            
        if($control->estVide($erreur))
        {
            //on peut proceder a la suite
            //on enregistre dans la base de données
            //il faut voir le model pdo qui peut faire ca avec noyessie
               
	}
        $this->page()->addVar('error_message', $erreur);
        $this->page()->getGeneratedPage();
        }
	public function __construct($app, $module, $action)
	{
		parent::__construct($app, $module, $action);
	}
        
}