// Activation / Desactivation des champs en fonction du usertype
function activeEtudiant(){
    enregMatricule.removeAttribute('disabled');
    enregNiv.removeAttribute('disabled');        
    
    enregUE.setAttribute('disabled', 'disabled');
    
    toInitialText(enregLblRight_0);
    toInitialBorder(enregMatricule);
    
    toInitialText(enregNiv);
    toInitialBorder(enregNiv);
    
    enregUE.value = 'Unité d\'enseignement';
    toGrayText(enregUE);
    toGrayBorder(enregUE);
    
    UEValidation.innerHTML = '';
}

function activeEnseignant(){
    enregMatricule.setAttribute('disabled', 'disabled');
    enregNiv.setAttribute('disabled', 'disabled');
                
    enregUE.removeAttribute('disabled');
                
    toInitialText(enregUE);
    toInitialBorder(enregUE);
    
    enregMatricule.value = '';
    moveDown(enregLblRight_0, enregMatricule);
    toGrayText(enregLblRight_0);
    toGrayBorder(enregMatricule);
    
    enregNiv.value = 'Niveau';
    toGrayText(enregNiv);
    toGrayBorder(enregNiv);
    
    matValidation.innerHTML = '';
    nivValidation.innerHTML = '';
}
            
function toInitialText(element){
    element.style.color = '';
}
function toInitialBorder(element){
    element.style.borderBottomColor = '';
}
function toGrayText(element){
    element.style.color = 'gray';
}
function toGrayBorder(element){
    element.style.borderBottomColor = 'gray';
}
            
    
// Verification en local de l'integrite des champs d'enregistrement
function reset_focus(element){
    element.value = '';
    element.focus();
}

function namesEmailVerification(regex, element, span, event){
    reset();
    try{
        if(!regex.test(element.value))
            throw 'Mauvais format';
        else
            throw '';
    }
    catch(e){
        span.innerHTML = e;
    }
    
    if(span.innerHTML != ''){
        reset_focus(element);
        event.preventDefault();
    }
    else return 124;
}

function sexeVerification(event){
    reset();
    try{
        if((enregSexe.value != 'M') && (enregSexe.value != 'F'))
            throw 'Valeur invalide';
        else
            throw '';
    }
    catch(sexe){
        sexeValidation.innerHTML = sexe;
    }
    
    if(sexeValidation.innerHTML != ''){
        reset_focus(enregSexe);         
        event.preventDefault();
    }
    else return 3;
}
            
function pwdLengthVerification(event){
    reset();
    try{
        if(enregPwd1.value.length < 6)
            throw 'Mot de passe trop court';
        else
            throw '';
    }
    catch(e){
        pwdLengthValidation.innerHTML = e;
    }
    
    if(pwdLengthValidation.innerHTML != ''){
        reset_focus(enregPwd1);
        event.preventDefault();
    }
    else return 5;
}

function pwdVerification(event){
    reset();
    try{
        if(enregPwd2.value != enregPwd1.value)
            throw 'Les mots de passe ne correspondent pas';
        else
            throw '';
    }
    catch(e){
        pwdValidation.innerHTML = e;
    }
    if(pwdValidation.innerHTML != ''){
        reset_focus(enregPwd2);
        event.preventDefault();
    }
    else return 6;
}
            
function reset(){
    if(($('#etudiant').is(':checked')) || ($('#enseignant').is(':checked'))){userTypeValidation.innerHTML = '';}
    
    if(enregMatricule.value != ''){matValidation.innerHTML = '';}
    
    if(enregNiv.value != 'Niveau'){nivValidation.innerHTML = '';}
    
    if(enregUE.value != 'Unité d\'enseignement'){UEValidation.innerHTML= '';}
}


function userTypeVerification(event){
    try{
        if(!($('#etudiant').is(':checked')) && !($('#enseignant').is(':checked')))
            throw 'Sélectionnez "Etudiant" ou "Enseignant" ci-dessous';
        else 
            throw '';
        }
    catch(userType){
        userTypeValidation.innerHTML = userType;
    }
    
    if(userTypeValidation.innerHTML != ''){
        event.preventDefault();
    }
    else return 1;
}

function matVerification(event){
    try{
        if(($('#etudiant').is(':checked')) && (enregMatricule.value == ''))
            throw 'Veuillez entrer un matricule';
        
        if(enregMatricule.value != '')
            if((/^\d+$/.test(enregMatricule.value)) == false || (enregMatricule.value.length < 11))
                throw 'Ce matricule n\'est pas valide';
    }
    catch(mat){
        matValidation.innerHTML = mat;
    }
    
    if(matValidation.innerHTML != ''){
        reset_focus(enregMatricule);
        event.preventDefault();
    }
    else return 1;
}
            
function nivVerification(event){
    try{
        if(($('#etudiant').is(':checked')) && (enregNiv.value == 'Niveau')){
            throw 'Veuillez choisir un niveau';
         } else {
             throw '';
         }
    }
    catch(niv){
        nivValidation.innerHTML = niv;
    }
    
    if(nivValidation.innerHTML != ''){
        event.preventDefault();
    }
    else return 1;
}
            
function UEVerification(event){
    try{
        if(($('#enseignant').is(':checked')) && (enregUE.value == 'Unite d\'enseignement')){
            throw 'Veuillez choisir une UE';
         } else {
             throw '';
         }
    }
    catch(UE){
        UEValidation.innerHTML = UE;
    }
    
    if(UEValidation.innerHTML != ''){
        event.preventDefault();
    }
    else return 1;
}
            
            
function enregValidation(){
    var n=0;
    
    if(n == 0){
        m = namesEmailVerification(regNoms, enregNom, name1Validation, event);
        if(m == 124)
            n++;
    }
    
    if(n == 1){
        if(enregPrenom.value != ''){
            m = namesEmailVerification(regNoms, enregPrenom, name2Validation, event);
            if(m == 124)
                n++;
        }
        else
            n++;
    }
    
    if(n == 2){
        m = sexeVerification(event);
        if(m == 3)
            n++;
    }
    
    if(n == 3){
        m = namesEmailVerification(regEmail, enregEmail, emailValidation, event);
        if (m == 124)
            n++;
    }
    
    if(n == 4){
        m = pwdLengthVerification(event);
        if(m == 5)
            n++;
    }      
            
    if(n == 5){
        m = pwdVerification(event);
        if(m == 6)
            n++;
    }
    
    if(
        enregNom.value != '' &&
        enregSexe.value != '' &&
        enregEmail.value != '' &&
        enregPwd1.value != '' &&
        enregPwd2.value != ''
    )
    {
        userTypeVerification(event);
        matVerification(event);
        nivVerification(event);
        UEVerification(event);
    }
}