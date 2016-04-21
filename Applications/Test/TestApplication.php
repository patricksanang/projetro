<?php
namespace Applications\Test;

use Library\Application;

class TestApplication extends Application{
	public function __construct(){
		parent::__construct();
		$this->name = "Test";
	}

	public function run(){
		$controller = $this->getController();
		$controller->execute();
		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
	}
}