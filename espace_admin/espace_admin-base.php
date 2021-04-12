<?php include '../et_ens_admin-header.php' ?>
        
<!-- Bloc de gauche -->
<div id='admin-left'>
    <div class='admin-left-up'>
        <h3 class='admin-title'>ESSFAR interaction</h3>
        <h4 class='admin-subtitle'>Espace administrateur</h4>
        <p id='admin-name'><?php echo explode(' ', $_SESSION['nom'])[0]. ' ' .explode(' ', $_SESSION['prenom'])[0] ?></p>
    </div>
    
    <nav class='reass-menu'>
        <button id='default-menu-title'><a href='espace_admin-reassigner_questions.php'>Questions non-traitees</a></button>
        <button id='UE-menu-title'>Afficher par UE</button>
        <button id='ens-menu-title'>Afficher par Enseignant</button>
    </nav>
    
    <form method='post' action='../logout.php'>
        <button name='logout' id='logout' value='logout'>Deconnexion</button>
    </form>
</div>

<script>
    var logout = document.getElementById('logout');
    var logoutConfirm = document.getElementById('logout-confirm');
    
    //Deconnexion
    logout.addEventListener('click', function(event){
        if(confirm('Souhaitez-vous vraiment vous deconnecter?'))
            logoutConfirm.submit();
    });
</script>

<!-- Bloc central -->
<div class='admin-center-container'>
    <div id='admin-center'>
        <div class='admin-options'>   
            <nav class='admin-menu'>
                <form method='post' action=''>
                    <button id='admin-user-registration'><a href='espace_admin-enregistrement.php'>Enregistrer</a></button>
                    <button id='admin-user-modification'><a href='espace_admin-modification.php'>Modifier</a></button>
                    <button id='admin-reassign-quest'><a href='espace_admin-reassigner_questions.php'>Reaffecter question</a></button>
                </form>
            </nav>
        </div>