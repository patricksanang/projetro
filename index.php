
<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL); 


ini_set('display_errors', 1);
error_reporting(E_ALL); 

ini_set('display_errors', 1);
error_reporting(E_ALL); 

require 'Library/autoload.php';

use Library\Utilities;
$app = "Backend";
if(isset($_GET['app']) && file_exists(__DIR__."/Applications/".$_GET['app']."/".$_GET['app']."Application.php")){
	$app = $_GET['app'];
}

//Utilities::print_table($_GET);


//echo 'la classe est '.$app;
$class = "Applications\\".$app."\\".$app."Application"; 


$app = new $class();
 $app->run();

