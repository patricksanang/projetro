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
                        $i=0;
                        $t=0;
                        //var_dump($c);
                        if($c['numeros']==null)
                        {
                            $t=0;
                        }else
                        {
                            $t=count($c['numeros']);
                        }
                        for($i=0; $i<3-$t; $i++)
                        {
                    ?> 
                    <td><center></center></td>
                    <?php
                        }
                    }
                    ?>
                    <td><center><span class="pull-right"><i class="fa fa-trash-o text-danger"></i><a href="/sms/test/<?=$c['id']?>/delete/"> supprimer </a></span></center></td>
                    </tr>
            <?php
                    $i++;
                
                endforeach;
            ?>

        </tbody>
    </table>
    
    <center>
    