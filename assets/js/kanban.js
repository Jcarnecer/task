$(function() {


// Initiate
$(document).getBoard(getAuthorId(), null, true).done(function(data) {

    if(data == null) {

        var boardDetails = {name: 'Default'};
        
        $(document).postBoard(boardDetails, getAuthorId());
    }

    $('#kanbanBoard').attr('data-value', data['id']);
    $(document).displayBoard(data);
});


$(document).getTask().done(function(data) {
    
    $(document).displayTask(data);
});


// Highlight
$(document).on('click', '#highlightBtn', function () {
    
    $(document).highlightTask(getUserId());
});


// Add Column
$(document).on('select, click', '#addColumnName', function(e) {

    $('#addColumnName').html('');
});


$(document).on('keypress', '#addColumnName', function(e) {

    if ($('#addColumnName').html() == 'Type Here') {
        
        $('#addColumnName').html('');
    }

    if (e.which == 13) {

        e.preventDefault();
        
        var columnDetails = new Object;
        columnDetails.name = $(this).html();
        columnDetails.position = $(document).getColumn($('#kanbanBoard').attr('data-value'), null, true).responseJSON.length + 1;

        columnDetails.id = $(document).postColumn(columnDetails, $('#kanbanBoard').attr('data-value'), null, true).responseJSON;

        $(document).addColumn(columnDetails);
        $('#addColumnName').html('Type Here');
    }
});


// Delete Column
$(document).on('click', '.kanban-column-delete',  function(e) {

    $(document).deleteColumn($(this).closest('.kanban-column').attr('data-value'));
    $(this).closest('.kanban-column').remove();


    var newWidth = $('#kanbanBoard>.card-group').css('width').replace(/\D/g, '') / $('#kanbanBoard').css('width').replace(/\D/g, '') * 100 - 25;

    $('#kanbanBoard>.card-group').css('width', `${newWidth}%`);
});
   

$(document).on('click', '.kanban-column-edit', function(e) {

    $(this).closest('.card-header').find('.kanban-column-title').attr('contenteditable', true);
    $(this).closest('.card-header').find('.kanban-column-title').focus();
});


$(document).on('keypress', '.kanban-column .kanban-column-title', function(e) {

    if(e.which == 13) {

        e.preventDefault();

        var columnDetails = {
            name: $(this).html(), 
            position: $(this).closest('.kanban-column').attr('data-position')
        };

        $(document).postColumn(columnDetails, $('#kanbanBoard').attr('data-value'), $(this).closest('.kanban-column').attr('data-value'));
        console.log(columnDetails + ' ' + $('#kanbanBoard').attr('data-value') + ' ' + $(this).closest('.kanban-column').attr('data-value'));

        $(this).attr('contenteditable', false);
    }
});

});