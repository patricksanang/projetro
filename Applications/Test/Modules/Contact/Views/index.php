<h1><a href="../../creation/carnet/contact"><i class="fa fa-plus-circle"></i> Nouveau contact...</a></h1>
<br>
<br>
<center><h2>liste des contacts</h2></center>
    <br>
    
    <table id="table_id"
           class="table table-striped table-bordered table-hover display to_pdf">
        <thead>
            <tr>
                <th>
        <center>#</center>
        </th>
        <th>
        <center>Nom</center>
        </th>
        <th>
        <center>Tel1</center>
        </th>
        <th>
        <center>Tel2</center>
        </th>
        <th>
        <center>Tel3</center>
        </th>
        <th>
        <center>Groupe</center>
        </th>
        <th>
        <center>Action</center>
        </th>
        
        </tr>
        </thead>
        <tbody>

            <?php
            $i = 0;
            foreach ($contacts as $c) :
                    ?>
                        <tr>
                        <td><center><?= $i + 1 ?></center></td>
                        <td><center><?= $c['nom'] ?></center></td>
                    <?php
                    foreach ($c['numeros'] as $n) :
                        $temp='m';
                        if($n!=null):
                            
                    ?>
                    <td><center><?=$n['numero']?></center></td>
                    <?php
                    endif;
                    endforeach;
                    if($c['numeros']==null || count($c['numeros'])<3)
                    {
                        $j=0;
                        $t=0;
                        //var_dump($c);
                        if($c['numeros']==null)
                        {
                            $t=0;
                        }else
                        {
                            $t=count($c['numeros']);
                        }
                        for($j=0; $j<3-$t; $j++)
                        {
                    ?> 
                    <td><center></center></td>
                    <?php
                        }
                    }
					$contactHasGroupe = $managercontactgroupe->find(array('contact'=>$c));
					if(isset($contactHasGroupe[0])){
					$cg=$contactHasGroupe[0];
					$groupe=$cg['groupe'];
					}else
                                        {
                                            $groupe['nom']='Public';
                                        }
                                        
					//var_dump($cg);
					?>
					<td><center><?=$groupe['nom']?></center></td>
                    <td><center><span class="pull-right"><i class="fa fa-trash-o text-danger"></i><a href="/sms/test/contact/<?=$c['id']?>/delete/"> supprimer </a></span></center></td>
                    </tr>
            <?php
                    $i++;
                
                endforeach;
            ?>

        </tbody>
    </table>
    
    <center>
    