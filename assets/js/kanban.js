$(function() {

// Column
$(document).on('click', '#addColumnName', function() {
    

    if($(this).html() == 'Add Column') {
     
        $(this).html('');
    }
});


$(document).on('keypress', '#addColumnName', function(e) {
    
    if (e.which == 13) {
        
        var columnDetails = new Object;
        columnDetails.name = $(this).html();
        columnDetails.position = $(document).getColumn($('#kanbanBoard').attr('data-value'), null, true).responseJSON.length + 1;

        $(document).postColumn(columnDetails, $('#kanbanBoard').attr('data-value')).done(function(data) {
            
            columnDetails.id = data;
        }).always(function(data){
            
            $('#addColumnName').html('Add Column');
        });

        $(document).addColumn(columnDetails);
    }
});
    
});