<?php
namespace Applications\Test\Modules\Contact;
use Library\BackController;
use Library\HTTPRequest;
use Library\Entities\Contact;
use Library\Entities\Numero;
use Library\Utilities;

class ContactController extends BackController{
	
	public function executeIndex(HTTPRequest $http){
		$manager = $this->managers->getManagerOf('Contact');
		$manager1 = $this->managers->getManagerOf('ContactHasGroupe');
		$this->page()->addVar('contacts' , $manager->find());
		$this->page()->addVar('managercontactgroupe' , $manager1);

	}

	public function executeCreate(HTTPRequest $http){

		if($http->postExists('create')){
			$manager = $this->managers->getManagerOf('Contact');
			$numeroManager = $this->managers->getManagerOf('Numero');
			$contact = new Contact();
			$contact['nom'] = $http->postData('nom');
			$contact['prenom'] = $http->postData('prenom');
			$contact['email'] = $http->postData('email');
			$id = $manager->create($contact);

			
			$numeros = $http->postData('numeros');

			//Utilities::print_table($numeros);
			foreach($numeros as $numero){
				$num = new Numero();
				$num['idContact'] = $id;
				$num['numero'] = $numero;
				$numeroManager->create($num);
			}

			$this->app()->httpResponse()->redirect('test/contact/');
		}
	}

	public function executeDelete(HTTPRequest $http){
		$id = $http->getData('id');
		$manager = $this->managers->getManagerOf('Contact');
		$contact = new Contact();
		$contact['id'] = $id;

		$manager->delete($contact);

		$this->app()->httpResponse()->redirect('test/contact/');

	}

	public function executeSearch(HTTPRequest $http){
		
	}
}