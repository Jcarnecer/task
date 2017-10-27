$(function () {
    
    var $container = null;
    var $kanbanPanel = [$('#todoPanel>.row'), $('#doingPanel>.row'), $('#donePanel>.row')];
    var column = 0;

    
    switch(getTaskType()) {
        
        case 'personal':
            $container = $('#taskTileList')
            column = 4;
            break;

        case 'team':
            $container = $('#todoPanel>.row');
            column = 2;
            break;
    }


    // Initialize
    $(document).getTask().done(function(data) {

        if(data.length == 0 && getTaskType() == 'personal') {

            $('#taskTileList').html(
                `<h1 class="no-task-text">
                    No Task yet :(
                </h1>`
            );
        } else {

            $(document).displayTask(getTaskType(), data, column);
        }
    });

    
    // Load Modal
    $(document).on('click', '.task-create', function() {

        $(document).resetForm();
        $('#taskModifyModal').find('form').attr('id', 'taskCreateForm');
        $('#taskModifyModal').find('button[type="submit"]').attr('form', 'taskCreateForm');
    });
    
    
    $(document).on('click', '.task-edit', function () {
        
        $(document).resetForm();
        $('#taskModifyModal').find('form').attr('id', 'taskUpdateForm');
        $('#taskModifyModal').find('button[type="submit"]').attr('form', 'taskUpdateForm');
        
        $(document).getTask($(this).attr('data-value')).done(function (data) {

            $('#taskModifyModal').find('form').attr('data-value', data['id']);
            $('#taskModifyModal').find('[name="title"]').val(data['title']);
            $('#taskModifyModal').find('[name="description"]').val(data['description']);
            $('#taskModifyModal').find('[name="date"]').val(data['due_date']);
            $('#taskModifyModal').find('[name="color"]').val(data['color']);

            $(document).displayTag(data['tags'], true);
            $(document).displayActor(data['actors'], true);
            
            $('#taskModifyModal').find('.modal-content').css('background-color', data['color']);
            $('#taskModifyModal').find('.btn-color').find('i').removeClass('fa fa-check fa-lg');
            $('#taskModifyModal').find(`button[data-value="${data['color']}"] i`).addClass('fa fa-check fa-lg');
        });
    });


    $(document).on('click', '.task-view', function () {

        $('#taskViewModal').find('form')[0].reset();
        $('#taskViewModal').find('.task-note-list').html('');

        $(document).getTask($(this).attr('data-value')).done(function (data) {

            $('#taskViewModal').find('.dropdown a').attr('data-value', data['id']);
            $('#taskViewModal').find('form').attr('data-value', data['id']);
            $('#taskViewModal').find('[id="title"]').html(data['title']);
            $('#taskViewModal').find('[id="description"]').html(data['description']);
            $('#taskViewModal').find('[id="date"] span').html(data['due_date']);
            $('#taskViewModal').find('[id="countdown"]').html(data['remaining_days']);
            $('#taskViewModal').find('.task-tag-list').html('');
            $('#taskViewModal').find('.task-actor-list').html('');
            $('#taskViewModal').find('.modal-content').css('background-color', data['color']);

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
    $(document).on('input', '#taskSearch', function () {

        $(document).getTask().done(function(data){

            $(document).searchTask(data, $('#taskSearch').val());
        });
    });


    // Button Color
    $(document).on('click', '.btn-color', function () {

        $(this).find('i').addClass('fa fa-check fa-lg');
        $(this).siblings('.btn-color').find('i').removeClass('fa fa-check fa-lg');
        $(this).siblings('[name="color"]').attr('value', $(this).attr('data-value'));
        $(this).closest('.task-container').css('background-color', $(this).attr('data-value'));
    });


    // Tags
    $(document).on('keypress', '.task-tag', function (e) {

        if(e.which == 13 || e.which == 32) {

            if($(this).val() != '') {
                
                if(!$(this).closest('.task-tag-list').parent().has(`input[name="tags[]"][value="${$(this).val().toLowerCase()}"]`).length){
                    
                    $(this).before(
                        `<span class="badge badge-default">${$(this).val().toLowerCase()} <a class="task-tag-remove" data-value="${$(this).val().toLowerCase()}">&times;</a></span>`
                    );
                    $(this).closest('.task-tag-list').parent().append(
                        `<input type="hidden" name="tags[]" value="${$(this).val().toLowerCase()}" />`
                    );
                }
            }
            
            $(this).val('');
            
            return false;
        }
    });


    $(document).on('click', '.task-tag-remove', function() {

        $(this).closest('.task-tag-list').parent().find(`input[name="tags[]"][value="${$(this).attr('data-value')}"]`).remove();
        $(this).parent().remove();
    });
    

    // Actors
    $(document).on('keypress', '.task-actor', function (e) {

        if(e.which == 13 || e.which == 32) {

            if(!$(this).val() == '') {

                var result = $(document).validateMember($(this).val().toLowerCase());
                
                if(result['exist']) {
                    
                    if(!$(this).closest('.task-actor-list').parent().has(`input[name="actors[]"][value="${$(this).val().toLowerCase()}"]`).length){

                        $(this).before(
                            `<span class="badge badge-default">${result['first_name'] + ' ' + result['last_name']} <a class="task-actor-remove" data-value="${$(this).val().toLowerCase()}">&times;</a></span>`
                        );

                        $(this).closest('.task-actor-list').parent().append(
                            `<input type="hidden" name="actors[]" value="${$(this).val().toLowerCase()}" />`
                        );
                    }
                } else {
                    
                    alert('User does not exist in the company');
                }
            }

            $(this).val('');

            return false;
        }
    });


    $(document).on('click', '.task-actor-remove', function() {

        $(this).closest('.task-actor-list').parent().find(`input[name="actors[]"][value="${$(this).attr('data-value')}"]`).remove();
        $(this).parent().remove();
    });


    // Notes
    $(document).on('keypress', '.task-note', function (e) {

        if(e.which == 13) {

            var $noteInput = $(this);
            
            $(document).getUser(getUserId()).done(function(data) {
                
                $noteInput.closest('form').find('.task-note-list').append(
                    `<div class="col-md-2 task-note-list-item">
                        <i class="fa fa-user-circle fa-2x task-note-user" 
                        data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="${data['first_name'] + ' ' + data['last_name']}">
                        </i>
                        </div>
                    </div>
                    <div class="col-md-10 card card-sm task-note-text task-note-list-item">
                        ${$noteInput.val()}
                    </div>`
                );
            }).always(function() {
                
                $noteInput.closest('form').find('input[name="notes"]').val($noteInput.val());
                $(document).postTaskNote($noteInput.closest('form').serialize(), $noteInput.closest('form').attr('data-value'));
                $noteInput.val('');
            }); 

            return false;
        }
    });


    // Submit
    $(document).on('submit', 'form#taskCreateForm, form#taskUpdateForm', function (e) {

        e.preventDefault();

        if($(this).find('input[name="title"]').val() != '') {

            var task = $(this).serializeArray();
            
            if($(this).is('#taskCreateForm')) {
                
                $(document).postTask(task).always(function() {
                    
                    $(document).getTask().done(function(data) {
                        
                        $(document).displayTask(getTaskType(), data);
                        $(document).resetForm();
                    });
                });
            } else if($(this).is('#taskUpdateForm')) {
                
                $(document).postTask(task, $(this).attr('data-value')).always(function(data) {
                    
                    $(document).getTask().always(function(data){
                        
                        $(document).displayTask(getTaskType(), data);
                        $(document).resetForm();
                    });
                });
            }

            if($(this).has('#taskClose'))
                $('#taskClose').click();

            if($(this).has('#createCollapse'))
                $(this).find('#createCollapse').removeClass('show');
                // $(this).find('input[name="title"]').click();
        }
    });


    $(document).on('click', 'button:submit', function(e) {
        
        e.preventDefault();
        $(this).closest('form').submit();
    });
    
    
    // Mark as Done
    $(document).on('click', '.task-mark-done', function () {
        
        if($(this).is('.glyphicon')) {

            $(this).toggleClass('glyphicon-check');
            $(this).toggleClass('glyphicon-unchecked');
        }

        $(this).removeClass('task-mark-done');

        $.ajax({

            type: 'POST',
            url: `${baseUrl}api/done/${$(this).attr('data-value')}`,
        }).done(function(data) {

            $(document).getTask().done(function(data){

                $(document).displayTask(getTaskType(), data);
            });
        });
    });
});