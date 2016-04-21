<?php
namespace Applications\Authentification;

use Library\Application;

class AuthentificationApplication extends Application{
	public function __construct(){
		parent::__construct();
		$this->name = "Authentification";
        }

	public function run(){
		$controller = $this->getController();
		$controller->execute();
		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
                
	}
}