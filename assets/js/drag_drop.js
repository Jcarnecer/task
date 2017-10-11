function allowDrop(ev) {

    ev.preventDefault();
}

function drag(ev) {

    ev.dataTransfer.setData('order', ev.target.parentElement.getAttribute('data-order'));
}

function drop(ev) {
    
    ev.preventDefault();
    var data = ev.dataTransfer.getData('order');
    $($(ev.target).is('div.kanban-panel>.row') ? ev.target : $(ev.target).closest('div.kanban-panel>.row')).append($(`[data-order="${data}"]`));
}