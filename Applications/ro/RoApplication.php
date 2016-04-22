<?php
namespace Applications\Authentification;

use Library\Application;

class RoApplication extends Application{
	public function __construct(){
		parent::__construct();
		$this->name = "Ro";
        }

	public function run(){
		$controller = $this->getController();
		$controller->execute();
		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
                
	}
}