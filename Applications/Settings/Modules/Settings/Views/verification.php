<div id="settings">
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger err"><?= $error_message; ?></div>
    <?php endif; ?>
    <h3>Parametres</h3>
    <br>
    Veuillez entrer les nouvelles valeurs:
    <br>
     <br>
    <div class="row">
        <div class="col-lg-6">
            <form method="post" name="form_settings" id="form_contact" action="/sms/settings/verification" onclick="verifAutreContact()">
                <div class="form-group">
                    <label for="cheminDossierReception">
                        Chemin du dossier de reception des contacts:
                    </label>
                    <input class="form-control" type="text" value="<?= $cheminDossierReception; ?>" disabled>
                    <input class="form-control" type="text" name="cheminDossierReception" value="">
                </div>
                <div class="form-group">
                    <label for="nomFichier">
                        Nom du fichier des contacts:
                    </label>
                    <input class="form-control" type="text" value="<?= $nomFichier; ?>" disabled>
                    <input class="form-control" type="text" name="nomFichier" value="">
                </div>
                <div class="form-group">
                    <label for="usernameAPI">
                        Nom d'utilisateur de l'api:
                    </label>
                    <input class="form-control" type="text" value="<?= $usernameAPI; ?>" disabled>
                    <input class="form-control" type="text" name="usernameAPI" value="">
                </div>
                <div class="form-group">
                    <label for="passwordAPI">
                        Mot de passe de l'api:
                    </label>
                    <br>
                    Entrer l'ancien mot de passe:
                    <input class="form-control" type="password" name="passwordAPIOld" value="">
                    Entrer le nouveau mot de passe:
                    <input class="form-control" type="password" name="passwordAPINew" value="">
                </div>
                <div class="form-group">
                    <label for="senderAPI">
                        Nom de l'expéditeur:
                    </label>
                    <input class="form-control" type="text" value="<?= $senderAPI; ?>" disabled>
                    <input class="form-control" type="text" name="senderAPI" value="">
                </div>
                
                <input class="btn btn-primary" type="submit" value="Modifier">
            </form>    
        </div>
    </div>
</div>
