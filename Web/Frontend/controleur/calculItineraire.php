<?php
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//var_dump($_POST);

//on commence les implementations pour le calcul d'itineraire
//recuperation du budget
$budget = $_POST['budget'];

//recuperation du temps
$temps = $_POST['temps'];

//recuperation de avec ou sans preference
$preference = ($_POST['submit'] != 'sans');

$tabPref = array();
if (!$preference) {
    echo 'on continue sans preference';
} else {
    foreach ($_POST as $key => $value) {
        if (substr($key, 0, 1) == 'P') {
            //ce sont les preferences
            //echo 'ok';
            $tabPref[substr($key, 1, 1)][] = substr($key, 2, 1);
        }
    }
    //var_dump($tabPref);
    //echo 'on recupere les preferences';
}

//fin des recuperations
//debut de l'etablissement des equations lineaires
//on recupere la liste des sites
require_once 'requetes.php';
$coordtab = getSites('../RestClient.php');

//etablissement de l'equation du budget
$corp1=array();
$corp1['minmax']='max';
$corp1['d']="0";

$corp1['a']=array();
for ($i = 0; $i < count($coordtab) - 1; $i++) {
    $corp1['a'][0]['a1'.($i+1)]=$coordtab[$i]->budget;
}
$corp1['a'][0]['a1'.(count($coordtab))]=$coordtab[count($coordtab) - 1]->budget;
//etablissement de l'equation du temps
for ($i = 0; $i < count($coordtab) - 1; $i++) {
    $corp1['a'][1]['a2'.($i+1)]=$coordtab[$i]->duree;
}
$corp1['a'][1]['a2'.(count($coordtab))]=$coordtab[count($coordtab) - 1]->duree;
//etablissement des equations sur le signe
for ($i = 0; $i < count($coordtab) - 1; $i++) {
    for ($j = 0; $j < count($coordtab) - 1; $j++) {
        if ($i == $j) {
            $corp1['a'][$i+2]['a'.($i + 3) . ($j + 1)]=1;
        } else {
            $corp1['a'][$i+2]['a'.($i + 3) . ($j + 1)]=0;
        }
    }
    if ($i == count($coordtab) - 1) {
        $corp1['a'][$i+2]['a'.($i + 3) . (count($coordtab))]=1;
    } else {
        $corp1['a'][$i+2]['a'.($i + 3) . (count($coordtab))]=0;
    }
}
for ($j = 0; $j < count($coordtab) - 1; $j++) {
    if ($j == count($coordtab) - 1) {
        $corp1['a'][count($coordtab)+1]['a'.(count($coordtab)+2) . ($j + 1)]=1;
    } else {
        $corp1['a'][count($coordtab)+1]['a'.(count($coordtab)+2) . ($j + 1)]=0;
    }
}
$corp1['a'][count($coordtab)+1]['a'.(count($coordtab)) . (count($coordtab))]=1;

//etablissement des equations des preferences
/*foreach ($tabPref as $key => $value) {
    for ($i = 0; $i < count($coordtab) - 1; $i++) {
        $corp.='
            "a2' . ($i + 1) . '" : "' . $coordtab[$i]->duree . '",';
    }
}*/

//var_dump($corp1);
//gestion du b

   $corp1['b'][0]['b1']=$budget;
   $corp1['b'][0]['b2']=$temps;
for ($j = 0; $j < count($coordtab) - 1; $j++) {
   $corp1['b'][0]['b'.($j+3)]=1;
}


$corp1['b'][0]['b'.(count($coordtab)+2)]=1;
//gestion du c

for ($i = 0; $i < count($coordtab) - 1; $i++) {
    $corp1['c'][0]['c'.(($i + 1))]=1;
}
$corp1['c'][0]['c'.(count($coordtab))]=1;

//var_dump($corp1);
//echo json_encode($corp1);
$r=new RestClient();
$body = array(json_encode($corp1));
$pHeaders = array(
        'Content-Type: application/json'
            );
$result=$r->setUrl('http://localhost/projetro/ro/resolution/solve/')->post($pHeaders, $body);

$result=  json_decode($result['content'], true);
print_r($result);

//on passe ensuite à l'ecriture des resultats

//on fait la correspondance ville numeros
$resultF=array();
$sommeTotal=0;
$tempsTotal=0;
foreach($coordtab as $key=>$value)
{
    if(in_array($key, $result['tabNumLieux']))
    {
        $resultF[]=$value;
        $sommeTotal+=$value->budget;
        $tempsTotal+=$value->duree;
        
    }
}

$_SESSION['resultF']=$resultF;
$_SESSION['sommeF']=$sommeTotal;
$_SESSION['tempsF']=$tempsTotal;
header('Location:../page_resultats.php');
//var_dump($resultF);

//require_once '../page_resultats.php';
//echo $corp;
