<?php
    $DB_DSN = 'mysql:host=localhost;dbname=essfar_interaction';
    $DB_USER = 'root';
    $DB_PASS = '';
    
    try{
        $options =
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        
        $connexion = new PDO($DB_DSN, $DB_USER, $DB_PASS, $options);
    }
    catch(PDOException $e){
        echo 'Erreur de connexion : ' .$e->getMessage();
    }
    
    // Monsieur ou Madame?
    function ensName($ens){
        echo $ens['ens_sexe'] == 'M' ? 'M. ' : 'Mme. ';
        echo explode(' ', $ens['ens_nom'])[0]. ' ' .explode(' ', $ens['ens_prenom'])[0];
    }
?>