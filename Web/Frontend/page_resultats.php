<?php session_start(); ?>
<html>
    <head>

        <Title> Site touristique </Title>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html" >
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="css/style.css" rel="stylesheet" type="text/css" media="screen"/>
    </head>

    <body>
        <?php include_once("header.php"); ?>
        <div class="bloc_carte" id="map" onClick="document.getElementById('lat').value = getCurrentLat();
                                    document.getElementById('lng').value = getCurrentLng();">
                             <?php
                             require_once 'google/carte.php';
                             if(isset($_SESSION['resultF']))
                             {
                                carte(3, 'test1', 'Yaoundé', '600px', '600px', 20, 'fr', $_SESSION['resultF']);
                             }  else {
                                carte(2, 'test1', 'Yaoundé', '600px', '600px', 20, 'fr', array());
                             }
                             
                             ?>
                    </div>
        <section class="body_resultat">
            <h2>
                Publication de l'itineraire
                <h2>
                    

                    <div class="resultat_publier">
                        <?php
                        if(isset($_SESSION['resultF'])&&$_SESSION['resultF']!=NULL){
                        
                        echo "Pour un budget de ". $_SESSION['sommeF']. " XAF pendant ".$_SESSION['tempsF']." Heures, vous pouvez visiter:";
                        $comp2=65;
                        foreach ($_SESSION['resultF'] as $r)
                        {
                            echo '<br>'.chr($comp2).' - '. $r->nom . '<br>';
                            $comp2++;
                        }
                        }elseif(isset($_SESSION['erreurF']))
                        {
                            echo $_SESSION['erreurF'];
                        }  else {
                            echo "Désolé, nous n'avons pas pu obtenir de sites!";
                        }
                        session_destroy();
                        ?>

                    </div>
                    <div  class="bloc_texte_resultat">
                        <?php
                        include_once("slider.php");
                        ?>
                    </div>

                    </section>

                    <script src="js/preference.js"></script>
                    <script src="js/jquery.js"></script>
                    <script src="js/bootstrap.min.js"></script>
                    </body>

                    </html>