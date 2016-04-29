<section id="partner">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2 id="option">Choix d'un itineraire</h2>
        </div>    
        <form  id="preference_form" method="post" action='controleur/calculItineraire.php' name="preference-form" style="display:block;" >
            <div class="panel panel-primary">
                <div class="panel-heading">Entrez vos informations</div>
                <div class="panel-body">
                    <div class="col-sm-5 col-sm-offset-1">
                        <div class="form-group">
                            <label>Votre budget</label>
                            <input onload="DecocheTout(this)" type="number" name="budget" id="budget" class="form-control" required="required">
                           
                        </div>
                        <div class="form-group">
                            <label>Le temps dont vous disposez(en Heures)</label>
                            <input type="number" name="temps" id="temps" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="col-sm-5 boutons">
						<div class="budget2">	
							<select name="monnaie" id="monnaie" class="form-control">
                                <option value="XAF"> XAF </option>
                                <option value="USD"> USD </option>
                                <option value="EUR"> EUR </option>
                                
                            </select>
						</div>
                        <div class="form-group gconfirm center boutons">
                            <button type="button" name="submit" class="btn btn-primary btn-lg" onclick="active_preference()" >Choisir des preferences</button>
                            <button type="submit" name="submit" value="sans" class="btn btn-primary btn-lg valider" >Valider</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary" id="preference_block1">
                <div class="panel-heading">Choix des preferences 1</div>
                <div class="panel-body">
                    Choisir parmi les: 
                    <div class="col-sm-5 col-sm-offset-1">
                        <div class="form-group">
                            <input type="checkbox" name="R1" />
                            <label>Restaurants</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="R2"  />
                            <label>Parcs</label>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <input type="checkbox" name="R3"   />
                            <label>Monuments</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="R4"   />
                            <label>Musées</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-primary" id="preference_block2">
                <div class="panel-heading">Choix des preferences</div>
                <div class="panel-body">
                    <div class="col-sm-5 col-sm-offset-1">
                        <div class="form-group">
                            <input type="checkbox" name="P1" />
                            <label>preference 1</label>
                            <p> Si deux sites se trouvent géographiquement très proches (dans un rayon de moins de 500m
                                de marche à pied), vous préférez visiter ces deux sites au lieu d’en visiter un seul.
                            </p>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="P3" data-toggle="modal" data-target="#modal_block3" />
                            <label>preference 2</label>
                            <p>Si vous visitez un lieu alors vous ne visiterez pas un autre lieu</p>

                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <input type="checkbox" name="P4"  data-toggle="modal" data-target="#modal_block4" />
                            <label>preference 3</label>
                            <p> Il souhaite visiter à tout prix certains lieux</p>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="P5"  data-toggle="modal" data-target="#modal_block5" />
                            <label>preference 4</label>
                            <p> Si vous visitez un lieu alors vous visiterez un autre lieu</p>
                        </div>
                        <div class="form-group gconfirm center">
                            <button type="submit" name="submit" value="avec" class="btn btn-primary btn-lg valider" >Valider</button>
                        </div>
                    </div>
                </div>
                <?php include_once("modal2.php"); ?>
                <?php include_once("modal3.php"); ?>
                <?php include_once("modal4.php"); ?>
                <?php include_once("modal5.php"); ?>
        </form>
		<div class="zone_carte">
			<p class="textecarte">ISERTION DE LA CARTE ICI</p>
		</div>
    </div>	
</div><!--/.container-->
</section><!--/#partner-->