<?php

session_start();
require_once 'requetes.php';

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

//monnaie
$monnaie=$_POST['monnaie'];

//echo $monnaie.'<br>';
//on convertit la monnaie en frscfa
//echo $budget.'<br>';
$budgetAn=$budget;
if($monnaie!='XAF')
{
    $budgetCon=convertisseur_monnaie($budget, $monnaie,'XAF', '../RestClient.php');
    if($budgetCon=='Erreur')
    {
        $_SESSION['erreurF']="Ooops, une erreur est survenue!";
        header('Location:../page_resultats.php');
    }  else {
        $budget=$budgetCon;
        
    }
}
//echo $budget.'<br>';
//recuperation de avec ou sans preference
$preference = ($_POST['submit'] != 'sans');

$type=array();
foreach ($_POST as $key => $value) {
        if (substr($key, 0, 1) == 'R') {
            //ce sont les preferences
            //echo 'ok';
            switch(substr($key, 1, 1))
            {
                case 1: 
                    $type[]='RESTAURANT';
                    break;
                case 2:
                    $type[]='PARC';
                    break;
                case 3:
                    $type[]='MONUMENT';
                    break;
                case 4:
                    $type[]='MUSEE';
                    break;
            }
        }
    }
    
    var_dump($type);
$tabPref = array();
if (!$preference) {
    //echo 'on continue sans preference';
} else {
    foreach ($_POST as $key => $value) {
        if (substr($key, 0, 1) == 'P') {
            //ce sont les preferences
            //echo 'ok';
            $tabPref[substr($key, 1, 1)][] = substr($key, 2);
        }
    }
    var_dump($tabPref);
    //echo 'on recupere les preferences';
}

//fin des recuperations
//debut de l'etablissement des equations lineaires
//on recupere la liste des sites
$coordtab = getSites('../RestClient.php');

//var_dump($coordtab);
$tempCoord=array();
foreach($coordtab as $key=>$coord)
{
    if(in_array($coord->type, $type))
    {
        //array_splice($coordtab, $key);
        $tempsCoord[]=$coord;
    }
}
$coordtab=array();
$coordtab=$tempsCoord;

//etablissement de l'equation du budget
$corp1 = array();
$corp1['minmax'] = 'max';
$corp1['d'] = "0";

$corp1['a'] = array();
for ($i = 0; $i < count($coordtab) - 1; $i++) {
    $corp1['a'][0]['a1' . ($i + 1)] = $coordtab[$i]->budget;
}
$corp1['a'][0]['a1' . (count($coordtab))] = $coordtab[count($coordtab) - 1]->budget;
//etablissement de l'equation du temps
for ($i = 0; $i < count($coordtab) - 1; $i++) {
    $corp1['a'][1]['a2' . ($i + 1)] = $coordtab[$i]->duree;
}
$corp1['a'][1]['a2' . (count($coordtab))] = $coordtab[count($coordtab) - 1]->duree;
//etablissement des equations sur le signe
for ($i = 0; $i < count($coordtab) - 1; $i++) {
    for ($j = 0; $j < count($coordtab) - 1; $j++) {
        if ($i == $j) {
            $corp1['a'][$i + 2]['a' . ($i + 3) . ($j + 1)] = 1;
        } else {
            $corp1['a'][$i + 2]['a' . ($i + 3) . ($j + 1)] = 0;
        }
    }
    if ($i == count($coordtab) - 1) {
        $corp1['a'][$i + 2]['a' . ($i + 3) . (count($coordtab))] = 1;
    } else {
        $corp1['a'][$i + 2]['a' . ($i + 3) . (count($coordtab))] = 0;
    }
}
for ($j = 0; $j < count($coordtab) - 1; $j++) {
    if ($j == count($coordtab) - 1) {
        $corp1['a'][count($coordtab) + 1]['a' . (count($coordtab) + 2) . ($j + 1)] = 1;
    } else {
        $corp1['a'][count($coordtab) + 1]['a' . (count($coordtab) + 2) . ($j + 1)] = 0;
    }
}
$corp1['a'][count($coordtab) + 1]['a' . (count($coordtab) + 2) . (count($coordtab))] = 1;

/* partie sans préférences */
$corp1['b'][0]['b1'] = $budget;
$corp1['b'][0]['b2'] = $temps;
for ($j = 0; $j < count($coordtab) - 1; $j++) {
    $corp1['b'][0]['b' . ($j + 3)] = 1;
}


$corp1['b'][0]['b' . (count($coordtab) + 2)] = 1;
//gestion du c

for ($i = 0; $i < count($coordtab) - 1; $i++) {
    $corp1['c'][0]['c' . (($i + 1))] = 1;
}
$corp1['c'][0]['c' . (count($coordtab))] = 1;
/* fin partie sans préférences ou on envoie C et B */

//etablissement des equations des preferences

/*
 * partie sonia
 */

//preference 1
if(isset($tabPref[1]))
{
//on commence par recuperer les sites proches  
$siteproches = array();

for ($i = 0; $i < count($coordtab); $i++) {
    for ($j = 0; $j < count($coordtab); $j++) {
        require_once '../google/carte.php';
        if ((getDistancePoints($coordtab[$i], $coordtab[$j]) <= 0.5) && ($i <> $j)) {
            // echo getDistancePoints($coordtab[$i], $coordtab[$j]).'<br />';
            $temp = array();
            $temp[] = ($i + 1);
            $temp[] = ($j + 1);
            $siteproches[] = $temp;
        }
    }
}

//var_dump($siteproches);
//var_dump($corp1['a']);
//echo 'taille '.count($corp1['a']);
$t=count($corp1['a']);
$comp=1;
//$comp1=1;
if ($siteproches) {
    $m=count($siteproches)+1;
  //  echo $m.' taille de sitesproches';
    foreach ($siteproches as $s) {
        for ($i = 1; $i <= count($coordtab); $i++) {
            //echo $s[0];
            if ($i == $s[0]) {//le premier site
                $corp1['a'][$t+$comp-1]['a' . ($t + $comp) . ($i)] = 1;
                //$corp1['a'][$t+$m+$comp-1]['a' . ($t + $comp) . ($i)] = -1;
            }else if($i == $s[1])
            {
                $corp1['a'][$t+$comp-1]['a' . ($t + $comp) . ($i)] = -1;
                //$corp1['a'][$t+$m+$comp-1]['a' . ($t + $comp) . ($i)] = 1;
            }
            else {
                $corp1['a'][$t+$comp-1]['a' . ($t + $comp) . ($i)] = 0;
                //$corp1['a'][$t+$m+$comp-1]['a' . ($t + $comp) . ($i)] = 0;
            }
            //$comp1++;
        }
        $comp++;
    }
    $comp=1;
    foreach ($siteproches as $s) {
        for ($i = 1; $i <= count($coordtab); $i++) {
            //echo $s[0];
            if ($i == $s[0]) {//le premier site
                $corp1['a'][$t+$m+$comp-2]['a' . ($t+$m+$comp-1) . ($i)] = 1;
                //$corp1['a'][$t+$m+$comp-1]['a' . ($t + $comp) . ($i)] = -1;
            }else if($i == $s[1])
            {
                $corp1['a'][$t+$m+$comp-2]['a' . ($t+$m+$comp-1) . ($i)] = -1;
                //$corp1['a'][$t+$m+$comp-1]['a' . ($t + $comp) . ($i)] = 1;
            }
            else {
                $corp1['a'][$t+$m+$comp-2]['a' . ($t+$m+$comp-1) . ($i)] = 0;
                //$corp1['a'][$t+$m+$comp-1]['a' . ($t + $comp) . ($i)] = 0;
            }
            //$comp1++;
        }
        $comp++;
    }

//var_dump($corp1);
$t=count($corp1['b'][0])+1;

//echo $t;
for ($j = $t; $j <$t+2*($m-1); $j++) {
    $corp1['b'][0]['b' . ($j)] = 0;
}
//var_dump($corp1['a']);
//var_dump($corp1['b']);

//var_dump($corp1['a']);
}
//preference 2
}
//preference 4
if(isset($tabPref[4]))
{
    //on peut recuperer les sites qui doivent figurer dans le resultat
    $comp=1;
    $t=count($corp1['a']);
    foreach ($tabPref[4] as $s) {
        for ($i = 1; $i <= count($coordtab); $i++) {
            //echo $s[0];
            if ($i == $s) {
                $corp1['a'][$t+$comp-1]['a' . ($t + $comp) . ($i)] = -1;
            }else {
                $corp1['a'][$t+$comp-1]['a' . ($t + $comp) . ($i)] = 0;
            }
            //$comp1++;
        }
        $comp++;
    }
    $comp=1;
    $m=count($tabPref[4]);
/*    foreach ($tabPref[4] as $s) {
        for ($i = 1; $i <= count($coordtab); $i++) {
            //echo $s[0];
            if ($i == $s) {//le premier site
                $corp1['a'][$t+$m+$comp-1]['a' . ($t+$m+$comp) . ($i)] = -1;
            }
            else {
                $corp1['a'][$t+$m+$comp-1]['a' . ($t +$m+ $comp) . ($i)] = 0;
            }
        }
        $comp++;
    }*/
    $t=count($corp1['b'][0])+1;

  //  echo $t;
    for ($j = $t; $j <$t+$m; $j++) {
        $corp1['b'][0]['b' . ($j)] = -1;
    }
    /*
    for ($j = $t+count($corp1['a'])-2-count($coordtab)-$m; $j <$t+count($corp1['a'])-2-count($coordtab); $j++) {
        $corp1['b'][0]['b' . ($j)] = -1;
    }
    */
    
}
//preference 3
if(isset($tabPref[3]))
{
    $comp=1;
    $t=count($corp1['a']);
    
        for ($i = 1; $i <= count($coordtab); $i++) {
            //echo $s[0];
            if ($i == $tabPref[3][0]) {
                $corp1['a'][$t]['a' . ($t + 1) . ($i)] = 1;
            }else if($i == $tabPref[3][1]) {
                $corp1['a'][$t]['a' . ($t + 1) . ($i)] = 1;
            }else{
                $corp1['a'][$t]['a' . ($t + 1) . ($i)] = 0;
            }
            //$comp1++;
        }
        for ($i = 1; $i <= count($coordtab); $i++) {
            //echo $s[0];
            if ($i == $tabPref[3][0]) {
                $corp1['a'][$t+1]['a' . ($t + 2) . ($i)] = -1;
            }else if($i == $tabPref[3][1]) {
                $corp1['a'][$t+1]['a' . ($t + 2) . ($i)] = -1;
            }else{
                $corp1['a'][$t+1]['a' . ($t + 2) . ($i)] = 0;
            }
            //$comp1++;
        }
        
        $t=count($corp1['b'][0])+1;
        echo $t;
        $corp1['b'][0]['b' . ($t+1)] = 1;
        $corp1['b'][0]['b' . ($t+2)] = -1;
}



//preference 5
if(isset($tabPref[5]))
{
    $comp=1;
    $t=count($corp1['a']);
    
        for ($i = 1; $i <= count($coordtab); $i++) {
            //echo $s[0];
            if ($i == $tabPref[5][0]) {
                $corp1['a'][$t]['a' . ($t + 1) . ($i)] = 1;
            }else if($i == $tabPref[5][1]) {
                $corp1['a'][$t]['a' . ($t + 1) . ($i)] = -1;
            }else{
                $corp1['a'][$t]['a' . ($t + 1) . ($i)] = 0;
            }
            //$comp1++;
        }
        for ($i = 1; $i <= count($coordtab); $i++) {
            //echo $s[0];
            if ($i == $tabPref[5][0]) {
                $corp1['a'][$t+1]['a' . ($t + 2) . ($i)] = -1;
            }else if($i == $tabPref[5][1]) {
                $corp1['a'][$t+1]['a' . ($t + 2) . ($i)] = 1;
            }else{
                $corp1['a'][$t+1]['a' . ($t + 2) . ($i)] = 0;
            }
            //$comp1++;
        }
        
        $t=count($corp1['b'][0])+1;
        echo $t;
        $corp1['b'][0]['b' . ($t+1)] = 0;
        $corp1['b'][0]['b' . ($t+2)] = 0;
}

//var_dump($corp1['a']);
//var_dump($corp1['b']);

/* foreach ($tabPref as $key => $value) {
  for ($i = 0; $i < count($coordtab) - 1; $i++) {
  $corp.='
  "a2' . ($i + 1) . '" : "' . $coordtab[$i]->duree . '",';
  }
  } */

/**
 * fin partie sonia
 */
var_dump($corp1);
//echo json_encode($corp1);
$r = new RestClient();
$body = array(json_encode($corp1));
$pHeaders = array(
    'Content-Type: application/json'
);
$result = $r->setUrl('http://localhost/projetro/ro/resolution/solve/')->post($pHeaders, $body);
print_r($result);
$result = json_decode($result['content'], true);

//on passe ensuite à l'ecriture des resultats
//on fait la correspondance ville numeros
$resultF = array();
$sommeTotal = 0;
$tempsTotal = 0;
/*
 *  attributs d'un objet $value
 * latitude
 * longitude
 * nom
 * budget
 * duree
 */

if(isset($result['tabNumLieux']))
{
foreach ($coordtab as $key => $value) {
    if (in_array($key, $result['tabNumLieux'])) {
        $resultF[] = $value;
        $sommeTotal+=$value->budget;
        $tempsTotal+=$value->duree;
    }
}
//    var_dump($result);

$_SESSION['resultF'] = $resultF;
$_SESSION['sommeF'] = $sommeTotal;
$_SESSION['tempsF'] = $tempsTotal;
 //header('Location:../page_resultats.php');  
}  else {
    $_SESSION['erreurF'] = 'Desolé, nous n\'avons pas pu trouver de sites...';
    //header('Location:../page_resultats.php');
}

//var_dump($_SESSION);
//
//var_dump($resultF);

//require_once '../page_resultats.php';
//echo $corp;
