<?php
    session_start();
    include '../db_config.php';
    
    
    // Recuperation des IDs UE / enseignant pour le tri
    if(isset($_POST['UE-questions']) && !empty($_POST['UE-questions']))
        $_SESSION['UE-questions'] = $_POST['UE-questions'];
    
    if(isset($_POST['ens-questions']) && !empty($_POST['ens-questions']))
        $_SESSION['ens-questions'] = $_POST['ens-questions'];
    
    
    // Envoi d'une question
    if(isset($_POST['send-quest']) && !empty($_POST['send-quest'])){
        $ajouterQuestion = $connexion->prepare("
            INSERT INTO questions(quest_libelle, quest_date, quest_heure, et_id, ens_id, UE_id)
            VALUES(:quest_libelle, :quest_date, :quest_heure, :et_id, :ens_id, :UE_id)
        ");
        
        date_default_timezone_set('Africa/Brazzaville');
        $date = date('Y-m-d');
        $hour = date('H:i:s');
        
        $ajouterQuestion->bindParam(':quest_libelle', $_POST['quest-wording']);
        $ajouterQuestion->bindParam(':quest_date', $date);
        $ajouterQuestion->bindParam(':quest_heure', $hour);
        $ajouterQuestion->bindParam(':et_id', $_SESSION['id']);
        $ajouterQuestion->bindParam(':ens_id', explode('|', $_POST['question-ens'])[0]);
        $ajouterQuestion->bindParam(':UE_id', explode('|', $_POST['question-ens'])[1]);
        
        $ajouterQuestion->execute();
    }
    
    
    // Suppression d'une question
    if(isset($_POST['question-id']) && !empty($_POST['question-id'])){
        $deleteQuest = $connexion->prepare('DELETE FROM questions WHERE quest_id = ' .$_POST['question-id']);
        $deleteQuest->execute();
    }
    
    
    echo "<script>location.replace('index.php')</script>";
?>