function allowDrop(e) {

    e.preventDefault();
}

function drag(e) {

    var $elem = $(e.target);

    e.dataTransfer.setData('id', $elem.parent().data('value'));

    if($elem.parent().hasClass('kanban-column')) {
      
        e.dataTransfer.setData('type', 'column');
    } else if($elem.parent().hasClass('kanban-task')) {
        
        e.dataTransfer.setData('type', 'task');
        $('#deleteTaskModal').removeClass('d-none');
    }
}

function closeDeleteModal(e) {
    
    $('#deleteTaskModal').addClass('d-none');
}

function drop(e) {
    
    e.preventDefault();

    $('#deleteTaskModal').addClass('d-none');

    var $elem = $(e.target).hasClass('.kanban-column') ? $(e.target) : $(e.target).closest('.kanban-column');
    var id = e.dataTransfer.getData('id');
    var type = e.dataTransfer.getData('type');
    var updateColumn = [];

    if (type == 'task') {
        
        $elem.children('.card-body').prepend($(`.kanban-task[data-value="${id}"]`));

        var task_details = {
            id:         id,
            column_id:  $elem.data('value')
        }

        changeTaskColumn(task_details);
    } else if (type == 'column') {

        if($elem.nextAll(`.kanban-column[data-value="${id}"]`).length) {
            
            $.each($('#kanbanBoard .kanban-column-holder').children('.kanban-column'), function(i, column) {
                
                if(Number($(column).data('position')) >= Number($elem.data('position')) && Number($(column).data('position')) < Number($(`.kanban-column[data-value="${id}"]`).data('position'))) {
                    
                    $(column).data('position', Number($(column).data('position')) + 1);

                    updateColumn.push({
                        id: $(column).data('value'),
                        position: $(column).data('position')
                    });
                }
            });
            
            $(`.kanban-column[data-value="${id}"]`).data('position', Number($elem.data('position')) - 1);

            updateColumn.push({
                id: $(`.kanban-column[data-value="${id}"]`).data('value'),
                position: $(`.kanban-column[data-value="${id}"]`).data('position')
            });
            
            $elem.before($(`.kanban-column[data-value="${id}"]`));
        } else if($elem.prevAll(`.kanban-column[data-value="${id}"]`).length) {
            
            $.each($('#kanbanBoard .kanban-column-holder').children('.kanban-column'), function(i, column) {
                
                if(Number($(column).data('position')) <= Number($elem.data('position')) &&  Number($(column).data('position')) > Number($(`.kanban-column[data-value="${id}"]`).data('position'))) {
                    
                    $(column).data('position', Number($(column).data('position')) - 1);

                    updateColumn.push({
                        id: $(column).data('value'),
                        position: $(column).data('position')
                    });
                }
            });
            
            $(`.kanban-column[data-value="${id}"]`).data('position', Number($elem.data('position')) + 1);

            updateColumn.push({
                id: $(`.kanban-column[data-value="${id}"]`).data('value'),
                position: $(`.kanban-column[data-value="${id}"]`).data('position')
            });

            $elem.after($(`.kanban-column[data-value="${id}"]`));
        }

        changeColumnsPosition({column_update: updateColumn});
    }
}

function deleteTask(e) {
    
    $(`.kanban-task[data-value="${e.dataTransfer.getData('id')}"]`).remove();
    $(`.task-count`).html(Number($(`.task-count`).html()) - 1);

    archiveTask(e.dataTransfer.getData('id'));
}