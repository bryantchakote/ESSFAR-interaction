function activeBloc(element, trigger, div, first, second, third){
    element.style.display = 'block';
    trigger.style.color = '#B22';
    
    div.style.backgroundColor = 'RGBa(102, 136, 170, 0.1)';
    active_background_color(first);
    active_background_color(second);
    active_background_color(third);
}
            
function desactiveBloc(element, trigger, div, first, second, third){
    element.style.display = '';
    trigger.style.color = '';
    
    desactive_background_color(div);
    desactive_background_color(first);
    desactive_background_color(second);
    desactive_background_color(third);
}

function active_background_color(element){element.style.backgroundColor = 'RGBa(102, 136, 170, 0.01)';}

function desactive_background_color(element){element.style.backgroundColor = '';}