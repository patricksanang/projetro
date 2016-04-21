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
		require str_replace('\\','/',$class).'.php';
	}catch(Exception $e){
		throw new Exception($e->getMessage());
	}
}

spl_autoload_register('autoload');
