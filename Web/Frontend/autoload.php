<?php

/**
 * Description of autoload
 *
 * @author hubert
 */
function autoload($class)
{
	try{
		//echo "<p>Load ". str_replace('\\','/',$class).'.php' . "</p>";
            if(file_exists($class.'.php')){
                require_once ''.str_replace('\\','/',$class).'.php';
            }elseif(file_exists('controleur/'.$class.'.php'))
            {
                require_once ''.str_replace('\\','/','controleur/'.$class).'.php';
            }else{
                echo 'ouiiouuuiiouoioi';
                require_once ''.str_replace('\\','/','../'.$class).'.php';
            }
            
	}catch(Exception $e){
		throw new Exception($e->getMessage());
	}
}

spl_autoload_register('autoload');
