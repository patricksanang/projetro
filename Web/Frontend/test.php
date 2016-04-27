<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'RestClient.php';


/**
 * client pour gerer les urls du solve
 */
$r=new RestClient();
$body = array('
    {
    "minmax" : "max",
    "d" : "0",
    "a":[
	{"a11" : "2", "a12" : "5"},
	{"a21" : "5", "a22" : "10"},
	{"a31" : "5", "a32" : "15"},
        {"a41" : "1", "a42" : "0"},
        {"a51" : "0", "a52" : "1"}
    ],
    "b":[
	{"b1" : "10", "b2" : "15", "b3" : "20", "b4" : "1", "b5" : "1"}
    ],
    "c":[
	{"c1" : "1", "c2" : "1"}
    ]
    }');
$pHeaders = array(
        'Content-Type: application/json'
            );
$result=$r->setUrl('http://localhost/projetro/ro/resolution/solve/')->post($pHeaders, $body);

print_r($result['content']);

$result=$r->setUrl('http://localhost/projetro/ro/donnees/getDonnees/')->get($pHeaders);

print_r($result['content']);