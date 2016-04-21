<?php
namespace Library;
/**
 * Description of Application
 *
 * @author hubert
 */

abstract class Application
{
	protected $httpRequest;
	protected $httpResponse;
	protected $name;
	protected $session;
	protected $config;
	protected $websiteName='sms';

	public function __construct()
	{
		$this-> httpRequest = new HTTPRequest($this);
		$this-> httpResponse = new HTTPResponse($this);
		$this->name = '';
		$this->session = new Session();
		$this->config = new Config($this);
	}

	public function getController(){
		$router = new \Library\Router;
		$xml = new \DOMDocument;
                //echo 'nom du controleur '.  $this->name;
		$xml->load(__DIR__.'/../Applications/'.$this->name.'/Config/routes.xml');
		$routes = $xml->getElementsByTagName('route');

		//on parcourt les routes du fichier XML
		foreach ($routes as $route) {
			//echo "on a la route : ". $route->getAttribute('url')."<br>";
			$vars = array();

			//on regarde si des variables sont présentes dans l'URI
			if($route->hasAttribute('vars')){
				$vars = explode(',',$route->getAttribute('vars'));
                                //echo "vars in config file";
                                //print_r($vars);
                                //echo "<br>";
			}
                         //var_dump($route->getAttribute('url'));
                         //var_dump($vars);
                        //On ajoute la route au routeur
			$router->addRout(new Route($route->getAttribute('url') , $route->getAttribute('module') , $route->getAttribute('action') , $vars));
		}
                //
                //var_dump($router->getRoute($this->httpRequest->requestURI()));
		try{
			//on récupère la route correspondante à l'url
			//echo "l'url que je resoit c'est  <br>"; 
			//var_dump($router->getRoute($this->httpRequest->requestURI()));
                        $matchedRoute = $router->getRoute($this->httpRequest->requestURI());
			//echo
                        //echo "ça correspond a la reponse <br>";
		}catch(\RuntimeException $e){
			if($e->getCode() == \Library\Router::NO_ROUTE){
				echo " ça ne correspond a aucune routes <br>";
				$this->httpResponse->redirect404();
			}
		}

		//on ajoute les variables de l'URL au tableau $_GET.
                //print_r($matchedRoute->vars());
		$_GET = array_merge($_GET , $matchedRoute->vars());
                  
		//On instancie le controleur.
		$controllerClass = 'Applications\\'.$this->name.'\\Modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';

		return new $controllerClass($this , $matchedRoute->module() , $matchedRoute->action());
	}

	abstract public function run();

	public function httpRequest()
	{
		return $this->httpRequest;
	}

	public function httpResponse(){
		return $this->httpResponse;
	}

	public function name()
	{
		return $this->name;
	}

	public function session(){
		return $this->session;
	}

	public function config(){
		return $this->config;
	}
}
