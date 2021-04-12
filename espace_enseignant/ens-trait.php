<?php
    session_start();
    include '../db_config.php';
    
    
    // Type de questions a afficher
    if(isset($_POST['untreated-quest']) && !empty($_POST['untreated-quest']))
        $_SESSION['untreated-quest'] = 1;
    
    if(isset($_POST['treated-quest']) && !empty($_POST['treated-quest']))
        $_SESSION['treated-quest'] = 1;
    
    
    // Envoi d'une reponse
    $success_ans_send = '';
    
    if(isset($_POST['send-ans']) && !empty($_POST['send-ans'])){
        $ajouterReponse = $connexion->prepare('
            UPDATE questions
            SET ans_libelle = :ans_libelle, ans_date = :ans_date, ans_heure = :ans_heure
            WHERE quest_id = ' .$_POST['ens-question-id']
        );
        
        $date = date('Y-m-d');
        $heure = date('H:i:s');
        
        $ajouterReponse->bindParam(':ans_libelle', $_POST['ans-wording']);
        $ajouterReponse->bindParam(':ans_date', $date);
        $ajouterReponse->bindParam(':ans_heure', $heure);
        
        $ajouterReponse->execute();
    }
    
    
    // Suppression d'une question
    $success_quest_delete = '';
    
    if(isset($_POST['ens-quest-delete']) && !empty($_POST['ens-quest-delete'])){
        $deleteQuest = $connexion->prepare('DELETE FROM questions WHERE quest_id = ' .$_POST['ens-question-id']);
        $deleteQuest->execute();
    }
    
    
    echo "<script>location.replace('index.php')</script>";
?>