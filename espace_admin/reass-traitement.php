<?php
    session_start();
    include '../db_config.php';

    if(isset($_POST['ens-filter']) && !empty($_POST['ens-filter'])){
        $_SESSION['ens-filter'] = $_POST['ens-filter'];
        $_SESSION['UE-filter'] = 0;
    }
    if(isset($_POST['UE-filter']) && !empty($_POST['UE-filter'])){
        $_SESSION['ens-filter'] = 0;
        $_SESSION['UE-filter'] = $_POST['UE-filter'];
    }

    if(isset($_POST['reass-quest']) && !empty($_POST['reass-quest'])){
        $reassQuest = $connexion->prepare('UPDATE questions SET ens_id = "' .$_POST['reass-quest']. '" WHERE quest_id = "' .$_POST['modif-question-id']. '"');
        $reassQuest->execute();
        echo "<script>alert('Question reassignée à un autre enseignant')</script>";
    }

    echo "<script>location.replace('espace_admin-reassigner_questions.php')</script>";
?>