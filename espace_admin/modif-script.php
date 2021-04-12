<script>
    // Titres h4 -> trigger
    var modifEtNivTitle = document.getElementById('modif-et-niv-title');
    var modifEnsUETitle = document.getElementById('modif-ens-UE-title');
    var modifNivUETitle = document.getElementById('modif-niv-UE-title');
    var modifSuppressTitle = document.getElementById('modif-suppress-title');
         
            
    // Div sous h4 -> element (display: block)
    var modifEtNivDisplay = document.getElementsByClassName('modif-subcontainer')[0];
    var modifEnsUEDisplay = document.getElementsByClassName('modif-subcontainer')[1];
    var modifNivUEDisplay = document.getElementsByClassName('modif-subcontainer')[2];
    var modifSuppressDisplay = document.getElementsByClassName('modif-subcontainer')[3];
            
            
    // Gros div d'encadrement -> prend la couleur de fond
    var modifEtNiv = document.getElementById('modif-et-niv');
    var modifEnsUE = document.getElementById('modif-ens-UE');
    var modifNivUE = document.getElementById('modif-niv-UE');
    var modifSuppress = document.getElementById('modif-suppress');
            
            
    // Champs de formulaire
        // Changer le niveau d'un etudiant
        var modifMatriculeLabel = document.getElementById('modif-matricule-label');
        var modifMatricule = document.getElementById('modif-matricule');
        var etNewNiv = document.getElementById('et-new-niv');

        // Gerer les UEs d'un enseignant
        var modifEnsUEAction = document.getElementById('modif-ens-UE-action');
        var modifEnsUEEnsList = document.getElementById('modif-ens-UE-ens-list');
        var modifEnsUEUEList = document.getElementById('modif-ens-UE-UE-list');

        // Gerer les UEs d'un enseignant
        var modifNivUEAction = document.getElementById('modif-niv-UE-action');
        var modifNivUENivList = document.getElementById('modif-niv-UE-niv-list');
        var modifNivUEUEList = document.getElementById('modif-niv-UE-UE-list');
                     
        // Supprimer un utilisateur
        var suppressMatriculeLabel = document.getElementById('suppress-matricule-label');
        var suppressMatricule = document.getElementById('suppress-matricule');
        var suppressEns = document.getElementById('suppress-ens');
            

    // Gestion des select
    etNewNiv.addEventListener('change', function(){selectMove(etNewNiv)});
            
    modifEnsUEAction.addEventListener('change', function(){selectMove(modifEnsUEAction)});
    
    modifEnsUEEnsList.addEventListener('change', function(){selectMove(modifEnsUEEnsList)});
        
    modifEnsUEUEList.addEventListener('change', function(){selectMove(modifEnsUEUEList)});
            
    modifNivUEAction.addEventListener('change', function(){selectMove(modifNivUEAction)});
            
    modifNivUENivList.addEventListener('change', function(){selectMove(modifNivUENivList)});
            
    modifNivUEUEList.addEventListener('change', function(){selectMove(modifNivUEUEList)});
            
    suppressEns.addEventListener('change', function(){selectMove(suppressEns)});
                    
            
    modifMatricule.addEventListener('focusin', function(){moveUp(modifMatriculeLabel, modifMatricule)});
    modifMatricule.addEventListener('focusout', function(){moveDown(modifMatriculeLabel, modifMatricule)});
            
    suppressMatricule.addEventListener('focusin', function(){moveUp(suppressMatriculeLabel, suppressMatricule)});
    suppressMatricule.addEventListener('focusout', function(){moveDown(suppressMatriculeLabel, suppressMatricule)});
 
    modifEtNivTitle.addEventListener('click', function(){
        activeBloc(modifEtNivDisplay, modifEtNivTitle, modifEtNiv, modifMatricule, etNewNiv, etNewNiv);
                
        desactiveBloc(modifEnsUEDisplay, modifEnsUETitle, modifEnsUE, modifEnsUEAction, modifEnsUEEnsList, modifEnsUEUEList);
        desactiveBloc(modifNivUEDisplay, modifNivUETitle, modifNivUE, modifNivUEAction, modifNivUENivList, modifNivUEUEList);
        desactiveBloc(modifSuppressDisplay, modifSuppressTitle, modifSuppress, suppressMatricule, suppressEns, suppressEns);
    });
            
    modifEnsUETitle.addEventListener('click', function(){
        activeBloc(modifEnsUEDisplay, modifEnsUETitle, modifEnsUE, modifEnsUEAction, modifEnsUEEnsList, modifEnsUEUEList);
        
        desactiveBloc(modifEtNivDisplay, modifEtNivTitle, modifEtNiv, modifMatricule, etNewNiv, etNewNiv);
        desactiveBloc(modifNivUEDisplay, modifNivUETitle, modifNivUE, modifNivUEAction, modifNivUENivList, modifNivUEUEList);
        desactiveBloc(modifSuppressDisplay, modifSuppressTitle, modifSuppress, suppressMatricule, suppressEns, suppressEns);
    });
    
    modifNivUETitle.addEventListener('click', function(){
        activeBloc(modifNivUEDisplay, modifNivUETitle, modifNivUE, modifNivUEAction, modifNivUENivList, modifNivUEUEList);
        
        desactiveBloc(modifEtNivDisplay, modifEtNivTitle, modifEtNiv, modifMatricule, etNewNiv, etNewNiv);
        desactiveBloc(modifEnsUEDisplay, modifEnsUETitle, modifEnsUE, modifEnsUEAction, modifEnsUEEnsList, modifEnsUEUEList);
        desactiveBloc(modifSuppressDisplay, modifSuppressTitle, modifSuppress, suppressMatricule, suppressEns, suppressEns);
    });
            
    modifSuppressTitle.addEventListener('click', function(){
        activeBloc(modifSuppressDisplay, modifSuppressTitle, modifSuppress, suppressMatricule, suppressEns, suppressEns);
        
        desactiveBloc(modifEtNivDisplay, modifEtNivTitle, modifEtNiv, modifMatricule, etNewNiv, etNewNiv);
        desactiveBloc(modifEnsUEDisplay, modifEnsUETitle, modifEnsUE, modifEnsUEAction, modifEnsUEEnsList, modifEnsUEUEList);
        desactiveBloc(modifNivUEDisplay, modifNivUETitle, modifNivUE, modifNivUEAction, modifNivUENivList, modifNivUEUEList);
    });
    
    // Confirmation du mot de passe a l'envoi
    var submitEtNiv = document.getElementById('submit-et-niv');
    var submitEnsUE = document.getElementById('submit-ens-UE');
    var submitNivUE = document.getElementById('submit-niv-UE');
    var submitSuppress = document.getElementById('submit-suppress');
    
    
    submitEtNiv.addEventListener('click', function(event){
        try{
            if(modifMatricule.value == '')
                throw 'Veuillez entrer un matricule';

            if((/^\d+$/.test(modifMatricule.value)) == false || (modifMatricule.value.length < 11))
                throw 'Ce matricule n\'est pas valide';
            
            if(etNewNiv.value == 'choix-niveau')
                throw 'Veuillez choisir un niveau';
        }
        catch(e){
            alert(e);
            event.preventDefault();
        }
    });
    
    submitEnsUE.addEventListener('click', function(event){
        try{
            if(modifEnsUEAction.value == 'action')
                throw 'Veuillez choisir une action a executer';

            if(modifEnsUEEnsList.value == 'choix-enseignant')
                throw 'Veuillez choisir un enseignant';
            
            if(modifEnsUEUEList.value == 'choix-UE')
                throw 'Veuillez choisir une UE';
        }
        catch(e){
            alert(e);
            event.preventDefault();
        }
    });
    
    submitNivUE.addEventListener('click', function(event){
        try{
            if(modifNivUEAction.value == 'action')
                throw 'Veuillez choisir une action a executer';

            if(modifNivUENivList.value == 'choix-niveau')
                throw 'Veuillez choisir un niveau';
            
            if(modifNivUEUEList.value == 'choix-UE')
                throw 'Veuillez choisir une UE';
        }
        catch(e){
            alert(e);
            event.preventDefault();
        }
    });
    
    submitSuppress.addEventListener('click', function(event){
        try{
            if((suppressMatricule.value == '') && (suppressEns.value == 'choix-enseignant'))
                throw 'Veuillez entrer un matricule ou selectionner un enseignant';

            if(suppressMatricule.value != '' && ((/^\d+$/.test(suppressMatricule.value)) == false || (suppressMatricule.value.length < 11)))
                throw 'Ce matricule n\'est pas valide';
        }
        catch(e){
            alert(e);
            event.preventDefault();
        }
    });
</script>