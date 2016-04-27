<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Library\Fichier;
$fichier = new Fichier();
$forme = array();
$forme[] = 'latitude';
$forme[] = 'longitude';
$forme[] = 'nom';
$forme[] = 'budget';
$forme[] = 'duree';
$result = $fichier->traiteFichier(__DIR__.'/../Files/donnees.csv', $forme);
        
$result=json_encode($result);

echo $result;