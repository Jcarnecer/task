$(function() {


// Initiate
$(document).getBoard(getAuthorId(), null, true).done(function(data) {

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


$(document).on('keypress', '#addColumnName', function(e) {

    
    if (e.which == 13) {
        e.preventDefault();
        
        var columnDetails = new Object;
        columnDetails.name = $(this).html();
        columnDetails.position = $(document).getColumn($('#kanbanBoard').attr('data-value'), null, true).responseJSON.length + 1;

        columnDetails.id = $(document).postColumn(columnDetails, $('#kanbanBoard').attr('data-value'), null, true).responseJSON;

        $(document).addColumn(columnDetails);
        $('#addColumnName').html('');
    }
});
    
});