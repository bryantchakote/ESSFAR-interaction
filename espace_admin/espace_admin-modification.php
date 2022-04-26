<?php
    session_start();
    include '../db_config.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>ESSFAR interaction - Espace admin - Modification</title>
        <?php include 'admin-head.php'; ?> 
        <link rel='stylesheet' href='modif.css'>
        <script src='modif.js'></script>
    </head>
    <body>
        <?php include 'espace_admin-base.php' ?>
        
                <h1 id='admin-heading'>Modifier des données</h1>
                
                <div id='admin-content'>
                    <div class='modif-container'>
                        <?php
                        $ensSelect = $connexion->prepare('SELECT * FROM enseignants');
                        
                        $UESelect = $connexion->prepare('SELECT * FROM UEs');
        
                        $nivSelect = $connexion->prepare('SELECT * FROM niveaux');
                        ?>
                        <div id='modif-et-niv'>
                            <h4 id='modif-et-niv-title'>Changer le niveau d'un etudiant</h4>
                            <div class='modif-subcontainer'>
                                <form method='post' action='modif-traitement.php'>
                                    <label for='modif-matricule' id='modif-matricule-label'>Matricule étudiant</label>
                                    <input type='text' name='modif-matricule' id='modif-matricule' maxlength='11'>

                                    <select name='et-new-niv' id='et-new-niv'>
                                        <option selected='selected' disabled='disabled' value='choix-niveau'>Choisir nouveau niveau</option>
                                        
                                        <?php
                                        $nivSelect->execute();
                                        while($nivEt = $nivSelect->fetch()){
                                        ?>
                                        <option value="<?php echo $nivEt['niv_id'] ?>"><?php echo $nivEt['niv_nom'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                    <input type='password' name='confirm-action' class='confirm-action' placeholder='Mot de passe' required='required'>
                                    <button type='submit' value='submit-et-niv' name='submit-et-niv' id='submit-et-niv'>Valider</button>
                                </form>
                            </div>
                        </div>

                        <div id='modif-ens-UE'>
                            <h4 id='modif-ens-UE-title'>Gérer les UEs d'un enseignant</h4>
                            <div class='modif-subcontainer'>
                                <form method='post' action='modif-traitement.php'>
                                    <select name='modif-ens-UE-action' id='modif-ens-UE-action'>
                                        <option value='action' selected='selected' disabled='disabled'>Action</option>
                                        <option value='ajouter-UE'>Ajouter une UE</option>
                                        <option value='retirer-UE'>Retirer une UE</option>
                                    </select>

                                    <select name='modif-ens-UE-ens-list' id='modif-ens-UE-ens-list'>
                                        <option value='choix-enseignant'>Choisir enseignant</option>
                                        
                                        <?php
                                        $ensSelect->execute();
                                        while($ensUE_ens = $ensSelect->fetch()){
                                        ?>
                                        <option value="<?php echo $ensUE_ens['ens_id'] ?>"><?php ensName($ensUE_ens) ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                    <select name='modif-ens-UE-UE-list' id='modif-ens-UE-UE-list'>
                                        <option selected='selected' disabled='disabled' value='choix-UE'>Choisir UE</option>
                                        
                                        <?php
                                        $UESelect->execute();
                                        while($ensUE_UE = $UESelect->fetch()){
                                        ?>
                                        <option value="<?php echo $ensUE_UE['UE_id'] ?>"><?php echo $ensUE_UE['UE_nom'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    
                                    <input type='password' name='confirm-action' class='confirm-action' placeholder='Mot de passe' required='required'>
                                    <button type='submit' value='submit-ens-UE' name='submit-ens-UE' id='submit-ens-UE'>Valider</button>
                                </form>
                            </div>
                        </div>

                        <div id='modif-niv-UE'>
                            <h4 id='modif-niv-UE-title'>Gérer les UEs d'un niveau</h4>
                            <div class='modif-subcontainer'>
                                <form method='post' action='modif-traitement.php'>
                                    <select name='modif-niv-UE-action' id='modif-niv-UE-action'>
                                        <option value='action' selected='selected' disabled='disabled'>Action</option>
                                        <option value='ajouter-UE'>Ajouter une UE</option>
                                        <option value='retirer-UE'>Retirer une UE</option>
                                    </select>

                                    <select name='modif-niv-UE-niv-list' id='modif-niv-UE-niv-list'>
                                        <option value='choix-niveau' selected='selected' disabled='disabled'>Choisir niveau</option>
                                        
                                        <?php
                                        $nivSelect->execute();
                                        while($nivUE_niv = $nivSelect->fetch()){
                                        ?>
                                        <option value="<?php echo $nivUE_niv['niv_id'] ?>"><?php echo $nivUE_niv['niv_nom'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                    <select name='modif-niv-UE-UE-list' id='modif-niv-UE-UE-list'>
                                        <option selected='selected' disabled='disabled' value='choix-UE'>Choisir UE</option>
                                        
                                        <?php
                                        $UESelect->execute();
                                        while($nivUE_UE = $UESelect->fetch()){
                                        ?>
                                        <option value="<?php echo $nivUE_UE['UE_id'] ?>"><?php echo $nivUE_UE['UE_nom'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                    <input type='password' name='confirm-action' class='confirm-action' placeholder='Mot de passe' required='required'>
                                    <button type='submit' value='submit-niv-UE' name='submit-niv-UE' id='submit-niv-UE'>Valider</button>
                                </form>
                            </div>
                        </div>

                        <div id='modif-suppress'>
                            <h4 id='modif-suppress-title'>Supprimer un utilisateur</h4>
                            <div class='modif-subcontainer'>
                                <form method='post' action='modif-traitement.php'>
                                    <label for='suppress-matricule' id='suppress-matricule-label'>Matricule étudiant</label>
                                    <input type='text' name='suppress-matricule' id='suppress-matricule' maxlength='11'>

                                    <p class='etou'>(ET / OU)</p>
                                    
                                    <select name='suppress-ens' id='suppress-ens'>
                                        <option name='ens-list' value='choix-enseignant'>Choisir enseignant</option>
                                        
                                        <?php
                                        $ensSelect->execute();
                                        while($suppress_ens = $ensSelect->fetch()){
                                        ?>
                                        <option value="<?php echo $suppress_ens['ens_id'] ?>"><?php ensName($suppress_ens) ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    
                                    <input type='password' name='confirm-action' class='confirm-action' placeholder='Mot de passe' required='required'>
                                    <button type='submit' value='submit-suppress' name='submit-suppress' id='submit-suppress'>Valider</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include 'modif-script.php' ?>
    </body>
</html>