<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * fonction pour recuperer la liste des sites
 */
function getSites($file)
{
    //client rest
    require_once $file;
    $r=new RestClient();
    $pHeaders = array(
        'Content-Type: application/json'
            );
    $result=$r->setUrl('http://localhost/projetro/ro/donnees/getDonnees/')->get($pHeaders);
    
    $coordtab [] = array();
    $coordtab=json_decode($result['content']);
    
    return $coordtab;
}
/**
 * fonction pour recuperer la monnaie
 */
function convertisseur_monnaie($montant,$de,$a, $file){
    
    $mc = "http://www.convertisseur-euros.com/api.php?d1=".$de."&d2=".$a."&x=".$montant."&t=json";
    $mjson = file_get_contents($mc);
    $result = json_decode($mjson, TRUE);
    $mok = $result['success'];
    if($mok)
        return round($result['rate']*$montant, 0);
    else
        return "Erreur";//$coordtab [] = array();
    //$coordtab=json_decode($result['content']);
    
    
}

