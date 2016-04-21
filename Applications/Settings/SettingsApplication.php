<?php
namespace Applications\Settings;

use Library\Application;

class SettingsApplication extends Application{
	public function __construct(){
		parent::__construct();
		$this->name = "Settings";
	}

	public function run(){
		$controller = $this->getController();
		$controller->execute();
		$this->httpResponse->setPage($controller->page());
		$this->httpResponse->send();
	}
}