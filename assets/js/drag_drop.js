function allowDrop(e) {

    e.preventDefault();
}

function drag(e) {

    e.dataTransfer.setData('order', e.target.parentElement.getAttribute('data-order'));
}

function drop(e) {
    
    e.preventDefault();
    var $column = $(e.target).is('div.kanban-panel>.row') ? $(e.target) : $(e.target).closest('div.kanban-panel>.row');
    var data = e.dataTransfer.getData('order');
    var taskId = $(`[data-order="${data}"]`).children('div').attr('id');
    var details = {column: $column.parent('div.kanban-panel').attr('id')};

    $column.append($(`[data-order="${data}"]`));
    $(document).changeColumn(details, taskId).done(function(data){
        console.log(data);
    });
}