<?php


/**
 * fonction pour l'affichage simple de la carte avec les marqueurs dessus
 */
function getCarteMarqueurs($gmap)
{
    require_once 'controleur/requetes.php';
    $coordtab=  getSites('RestClient.php');
    //print_r($coordtab);
    $comp=0;
    foreach($coordtab as $c)
    {
        $comp++;
        $coordtab1=array();
        $coordtab1[] = array($c->latitude, $c->longitude, $c->nom, '<strong>'.$c->nom.'</strong>');
        $gmap->addArrayMarkerByCoords($coordtab1, 'cat'.$comp);
    }
    //foreach($result )
    
    return $gmap;
    
}
/**
 * fonction pour afficher la carte avec un itineraire
 */
function getCarteItineraire($gmap, $sites)
{
    $gmap=getCarteMarqueurs($gmap);
    $points=array();
    foreach($sites as $s)
    {
        $t=array();
        $t[0]=$s->latitude;
        $t[1]=$s->longitude;
        $points[]=$t;
    }
    //var_dump($points);
    $gmap->addDirectionPoints($sites[0]->latitude, $sites[0]->longitude, $sites[count($sites)-1]->latitude, $sites[count($sites)-1]->longitude, $points);
    return $gmap;

}
/**
 * fonction de retour de la carte
 */
function carte($etat, $id, $center, $width, $height, $zoom, $language, $sites=array())
{
    require('GoogleMapAPIv3.class.php');

$gmap = new GoogleMapAPI();
$gmap->setDivId($id);
$gmap->setDirectionDivId('route');
$gmap->setCenter($center);
$gmap->setEnableWindowZoom(true);
$gmap->setEnableAutomaticCenterZoom(true);
$gmap->setDisplayDirectionFields(true);
$gmap->setClusterer(true);
$gmap->setSize($width, $height);
$gmap->setZoom($zoom);
$gmap->setLang($language);
$gmap->setDefaultHideMarker(false);

    switch ($etat)
    {
        case 1:
            //on veut juste afficher la carte
            $gmap->generate();
            echo $gmap->getGoogleMap();
            break;
        case 2:
            //on veut afficher la carte avec les marqueurs
            $gmap=getCarteMarqueurs($gmap);
            $gmap->generate();
            echo $gmap->getGoogleMap();
            break;
        case 3:
            //on veut afficher la carte avec l'itineraire
            $gmap= getCarteItineraire($gmap, $sites);
            $gmap->generate();
            echo $gmap->getGoogleMap();
            break;
        default :
            //on veut juste afficher la carte
            $gmap->generate();
            echo $gmap->getGoogleMap();
            break;
    }
}

            