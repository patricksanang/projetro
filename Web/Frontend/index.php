<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <style type="text/css">
            body {
                margin: 10px; /* pour eviter les marges */
                text-align: center; /* pour corriger le bug de centrage IE */
                width: 1000px;
            }
            #global {
                text-align: center;
                margin-left: auto;
                margin-right: auto;
            }
            #route {
                height: 130px;
                overflow-y: auto;
            }
            #map {
                float: left;
            }
            #options {
                width: 350px;
                float: left;
                padding: 0 10px 10px 10px;
                text-align: left;
            }
            .panel {
                background-color: #E8ECF9;
                border: 1px dashed black;
                padding: 5px;
                margin: 10px 0 10px 0;
            }
            .titre {
                text-align: left;
                font-weight: bold;
                margin: 0 0 5px 0;
            }

            .inputTxt {
                width: 100px;
            }
        </style>
    </head>
    <body>
        <div id="global">
            <div id="map" onClick="document.getElementById('lat').value = getCurrentLat();
                    document.getElementById('lng').value = getCurrentLng();">
                 <?php
                    require_once 'google/carte.php';
                    carte(2, 'test1', 'Yaoundé', '600px', '600px', 20, 'fr');
                 ?>
            </div>
            <div id="options">
                <span class="titre">Informations : </span>
                <div class="panel">
                    Lat : <input type="text" id="lat" class="inputTxt" onClick="" value=""/>
                    Lng : <input type="text" id="lng" class="inputTxt" onClick="" value=""/>
                </div>
                <span class="titre">Budget (en FCFA): </span>
                <div class="panel">
                    <input name="budget" type="text"/>
                </div>
                <span class="titre">Temps(en Heures) : </span>
                <div class="panel">
                    <input name="temps" type="number"/>
                </div>
                <span class="titre">Preferences : </span>
                <div class="panel">
                    <input name="temps" type="number"/>
                </div>
                
                <input name="envoyer" type="submit"/>

                <span class="titre">Resultats : </span>
                <div class="panel">

                </div>

            </div>
        </div>

    </body>
</html>