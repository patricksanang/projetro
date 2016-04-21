<?php
namespace Applications\Creation;

use Library\Application;

class CreationApplication extends Application{
	public function __construct(){
		parent::__construct();
		$this->name = "Creation";
	}

	public function run(){
		$controller = $this->getController();
		$controller->execute();
		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
	}
}