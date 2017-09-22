$(function () {

    // Initialize

    $(document).getTask().done(function(data) {
        $(document).displayTask(data);
    });
    
    // Load Modal

    $(document).on('click', '.task-create', function() {
        $('#taskModifyModal').find('form')[0].reset();

        $('#taskModifyModal').find('form').attr('id', 'taskCreateForm');
        $('#taskModifyModal').find('.task-tag-list').find('span.label').remove();
        $('#taskModifyModal').find('.task-tag-list').siblings('input').remove();
    });


    $(document).on('click', '.task-edit', function () {
        $('#taskModifyModal').find('form')[0].reset();

        $('#taskModifyModal').find('.task-tag-list').siblings('input').remove();
        $('#taskModifyModal').find('.task-tag-list').find('span.label').remove();
        
        $(document).getTask($(this).attr('data-value')).done(function (data) {
            $('#taskModifyModal').find('form').attr('data-value', data['id']);
            $('#taskModifyModal').find('form').attr('id', 'taskUpdateForm');

            $('#taskModifyModal').find('[name="title"]').val(data['title']);
            $('#taskModifyModal').find('[name="description"]').val(data['description']);
            $('#taskModifyModal').find('[name="date"]').val(data['due_date']);
            $('#taskModifyModal').find('[name="color"]').val(data['color']);

            $(document).displayTag(data['tags'], true);
            
            $('#taskModifyModal').find('.modal-content').css('background-color', data['color']);
            $('#taskModifyModal').find('.btn-color').find('span').removeClass('glyphicon glyphicon-ok');
            $('#taskModifyModal').find(`button[data-value="${data['color']}"] span`).addClass('glyphicon glyphicon-ok');
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

            if(data['tags'].length != 0) 
                $(document).displayTag(data['tags']);
            else
                $('#taskViewModal').find('.task-tag-list').html('None');

            $(document).displayNote(data['notes']);

            $('#taskViewModal').find('.modal-content').css('background-color', data['color']);
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
        $(this).find('span').addClass('glyphicon glyphicon-ok');
        $(this).siblings('.btn-color').find('span').removeClass('glyphicon glyphicon-ok');
        $(this).siblings('[name="color"]').attr('value', $(this).attr('data-value'));
        
        $(this).closest('.modal-content').css('background-color', $(this).attr('data-value'));
    });

    // Tags

    $('.task-tag').keypress(function (e) {
        if(e.which == 13 || e.which == 32) {
            if(!$(this).closest('.task-tag-list').parent().has(`input[name="tags[]"][value="${$(this).val().toLowerCase()}"]`).length){
                $(this).before(
                    `<span class="label label-default">${$(this).val().toLowerCase()} <a class="task-tag-remove" data-value="${$(this).val().toLowerCase()}">&times;</a></span>`
                );
                $(this).closest('.task-tag-list').parent().append(
                    `<input type="hidden" name="tags[]" value="${$(this).val().toLowerCase()}" />`
                );
                
            }
            $(this).val('');
            return false;
        }
    });


    $(document).on('click', '.task-tag-remove', function() {
        $(this).closest('.task-tag-list').parent().find(`input[name="tags[]"][value="${$(this).attr('data-value')}"]`).remove();
        $(this).parent().remove();
    });
    
    // Notes

    $('.task-note').keypress(function (e) {
        if(e.which == 13) {

            $(this).closest('form').find('.task-note-list').append(
                // `<div class="row task-note-list-item">
                    `<div class="col-md-2">
                        <div class="task-note-user circle"></div>
                    </div>
                    <div class="col-md-10 well well-sm task-note-text">
                        ${$(this).val()}
                    </div>`
                // </div>`
            );

            $(this).closest('form').find('input[name="notes"]').val($(this).val());

            $(document).postTaskNote($(this).closest('form').serialize(), $(this).closest('form').attr('data-value'));

            $(this).val('');
            return false;
        }
    });

    // Submit

    $(document).on('click', '#taskSubmit', function () {
        var task = $(this).closest('form').serializeArray();

        if($(this).closest('form').is('#taskCreateForm')) {
            $(document).postTask(task).always(function() {
                $(document).getTask().done(function(data){
                    $(document).displayTask(data);
                });
            }); 
        } else if($(this).closest('form').is('#taskUpdateForm')) {
            $(document).postTask(task, $(this).closest('form').attr('data-value')).always(function(data) {
                $(document).getTask().done(function(data){
                    $(document).displayTask(data);
                });
            });
        }
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
                $(document).displayTask(data);
            });
        });
    });

}); 