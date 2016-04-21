
<h1><a href="create/"> new Numero</a></h1>
<?php
use Library\Utilities;

foreach($numeros as $c):
	Utilities::print_table($c);
?>
<h3><a href="<?=$c['id']?>/delete/"> delete numero <?= $c['numero']?></a></h3>
<?php endforeach;?>
