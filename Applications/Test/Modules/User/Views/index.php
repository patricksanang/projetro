<?php
use Library\Utilities;

foreach($users as $u):
	Utilities::print_table($u);
?>
<a href="<?=$u['id']?>/delete"> delete user <?= $u['nom']?></a>
<?php endforeach;?>

Utilities::print_table($users);
