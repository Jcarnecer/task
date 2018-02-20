$(function() {

// Initiate
getUser(getUserId()).done(function(data) {

    userName    = data['first_name'] + ' ' + data['last_name'];
    avatarUrl   = data['avatar_url'];
});

getBoard().done(function(data) {

    $('#kanbanBoard').attr('data-value', data['id']);
    
    displayBoard(data);
});


getAllTask().done(function(data) {
    
    displayTask(data);

    if(getTaskType() == 'personal') {
        $('.task-count').html(data.length);
    }
});


// Highlight
$(document).on('click', '#highlightBtn', function() {
    
    highlightTask();
});


// Add Column
$(document).on('select, click', '#addColumnName', function(e) {

    $('#addColumnName').html('');
});


$(document).on('blur', '#addColumnName', function(e) {

    $('#addColumnName').html('Type Here');
});


$(document).on('keypress', '#addColumnName', function(e) {

    if ($('#addColumnName').html() == 'Type Here') {
        
        $('#addColumnName').html('');
    }

    if (e.which == 13) {

        e.preventDefault();

        var columnCount = getAllColumn($('#kanbanBoard').attr('data-value')).responseJSON.length + 1;
        
        var columnDetails = {
            name:       $(this).html(),
            board_id:   $('#kanbanBoard').attr('data-value'),
            position:   columnCount
        };
        
        columnDetails.id = createColumn(columnDetails).responseJSON['response'];

        addColumn(columnDetails);
        $('#addColumnName').html('Type Here');
    }
});


// Delete Column
$(document).on('click', '.kanban-column-delete',  function(e) {

    if(confirm(`Are you sure you want to delete ${$(this).closest('.kanban-column').find('.kanban-column-title').html().trim()}?`)){

        var columnDetails = {
            id: $(this).closest('.kanban-column').attr('data-value')
        };

        deleteColumn(columnDetails);
        // $(this).closest('.kanban-column').remove();
    
        // var newWidth = $('#kanbanColumnContainer').css('width').replace(/\D/g, '') / $('#kanbanBoard').css('width').replace(/\D/g, '') * 100 - 25;
    
        // $('#kanbanColumnContainer').css('width', `${newWidth}%`);
        getBoard().done(function(data) {

            displayBoard(data);
            
            getAllTask().done(function(data) {
    
                displayTask(data);
            
                if(getTaskType() == 'personal') {
                    $('.task-count').html(data.length);
                }
            });
        });

       
    }
});
   

// Update Column
$(document).on('click', '.kanban-column-edit', function(e) {

    $(this).closest('.card-header').find('.kanban-column-title').attr('contenteditable', true);
    $(this).closest('.card-header').find('.kanban-column-title').focus();
});


$(document).on('keypress', '.kanban-column .kanban-column-title', function(e) {

    if(e.which == 13) {

        e.preventDefault();

        var columnDetails = {
            id:         $(this).closest('.kanban-column').attr('data-value'), 
            name:       $(this).html(), 
            position:   $(this).closest('.kanban-column').attr('data-position')
        };

        updateColumn(columnDetails);

        $(this).attr('contenteditable', false);
    }
});

});