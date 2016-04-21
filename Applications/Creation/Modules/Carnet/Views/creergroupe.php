<div id="creergroupe">
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger err"><?= $error_message; ?></div>
    <?php endif; ?>
    <br>
    <br>
    <div class="row">
        <div class="col-lg-6">
            <form role="form" method="post" id="groupe" action="/sms/creation/carnet/groupe">
                <div class="form-group">
                    <label for="groupe">
                        Creer un groupe:
                    </label>
                    <input class="form-control" placeholder="Entrer un nom de groupe" type="text" name="groupe" id="groupe" value="">
                </div>
                <div class="">
                    <input class="btn btn-primary" type="submit" value="Creer">
                </div>
            </form>
        </div>
    </div>    



</div>
