<?php
    session_start();
    include '../db_config.php';
    
    $questionEtSelect = $connexion->prepare('SELECT * FROM etudiants WHERE et_id = :et_id');
    
    $nivNameSelect = $connexion->prepare('SELECT * FROM niveaux WHERE niv_id = :niv_id');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>ESSFAR interaction - Espace enseignant</title>
        <link rel='stylesheet' href='../styles.css'>
        <link rel='stylesheet' href='../et-ens-admin-styles.css'>
        <link rel='stylesheet' href='ens-styles.css'>
    </head>
    <body>
        <?php include '../et_ens_admin-header.php' ?>
        
        <!-- Bloc de gauche -->
        <div id='ens-left'>
            <div class='ens-left-up'>
                <h3 class='ens-title'>ESSFAR interaction</h3>
                <h4 class='ens-subtitle'>Espace enseignants</h4>
                <p id='ens-name'>
                    <?php
                        $userName = explode(' ', $_SESSION['nom'])[0];
                        $userFirstname = explode(' ', $_SESSION['prenom'])[0];
                        
                        if($_SESSION['sexe'] == 'M') echo 'M. ';
                        else echo 'Mme. ';
                        
                        if(strlen($userName) > 11 || strlen($userFirstname) > 11) echo $userName;
                        else echo $userName. ' ' .$userFirstname;
                    ?>
                </p>
            </div>
            
            <form method='post' id='logout-confirm' action='../logout.php'>
                <button name='logout' id='logout' value='logout'>Deconnexion</button>
            </form>
        </div>
        
        <!-- Bloc central -->
        <div class='ens-center-container'>
            <div id='ens-center'>
                <div class='ens-options'>  
                    <nav class='ens-menu'>
                        <form method='post' action='ens-trait.php'>
                            <button id='ens-all-quest'>Toutes les questions</button>
                            <button type='submit' name='untreated-quest' value='untreated-quest' id='ens-untreated-quest'>Non-traitees</button>
                            <button type='submit' name='treated-quest' value='treated-quest' id='ens-treated-quest'>Traitees</button>
                        </form>
                    </nav>
                </div>
                
                <?php
                if(isset($_SESSION['untreated-quest']) && !empty($_SESSION['untreated-quest']) && $_SESSION['untreated-quest'] == 1){
                    $questionsSelect = $connexion->prepare('
                        SELECT * FROM questions
                        WHERE ens_id = ' .$_SESSION['id']. ' AND ans_libelle = ""
                        ORDER BY quest_id DESC'
                    );
                    
                    unset($_SESSION['untreated-quest']);
                ?>  <h1 id='ens-questions-heading'>Questions non traitees</h1> <?php
                }
                
                elseif(isset($_SESSION['treated-quest']) && !empty($_SESSION['treated-quest']) && $_SESSION['treated-quest'] == 1){
                    $questionsSelect = $connexion->prepare('
                        SELECT * FROM questions
                        WHERE ens_id = ' .$_SESSION['id']. ' AND ans_libelle != ""
                        ORDER BY quest_id DESC'
                    );
                    
                    unset($_SESSION['treated-quest']);
                ?>  <h1 id='ens-questions-heading'>Questions traitees</h1> <?php
                }
                
                else{
                    $questionsSelect = $connexion->prepare('
                        SELECT * FROM questions WHERE ens_id = ' .$_SESSION['id']. '
                        ORDER BY quest_id DESC'
                    );
                    
                ?>  <h1 id='ens-questions-heading'>Toutes les questions</h1> <?php
                }
                
                $questionsSelect->execute();
                
                $questCounter = 0;
                while($question = $questionsSelect->fetch()){
                    $questCounter++;
                    
                    $questionEtSelect->bindParam(':et_id', $question['et_id']);
                    $questionEtSelect->execute();
                    $questionEt = $questionEtSelect->fetch();
                    
                    $nivNameSelect->bindParam(':niv_id', $questionEt['niv_id']);
                    $nivNameSelect->execute();
                    $nivName = $nivNameSelect->fetch();
                ?>
                <div class='ens-questions-display'>
                    <div class='ens-quest-recept-date'>
                        <b>Date question</b>
                        <br>
                        <p><?php echo $question['quest_date'] ?></p>
                        <br>
                        <p><?php echo $question['quest_heure'] ?></p>
                    </div>
                    <div class='ens-quest-infos' title='Cliquez pour afficher le contenu'>
                        <p>Posee par :</p>
                        <b><?php echo explode(' ', $questionEt['et_prenom'])[0]. ' ' .explode(' ', $questionEt['et_nom'])[0] ?></b>
                        <br>
                        <p>Etudiant en :</p>
                        <b><?php echo $nivName['niv_alias'] ?></b>
                        <br>
                        <div class='ens-answer-content'>
                            <span class='question-id'><?php echo $question['quest_id'] ?></span>
                            <p>Question :</p>
                            <b><?php echo $question['quest_libelle'] ?></b>
                            <br><br>
                            <p>Reponse :</p>
                            <b><?php echo ($question['ans_libelle'] == '') ? 'Vous n\'avez pas encore repondu a cette question' : $question['ans_libelle'] ?></b>
                            <br><br>
                        </div>
                    </div>
                    <div class='ens-ans-send-date'>
                        <b>Date reponse</b>
                        <br>
                        <p><?php echo $question['ans_date'] == NULL ? '----------------' : $question['ans_date'] ?></p>
                        <br>
                        <p><?php echo $question['ans_heure'] == NULL ? '----------------' : $question['ans_heure'] ?></p>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        
        <div id='ens-right'>
            <button id='close'></button>
            
            <div id='ens-quest-ans-text'></div>
            
            <div id='actions'>
                <div id='ens-ans-display'>
                    <button id='answer'>Repondre</button>
                    
                    <form method='post' action='ens-trait.php' id='answer-form'>
                    <!-- Bloc de formulation de la reponse -->
                        <input name='ens-question-id' id='ens-question-id'>
                        
                        <div id='ens-edit-ans'>
                            <textarea name='ans-wording' id='ans-wording' rows='12' cols='18' maxlength= '500' placeholder='Tapez votre reponse'></textarea>
                            
                            <button type='submit' name='send-ans' id='send-ans' value='send-ans'>Envoyer</button>
                        </div>
                        
                        <button name='ens-quest-delete' id='ens-quest-delete' value='ens-quest-delete'>Supprimer</button>
                    </form>
                </div>
            </div> 
        </div>
        
        <?php include 'ens-script.php' ?>
    </body>
</html>