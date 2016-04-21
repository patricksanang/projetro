<?php
namespace Applications\Test\Modules\Numero;
use Library\BackController;
use Library\HTTPRequest;
use Library\Entities\Numero;
use Library\Utilities;

class NumeroController extends BackController{
	
	public function executeIndex(HTTPRequest $http){
		$manager = $this->managers->getManagerOf('Numero');
		$this->page()->addVar('numeros' , $manager->find(array('idContact'=>1)));

	}

	public function executeCreate(HTTPRequest $http){

		if($http->postExists('create')){
			$manager = $this->managers->getManagerOf('Numero');
			$numero = new Numero();

			$numero['numero'] = $http->postData('numero');
			$numero['idContact'] = $http->postData('contact');
			

			$manager->create($numero);
			$this->app()->httpResponse()->redirect('test/numero/');
		}
	}

	public function executeDelete(HTTPRequest $http){
		$id = $http->getData('id');
		$manager = $this->managers->getManagerOf('Numero');
		$numero = new Numero();
		$numero['id'] = $id;

		$manager->delete($numero);

		$this->app()->httpResponse()->redirect('test/numero/');

	}

	public function executeSearch(HTTPRequest $http){
		
	}
}