
<h1><a href="create/"><i class="fa fa-plus-circle"></i> Nouveau message...</a></h1>
<br>
<br>
<table id="table_id" class="table table-striped table-bordered table-hover display to_pdf">
        <thead>
            <tr>
        <th>
        <center>Message</center>
        </th>
        <th>
        <center>Date</center>
        </th>
        <th>
        <center>Action</center>
        </th>
        </tr>
        </thead>
        <tbody>
    <?php
//use Library\Utilities;
foreach($sms as $c):
	//Utilities::print_table($c);
    $date = new DateTime($c['dateEnregistrement'],new DateTimeZone("Europe/Paris"));
        
?>
<tr>
        <td><center><?=$c['corps']?></center></td>
<td><center><?=$date->format('d/m/Y');?></center></td>
<td><center><span class="pull-right"><i class="fa fa-trash-o text-danger"></i><a href="<?=$c['id']?>/delete/"> supprimer</a></span></center></td>
</tr>        
<?php endforeach;?>
</tbody>
</table>