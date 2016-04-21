<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Library;

/**
 * Description of Fichier
 * permet de manipuler les fichiers
 * @author patrick
 */
class Fichier {
    //put your code here
    protected $cheminFichier;
    protected $file; //identifiant du fichier
    /**
     * getters and setters
     */
    public function getFile()
    {
        return $this->file;
    }
    public function setFile($file1)
    {
        $this->file=$file1;
    }
    public function getCheminFichier()
    {
        return $this->cheminFichier;
    }
    public function setCheminFichier($cheminFichier1)
    {
        $this->cheminFichier=$cheminFichier1;
    }
    /**
     * methodes de manipulation du fichier
     */
    /**
     * ouverture du fichier
     * prend en parametre $mode qui represente le mode d'ouverture du fichier
     */
    public function openFile($mode)
    {
        $this->file=fopen($this->cheminFichier,$mode,1);
        //echo $this->file;
    }
    /**
     * fermeture de fichier
     * Elle retourne TRUE en cas de réussite,FALSE sinon.
     */
    public function closeFile()
    {
        return fclose($this->file);
    }
    /**
     * methode permettant d'extraire le nom d'un fichier sans son extension
     */
    public function extractionNomFichier()
    {
        
    }
    /**
     * methode permettant de retourner tous les fichiers d'un repertoire disponibles
     */
    public function listeFichierRepertoire($chemin)
    {
        $files=scandir($chemin);
        $temp=array();
        /*
         * on recherche tous les fichiers qui commencent par
         * quizz
         */
        foreach($files as $key)
        {
            if((strstr($key, 'user')=='')&&($key!='.')&&($key!='..'))
            {
                $temp[]=explode('.', basename($key))[0];
            }
        }
        return $temp;
    }
    /**
     * methode permettant d'ecrire en ajout dans un fichier
     */
    public function writeFichier($msg)
    {
        $this->openFile('a');
        //on ecrit le message
        fprintf($this->file, PHP_EOL.'%s', $msg);        
        $this->closeFile();
    }
        /**
     * methode permettant de traiter le fichier recu 
     */
    public function traiteFichier($cheminFichier, $forme) {
        //on commence par ouvrir le fichier en mode lecture
        $file = fopen($cheminFichier, "r");
        //puis on parcour   s le csv en recuperant les elements ligne par ligne
        while ($ligne = fgetcsv($file, filesize($cheminFichier))) {
            $table[] = $ligne;
        }
        fclose($file);
        //var_dump($table);
        $i=0;
        $j=0;
        $tab;
        foreach ($table as $key) {
            //var_dump($key[0]);
                $temp=\explode(';', $key[0]);
                foreach($forme as $f)
                {
                    if($j<count($temp)){
                        $tab[$i][$f] = $temp[$j];
                        $j++;
                    }
                }
            $j=0;
              $i++;
         }
            
       
        //puis on charge dans la base de donnees
        return $tab;
    }

}

/*$fichier=new Fichier();
$fichier->setCheminFichier('pat.txt');
$fichier->writeFichier('tagrossetete');*/