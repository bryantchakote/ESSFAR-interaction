<script>
    var reassMenu = document.querySelector('.reass-menu');
    
    var adminQuestInfos = document.querySelectorAll('.admin-quest-infos');
        
    var adminRight= document.getElementById('admin-right');
    
    var close = document.getElementById('close');
    
    var ensMenuTitle = document.getElementById('ens-menu-title');
    var ensFilterBloc = document.getElementById('ens-filter-bloc');
    
    var UEMenuTitle = document.getElementById('UE-menu-title');
    var UEFilterBloc = document.getElementById('UE-filter-bloc');
    
    var reassignBloc = document.getElementById('reassign-bloc');
    
    var modifQuestionId = document.getElementById('modif-question-id');
    
    var newEnsList = document.querySelectorAll('.new-ens-list');
    
    <?php for($i = 0; $i < $questCounter; $i++){ ?>
        var adminQuestInfos<?php echo $i ?> = adminQuestInfos[<?php echo $i ?>];
        var newEnsList<?php echo $i ?> = newEnsList[<?php echo $i ?>];
    <?php
    }
    ?>
    
    reassMenu.style.display = 'block';
    
    // Ouvrir la fenetre de droite
    function divRightActive(event, active, other1, other2){
        adminRight.style.display = 'block';
        close.style.display = 'inline';
        active.style.display = 'block';
        other1.style.display = 'none';
        other2.style.display = 'none';
        event.preventDefault();

        <?php for($i = 0; $i < $questCounter; $i++){ ?>
            adminQuestInfos<?php echo $i ?>.style.backgroundColor = '';
        <?php
        }
        ?>
    }
    
    // Recherche de questions par enseignants
    ensMenuTitle.addEventListener('click', function(){
        divRightActive(event, ensFilterBloc, UEFilterBloc, reassignBloc);
    });
    
    // Recherche de questions par matieres
    UEMenuTitle.addEventListener('click', function(){
        divRightActive(event, UEFilterBloc, ensFilterBloc, reassignBloc);
    });
    
    // Infos question au clic
    <?php for($i = 0; $i < $questCounter; $i++){ ?>
        adminQuestInfos<?php echo $i ?>.addEventListener('click', function(){
            divRightActive(event, reassignBloc, ensFilterBloc, UEFilterBloc);
            this.style.backgroundColor = 'RGBa(187, 34, 34, 0.3)';
            newEnsList<?php echo $i ?>.style.display = 'block';
            
            modifQuestionId.value = adminQuestInfos<?php echo $i ?>.childNodes[1].textContent;

            <?php
            for($j = 0; $j < $questCounter; $j++)
                if($i != $j){
            ?>
                    adminQuestInfos<?php echo $j ?>.style.backgroundColor = '';
                    newEnsList<?php echo $j ?>.style.display = '';
            <?php
                }
            ?>
        });
    <?php
    }
    ?>
    
    // Fermer les fenetres
    close.addEventListener('click', function(event){
        adminRight.style.display = 'none';
        event.preventDefault();
        
        <?php for($i = 0; $i < $questCounter; $i++){ ?>
            adminQuestInfos<?php echo $i ?>.style.backgroundColor = '';
        <?php
        }
        ?>
    });
</script>