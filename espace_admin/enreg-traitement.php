<?php
    session_start();
    include '../db_config.php';

    if(isset($_POST['enreg-submit']) && !empty($_POST['enreg-submit'])){
        $et_enreg = $ens_enreg = $et_infos_control = $ens_infos_control = $confirm_action = 0;
        
        if($_POST['confirm-action'] == $_SESSION['mdp'])
            $etInfosSelect = $connexion->prepare('SELECT * FROM etudiants');
            $etInfosSelect->execute();

            $ensInfosSelect = $connexion->prepare('SELECT * FROM enseignants');
            $ensInfosSelect->execute();

            $adminInfosSelect = $connexion->prepare('SELECT * FROM administrateurs');
            $adminInfosSelect->execute();

            if($_POST['qualite'] == 'etudiant'){
                while($etInfos = $etInfosSelect->fetch())
                    if(($etInfos['et_email'] == $_POST['enreg-email']) || ($etInfos['et_matricule'] == $_POST['enreg-matricule']))
                        $et_infos_control = 1;
                        
                while($ensInfos = $ensInfosSelect->fetch())
                    if(($ensInfos['ens_email'] == $_POST['enreg-email']))
                        $et_infos_control = 1;

                while($adminInfos = $adminInfosSelect->fetch())
                    if(($adminInfos['admin_email'] == $_POST['enreg-email']))
                        $et_infos_control = 1;
                
                if($et_infos_control == 0){
                    $ajouterEtudiant = $connexion->prepare('
                    INSERT INTO etudiants(et_nom, et_prenom, et_sexe, et_email, et_mdp, et_matricule, niv_id)
                    VALUES(:et_nom, :et_prenom, :et_sexe, :et_email, :et_mdp, :et_matricule, :niv_id)
                    ');

                    $ajouterEtudiant->bindParam(':et_nom', $_POST['enreg-nom']);
                    $ajouterEtudiant->bindParam(':et_prenom', $_POST['enreg-prenom']);
                    $ajouterEtudiant->bindParam(':et_sexe', $_POST['enreg-sexe']);
                    $ajouterEtudiant->bindParam(':et_email', $_POST['enreg-email']);
                    $ajouterEtudiant->bindParam(':et_mdp', $_POST['enreg-pwd2']);
                    $ajouterEtudiant->bindParam(':et_matricule', $_POST['enreg-matricule']);
                    $ajouterEtudiant->bindParam(':niv_id', $_POST['enreg-niv']);

                    $ajouterEtudiant->execute();
                    $et_enreg = 1;
                }
            }

            if($_POST['qualite'] == 'enseignant'){
                while($etInfos = $etInfosSelect->fetch())
                    if(($etInfos['et_email'] == $_POST['enreg-email']))
                        $ens_infos_control = 1;
                        
                while($ensInfos = $ensInfosSelect->fetch())
                    if(($ensInfos['ens_email'] == $_POST['enreg-email']))
                        $ens_infos_control = 1;
                        
                while($adminInfos = $adminInfosSelect->fetch())
                    if(($adminInfos['admin_email'] == $_POST['enreg-email']) && ($adminInfos['admin_mdp'] == $_POST['enreg-pwd2']))
                        $ens_infos_control = 1;
                
                if($ens_infos_control == 0){
                    $ajouterEnseignant = $connexion->prepare('
                    INSERT INTO enseignants(ens_nom, ens_prenom, ens_sexe, ens_email, ens_mdp)
                    VALUES(:ens_nom, :ens_prenom, :ens_sexe, :ens_email, :ens_mdp)
                    ');

                    $ajouterEnseignant->bindParam(':ens_nom', $_POST['enreg-nom']);
                    $ajouterEnseignant->bindParam(':ens_prenom', $_POST['enreg-prenom']);
                    $ajouterEnseignant->bindParam(':ens_sexe', $_POST['enreg-sexe']);
                    $ajouterEnseignant->bindParam(':ens_email', $_POST['enreg-email']);
                    $ajouterEnseignant->bindParam(':ens_mdp', $_POST['enreg-pwd2']);

                    $ajouterEnseignant->execute();


                    $ensInfosSelect2 = $connexion->prepare('SELECT * FROM enseignants ORDER BY ens_id DESC LIMIT 1');
                    $ensInfosSelect2->execute();
                    $ensInfos2 = $ensInfosSelect2->fetch();

                    $ajouterUEEnseignant = $connexion->prepare('
                    INSERT INTO enseigne(UE_id, ens_id)
                    VALUES(:UE_id, :ens_id)
                    ');

                    $ajouterUEEnseignant->bindParam(':UE_id', $_POST['enreg-UE']);
                    $ajouterUEEnseignant->bindParam(':ens_id', $ensInfos2['ens_id']);

                    $ajouterUEEnseignant->execute();
                    $ens_enreg = 1;
                }
            }
        
        else
            $confirm_action = 1;
        
        // Messages d'erreur
        function reportMessage($var, $message){
            if(isset($var) && !empty($var) && ($var == 1)){
                echo $message;
                echo "<script>location.replace('espace_admin-enregistrement.php')</script>";
            }
        }
            
        
        reportMessage($et_enreg, "<script>alert('Le nouvel étudiant a bien été enregistré!')</script>");
        reportMessage($et_infos_control, "<script>alert('Adresse mail ou matricule invalide!')</script>");
            
        reportMessage($ens_enreg, "<script>alert('Le nouvel enseignant a bien été enregistré!')</script>");
        reportMessage($ens_infos_control, "<script>alert('Adresse mail ou mot de passe invalide!')</script>");
            
        reportMessage($confirm_action, "<script>alert('Mot de passe invalide!')</script>");
    }
?>