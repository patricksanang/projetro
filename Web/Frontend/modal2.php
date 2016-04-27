<div class="modal fade" id="modal_block" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">



            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Liste des sites disponibles</h4>
                <h3 class="modal-title" id="myModalLabel">Veiller choisir le/les site(s) en question </h3>
            </div>

            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th> Sites </th>
                        <th> Selection </th>
                    </tr>

                    <?php
                    //on recupere la liste des sites
                    require_once 'controleur/requetes.php';
                    $coordtab = getSites('RestClient.php');
                    $comp = 1;
                    foreach ($coordtab as $coord):
                        ?>
                        <tr onclick="choisi_site()">
                            <td><?= $coord->nom; ?></td>
                            <td><input type="checkbox" name="P2<?= $comp; ?>" id="P2<?= $comp; ?>"></td>				
                        </tr>
                        <?php
                        $comp++;
                    endforeach;
                    ?>

                </table>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <input type="button" class="btn btn-primary" data-dismiss="modal" value="Enregistrer">
            </div>

        </div>
    </div>
</div>