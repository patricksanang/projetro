<div id="uploadercontacts">
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger err"><?= $error_message; ?></div>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-6">
            <h3>Ou bien, uploader un fichier de contacts:</h3>
            D'abord, selectionner un groupe:
            <form action="/sms/creation/carnet/upload/contacts" method="post" id="form_uploadContact" name="form_uploadContact"
                  enctype="multipart/form-data" onclick="verifAutreUploadContact()">
                <div class="form-group">
                    <label for="groupeUploadContact">
                        Groupe:
                    </label>      
                    <select name="groupeUploadContact" id="groupeUploadContact" class="form-control">
                        <?php
                        foreach ($groups as $group):
                            $groupName = $group->getNom();
                            ?>
                            <option value="<?= $groupName; ?>"><?= $groupName; ?></option>		
                        <?php endforeach; ?>
                     </select>
                    <p id="autreUploadGroupe" style="display:none; color:blue">
                        Veuillez entrer la nouvelle valeur ici:
                        <input type="text" name="inputAutreUploadGroupeContact" id="inputAutreUploadGroupeContact" class="form-control" style="color:black" value="">
                    </p>

                </div>
                <div class="form-group">
                    Selectionner un fichier à upload: <br />

                    <input type="file" name="fichier" size="50" />

                </div>
                <input type="submit" class="btn btn-primary" value="Enregistrer"/>
            </form>
        </div>

    </div>
</div>