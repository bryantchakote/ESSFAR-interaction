<?php
    session_start();
    include '../db_config.php';
    
    // Niveau de l'etudiant connecte
    $etNivSelect = $connexion->prepare('
        SELECT niv_id, niv_alias FROM niveaux
        NATURAL JOIN etudiants
        WHERE etudiants.et_id = ' .$_SESSION['id']. '
    ');
    $etNivSelect->execute();
    $etNiv = $etNivSelect->fetch();
    
    // Enseignant et UE pour chaque question
    $questionEnsSelect = $connexion->prepare('SELECT * FROM enseignants WHERE ens_id = :ens_id');
    $questionUESelect = $connexion->prepare('SELECT * FROM UEs WHERE UE_id = :UE_id');
    
    // UEs du niveau (pour une nouvelle question)
    $UEsSelect = $connexion->prepare('
        SELECT * FROM appartient
        NATURAL JOIN ues
        WHERE niv_id = ' .$etNiv['niv_id']. '
        ORDER BY UE_nom'
    );
    
    // Enseignants de chacune des UEs selectionnees ci-dessus
    $ensSelect = $connexion->prepare('
        SELECT * FROM enseigne
        NATURAL JOIN enseignants
        WHERE UE_id = :UE_id
        ORDER BY ens_nom
    ');
    
    // UEs dans lesquelles on a des questions posees
    $findUESelect = $connexion->prepare('
        SELECT DISTINCT UE_id, UE_nom FROM UEs
        NATURAL JOIN questions
        WHERE UE_id IN
            (SELECT UE_id FROM appartient WHERE niv_id = "' .$etNiv['niv_id']. '")
        AND et_id = "' .$_SESSION['id']. '"
        ORDER BY UE_nom
    ');
    
    // Enseignants auxquels non questions ont ete destinees
    $findEnsSelect = $connexion->prepare('
        SELECT DISTINCT ens_id, ens_nom, ens_prenom, ens_sexe FROM enseignants
        NATURAL JOIN questions
        WHERE ens_id IN
            (SELECT ens_id FROM enseigne WHERE UE_id IN
                (SELECT UE_id FROM appartient WHERE niv_id = "' .$etNiv['niv_id']. '")
            )
        AND et_id = "' .$_SESSION['id']. '"
        ORDER BY ens_nom
    ');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>ESSFAR interaction - Espace etudiant</title>
        <link rel='stylesheet' href='../styles.css'>
        <link rel='stylesheet' href='../et-ens-admin-styles.css'>
        <link rel='stylesheet' href='et-styles.css'>
        <script src='../forms.js'></script>
    </head>
    <body>
        <?php include '../et_ens_admin-header.php' ?>
        
        <div id='et-left'>
            <div class='et-left-up'>
                <h3 class='et-title'>ESSFAR interaction</h3>
                <h4 class='et-subtitle'>Espace étudiant</h4>
                <p id='et-name'>
                    <?php
                        // Recuperer uniquement le premier mot du nom et du prenom
                        $userName = explode(' ', $_SESSION['nom'])[0];
                        $userFirstname = explode(' ', $_SESSION['prenom'])[0];
                        
                        if(strlen($userName) > 11 || strlen($userFirstname) > 11) echo $userName. ' | ' .$etNiv['niv_alias'];
                        else echo $userFirstname. ' ' .$userName. ' | ' .$etNiv['niv_alias'];
                    ?>
                </p>
            </div>
            
            <nav class='et-menu'>
                <button id='default-menu-title'><a href='index.php'>Toutes mes questions</a></button>
                <button id='UE-menu-title'>Afficher par UE</button>
                <button id='ens-menu-title'>Afficher par Enseignant</button>
            </nav>
            
            <form method='post' action='../logout.php' id='logout-confirm'>
                <button name='logout' id='logout' value='logout'>Déconnexion</button>
            </form>
        </div>
        
        <div class='et-center-container'>
            <div class='et-center'>
                <div class='et-ask-question'>
                    <button id='new-question'>Poser une question</button>
                </div>
                
                <?php
                // Visuel des questions ...
                
                // Au clic sur 'Afficher par UE'
                if(isset($_SESSION['UE-questions']) && !empty($_SESSION['UE-questions']) && $_SESSION['UE-questions'] != 0){
                    $questionsSelect = $connexion->prepare('
                        SELECT * FROM questions
                        WHERE et_id = "' .$_SESSION['id']. '"
                        AND UE_id = "' .$_SESSION['UE-questions']. '"
                        ORDER BY quest_id DESC
                    ');
                    
                    $questionUESelect->bindParam('UE_id', $_SESSION['UE-questions']);
                    $questionUESelect->execute();
                    $UETitle = $questionUESelect->fetch();
                    ?>
                    <h1 id='admin-heading'>Questions posées en <?php echo $UETitle['UE_nom'] ?></h1>
                    
                    <?php unset($_SESSION['UE-questions']);
                }
                
                // Au clic sur 'Afficher par enseignant'
                elseif(isset($_SESSION['ens-questions']) && !empty($_SESSION['ens-questions']) && $_SESSION['ens-questions'] != 0){
                    $questionsSelect = $connexion->prepare('
                        SELECT * FROM questions
                        WHERE et_id = "' .$_SESSION['id']. '"
                        AND ens_id = "' .$_SESSION['ens-questions']. '"
                        ORDER BY quest_id DESC
                    ');
                    
                    $questionEnsSelect->bindParam('ens_id', $_SESSION['ens-questions']);
                    $questionEnsSelect->execute();
                    $ensTitle = $questionEnsSelect->fetch();
                    ?>
                    <h1 id='admin-heading'>Questions posées à <?php echo ensName($ensTitle) ?></h1>
                    
                    <?php unset($_SESSION['ens-questions']);
                }
                
                // Affichage de toutes les questions (par defaut)
                else{
                    $questionsSelect = $connexion->prepare('
                        SELECT * FROM questions
                        WHERE et_id = ' .$_SESSION['id']. '
                        ORDER BY quest_id DESC
                    ');
                    
                    ?>  <h1 id='admin-heading'>Toutes mes questions</h1> <?php
                }
                
                $questionsSelect->execute();
                
                // Affichage et decompte des questions
                $questCounter = 0;
                while($question = $questionsSelect->fetch()){
                    $questCounter++;
                    
                    $questionEnsSelect->bindParam(':ens_id', $question['ens_id']);
                    $questionEnsSelect->execute();
                    $questionEns = $questionEnsSelect->fetch();
                    
                    $questionUESelect->bindParam(':UE_id', $question['UE_id']);
                    $questionUESelect->execute();
                    $questionUE = $questionUESelect->fetch();
                ?>
                <div class='et-questions-display'>
                    <div class='et-ans-recept-date'>
                        <b>Date réponse</b>
                        <br>
                        <p><?php echo $question['ans_date'] == NULL ? '----------------' : $question['ans_date'] ?></p>
                        <br>
                        <p><?php echo $question['ans_heure'] == NULL ? '------------' : $question['ans_heure'] ?></p>
                    </div>
                    <div class='et-quest-infos' title='Cliquez pour afficher le contenu'>
                        <p>Posée à : </p>
                        <b><?php ensName($questionEns) ?></b>
                        <br>
                        <p>UE concernée : </p>
                        <b><?php echo $questionUE['UE_nom'] ?></b>
                        <br>
                        <div class='et-answer-content'>
                            <span class='question-id'><?php echo $question['quest_id'] ?></span>
                            <p>Question : </p>
                            <b><?php echo $question['quest_libelle'] ?></b>
                            <br><br>
                            <p>Réponse : </p>
                            <b><?php echo ($question['ans_libelle'] == '') ? 'Votre enseignant n\'a pas encore répondu à cette question' : $question['ans_libelle'] ?></b>
                            <br><br>
                        </div>
                    </div>
                    <div class='et-quest-send-date'>
                        <b>Date question</b>
                        <br>
                        <p><?php echo $question['quest_date'] ?></p>
                        <br>
                        <p><?php echo $question['quest_heure'] ?></p>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        
        <div id='et-right'>
            <button id='close' title='Fermer'></button>
            
            <!-- Poser une question -->
            <div id='ask-quest-active'>
                <form method='post' action='et-trait.php'>
                    <select id='question-ens' name='question-ens'>
                        <option disabled='disabled' selected='selected' value='choix-ens'>Choisir enseignant</option>
                        
                        <!-- Pour chaque UE un optgroup, dans chaque optgroup les enseignants concernes -->
                        <?php
                        $UEsSelect->execute();
                        
                        $ensListCounter = 0;
                        while($UE = $UEsSelect->fetch()){
                        ?>
                        <optgroup label="<?php echo $UE['UE_nom'] ?>">
                            <?php
                            $ensSelect->bindParam(':UE_id', $UE['UE_id']);
                            $ensSelect->execute();
                            
                            while($ensItem = $ensSelect->fetch()){
                                $ensListCounter++;
                            ?>
                            <option class='ens-list' value="<?php echo $ensItem['ens_id']. '|' .$UE['UE_id'] ?>"><?php ensName($ensItem) ?></option>
                            <?php
                            }
                            ?>
                        </optgroup>
                        <?php
                        }
                        ?>
                    </select>
                    
                    <textarea name='quest-wording' id='et-quest-wording' rows='16' cols='18' maxlength= '500' placeholder='Tapez votre question'></textarea>
                    
                    <button type='submit' name='send-quest' id='send-quest' value='Envoyer'>Envoyer</button>
                    <button type='reset' name='cancel-quest' id='cancel-quest'>Annuler</button>
                </form>
            </div>
            
            <!-- Affichage du contenu -->
            <div id='show-ans-active'>
                <!-- Contient le texte integral de la question cliquee et sa reponse eventuelle -->
                <div id='et-quest-ans-text'></div>
                
                <form method='post' action='et-trait.php' id='delete-form'>
                    <!-- Contient l'id de la question cliquee -->
                    <input type='text' name='et-question-id' id='et-question-id'>
                    
                    <button id='et-quest-delete' name='et-quest-delete'>Supprimer</button>
                </form>
            </div>
            
            <!-- Rechercher UE -->
            <div id='show-UE'>
                <h4 class='UE-list-title'>Rechercher UE</h4>
                <form method='post' action='et-trait.php'>
                    <?php
                    $findUESelect->execute();
                    
                    // UEs dans lesquelles on a des questions posees
                    $UECounter = 0;
                    while($findUE = $findUESelect->fetch()){
                        $UECounter++;
                    ?>
                    <button type="submit" name="UE-questions" value="<?php echo $findUE['UE_id'] ?>" class='UE-menu-item'><?php echo $findUE['UE_nom'] ?></button>
                    <?php
                    }
                    ?>
                </form>
            </div>
            
            <!-- Rechercher enseignant -->
            <div id='show-ens'>
                <h4 class='ens-list-title'>Rechercher enseignant</h4>
                <form method='post' action='et-trait.php'>
                    <?php
                    $findEnsSelect->execute();
                    
                    // Enseignants auxquels non questions ont ete destinees
                    $ensCounter = 0;
                    while($findEns = $findEnsSelect->fetch()){
                        $ensCounter++;
                    ?>
                    <button type="submit" name="ens-questions" value="<?php echo $findEns['ens_id'] ?>" class='ens-menu-item'><?php echo ensName($findEns) ?></button>
                    <?php
                    }
                    ?>
                </form>
            </div>
        </div>
        
        <?php include 'et-script.php' ?>
    </body>
</html>