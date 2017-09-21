$(function () {

    const baseUrl = window.location.origin + '/task/';

    // Functions

    $.fn.displayTag = function(items, edit = false) {
        $.each(items, function(i, item) {

            if(edit)
                $('.task-tag-list').find('.task-tag').before(
                    `<span class="label label-default">${item} <a class="task-tag-remove" data-value="${item}">&times;</a></span>`
                );
            else
                $('.task-tag-list').append(
                    `<span class="label label-default">${item}</span>`
                );
            if(edit)
                $('.task-tag-list').parent().append(
                    `<input type="hidden" name="tags[]" value="${item}" />`
                );
        });
    };


    $.fn.displayTask = function(items, rowNumber = 4) { 
        $('#taskTileList').html('');

        rowNumber = 12/rowNumber;

        $.each(items, function(i, item) {
            $('#taskTileList').append(
                `<div class="col-md-${rowNumber}" style="padding:3px;">
                    <div class="task-tile  container-fluid" style="background-color:` + (item['status'] == 1 ? item['color'] : '#808080') + `;">
                        <div class="row">
                            <div class="col-md-2" style="padding-top:5%;">
                                <a class="task-mark-done" data-value="${item['id']}"><span class="glyphicon glyphicon-` + (item['status'] == 1 ? `unchecked` : `check`) + ` pull-right lead" "></span></a>
                            </div>
                            <div class="col-md-10 task-view" data-toggle="modal" data-target="#taskViewModal" data-value="${item['id']}">
                                <span class="tile-title">${item['title']}</span>
                                <br/>
                                <span class="tile-description">${item['description']}</span>
                            </div>
                        </div>
                    </div>
                </div>`
            );
        });
    };


    $.fn.getTask = function(id = null) {
        return $.ajax({
            type: 'GET',
            url: `${baseUrl}api/task` + (id != null ? `/${id}` : ''),
            dataType: 'json'
        });
    };

    
    $.fn.postTask = function(details, id = null) {
        return $.ajax({
            type: 'POST',
            url: `${baseUrl}api/task` + (id != null ? `/${id}` : ''),
            data: details,
            dataType: 'json'
        });
    };


    $.fn.searchTask = function(items, keyword) {
        $('#taskSearchQuery').html('');

        if(keyword == '')
            return;

        $.each(items, function(i, item) {
            if(item['title'].toLowerCase().indexOf(keyword.toLowerCase()) != -1) {
                $('#taskSearchQuery').append(
                    `<li class="list-group-item task-search-item" data-dismiss="modal" style="background-color:${item['color']};">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-1"><a class="task-mark-done" data-value="${item['id']}"><span class="glyphicon glyphicon-` + (item['status'] == 1 ? `unchecked` : `check`) + `"></span></a></div>
                                <div class="col-md-10" data-target="#taskViewModal" data-toggle="modal" data-value="${item['id']}">${item['title']}</div>
                                <div class="col-md-1"><a class="task-edit" href="#taskModifyModal" data-toggle="modal" data-value="${item['id']}"><span class="glyphicon glyphicon-edit"></span></a></div>
                            </div>
                        </div>
                    </li>`
                );
            }
        });
    };

    // Initialize

    $(document).getTask().done(function(data) {
        $(document).displayTask(data);
    });
    
    // Search

    $(document).on('input', '#taskSearch', function () {
        $(document).getTask().done(function(data){
            $(document).searchTask(data, $('#taskSearch').val());
        });
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

            $('#taskViewModal').find('.modal-content').css('background-color', data['color']);
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

    $('#taskNote').keypress(function (e) {
        if(e.which == 13) {
            $(this).parent().find('#taskNoteList').append(
                `<li class="list-group-item">${$(this).val()}</li>`
            );
            $(this).parent().append(
                `<input type="hidden" name="notes[]" value="${$(this).val()}" />`
            );
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