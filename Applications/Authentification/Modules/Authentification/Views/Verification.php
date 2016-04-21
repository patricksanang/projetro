<?php if (isset($error_message)) : ?>
    <div class="alert alert-danger err"><?= $error_message; ?></div>
<?php endif; ?>
<form method="post" class="login-form" action="/sms/authentification/verification/">
        <div class="control-group has-feedback">
            <input placeholder="Votre email" type="email" name="login" value="" required>
        </div>


        <div class="control-group">
            <input  autocomplete="off" placeholder="Votre mot de passe" type="password" name="password" value=""><br>	

        </div>
        <center> <input class="btn btn-primary btn-large btn-block" value="Se Connecter" type="submit"/></span>  
</form>