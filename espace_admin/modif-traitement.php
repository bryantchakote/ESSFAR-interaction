<?php
    session_start();
    include '../db_config.php';
    
    $etSelect = $connexion->prepare('SELECT * FROM etudiants WHERE et_matricule = :et_matricule');
    
    $modif_et_niv_effective = $modif_ens_UE_effective = $modif_niv_UE_effective = $modif_supress_effective =
    $modif_et_niv_control = $modif_ens_UE_control = $modif_niv_UE_control = $modif_supress = $confirm_action = '';
    
    if(isset($_POST['submit-et-niv']) && !empty($_POST['submit-et-niv'])){
        if($_POST['confirm-action'] == $_SESSION['mdp']){
            $etSelect->bindParam(':et_matricule', $_POST['modif-matricule']);
            $etSelect->execute();
            $et = $etSelect->fetch();
            
            if((!empty($et)) && ($_POST['et-new-niv'] != $et['niv_id'])){
                $setNivEt = $connexion->prepare('
                    UPDATE etudiants
                    SET niv_id = ' .$_POST['et-new-niv']. '
                    WHERE et_matricule = ' .$_POST['modif-matricule']
                );
                $setNivEt->execute();
                $modif_et_niv_effective = 1;
            }
            elseif(empty($et)) $modif_et_niv_control = 1;
            else $modif_et_niv_control = 2;
        }
        else $confirm_action = 1;
    }
    
    if(isset($_POST['submit-ens-UE']) && !empty($_POST['submit-ens-UE'])){
        if($_POST['confirm-action'] == $_SESSION['mdp']){
            $UEEnsSelect = $connexion->prepare('SELECT * FROM enseigne WHERE ens_id = ' .$_POST['modif-ens-UE-ens-list']);
            
            if($_POST['modif-ens-UE-action'] == 'ajouter-UE'){
                $UEEnsSelect->execute();
                
                $addEnsUE = $connexion->prepare('
                    INSERT INTO enseigne(UE_id, ens_id)
                    VALUES(' .$_POST['modif-ens-UE-UE-list']. ', ' .$_POST['modif-ens-UE-ens-list']. ')
                ');
                
                while($UEEns1 = $UEEnsSelect->fetch())
                    if($UEEns1['UE_id'] == $_POST['modif-ens-UE-UE-list'])
                        $modif_ens_UE_control = 1;
                
                if($modif_ens_UE_control == 0){
                    $addEnsUE->execute();
                    $modif_ens_UE_effective = 1;
                }
            }
            else{
                $UEEnsSelect->execute();
                
                $removeEnsUE = $connexion->prepare('
                    DELETE FROM enseigne
                    WHERE UE_id = ' .$_POST['modif-ens-UE-UE-list']. ' AND ens_id = ' .$_POST['modif-ens-UE-ens-list']
                );
                
                $modif_ens_UE_control = 2;
                while($UEEns2 = $UEEnsSelect->fetch())
                    if($UEEns2['UE_id'] == $_POST['modif-ens-UE-UE-list'])
                        $modif_ens_UE_control = 0;
                
                if($modif_ens_UE_control == 0){
                    $removeEnsUE->execute();
                    $modif_ens_UE_effective = 1;
                }
            }
        }
        else $confirm_action = 1;
    }
    
    if(isset($_POST['submit-niv-UE']) && !empty($_POST['submit-niv-UE'])){
        if($_POST['confirm-action'] == $_SESSION['mdp']){
            $UENivSelect = $connexion->prepare('SELECT * FROM appartient WHERE niv_id = ' .$_POST['modif-niv-UE-niv-list']);
            
            if($_POST['modif-niv-UE-action'] == 'ajouter-UE'){
                $UENivSelect->execute();
                
                $addNivUE = $connexion->prepare('
                    INSERT INTO appartient(UE_id, niv_id)
                    VALUES(' .$_POST['modif-niv-UE-UE-list']. ', ' .$_POST['modif-niv-UE-niv-list']. ')
                ');
                
                while($UENiv1 = $UENivSelect->fetch())
                    if($UENiv1['UE_id'] == $_POST['modif-niv-UE-UE-list'])
                        $modif_niv_UE_control = 1;
                
                if($modif_niv_UE_control == 0){
                    $addNivUE->execute();
                    $modif_niv_UE_effective = 1;
                }
            }
            else{
                $UENivSelect->execute();
                
                $removeNivUE = $connexion->prepare('
                    DELETE FROM appartient
                    WHERE UE_id = ' .$_POST['modif-niv-UE-UE-list']. ' AND niv_id = ' .$_POST['modif-niv-UE-niv-list']
                );
                
                $modif_niv_UE_control = 2;
                while($UENiv2 = $UENivSelect->fetch())
                    if($UENiv2['UE_id'] == $_POST['modif-niv-UE-UE-list'])
                        $modif_niv_UE_control = 0;
                
                if($modif_niv_UE_control == 0){
                    $removeNivUE->execute();
                    $modif_niv_UE_effective = 1;
                }
            }
        }
        else $confirm_action = 1;
    }
    
    if(isset($_POST['submit-suppress']) && !empty($_POST['submit-suppress'])){
        if($_POST['confirm-action'] == $_SESSION['mdp']){
            if(isset($_POST['suppress-matricule']) && !empty($_POST['suppress-matricule'])){
                $etSelect->bindParam(':et_matricule', $_POST['suppress-matricule']);
                $etSelect->execute();
                
                $modif_suppress = 1;
                while($etCheck = $etSelect->fetch())
                    if($etCheck['et_matricule'] == $_POST['suppress-matricule'])
                        $modif_suppress = 0;
                
                if($modif_suppress == 0){
                    $removeEt = $connexion->prepare('DELETE FROM etudiants WHERE et_matricule = ' .$_POST['suppress-matricule']);
                    $removeEt->execute();
                    $modif_supress_effective = 1;
                }
            }
            if(isset($_POST['suppress-ens']) && !empty($_POST['suppress-ens'])){
                $removeEns = $connexion->prepare("DELETE FROM enseignants WHERE ens_id = '" .$_POST['suppress-ens']. "'");
                $removeEns->execute();
                $modif_supress_effective = 1;
            }
        }
        else $confirm_action = 1;
    }
    
    // Messages d'erreur
    function reportMessage($var, $value, $message){
        if(isset($var) && !empty($var) && ($var == $value)){
            echo $message;
            echo "<script>location.replace('espace_admin-modification.php')</script>";
        }
    }
    
    reportMessage($modif_et_niv_effective, 1, "<script>alert('Niveau de l\'etudiant modifie!')</script>");
    reportMessage($modif_et_niv_control, 1, "<script>alert('Matricule invalide!')</script>");
    reportMessage($modif_et_niv_control, 2, "<script>alert('Etudiant deja dans le niveau selectionne!')</script>");
    
    reportMessage($modif_ens_UE_effective, 1, "<script>alert('Donnees de l\'enseignant modifiees!')</script>");
    reportMessage($modif_ens_UE_control, 1, "<script>alert('UE deja enseignee par l\'enseignant selectionne!')</script>");
    reportMessage($modif_ens_UE_control, 2, "<script>alert('UE non enseignee par l\'enseignant selectionne!')</script>");
    
    reportMessage($modif_niv_UE_effective, 1, "<script>alert('Donnees du niveau modifiees!')</script>");
    reportMessage($modif_niv_UE_control, 1, "<script>alert('UE appartenant deja au niveau selectionne!')</script>");
    reportMessage($modif_niv_UE_control, 2, "<script>alert('UE n\'appartenant pas au niveau selectionne!')</script>");
    
    reportMessage($modif_supress_effective, 1, "<script>alert('Utilisateur(s) supprimee(s)!')</script>");
    reportMessage($modif_supress, 1, "<script>alert('Matricule invalide!')</script>");
    
    reportMessage($confirm_action, 1, "<script>alert('Mot de passe invalide!')</script>");
?>