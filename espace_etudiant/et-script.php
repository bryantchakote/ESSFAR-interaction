<script>
    var etName = document.getElementById('et-name');
    
    var UEMenuTitle = document.getElementById('UE-menu-title');
    var ensMenuTitle = document.getElementById('ens-menu-title');
    
    var logout = document.getElementById('logout');
    var logoutConfirm = document.getElementById('logout-confirm');
    
    var newQuestion = document.getElementById('new-question');
    
    var etQuestInfos = document.querySelectorAll('.et-quest-infos');
    var etAnswerContent = document.querySelectorAll('.et-answer-content');
    var etQuestSendDate = document.querySelectorAll('.et-quest-send-date');
    var etAnsReceptDate = document.querySelectorAll('.et-ans-recept-date');
    
    <?php for($i = 0; $i < $questCounter; $i++){ ?>
        var etQuestInfos<?php echo $i?> = etQuestInfos[<?php echo $i ?>];
        var etAnswerContent<?php echo $i?> = etAnswerContent[<?php echo $i ?>];
        var etQuestSendDate<?php echo $i?> = etQuestSendDate[<?php echo $i ?>];
        var etAnsReceptDate<?php echo $i?> = etAnsReceptDate[<?php echo $i ?>];
    <?php
    }
    ?>
    var etRight = document.getElementById('et-right');
    var close = document.getElementById('close');
    
    var askQuestActive = document.getElementById('ask-quest-active');
    var questionEns = document.getElementById('question-ens');
    var etQuestWording = document.getElementById('et-quest-wording');
    var sendQuest = document.getElementById('send-quest');
    var cancelQuest = document.getElementById('cancel-quest');
    
    var showAnsActive = document.getElementById('show-ans-active');
    var etQuestAnsText = document.getElementById('et-quest-ans-text');
    var deleteForm = document.getElementById('delete-form');
    var etQuestionId = document.getElementById('et-question-id');
    var etQuestDelete = document.getElementById('et-quest-delete');
    
    var showUE = document.getElementById('show-UE');
    
    var showEns = document.getElementById('show-ens');
    
    
    // Ouvrir la fenetre de droite
    function divRightActive(active, other1, other2, other3){
        etRight.style.display = 'block';
        close.style.display = 'inline';
        active.style.display = 'block';
        other1.style.display = 'none';
        other2.style.display = 'none';
        other3.style.display = 'none';
        
        <?php for($i = 0; $i < $questCounter; $i++){ ?>
            etQuestInfos<?php echo $i ?>.style.backgroundColor = '';
        <?php
        }
        ?>
    }
    
    // Poser une question
    newQuestion.addEventListener('click', function(){divRightActive(askQuestActive, showUE, showEns, showAnsActive)});
    
    // Recherche de questions par enseignants
    ensMenuTitle.addEventListener('click', function(){divRightActive(showEns, askQuestActive, showUE, showAnsActive)});
    
    // Recherche de questions par matieres
    UEMenuTitle.addEventListener('click', function(){divRightActive(showUE, askQuestActive, showEns, showAnsActive)});
    
    // Affichage du contenu
    <?php for($i = 0; $i < $questCounter; $i++){ ?>
        etQuestInfos<?php echo $i ?>.addEventListener('click', function(){
            divRightActive(showAnsActive, askQuestActive, showUE, showEns);
            this.style.backgroundColor = 'RGBa(187, 34, 34, 0.3)';
            <?php
            for($j = 0; $j < $questCounter; $j++)
                if($j != $i){
            ?>      etQuestInfos<?php echo $j ?>.style.backgroundColor = '';
            <?php
                }
            ?>
            
            etQuestAnsText.innerHTML = etAnswerContent<?php echo $i ?>.innerHTML;
            etQuestionId.value = etAnswerContent<?php echo $i?>.childNodes[1].textContent;
            
            var questionTime = etQuestSendDate<?php echo $i ?>.childNodes[5].textContent + 'T' + etQuestSendDate<?php echo $i ?>.childNodes[9].textContent;
            var answerTime = etAnsReceptDate<?php echo $i ?>.childNodes[5].textContent + 'T' + etAnsReceptDate<?php echo $i ?>.childNodes[9].textContent;
            
            var questionTimeStamp = Date.parse(questionTime)/1000;
            var actualTimeStamp = Math.round(Date.now()/1000);
            var duration = actualTimeStamp - questionTimeStamp;
            
            if((duration < 3600*24*3) && (answerTime == '----------------T------------')){
                etQuestDelete.style.backgroundColor = 'gray';
                
                var remainingTimeSeconds = 3600*24*3 - duration;
                return remainingTime = dateDHMS(remainingTimeSeconds);
            }
            else etQuestDelete.style.backgroundColor = '';
        });
    <?php
    }
    ?>
    
    // Fermer le bloc de droite
    close.addEventListener('click', function closeRight(){
        etRight.style.display = 'none';
        
        <?php for($i = 0; $i < $questCounter; $i++){ ?>
            etQuestInfos<?php echo $i ?>.style.backgroundColor = '';
        <?php
        }
        ?>
    });
    
    // Envoyer une question
    sendQuest.addEventListener('click', function(event){
        try{
            if(questionEns.value == 'choix-ens')
                throw 'Veuillez choisir un enseignant';
            else if(etQuestWording.value == '')
                throw 'Veuillez entrer le libelle de votre question';
        }
        catch(e){
            alert(e);
            event.preventDefault();
        }
    });
    
    // Supprimer une question
    etQuestDelete.addEventListener('click', function(event){
        if(this.style.backgroundColor == 'gray'){
            alert('Suppression disponible dans ' + remainingTime + ',\nou en cas de reponse de la part de votre enseignant');
            event.preventDefault();
        }
        else{
            if(confirm('Voulez vous vraiment supprimer cette question?')) deleteForm.submit();
            else event.preventDefault();
        }
    });
    
    //Deconnexion
    logout.addEventListener('click', function(event){
        if(confirm('Souhaitez-vous vraiment vous deconnecter?')) logoutConfirm.submit();
        else event.preventDefault();
    });
</script>