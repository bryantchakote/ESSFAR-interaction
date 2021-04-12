<?php
    session_start();
    include '../db_config.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>ESSFAR interaction - Espace admin - Enregistrement</title>
        <?php include 'admin-head.php'; ?>
        <link rel='stylesheet' href='enreg.css'>
        <script src='enreg.js'></script>
    </head>
    <body>
        <?php include 'espace_admin-base.php' ?>

                <h1 id='admin-heading'>Enregistrer un nouvel utilisateur</h1>
                
                <div id='admin-content'>
                    <form method='post' action='enreg-traitement.php'>
                        <div class='enreg-left'>
                            <label for='enreg-nom' class='enreg-lbl-left'>Nom</label>
                            <input type='text' name='enreg-nom' id='enreg-nom' required='required'>
                            <span id='name1-validation'></span>

                            <label for='enreg-prenom' class='enreg-lbl-left'>Prenom</label>
                            <input type='text' name='enreg-prenom' id='enreg-prenom'>
                            <span id='name2-validation'></span>

                            <label for='enreg-sexe' class='enreg-lbl-left'>Sexe (M ou F)</label>
                            <input type='text' name='enreg-sexe' id='enreg-sexe' required='required'>
                            <span id='sexe-validation'></span>

                            <label for='enreg-email' class='enreg-lbl-left'>Adresse mail</label>
                            <input type='email' name='enreg-email' id='enreg-email' required='required'>
                            <span id='email-validation'></span>

                            <label for='enreg-pwd1' class='enreg-lbl-left'>Mot de passe (6 - 16 caracteres)</label>
                            <input type='password' name='enreg-pwd1' id='enreg-pwd1' maxlength='16' required='required'>
                            <span id='pwd-length-validation'></span>

                            <label for='enreg-pwd2' class='enreg-lbl-left'>Confirmation du mot de passe</label>
                            <input type='password' name='enreg-pwd2' id='enreg-pwd2' maxlength='16' required='required'>
                            <span id='pwd-validation'></span>
                        </div>

                        <div class='enreg-right'>
                        <span id='user-type-validation'></span>
                            <div id='first-right'>
                                <input type='radio' name='qualite' id='etudiant' value='etudiant'>
                                <label for='etudiant' class='radio-lbl'>Etudiant</label>

                                <label for='enreg-matricule' class='enreg-lbl-right'>Matricule</label>
                                <input type='text' name='enreg-matricule' id='enreg-matricule' maxlength='11' disabled='disabled'>
                                <span id='mat-validation'></span>

                                <select name='enreg-niv' id='enreg-niv' disabled='disabled'>
                                    <option disabled='disabled' selected='selected' value="Niveau">Niveau</option>
                                    
                                    <?php
                                    $nivSelect = $connexion->prepare('SELECT * FROM niveaux');
                                    $nivSelect->execute();
                                    while($niv = $nivSelect->fetch()){
                                    ?>
                                        <option value="<?php echo $niv['niv_id'] ?>"><?php echo $niv['niv_nom'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <span id='niv-validation'></span>
                            </div>

                            <div id='second-right'>
                                <input type='radio' name='qualite' id='enseignant' value='enseignant'>
                                <label for='enseignant' class='radio-lbl'>Enseignant</label>

                                <select name='enreg-UE' id='enreg-UE' size='1' disabled='disabled'>
                                    <option disabled='disabled' selected='selected' value="Unite d'enseignement">Unite d'enseignement</option>
                                    
                                    <?php
                                    $UESelect = $connexion->prepare('SELECT * FROM UEs');
                                    $UESelect->execute();
                                    while($UE = $UESelect->fetch()){
                                    ?>
                                        <option value="<?php echo $UE['UE_id'] ?>"><?php echo $UE['UE_nom'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <span id='UE-validation'></span>
                            </div>
                            
                            <div id='third-right'>
                                <input type='password' name='confirm-action' class='confirm-action' placeholder='Votre mot de passe' required='required'>
                                <button type='submit' value='valider' id='enreg-submit' name='enreg-submit'>Valider</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <?php include 'enreg-script.php' ?>
    </body>
</html>