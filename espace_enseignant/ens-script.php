<script>
    var logoutConfirm = document.getElementById('logout-confirm');
    var logout = document.getElementById('logout');
    
    var ensQuestInfos = document.querySelectorAll('.ens-quest-infos');
    var ensAnswerContent = document.querySelectorAll('.ens-answer-content');
    var ensAnsSendDate = document.querySelectorAll('.ens-ans-send-date');
    
    <?php for($i = 0; $i < $questCounter; $i++){ ?>
        var ensQuestInfos<?php echo $i ?> = ensQuestInfos[<?php echo $i ?>];
        var ensAnswerContent<?php echo $i ?> = ensAnswerContent[<?php echo $i ?>];
        var ensAnsSendDate<?php echo $i ?> = ensAnsSendDate[<?php echo $i ?>];
    <?php
    }
    ?>
    
    var ensRight = document.getElementById('ens-right');
    var close = document.getElementById('close');
    
    var ensQuestAnsText = document.getElementById('ens-quest-ans-text');
    
    var answerForm = document.getElementById('answer-form');
    
    var ensQuestionId = document.getElementById('ens-question-id');
    
    var answer = document.getElementById('answer');
    var ensEditAns = document.getElementById('ens-edit-ans');
    var ansWording = document.getElementById('ans-wording');
    
    var sendAns = document.getElementById('send-ans');
    var ensQuestDelete = document.getElementById('ens-quest-delete');
    
    
    // Affichage du contenu
    <?php for($i = 0; $i < $questCounter; $i++){ ?>
        ensQuestInfos<?php echo $i ?>.addEventListener('click', function(){
            ensRight.style.display = 'block';
            ensEditAns.style.display = '';
            
            this.style.backgroundColor = 'RGBa(187, 34, 34, 0.3)';
            <?php
            for($j = 0; $j < $questCounter; $j++)
                if($j != $i){
            ?>      ensQuestInfos<?php echo $j ?>.style.backgroundColor = '';
            <?php
                }
            ?>
            
            ensQuestAnsText.innerHTML = ensAnswerContent<?php echo $i ?>.innerHTML;
            ansWording.value = '';
            ensQuestionId.value = ensAnswerContent<?php echo $i ?>.childNodes[1].textContent;
            
            var answerTime = ensAnsSendDate<?php echo $i ?>.childNodes[5].textContent + 'T' + ensAnsSendDate<?php echo $i ?>.childNodes[9].textContent;
            
            var answerTimeStamp = Date.parse(answerTime)/1000;
            var actualTimeStamp = Math.round(Date.now()/1000);
            var duration = actualTimeStamp - answerTimeStamp;
            
            if((duration > 3600*24*3) && (answerTime != '----------------T----------------'))
                ensQuestDelete.style.backgroundColor = '';
            else{
                ensQuestDelete.style.backgroundColor = 'gray';
            
                var remainingTimeSeconds = 3600*24*3 - duration;
                return remainingTime = dateDHMS(remainingTimeSeconds);
            }
        });
    <?php
    }
    ?>
    
    // Fermer le bloc de droite
    close.addEventListener('click', function(){
        ensRight.style.display = '';
        ensEditAns.style.display = '';
        ansWording.value = '';
        
        <?php for($i = 0; $i < $questCounter; $i++){ ?>
            ensQuestInfos<?php echo $i ?>.style.backgroundColor = '';
        <?php
        }
        ?>
    });
    
    // Editer une reponse
    answer.addEventListener('click', function(event){
        ensEditAns.style.display = 'block';
        ansWording.focus();
    });
    
    // Envoyer une reponse
    sendAns.addEventListener('click', function(event){
        try{
            if(ansWording.value == '')
                throw 'Veuillez saisir votre reponse';
        }
        catch(e){
            alert(e);
            event.preventDefault();
        }
    });
    
    // Supprimer une question
    ensQuestDelete.addEventListener('click', function(event){
        if(this.style.backgroundColor == 'gray'){
            alert('Suppression disponible trois jours apres une reponse reponse');
            event.preventDefault();
        }
        else{
            if(confirm('Voulez-vous vraiment supprimer cette question?')) answerForm.submit();
            else event.preventDefault();   
        }
    });
    
    // Deconnexion
    logout.addEventListener('click', function(event){
        if(confirm('Souhaitez-vous vraiment vous deconnecter?')) logoutConfirm.submit();
        else event.preventDefault();
    });
</script>