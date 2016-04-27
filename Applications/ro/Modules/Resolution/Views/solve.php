<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//echo $_GET['app'];
$data = json_decode(file_get_contents('php://input'), true);
//echo 'datatatat';
//var_dump($data);
//echo $data["content"];
$comp = 0;
foreach ($data['a'] as $d) {
    $comp++;
}
$tab = array();
$tab['minmax'] = $data["minmax"];
$tab['numVariables'] = count($data['a'][1]);
$tab['numConstraints'] = $comp;

//var_dump($a);
$tab['a'] = array();
foreach($data['a'] as $key=>$val)
{
    $comp=0;
    foreach($val as $k)
    {
        $tempA[$key+1][$comp+1]=$k;
        $comp++;
    }
}
$tab['a']=$tempA;
$tab['b'] = array();
$tempA=array();
foreach($data['b'] as $key=>$val)
{
    $comp=0;
    foreach($val as $k)
    {
        $tempA[$comp+1]=$k;
        $comp++;
    }
}
$tab['b']=$tempA;
$tab['c'] = array();
$tempA=array();
foreach($data['c'] as $key=>$val)
{
    $comp=0;
    foreach($val as $k)
    {
        $tempA[$comp+1]=$k;
        $comp++;
    }
}
$tab['c']=$tempA;
$tab['d'] = 0;
$lge=array();
foreach($tab['b'] as $k=>$val)
{
    $lge[$k]='=<';
}
$tab['lge'] = $lge;
$tab['intera'] = true;

//var_dump($tab);
require 'Simplexe/simplesso.php';

$tabResult = explode(';', $result);
//echo $result;
//$resultFinal=json_encode($tabResult);
$comp=0;
$nombreLieux=0;
$tabLieux=array();
foreach($tabResult as $val)
{
    if($comp==$tab['numVariables']+1)
         break;
    if($val==1)
    {
        $nombreLieux++;
        $tabLieux[]=$comp;
    }
    $comp++;         
}

$resultFinal=array();
$resultFinal['nombreLieux']=$nombreLieux;
$resultFinal['tabNumLieux']=$tabLieux;
$resultFinal=  json_encode($resultFinal);
echo $resultFinal;

