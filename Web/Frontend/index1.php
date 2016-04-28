<html>
    <head>

        <Title> Site touristique </Title>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html" >
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="css/style.css" rel="stylesheet" type="text/css" media="screen"/>
    </head>

    <body onload="DecocheTout(this)">
        <?php include_once("header.php"); ?>
        <section class="carte">
            <div class="bloc_carte" id="map" onClick="document.getElementById('lat').value = getCurrentLat();
                    document.getElementById('lng').value = getCurrentLng();">
                 <?php
                    require_once 'google/carte.php';
                    carte(2, 'test1', 'Yaoundé', '600px', '600px', 20, 'fr', array());
                 ?>
            </div>
            <div  class="bloc_texte">
                <?php
                include_once("slider.php");
                ?>
            </div>
        </section>
        <section>

            <?php
            include_once("options.php");
            ?>
        </section>
        <script src="js/jquery-1.7.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/preference.js"></script>
        <script src="ajax/envoi.js"></script>
    </body>

</html>