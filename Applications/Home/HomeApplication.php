<?php
namespace Applications\Home;

use Library\Application;

class HomeApplication extends Application{
	public function __construct(){
		parent::__construct();
		$this->name = "Home";
	}

	public function run(){
		$controller = $this->getController();
		$controller->execute();
		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
	}
}