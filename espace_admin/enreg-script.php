<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
        
<script>
    var enregLblLeft_0 = document.getElementsByClassName('enreg-lbl-left')[0];
    var enregNom = document.getElementById('enreg-nom');
    var name1Validation = document.getElementById('name1-validation');
    var regNoms = /^[A-Z][a-zéèïî']+([-'\s[A-Z][a-zéèïî']+)?/;
            
    var enregLblLeft_1 = document.getElementsByClassName('enreg-lbl-left')[1];
    var enregPrenom = document.getElementById('enreg-prenom');
    var name2Validation = document.getElementById('name2-validation');

    var enregLblLeft_2 = document.getElementsByClassName('enreg-lbl-left')[2];
    var enregSexe = document.getElementById('enreg-sexe');
    var sexeValidation = document.getElementById('sexe-validation');
            
    var enregLblLeft_3 = document.getElementsByClassName('enreg-lbl-left')[3];
    var enregEmail = document.getElementById('enreg-email');
    var emailValidation = document.getElementById('email-validation');
    var regEmail = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
            
    var enregLblLeft_4 = document.getElementsByClassName('enreg-lbl-left')[4];
    var enregPwd1 = document.getElementById('enreg-pwd1');
    var pwdLengthValidation = document.getElementById('pwd-length-validation');
            
    var enregLblLeft_5 = document.getElementsByClassName('enreg-lbl-left')[5];
    var enregPwd2 = document.getElementById('enreg-pwd2');
    var pwdValidation = document.getElementById('pwd-validation');

    var userTypeValidation = document.getElementById('user-type-validation');
            
    var etudiant = document.getElementById('etudiant');
            
    var enregLblRight_0 = document.getElementsByClassName('enreg-lbl-right')[0];
    var enregMatricule = document.getElementById('enreg-matricule');
    var matValidation = document.getElementById('mat-validation');
            
    var enregNiv = document.getElementById('enreg-niv');
    var nivValidation = document.getElementById('niv-validation');

    var enseignant = document.getElementById('enseignant');
            
    var enregUE = document.getElementById('enreg-UE');
    var UEValidation = document.getElementById('UE-validation');

    var enregSubmit = document.getElementById('enreg-submit');
    
    
    // Etat initial du bloc de droite
    toGrayText(enregLblRight_0);
    toGrayText(enregUE);
    toGrayText(enregNiv);
            
    toGrayBorder(enregMatricule);    
    toGrayBorder(enregUE);
    toGrayBorder(enregNiv);
            
            
    enregNom.addEventListener('focusin', function(){moveUp(enregLblLeft_0, enregNom)});
    enregNom.addEventListener('focusout', function(){moveDown(enregLblLeft_0, enregNom)});

    enregPrenom.addEventListener('focusin', function(){moveUp(enregLblLeft_1, enregPrenom)});
    enregPrenom.addEventListener('focusout', function(){moveDown(enregLblLeft_1, enregPrenom)});
            
    enregSexe.addEventListener('focusin', function(){moveUp(enregLblLeft_2, enregSexe)});
    enregSexe.addEventListener('focusout', function(){moveDown(enregLblLeft_2, enregSexe)});

    enregEmail.addEventListener('focusin', function(){moveUp(enregLblLeft_3, enregEmail)});
    enregEmail.addEventListener('focusout', function(){moveDown(enregLblLeft_3, enregEmail)});

    enregPwd1.addEventListener('focusin', function(){moveUp(enregLblLeft_4, enregPwd1)});
    enregPwd1.addEventListener('focusout', function(){moveDown(enregLblLeft_4, enregPwd1)});

    enregPwd2.addEventListener('focusin', function(){moveUp(enregLblLeft_5, enregPwd2)});
    enregPwd2.addEventListener('focusout', function(){moveDown(enregLblLeft_5, enregPwd2)});
            
            
    etudiant.addEventListener('click', activeEtudiant);
   
    enregMatricule.addEventListener('focusin', function(){moveUp(enregLblRight_0, enregMatricule)});
    enregMatricule.addEventListener('focusout', function(){moveDown(enregLblRight_0, enregMatricule)});
            
    enregNiv.addEventListener('change', function(){selectMove(enregNiv);});
            
            
    enseignant.addEventListener('click', activeEnseignant);
            
    enregUE.addEventListener('change', function(){selectMove(enregUE);});
            

    enregSubmit.addEventListener('click', enregValidation);
</script>