<?php
    session_start();
    include '../db_config.php';

    $questionEtSelect = $connexion->prepare('SELECT * FROM etudiants WHERE et_id = :et_id');

    $questionEnsSelect = $connexion->prepare('SELECT * FROM enseignants WHERE ens_id = :ens_id');
    
    $questionUESelect = $connexion->prepare('SELECT * FROM UEs WHERE UE_id = :UE_id');

    $ensSelect = $connexion->prepare('
        SELECT DISTINCT enseignants.*
        FROM enseignants
        INNER JOIN questions
        ON enseignants.ens_id = questions.ens_id
        WHERE questions.ans_libelle = ""
    ');

    $UESelect = $connexion->prepare('
        SELECT DISTINCT UEs.*
        FROM UEs
        INNER JOIN questions
        ON UEs.UE_id = questions.UE_id
        WHERE questions.ans_libelle = ""
    ');
    
    $newEnsSelect = $connexion->prepare('
        SELECT * FROM enseignants WHERE ens_id IN
            (SELECT ens_id FROM enseigne WHERE UE_id =
                (SELECT UE_id FROM UEs WHERE UE_id = :UE_id)
            )
        AND ens_id != :ens_id'
    );
?>
<!DOCTYPE html>
<html>
    <head>
        <title>ESSFAR interaction - Espace admin - Réassigner</title>
        <?php include 'admin-head.php'; ?>
        <link rel='stylesheet' href='reass.css'>
        <script src='reass.js'></script>
        <style>
            .admin-quest-send-date{width: 10.8%;}
            .admin-quest-infos{
                width: 87.2%;
                border-left: 0.4px solid white;
            }
            div.admin-center-container{right: 200px;}
        </style>
    </head>
    <body>
        <?php include 'espace_admin-base.php' ?>
        
                <?php                    
                if(isset($_SESSION['UE-filter']) && !empty($_SESSION['UE-filter']) && $_SESSION['UE-filter'] != 0){
                    $questionsSelect = $connexion->prepare('SELECT * FROM questions WHERE ans_libelle = "" AND UE_id = '  .$_SESSION['UE-filter']);
                    
                    $questionUESelect->bindParam('UE_id', $_SESSION['UE-filter']);
                    $questionUESelect->execute();
                    $UETitle = $questionUESelect->fetch();
                    ?>
                    <h1 id='admin-heading'>Questions non traitées en <?php echo $UETitle['UE_nom'] ?></h1>
        
                    <?php unset($_SESSION['UE-filter']);
                }
                
                elseif(isset($_SESSION['ens-filter']) && !empty($_SESSION['ens-filter']) && $_SESSION['ens-filter'] != 0){
                    $questionsSelect = $connexion->prepare('SELECT * FROM questions WHERE ans_libelle = "" AND ens_id = ' .$_SESSION['ens-filter']);
                    
                    $questionEnsSelect->bindParam('ens_id', $_SESSION['ens-filter']);
                    $questionEnsSelect->execute();
                    $ensTitle = $questionEnsSelect->fetch();
                    ?>
                    <h1 id='admin-heading'>Questions non traitées de <?php echo ensName($ensTitle) ?></h1>
        
                    <?php unset($_SESSION['ens-filter']);
                }
        
                else{
                    $questionsSelect = $connexion->prepare('SELECT * FROM questions WHERE ans_libelle = ""');
                    
                    ?> <h1 id='admin-heading'>Questions non traitées</h1> <?php
                }
                    
                $questionsSelect->execute();

                $questCounter = 0;
                while($question = $questionsSelect->fetch()){
                    $questCounter++;

                    $questionEtSelect->bindParam(':et_id', $question['et_id']);
                    $questionEtSelect->execute();
                    $questionEt = $questionEtSelect->fetch();

                    $questionEnsSelect->bindParam(':ens_id', $question['ens_id']);
                    $questionEnsSelect->execute();
                    $questionEns = $questionEnsSelect->fetch();
                    
                    $questionUESelect->bindParam(':UE_id', $question['UE_id']);
                    $questionUESelect->execute();
                    $questionUE = $questionUESelect->fetch();
                ?>
        
                <div id='admin-content'>
                    <div class='admin-questions-display'>
                        <div class='admin-quest-send-date'>
                            <b>Date question</b>
                            <br>
                            <p><?php echo $question['quest_date'] ?></p>
                            <br>
                            <p><?php echo $question['quest_heure'] ?></p>
                        </div>
                        <div class='admin-quest-infos' title='Cliquez pour assigner la question a un autre enseignant'>
                            <span id='question-id'><?php echo $question['quest_id'] ?></span>
                            <p>Posee par : </p>
                            <b><?php echo explode(' ', $questionEt['et_prenom'])[0]. ' ' .explode(' ', $questionEt['et_nom'])[0] ?></b>
                            <br>
                            <p>A :</p>
                            <b><?php ensName($questionEns) ?></b>
                            <br>
                            <p>UE concernee : </p>
                            <b><?php echo $questionUE['UE_nom'] ?></b>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>

        <div id='admin-right'>
            <button id='close' title='Fermer'></button>
            
            <div id='ens-filter-bloc'>
                <h4>Trier par enseignant</h4>
                <form method='post' id='filter' action='reass-traitement.php'>      
                    <?php
                    $ensSelect->execute();
                        
                    while($ensItem = $ensSelect->fetch()){
                    ?>
                    <button type='submit' name='ens-filter' value="<?php echo $ensItem['ens_id'] ?>"><?php ensName($ensItem) ?></button>
                    <?php
                    }
                    ?>
                </form>
            </div>
            <div id='UE-filter-bloc'>
                <h4>Trier par UE</h4>
                <form method='post' id='filter' action='reass-traitement.php'>
                    <?php
                    $UESelect->execute();
                        
                    while($UEItem = $UESelect->fetch()){
                    ?>
                    <button type='submit' name='UE-filter' value="<?php echo $UEItem['UE_id'] ?>"><?php echo $UEItem['UE_nom'] ?></button>
                    <?php
                    }
                    ?>
                </form>
            </div>
            
            <div id='reassign-bloc'>
                <h4>Assigner cette question a</h4>
                <form method='post' action='reass-traitement.php' id='reassign-form'>
                    <input type='text' name='modif-question-id' id='modif-question-id'>                        
                        <?php                        
                        $questionsSelect->execute();
                        
                            while($questionEnsList = $questionsSelect->fetch()){
                        ?>      <div class='new-ens-list' label="Choisir nouvel enseignant"> <?php
                                $newEnsSelect->bindParam(':UE_id', $questionEnsList['UE_id']);
                                $newEnsSelect->bindParam(':ens_id', $questionEnsList['ens_id']);
                                
                                $newEnsSelect->execute();
                        
                                while($newEns = $newEnsSelect->fetch()){
                        ?>
                                    <button name='reass-quest' class='ens-choice' value="<?php echo $newEns['ens_id'] ?>" name="ens-choice"><?php ensName($newEns) ?></button>
                        <?php
                                }
                        ?>      </div> <?php
                            }
                        
                        ?>
                    <input type='password' name='confirm-action' class='confirm-action' placeholder='Votre mot de passe' required='required'>
                </form>
            </div>
        </div>
        
        <?php include "reass-script.php"; ?>
    </body>
</html>