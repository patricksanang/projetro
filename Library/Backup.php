<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Library;

/**
 * Description of Backup
 *
 * @author patrick
 */
class Backup {
    //put your code here
    /**
     * Note: quand on fait le backup un fichier temporaire est cree
     * mais il faut le supprimer a la fin du transfert.
     */

    /**
     * fonction permettant de sauvegarder la bd
     */
    public function backup($ignore, $serveur_sql, $username, $nom_de_la_base, $mot_de_passe, $cheminSauvegardeTempBD) {
        $server = $serveur_sql;
        $database = $nom_de_la_base;
        $user = $username;
        $password = $mot_de_passe;

        //Connexion Ã  la base
        $db = mysql_connect($server, $user, $password) or die(mysql_error());
        mysql_select_db($database, $db) or die(mysql_error());

        //on rÃ©cupÃ¨re la liste des tables de la base de donnÃ©es
        //$tables = mysql_list_tables($database, $db) or die(mysql_error());
        $sql = 'SHOW TABLES FROM ' . $database;
        $tables = mysql_query($sql) or die(mysql_error());

        // si on ne veut pas rÃ©cupÃ©rer les $ignore premiÃ¨res tables
        for ($i = 0; $i < $ignore; $i++)
            ($donnees = mysql_fetch_array($tables));

        // aller on boucle sur toutes les tables
        while ($donnees = mysql_fetch_array($tables)) {
            // on rÃ©cupÃ¨re le create table (structure de la table)
            $table = $donnees[0];
            $sql = 'SHOW CREATE TABLE ' . $table;
            $res = mysql_query($sql) or die(mysql_error() . $sql);
            if ($res) {
                //$datedossier = date("d_m_Y-H_i_s");
                $backup_file = $cheminSauvegardeTempBD;
                $fp = fopen($backup_file, 'a', 1);

                $tableau = mysql_fetch_array($res);
                $tableau[1] .= ";\n";
                $insertions = $tableau[1];
                fwrite($fp, $insertions);

                $req_table = mysql_query('SELECT * FROM ' . $table) or die(mysql_error());
                $nbr_champs = mysql_num_fields($req_table);
                while ($ligne = mysql_fetch_array($req_table)) {
                    $insertions = 'INSERT INTO ' . $table . ' VALUES (';
                    for ($i = 0; $i < $nbr_champs; $i++) {
                        $insertions .= '\'' . mysql_real_escape_string($ligne[$i]) . '\', ';
                    }
                    $insertions = substr($insertions, 0, -2);
                    $insertions .= ");\n\n";
                    fwrite($fp, $insertions);
                }
            } // fin if ($res)
            mysql_free_result($res);
            fclose($fp);
        }
        return true;
    }

    /**
     * fonction permettant de se connecter au serveur distant pour transferer les
     * fichiers
     */
    public function save($ftp_server, $login, $password, $destination_file, $source_file) {
        $connect = ftp_connect($ftp_server);
        if (!$connect) {
            return false;
        }
        if (ftp_login($connect, $login, $password)) {
            $upload = ftp_put($connect, $destination_file, $source_file, FTP_ASCII);
            return $upload;
        } else {
            return false;
        }


        /* if (!$upload) {
          echo "Le transfert Ftp a échoué!";
          } else {
          echo "Téléchargement de " . $source_file . " sur " . $ftp_server . " en " . $destination_file;
          } */
    }

}
