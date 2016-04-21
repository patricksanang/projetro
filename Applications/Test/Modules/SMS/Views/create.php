<?php if(isset($error)){
	echo "<h1>";
	print_r($error);
	echo "</h1>";
}
?>

<form action="" method="post" accept-charset="utf-8">
	<input type="hidden" name = "create"/>
	<label for="groupe">Selectionnez le groupe : </label>
	<select name="groupe" id="">
		<?php foreach($groupes as $g):?>
			<option value="<?=$g['id']?>"><?=$g['nom']?></option>
		<?php endforeach; ?>
			
	</select><br><br>

	<h4 for="message">Veuillez entrer votre message</h4>
	<textarea placeholder="Veuillez saisir votre message" rows="20" name="message" id="comment_text" cols="40" class="ui-autocomplete-input" autocomplete="on" role="textbox" aria-autocomplete="list" class="focused" aria-haspopup="true" ></textarea><br>

	<label for="send">Envoyer le message</label>
	<input type="checkbox" name='send'/>

	
	<input type="submit" value="envoyer">;
</form>


