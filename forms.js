function moveUp(label, input){
    label.style.top = '0px';
    label.style.fontSize = '12px';
    label.style.paddingTop = '4.7px';
    label.style.color = 'RGB(200, 80, 80)';
    input.style.borderBottomColor = 'RGB(200, 80, 80)';
}

function moveDown(label, input){
    if(input.value == ''){
        label.style.top = '';
        label.style.fontSize = '';
        label.style.paddingTop = '';
        label.style.color = '';
        input.style.borderBottomColor = '';
    }
}

function selectMove(select){
    select.style.borderBottomColor = 'RGB(200, 80, 80)';
}

function dateDHMS(time){
    var d = new Date(time * 1000);
    
    var jours = parseInt(time/(24*3600));
    
    var addZero = function(hms){return hms < 10 ? '0' + hms : hms;}
    var heures = addZero(d.getHours());
    var minutes = addZero(d.getMinutes());
    var secondes = addZero(d.getSeconds());
    
    return jours + ' jours ' + heures + ' h ' + minutes + ' min ' + secondes + ' sec';
}