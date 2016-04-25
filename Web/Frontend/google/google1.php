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
                require('GoogleMapAPIv3.class.php');

                $gmap = new GoogleMapAPI();
                $gmap->setDivId('test1');
                $gmap->setDirectionDivId('route');
                $gmap->setCenter('Yaoundé');
                $gmap->setEnableWindowZoom(true);
                $gmap->setEnableAutomaticCenterZoom(true);
                $gmap->setDisplayDirectionFields(true);
                // $gmap->setClusterer(true);
                $gmap->setSize('600px', '600px');
                $gmap->setZoom(20);
                $gmap->setLang('fr');
                $gmap->setDefaultHideMarker(false);
                // $gmap->addDirection('nantes','paris');

                $coordtab = array();
                $coordtab [] = array(3.891843, 11.513929, 'Chez Wou', '<strong>Chez Wou</strong>');
                $gmap->addArrayMarkerByCoords($coordtab, 'cat1');

                $coordtab = array();
                $coordtab [] = array(3.871295, 11.520091, 'La Plaza', '<strong>La plaza</strong>');
                $gmap->addArrayMarkerByCoords($coordtab, 'cat2');

                $coordtab = array();
                $coordtab [] = array(3.873311, 11.518344, 'Le Biniou', '<strong>Le Biniou</strong>');
                $gmap->addArrayMarkerByCoords($coordtab, 'cat3');

                $coordtab = array();
                $coordtab [] = array(3.864811, 11.516351, 'La marmite du Boulevard', '<strong>La Marmite du Boulevard</strong>');
                $gmap->addArrayMarkerByCoords($coordtab, 'cat4');

                $coordtab = array();
                $coordtab [] = array(3.864720, 11.515949, 'Restaurant Hilton', '<strong>Restaurant Hilton</strong>');
                $gmap->addArrayMarkerByCoords($coordtab, 'cat5');

                $coordtab = array();
                $coordtab [] = array(3.892329, 11.512291, 'Istanbul Turkish Restaurant', '<strong>Istanbul Turkish Restaurant</strong>');
                $gmap->addArrayMarkerByCoords($coordtab, 'cat6');

                $coordtab = array();
                $coordtab [] = array(3.852583, 11.517776, 'Statue Charles Atangana', '<strong>Statue Charles Atangana</strong>');
                $gmap->addArrayMarkerByCoords($coordtab, 'cat7');

                $coordtab = array();
                $coordtab [] = array(3.852734, 11.513607, 'Monument de la reunification', '<strong>Monument de la reunification</strong>');
                $gmap->addArrayMarkerByCoords($coordtab, 'cat8');

                $coordtab = array();
                $coordtab [] = array(3.860976, 11.515915, 'Musée national', '<strong>Musée national</strong>');
                $gmap->addArrayMarkerByCoords($coordtab, 'cat9');

                $coordtab = array();
                $coordtab [] = array(3.871576, 11.514482, 'Bois Saint-Anastasie', '<strong>Bois Saint-Anastasie</strong>');
                $gmap->addArrayMarkerByCoords($coordtab, 'cat10');

                $coordtab = array();
                $coordtab [] = array(3.870336, 11.489643, 'Parc de Yaoundé', '<strong>Parc de Yaoundé</strong>');
                $gmap->addArrayMarkerByCoords($coordtab, 'cat11');

                $coordtab = array();
                $coordtab [] = array(3.877057, 11.517981, 'L\'awalé', '<strong>L\'awalé</strong>');
                $gmap->addArrayMarkerByCoords($coordtab, 'cat12');

                $coordtab = array();
                $coordtab [] = array(3.879508, 11.517487, 'Cafeneio', '<strong>Cafeneio</strong>');
                $gmap->addArrayMarkerByCoords($coordtab, 'cat12');


                $coordtab1 = array(3.871576, 11.514482, 'Bois Saint-Anastasie', '<strong>Bois Saint-Anastasie</strong>');
                $coordtab2 = array(3.879508, 11.517487, 'Cafeneio', '<strong>Cafeneio</strong>');

                /**
                 * Tableau de depenses en terme d'argent et de temps par lieux
                 * */
                $tabBudDuree = array();
                $tabBudDuree[1] = array(3.891843, 11.513929, 'Chez Wou', 1000, 2);
                $tabBudDuree[2] = array(3.871295, 11.520091, 'La Plaza', 500, 2);
                $tabBudDuree[3] = array(3.873311, 11.518344, 'Le Biniou', 0, 2);
                $tabBudDuree[4] = array(3.864811, 11.516351, 'La marmite du Boulevard', 1000, 2);
                $tabBudDuree[5] = array(3.864720, 11.515949, 'Restaurant Hilton', 1000, 2);
                $tabBudDuree[6] = array(3.892329, 11.512291, 'Istanbul Turkish Restaurant', 1000, 2);
                $tabBudDuree[7] = array(3.852583, 11.517776, 'Statue Charles Atangana', 1000, 2);
                $tabBudDuree[8] = array(3.852734, 11.513607, 'Monument de la reunification', 1000, 2);
                $tabBudDuree[9] = array(3.860976, 11.515915, 'Musée national', 1000, 2);
                $tabBudDuree[10] = array(3.871576, 11.514482, 'Bois Saint-Anastasie', 1000, 2);
                $tabBudDuree[11] = array(3.870336, 11.489643, 'Parc de Yaoundé', 1000, 2);
                $tabBudDuree[12] = array(3.877057, 11.517981, 'L\'awalé', 0, 0);
                $tabBudDuree[13] = array(3.879508, 11.517487, 'Cafeneio', 1000, 2);

                //var_dump($tabBudDuree);

                /**
                  Debut de la programmation lineaire
                  de maniere generique
                 * */
                $tab = array();
                $tab['minmax'] = "max";
                $tab['numVariables'] = 13;
                $tab['numConstraints'] = 15;
                $a = array();
                $b = array();
                $c = array();

                $b[1] = 10000;
                $b[2] = 15;

                for ($i = 0; $i < 13; $i++) {
                    $c[$i + 1] = 1;
                    $b[$i + 3] = 1;
                    $lge[$i + 1] = '=<';
                }
                $lge[] = '=<';
                $lge[] = '=<';
                $temp = array();
                for ($i = 1; $i <= 13; $i++) {
                    $temp[$i] = $tabBudDuree[$i][3];
                }
                $a[1] = $temp;
                $temp = array();
                for ($i = 1; $i <= 13; $i++) {
                    $temp[$i] = $tabBudDuree[$i][4];
                }
                $a[2] = $temp;
                $temp = array();
                for ($i = 0; $i < 13; $i++) {
                    for ($j = 0; $j < 13; $j++) {
                        if ($i == $j) {
                            $temp[$j + 1] = 1;
                        } else {
                            $temp[$j + 1] = 0;
                        }
                    }
                    $a[$i + 3] = $temp;
                    $temp = array();
                }

                //var_dump($a);
                $tab['a'] = $a;
                $tab['b'] = $b;
                $tab['c'] = $c;
                $tab['d'] = '';
                $tab['lge'] = $lge;
                $tab['intera'] = true;
                require_once '../simplesso.php';

                $tabResult = explode(';', $result);
                $tabFinal = array();
                $content1 = 'Les lieux à visiter sont : <br>';
                $keyPrec = 0;
                $comp = 0;
                $points = array();
                foreach ($tabResult as $key => $value) {
                    if (($value == '1') && ($key <= 13)) {

                        $tabFinal[] = $key;
                        $content1.=$tabBudDuree[$key][2] . '<br>';
                        $t = array();
                        $t[0] = $tabBudDuree[$key][0];
                        $t[1] = $tabBudDuree[$key][1];
                        $points[] = $t;
                        if ($comp > 0) {
                            echo $tabBudDuree[$keyPrec][2] . ' - ' . $tabBudDuree[$key][2] . '<br>';

                            //break;
                        }
                        $comp++;
                        $keyPrec = $key;
                    }
                }

                $gmap->addDirectionPoints($tabBudDuree[1][0], $tabBudDuree[1][1], $tabBudDuree[$keyPrec][0], $tabBudDuree[$keyPrec][1], $points);
                $gmap->generate();

                //echo 'Distance: <b>'.round($gmap->GetDrivingDistance($coordtab1[0], $coordtab2[0], $coordtab1[1], $coordtab2[1])['time'], 1).'</b> km';


                /* echo $coordinates1 = $gmap->get_coordinates('Katowice', 'Korfantego', 'Katowicki');
                  echo $coordinates2 = $gmap->get_coordinates('Tychy', 'Jana Pawła II', 'Tyski');
                 */
                //$gmap->addPolyLineByCoords($coordtab1[0], $coordtab2[0], $coordtab1[1], $coordtab2[1], '', 10, 0);
                echo $gmap->getGoogleMap();

                echo $content1;
                //var_dump($tabResult);
                //var_dump($tabFinal);
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
                <input name="envoyer" type="submit"/>

                <span class="titre">Resultats : </span>
                <div class="panel">

                </div>

            </div>
        </div>

    </body>
</html>