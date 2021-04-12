<?php
    include 'db_config.php';
    $GLOBALS['connexion'] = $connexion;  // Pour s'en servir dans la fonction ci-dessous
    
    function userVerification($userTypeTable, $userEmail, $userPassword, $userId, $userName, $userFirstname, $userGender, $userPage){
        $userTypeBrowse = $GLOBALS['connexion']->prepare("SELECT * FROM $userTypeTable");
        $userTypeBrowse->execute();
        
        while($datas = $userTypeBrowse->fetch()){
            if($datas[$userEmail] == $_POST['connex-email'] && $datas[$userPassword] == $_POST['connex-pwd']){
                session_start();
                
                $_SESSION['id'] = $datas[$userId];
                $_SESSION['nom'] = $datas[$userName];
                $_SESSION['prenom'] = $datas[$userFirstname];
                $_SESSION['sexe'] = $datas[$userGender];
                
                header("location: $userPage");
                
                return true;
            }
        }
    }
    
    if(isset($_POST['connex-submit']) && !empty($_POST['connex-submit'])){
        $etBrowse = userVerification('etudiants', 'et_email', 'et_mdp', 'et_id', 'et_nom', 'et_prenom', 'et_sexe', 'espace_etudiant/index.php');
        
        $ensBrowse = userVerification('enseignants', 'ens_email', 'ens_mdp', 'ens_id', 'ens_nom', 'ens_prenom', 'ens_sexe', 'espace_enseignant/index.php');
        
        $adminBrowse = userVerification('administrateurs', 'admin_email', 'admin_mdp', 'admin_id', 'admin_nom', 'admin_prenom', 'admin_sexe', 'espace_admin/index.php');
        
        if($etBrowse != true && $ensBrowse != true && $adminBrowse != true){
            echo "<script>alert('Identifiants incorrects')</script>";
            echo "<script>location.replace('index.php')</script>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>ESSFAR interaction - Connexion</title>
        <link rel='stylesheet' href='styles.css'>
        <link rel='stylesheet' href='connex.css'>
        <script src='forms.js'></script>
    </head>
    <body>
        <?php include 'header.php' ?>
        
        <div class='connex-container'>
            <h1 class='connex-heading'>Connexion</h1>
            
            <form method='post' action=''>
                <label for='connex-email' class='connex-lbl'>Adresse mail</label>
                <input type='email' name='connex-email' id='connex-email' maxlength='70' required='required'>
                
                <label for='connex-pwd' class='connex-lbl'>Mot de passe</label>
                <input type='password' name='connex-pwd' id='connex-pwd' maxlength='16' required='required'>
                
                <button type='submit' value='connexion' id='connex-submit' name='connex-submit'>Connexion</button>
            </form>
        </div>
        
        <script>
            var connexEmail = document.getElementById('connex-email');
            var connexLbl_0 = document.getElementsByClassName('connex-lbl')[0];
            
            var connexPwd = document.getElementById('connex-pwd');
            var connexLbl_1 = document.getElementsByClassName('connex-lbl')[1];
            
            
            connexEmail.addEventListener('focusin', function(){moveUp(connexLbl_0, connexEmail)});
            connexEmail.addEventListener('focusout', function(){moveDown(connexLbl_0, connexEmail)});
            
            connexPwd.addEventListener('focusin', function(){moveUp(connexLbl_1, connexPwd)});
            connexPwd.addEventListener('focusout', function(){moveDown(connexLbl_1, connexPwd)});
        </script>
    </body>
</html>