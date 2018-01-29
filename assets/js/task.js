$(function () {

var storedTasks = null;

function archive(taskId) {

    $(document).archiveTask(taskId);
}

// Load Modal
$(document).on('click', '.task-create', function() {

    $(document).resetForm();
    $('#taskModifyModal').find('form').attr('id', 'taskCreateForm');
    $('#taskModifyModal').find('button[type="submit"]').attr('form', 'taskCreateForm');
    $('#taskModifyModal').find('[name="column_id"]').val($(this).attr('data-parent'));
});


$(document).on('click', '.task-edit', function () {
    
    $(document).resetForm();
    $('#taskModifyModal').find('form').attr('id', 'taskUpdateForm');
    $('#taskModifyModal').find('button[type="submit"]').attr('form', 'taskUpdateForm');
    
    $(document).getTask($(this).attr('data-value')).done(function (data) {
        
        $('#taskModifyModal').find('form').attr('data-value', data['id']);
        $('#taskModifyModal').find('[name="title"]').val(data['title']);
        $('#taskModifyModal').find('[name="description"]').val(data['description']);
        $('#taskModifyModal').find('[name="due_date"]').val(data['due_date']);
        $('#taskModifyModal').find('[name="color"]').val(data['color']);
        
        $(document).displayTag(data['tags'], true);
        $(document).displayActor(data['actors'], true);
        
        $('#taskModifyModal .card-header').css('background-color', data['color']);
        $('#taskModifyModal').find('.btn-color').find('i').removeClass('fa fa-check fa-lg');
        $('#taskModifyModal').find(`button[data-value="${data['color']}"] i`).addClass('fa fa-check fa-lg');
    });
});


$(document).on('click', '.task-view', function () {

    $('#taskViewModal').find('.task-note-list').html('');

    $(document).getTask($(this).attr('data-value')).always(function (data) {

        $('#taskViewModal').find('[data-target="#taskModifyModal"], [href="#taskModifyModal"]').attr('data-value', data['id']);
        $('#taskViewModal').find('.task-note').attr('data-value', data['id']);
        $('#taskViewModal').find('.task-title').html(data['title']);
        $('#taskViewModal').find('.task-description').html(data['description'] ? data['description'] : '<small class="text-muted">No Description</small>');
        $('#taskViewModal').find('.task-date').html(data['due_date_long']);
        $('#taskViewModal').find('.task-countdown').css('color', 'black');
        $('#taskViewModal').find('.task-countdown-text').css('color', 'black');
        $('#taskViewModal').find('.task-countdown').html(Math.abs(data['remaining_days']));
        $('#taskViewModal').find('.task-countdown-text').html('');
        $('#taskViewModal').find('.task-tag-list').html('');
        $('#taskViewModal').find('.task-actor-list').html('');
        $('#taskViewModal').find('.card-header').css('background-color', data['color']);

        if(data['status'] == 2) // ARCHIVE

            $('#taskViewModal').find('.task-countdown-text').html('COMPLETED');
        else {

            if(data['remaining_days'] > 0) {
                $('#taskViewModal').find('.task-countdown').css('color', 'black');
                $('#taskViewModal').find('.task-countdown-text').css('color', 'black');
                $('#taskViewModal').find('.task-countdown-text').html(' day(s) remaining');
            } else if(data['remaining_days'] == 0) {
                $('#taskViewModal').find('.task-countdown').css('color', 'red');
                $('#taskViewModal').find('.task-countdown-text').css('color', 'red');
                $('#taskViewModal').find('.task-countdown').html('DUE TODAY');
            } else {
                $('#taskViewModal').find('.task-countdown').css('color', 'red');
                $('#taskViewModal').find('.task-countdown-text').css('color', 'red');
                $('#taskViewModal').find('.task-countdown-text').html(' day(s) overdue');
            }
        }

        if(data['tags'].length != 0) 

            $(document).displayTag(data['tags']);
        else

            $('#taskViewModal').find('.task-tag-list').html('None');

        if(data['actors'].length != 0) 
        
            $(document).displayActor(data['actors']);
        else

            $('#taskViewModal').find('.task-actor-list').html('None');

        $(document).displayNote(data['notes']);
    });
});


// Search
$(document).on('click', '[href="#taskSearchModal"]', function(e) {

    storedTasks = storeTask();
});


$(document).on('input', '#taskSearch', function (e) {

    if(e.which == 13) {

        e.preventDefault();
    }

    $(document).searchTask(storedTasks, $('#taskSearch').val());
});

$('#taskSearchModal').on('hidden.bs.modal', function () {
    
    $('#taskSearchList').html('');
});


// Button Color
$(document).on('click', '.btn-color', function () {

    $(this).find('i').addClass('fa fa-check fa-lg');
    $(this).siblings('.btn-color').find('i').removeClass('fa fa-check fa-lg');
    $(this).closest('form').find('[name="color"]').attr('value', $(this).attr('data-value'));
    $(this).closest('#taskModifyModal .card').css('background-color', $(this).attr('data-value'));
});


// Description
$(document).on('keypress', 'textarea[name="description"]', function(e) {

    if(e.which == 13) {

        e.preventDefault();
        $(this).closest('form').submit();
    }
})


// Tags
$(document).on('keypress', '.task-tag', function (e) {

    if(e.which == 13 || e.which == 32) {

        e.preventDefault();

        if(!$(this).closest('form').has(`input[name="tags[]"][value="${$(this).val().toLowerCase()}"]`).length){
            
            $(this).before(
                `<span class="badge badge-dark badge-pill mx-1">${$(this).val().toLowerCase()} <a class="task-tag-remove" data-value="${$(this).val().toLowerCase()}">&times;</a></span>`
            );

            $(this).closest('form').append(
                `<input type="hidden" name="tags[]" value="${$(this).val().toLowerCase()}" />`
            );
        }
        
        $(this).val('');
    }
});


$(document).on('click', '.task-tag-remove', function() {

    $(this).closest('form').find(`input[name="tags[]"][value="${$(this).attr('data-value')}"]`).remove();
    $(this).parent().remove();
});


// Actors
$(document).on('keypress', '.task-actor', function (e) {

    if(e.which == 13 || e.which == 32) {

        e.preventDefault();

        var result = $(document).validateMember($(this).val().toLowerCase(), getAuthorId(), true).responseJSON;
        
        if(result['exist']) {
            
            if(!$(this).closest('form').has(`input[name="actors[]"][value="${$(this).val().toLowerCase()}"]`).length){

                $(this).before(
                    `<span class="badge badge-dark mx-1">${result['first_name'] + ' ' + result['last_name']} <a class="task-actor-remove" data-value="${$(this).val().toLowerCase()}">&times;</a></span>`
                );

                $(this).closest('form').append(
                    `<input type="hidden" name="actors[]" value="${$(this).val().toLowerCase()}" />`
                );
            }
        } else {
            
            alert('User does not exist in the team');
        }

        $(this).val('');

        return false;
    }
});


$(document).on('click', '.task-actor-remove', function() {

    $(this).closest('form').find(`input[name="actors[]"][value="${$(this).attr('data-value')}"]`).remove();
    $(this).parent().remove();
});


// Notes
$(document).on('keypress', '.task-note', function (e) {

    if(e.which == 13) {

        e.preventDefault();
        $(this).closest('.modal').find('.task-note-list').append(`
            <div class="col-2 my-1">
                <h4 class="text-center">
                <img class="img-avatar-sm" src="${avatarUrl}" 
                    data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="${userName}">
                </h4>
            </div>
            <div class="col-10 d-flex align-self-stretch my-1 text-dark">
                ${$(this).val()}
            </div>
        `);
        
        $(document).postTaskNote($(this).val(), $(this).attr('data-value'));
        $(this).val('');
    }
});


// Submit
$(document).on('submit', 'form#taskCreateForm, form#taskUpdateForm', function (e) {
    
    e.preventDefault();    

    if($(this).find('input[required]').val() != '') {

        var task = $(this).serializeArray();
        
        if($(this).is('#taskCreateForm')) {
            
            $(document).postTask(task).always(function() {
                
                $(document).getTask().done(function(data) {
                    
                    $(document).displayTask(data);
                    $(document).resetForm();
                });
            });
        } else if($(this).is('#taskUpdateForm')) {
            
            $(document).postTask(task, $(this).attr('data-value')).always(function(data) {
                
                $(document).getTask().always(function(data){
                    
                    $(document).displayTask(data);
                    $(document).resetForm();
                });
            });
        }

        if($(this).has('.close-modal')) {
            
            $(this).find('.close-modal').click();
        } 
    }
});

});