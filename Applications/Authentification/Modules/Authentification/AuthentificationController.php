<?php
namespace Applications\Authentification\Modules\Authentification;
use Library\BackController;
use Library\HTTPRequest;
use Library\Entities\User;
use Library\Controls;
use Library\Backup;

class AuthentificationController extends BackController{
	//permet l'authentification de l'utilisateur
	//si ce dernier est deja connecter et qui'l demander
	//une nouvelle authentification, on le rediriger vers
	//la page d'acceuil
	public function executeVerification(HTTPRequest $http){
            $this->page()->addVar('message' , 'open login');
            /*var_dump($http);
            var_dump($http->postData('login'));*/
            //on commence par le test
            $control=new \Library\Controls();
            $erreur=$control->validationChamp($http->postData('login'));
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
           //     echo 'on entre!';
            //on hydrate un bean qui va se charger de recuperer les infos et de faire la verification
                
                $manager = $this->managers->getManagerOf('User');
		$user = new User();

		$user['email'] = $http->postData('login');
		$user['password'] = $http->postData('password');

                $result=$manager->find();
		foreach($result as $userResult)
                {
                    if(($userResult->getEmail()==$http->postData('login'))&&($userResult->getPassword()==$http->postData('password')))
                    {
                            //c'est ok!
                            //on continue dans la plateforme
                            $_SESSION['user']=$userResult['nom'];
                            $this->app()->httpResponse()->redirect('home/');
                        break;
                    }
                }
                //sinon c'est le ndem, on rentre à la page de depart
                $erreur="Utilisateur inconnu!";
               
	}
        $this->page()->addVar('error_message', $erreur);
        $this->page()->getGeneratedPage();
        
        }
        /*public function executeLogin(HTTPRequest $http){
            $backup=new Backup();
            $backup->save();
            $this->page()->getGeneratedPage();
            }*/
       public function executeLogin(HTTPRequest $http){
		if($this->app()->session()->isAuthenticated()){
			if($this->app()->session()->getAttribute('user')['username']
                                == 'admin'){
				$this->app()->httpResponse()->redirect('admin/home');
			}else{
				$this->app()->httpResponse()->redirect('etudiant/home');
			}
		}
		//si l'utilisateur fait une demande de connection
		if($http->postExists('login') && $http->postExists('password')){
			$login = $http->postData('login');
			$password = $http->postData('password');
			$search = array('login'=>$login , 'password'=>$password);
			$manager = $this->managers->getManagerOf('User');
			$result = $manager->find($search);
			if(count($result)==1){
				//l'uilisateur est connecter
				$user = $result[0];
				$this->app()->session()->setAuthenticated(true);
				$this->app()->session()->setAttribute('user' , $user);
				//on rediriger vers l'accueil
				if($user['username'] == 'admin'){
					$this->app()->httpResponse()->redirect('admin/home');
				}else{
					$this->app()->httpResponse()->redirect('etudiant/home');
				}
			}else{
				$error_message = " Bad Login or Incorrect Password ";
				$this->page()->addVar('error_message' , $error_message);
			}
		}
	}

	public function executeLogout(HTTPRequest $http){
		$this->app()->session()->setAuthenticated(false);
		$this->app()->session()->setAttribute('user' , null);
		$this->app()->httpResponse()->redirect('authentification/login');
		//$this->app()->session()->destroy();
	}
}