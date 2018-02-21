$(function () {

var storedTasks = null;

// Load Modal
$(document).on('click', '.task-create', function () {

    resetForm();
    $('#taskModifyModal').find('form').attr('id', 'taskCreateForm');
    $('#taskModifyModal').find('button[type="submit"]').attr('form', 'taskCreateForm');
    $('#taskModifyModal').find('[name="column_id"]').val($(this).attr('data-parent'));
});


$(document).on('click', '.task-edit', function () {

    resetForm();
    $('#taskModifyModal').find('form').attr('id', 'taskUpdateForm');
    $('#taskModifyModal').find('button[type="submit"]').attr('form', 'taskUpdateForm');
    
    getTask($(this).attr('data-value')).done(function (data) {
        
        $('#taskModifyModal').find('form').attr('data-value', data['id']);
        $('#taskModifyModal').find('[name="title"]').val(data['title']);
        $('#taskModifyModal').find('[name="description"]').val(data['description']);
        $('#taskModifyModal').find('[name="due_date"]').val(data['due_date']);
        $('#taskModifyModal').find('[name="color"]').val(data['color']);
        
        displayTag(data['tags'], true);
        displayActor(data['actors'], true);
        
        $('#taskModifyModal .card .card-header').css('background-color', data['color']);
        $('#taskModifyModal').find('.btn-color').find('i').removeClass('fa fa-check fa-lg');
        $('#taskModifyModal').find(`button[data-value="${data['color']}"] i`).addClass('fa fa-check fa-lg');
    });
});


$(document).on('click', '.task-view', function () {

    $('#taskViewModal').find('.task-note-list').html('');

    getTask($(this).attr('data-value')).always(function (data) {

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
        $('#taskViewModal').find('.card .card-header').css('background-color', data['color']);

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

        if(data['tags'].length != 0) {

            displayTag(data['tags']);
        } else {

            $('#taskViewModal').find('.task-tag-list').html('None');
        }

        if(data['actors'].length != 0) {

            displayActor(data['actors']);
        } else {

            $('#taskViewModal').find('.task-actor-list').html('None');
        }

        displayNote(data['notes']);
    });
});


$(document).on('click', '.task-archive', function() {

    var $task = $(this).closest('.card.kanban-task');
 
    if(confirm('Are you sure you want to delete this task?')) {

        $task.popover('hide');

        archiveTask($(this).attr('data-value')).done(function() {

            $task.remove();
        });
    }
});


// Search
$(document).on('click', '[href="#taskSearchModal"]', function(e) {

    storedTasks = getAllTask(false).responseJSON;
});


$(document).on('input', '#taskSearch', function (e) {

    if(e.which == 13) {

        e.preventDefault();
    }

    searchTask(storedTasks, $('#taskSearch').val());
});


$('#taskSearchModal').on('hidden.bs.modal', function () {
    
    $('#taskSearchList').html('');
});


// Button Color
$(document).on('click', '.btn-color', function () {

    $('.btn-color .fa-check').hide();
    $(this).find('.fa-check').show();
    $(this).closest('form').find('[name="color"]').attr('value', $(this).data('value'));
    $('#taskModifyModal .card .card-header').css('background-color', $(this).data('value'));
    // console.log($('#taskModifyModal .card').find('.card-header'));
    // $(this).closest('#taskModifyModal .card .card-footer').css('background-color', $(this).data('value'));
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

        checkTeamMember($(this));

        $(this).val('');
    }
});


// $(document).on('blur', '.task-actor', function (e) {

//     e.preventDefault();

//     var data = {
//         email: $(this).val().toLowerCase(),
//         proj_id: getAuthorId()
//     };

//     var result = validateMember(data).responseJSON;
    
//     if(result['exists']) {
        
//         if(!$(this).closest('form').has(`input[name="actors[]"][value="${$(this).val().toLowerCase()}"]`).length){

//             $(this).before(
//                 `<span class="badge badge-dark mx-1">${result['first_name'] + ' ' + result['last_name']} <a class="task-actor-remove" data-value="${$(this).val().toLowerCase()}">&times;</a></span>`
//             );

//             $(this).closest('form').append(
//                 `<input type="hidden" name="actors[]" value="${$(this).val().toLowerCase()}" />`
//             );
//         }
//     } else {
        
//         alert('User does not exist in the team');
//     }

//     $(this).val('');
// });


$(document).on('click', '.task-actor-remove', function() {

    $(this).closest('form').find(`input[name="actors[]"][value="${$(this).attr('data-value')}"]`).remove();
    $(this).parent().remove();
});


// Notes
$(document).on('keypress', '.task-note', function (e) {

    if(e.which == 13) {

        e.preventDefault();

        var data = {
            note: $(this).val(),
            task_id: $(this).attr('data-value')        
        };
        
        addNote(data);

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

        $(this).val('');
    }
});


// Submit
$(document).on('submit', 'form#taskCreateForm, form#taskUpdateForm', function (e) {
    
    e.preventDefault();    

    if($(this).find('input[required]').val() != '' && $(this).find('.task-actor').val() == '') {

        var task = $(this).serializeArray();
        
        if($(this).is('#taskCreateForm')) {

            task.push({name: 'author_id', value: getAuthorId()});
            
            addTask(task).always(function() {
                
                getAllTask().always(function(data) {
                    
                    displayTask(data);
                    resetForm();
                });
            });
        } else if($(this).is('#taskUpdateForm')) {
            
            task.push({name: 'id', value: $(this).attr('data-value')});

            updateTask(task).always(function() {
                
                getAllTask().always(function(data){
                    
                    displayTask(data);
                    resetForm();
                });
            });
        }

        if($(this).has('.close-modal')) {
            
            $(this).find('.close-modal').click();
        } 
    } else if($(this).find('.task-actor').val() != '') {

        checkTeamMember($(this).find('.task-actor'));

        $(this).find('.task-actor').val('');
    }
});

});