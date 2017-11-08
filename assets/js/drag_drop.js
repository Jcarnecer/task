function allowDrop(e) {

    e.preventDefault();
}

function drag(e) {

    var $elem = $(e.target);

    e.dataTransfer.setData('id', $elem.parent().attr('data-value'));

    if($elem.parent().hasClass('kanban-column')) {
      
        e.dataTransfer.setData('type', 'column');
    } else if($elem.parent().hasClass('kanban-task')) {
        
        e.dataTransfer.setData('type', 'task');
    }
}

function drop(e) {
    
    e.preventDefault();

    var $elem = $(e.target).hasClass('.kanban-column') ? $(e.target) : $(e.target).closest('.kanban-column');
    var id = e.dataTransfer.getData('id');
    var type = e.dataTransfer.getData('type');
    var updateColumn = [];

    if (type == 'task') {
        
        $elem.find('.card-body').prepend($(`.kanban-task[data-value="${id}"]`));
        $(document).changeColumn($elem.attr('data-value'), id);
    } else if (type == 'column') {

        if($elem.nextAll(`.kanban-column[data-value="${id}"]`).length) {
            
            $.each($('#kanbanBoard .card-group').children('.kanban-column'), function(i, column) {
                
                if(Number($(column).attr('data-position')) >= Number($elem.attr('data-position')) && 
                    Number($(column).attr('data-position')) < Number($(`.kanban-column[data-value="${id}"]`).attr('data-position'))) {
                    
                    $(column).attr('data-position', Number($(column).attr('data-position')) + 1);
                    updateColumn.push({
                        id: $(column).attr('data-value'),
                        position: $(column).attr('data-position')
                    });
                }
            });
            
            $(`.kanban-column[data-value="${id}"]`).attr('data-position', Number($elem.attr('data-position')) - 1);
            updateColumn.push({
                id: $(`.kanban-column[data-value="${id}"]`).attr('data-value'),
                position: $(`.kanban-column[data-value="${id}"]`).attr('data-position')
            });
            
            $elem.before($(`.kanban-column[data-value="${id}"]`));
        } else if($elem.prevAll(`.kanban-column[data-value="${id}"]`).length) {
            
            $.each($('#kanbanBoard .card-group').children('.kanban-column'), function(i, column) {
                
                if(Number($(column).attr('data-position')) <= Number($elem.attr('data-position')) && 
                Number($(column).attr('data-position')) > Number($(`.kanban-column[data-value="${id}"]`).attr('data-position'))) {
                    
                    $(column).attr('data-position', Number($(column).attr('data-position')) - 1);
                    updateColumn.push({
                        id: $(column).attr('data-value'),
                        position: $(column).attr('data-position')
                    });
                }
            });
            
            $(`.kanban-column[data-value="${id}"]`).attr('data-position', Number($elem.attr('data-position')) + 1);
            updateColumn.push({
                id: $(`.kanban-column[data-value="${id}"]`).attr('data-value'),
                position: $(`.kanban-column[data-value="${id}"]`).attr('data-position')
            });

            $elem.after($(`.kanban-column[data-value="${id}"]`));
        }

        $(document).updatePositions({column_update: updateColumn}, true);
    }
}