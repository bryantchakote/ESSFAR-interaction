<?php
    session_start();
    include '../db_config.php';

    $adminMdpSelect = $connexion->prepare('SELECT admin_mdp FROM administrateurs WHERE admin_id = ' .$_SESSION['id']);
    $adminMdpSelect->execute();
    $adminMdp = $adminMdpSelect->fetch();
    $_SESSION['mdp'] = $adminMdp['admin_mdp'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>ESSFAR interaction - Espace admin</title>
        <?php include 'admin-head.php'; ?>
        <link rel='stylesheet' href='infos.css'>
        <script src='infos.js'></script>
    </head>
    <body>
        <?php include 'espace_admin-base.php' ?>

                <h1 id='admin-heading'>Informations</h1>
        
                <div id='admin-content'>
                </div>
            </div>
        </div>
    </body>
</html>