<?php
namespace Applications\Test\Modules\User;
use Library\BackController;
use Library\HTTPRequest;
use Library\Entities\User;
use Library\Utilities;

class UserController extends BackController{
	
	public function executeIndex(HTTPRequest $http){
		$manager = $this->managers->getManagerOf('User');
		$this->page()->addVar('users' , $manager->find());

	}

	public function executeCreate(HTTPRequest $http){

		if($http->postExists('create')){
			$manager = $this->managers->getManagerOf('User');
			$user = new User();

			$user['nom'] = $http->postData('nom');
			$user['prenom'] = $http->postData('prenom');
			$user['email'] = $http->postData('email');
			$user['email'] = $http->postData('email');
			$user['password'] = $http->postData('password');

			$manager->create($user);
			$this->app()->httpResponse()->redirect('test/user/');
		}
	}

	public function executeDelete(HTTPRequest $http){
		$id = $http->getData('id');
		$manager = $this->managers->getManagerOf('User');
		$user = new User();
		$user['id'] = $id;

		$manager->delete($user);

		$this->app()->httpResponse()->redirect('test/user');

	}

	public function executeSearch(HTTPRequest $http){
		
	}
}