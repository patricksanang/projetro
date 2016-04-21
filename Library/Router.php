<?php
namespace Library;
/**
 * Description of Router
 *
 * @author hubert
 */

class Router
{
	protected $routes = array();

	const NO_ROUTE = 1;

	public function addRout(Route $route)
	{
		if(!in_array($route , $this->routes))
		{
			$this->routes[] = $route;
		}
	}

	public function getRoute($url){
            //var_dump($url);
            //var_dump($this->routes);
            foreach ($this->routes as $route) {
                // Si la route correspond à l'URI
                if(($varsValues = $route->match($url)) !== false)
                {
                    //si elle a des variables
                    if($route->hasVars())
                    {
                        //echo "has var !";
                        $varsNames = $route->varsNames();
//                        print_r($varsNames);
                        $listVars = array();

                        //on crée un nouveau tableau clé/Valeur.
                        //(clé = nom de la varialbe , valeur = sa valeur)
                        foreach ($varsValues as $key => $match) {
                            if($key !== 0){
                                    $listVars[$varsNames[$key-1]] = $match;
                            }
                        }

                        //on assigne ce tableau de variable à la route
  //                      print_r($listVars);
                        $route->setVars($listVars);
                    }
                    return $route;
                }
            }
            //echo "on a aucune route <br>";
            throw new \RuntimeException('Aucune route ne correspond à l\'URI' , self::NO_ROUTE);
	}

	
}
