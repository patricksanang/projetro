<?php if (isset($error_message)) : ?>
    <div class="alert alert-danger err"><?= $error_message; ?></div>
<?php endif; ?>
<form method="post" action="verification">
    <fieldset>
        <legend> Veuillez entrer vos informations! </legend>
        <!--form method="post" action="/stage/login"-->
        <div class="form-group has-feedback">
            <i class="glyphicon glyphicon-user form-control-feedback"></i>
            <input class="form-control" placeholder="Votre email" type="email" name="login" value="" required>
        </div>


        <div class="form-group">
            <input class="form-control" autocomplete="off" placeholder="Votre mot de passe" type="password" name="password" value=""><br>	

        </div>
        <center> <input class="btn btn-info btn-lg" value="Se Connecter" type="submit"/> <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>  
    </fieldset>

</form>