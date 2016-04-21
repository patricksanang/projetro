<?php
namespace Library;
/**
 * Description of Page
 *
 * @author hubert
 */

class Page extends ApplicationComponent
{
	protected $contentFile;
	protected $vars = array();
    
	public function addVar($var , $value){
		if(!is_string($var) || is_numeric($var) || empty($var)){
			throw new \InvalidArgumentException('Le nom de la variable
				doit être une chaine de de carractere non nulle');
		}

		$this->vars[$var] = $value;
	}

	/*
	*	cette fonction est charge de generer la parge final ou la
	* 	reponse a la requete http emit par l'emeteur
	*/
	public function getGeneratedPage(){
		
		//sinon l'execution continue normalelement;
		if(!file_exists($this->contentFile)){
			throw new \RuntimeException('La vue spécifiée 
				n\'existe pas : '.$this->contentFile);
		}

		
		
		//ob_end_clean();

		extract($this->vars);
		ob_start();
			require $this->contentFile;
		$content = ob_get_clean();
		//si c'est une requete ajax, alors le controleur du module genere
		//toutes les données de sortie necessaires
		if($this->app()->httpRequest()->isAjax()){
			//echo "<br> C'est une requette ajax <br>";
			return $content;
		}

		//echo "<br> C'est une requette ajax ".$content."<br>";

		ob_start();
                //on change un tout petit peu la philosopie de chargement des vues
                //$_SESSION['user']='patrick';
                //$user=$_SESSION['user'];
                //chargement du header
                $flag=file_exists(__DIR__.'/../Applications/'.
			$this->app->name().'/Templates/header.php');
                ob_start();
                if($flag)
                {
                    require(__DIR__.'/../Applications/'.
			$this->app->name().'/Templates/header.php');
                }else{
                    require __DIR__.'/../Library/'.
			'Views/header.php';
                }
		$header=ob_get_clean();
                
                //chargement du menu
                $flag=file_exists(__DIR__.'/../Applications/'.
			$this->app->name().'/Templates/nav.php');
                ob_start();
                if($flag)
                {
                    require(__DIR__.'/../Applications/'.
			$this->app->name().'/Templates/nav.php');
                }else{
                    require __DIR__.'/../Library/'.
			'Views/nav.php';
                }
		$nav=ob_get_clean();
                //chargement du template de base
                $flag=file_exists(__DIR__.'/../Applications/'.
			$this->app->name().'/Templates/layout.php');
                
                if($flag)
                {
                    require(__DIR__.'/../Applications/'.
			$this->app->name().'/Templates/layout.php');
                }else{
                    require __DIR__.'/../Library/'.
			'Views/layout.php';
                }
		return ob_get_clean();
	}

	public function contentFile(){
		return $this->contentFile;
	}

	public function setContentFile($contentFile)
	{
		if(!is_string($contentFile) || empty($contentFile)){
			throw new \InvalidArgumentException('La vue spécifiée
				est invalide');
		}
		$this->contentFile = $contentFile;
	}

    public function jsonSerialize() {
	    $json = array();
	    foreach($this as $key => $value) {
	        $json[$key] = $value;
	    }
	    return $json;
    }
}