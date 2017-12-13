$(function() {


// Initiate
$(document).getBoard(getAuthorId(), null, true).done(function(data) {

    if(data == null) {

        var boardDetails = {name: 'Default'};
        
        $(document).postBoard(boardDetails, getAuthorId());
    }

    $('#kanbanMdBoard').attr('data-value', data['id']);
    $('#kanbanSmBoard').attr('data-value', data['id']);
    $(document).displayBoard(data);
});


$(document).getTask().done(function(data) {
    
    $(document).displayTask(data);

    if(getTaskType() == 'personal') {
        $('.task-count').html(data.length);
    }
});


// Highlight
$(document).on('click', '#highlightBtn', function() {
    
    $(document).highlightTask(getUserId());
});


// Add Column
$(document).on('select, click', '.add-column-name', function(e) {

    $('.add-column-name').html('');
});


$(document).on('keypress', '.add-column-name', function(e) {

    if ($('.add-column-name').html() == 'Type Here') {
        
        $('.add-column-name').html('');
    }

    if (e.which == 13) {

        e.preventDefault();
        
        var columnDetails = new Object;
        columnDetails.name = $(this).html();
        columnDetails.position = $(document).getColumn($('#kanbanMdBoard').attr('data-value'), null, true).responseJSON.length + 1;

        columnDetails.id = $(document).postColumn(columnDetails, $('#kanbanMdBoard').attr('data-value'), null, true).responseJSON;

        $(document).addColumn(columnDetails);
        $('.add-column-name').html('Type Here');
    }
});


// Delete Column
$(document).on('click', '.kanban-column-delete',  function(e) {

    $(document).deleteColumn($(this).closest('.kanban-column').attr('data-value'));
    $(this).closest('.kanban-column').remove();


    var newSmWidth = $('#kanbanSmBoard .kanban-column-holder').css('width').replace(/\D/g, '') / $('#kanbanSmBoard').css('width').replace(/\D/g, '') * 100 - 100;
    var newMdWidth = $('#kanbanMdBoard .kanban-column-holder').css('width').replace(/\D/g, '') / $('#kanbanMdBoard').css('width').replace(/\D/g, '') * 100 - 25;

    newSmWidth = Number(newSmWidth) < 100 ? '100' : newSmWidth;
    newMdWidth = Number(newMdWidth) < 100 ? '100' : newMdWidth;

    $('#kanbanSmBoard .kanban-column-holder').css('width', `${newSmWidth}%`);
    $('#kanbanMdBoard .kanban-column-holder').css('width', `${newMdWidth}%`);
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

        $(document).postColumn(columnDetails, $('#kanbanMdBoard').attr('data-value'), $(this).closest('.kanban-column').attr('data-value'));
        // console.log(columnDetails + ' ' + $('#kanbanBoard').attr('data-value') + ' ' + $(this).closest('.kanban-column').attr('data-value'));

        $(this).attr('contenteditable', false);
    }
});

});