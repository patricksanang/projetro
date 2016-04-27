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

