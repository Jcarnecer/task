$(function () {

    const baseUrl = window.location.origin + '/task/';

    // Functions

    $.fn.displayTag = function($element, items, edit = false) {
        $.each(items, function(i, item) {

            if(edit)
                $element.find('.task-tag').before(
                    `<span class="label label-default">${item} <a class="task-tag-remove" data-value="${item}">&times;</a></span>`
                );
            else
                $element.append(
                    `<span class="label label-default">${item}</span>`
                );
            if(edit)
                $element.parent().append(
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
                            <div class="col-md-2">
                                <span class="glyphicon glyphicon-` + (item['status'] == 1 ? `unchecked task-mark-done` : `check`) + ` pull-right lead" data-value="${item['id']}"></span>
                            </div>
                            <div class="col-md-10" data-toggle="modal" data-target="#taskViewModal" data-value="${item['id']}">
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
                                <div class="col-md-1"><span class="glyphicon glyphicon-` + (item['status'] == 1 ? `unchecked task-mark-done` : `check`) + `" data-value="${item['id']}"></span></div>
                                <div class="col-md-10" data-target="#taskViewModal" data-toggle="modal" data-value="${item['id']}">${item['title']}</div>
                                <div class="col-md-1"><span class="glyphicon glyphicon-edit" data-target="#taskUpdateModal" data-toggle="modal" data-value="${item['id']}"></span></div>
                            </div>
                        </div>
                    </li>`
                );
            }
        });
    };

    // Initialize

    $(document).getTask().done(function (data) {
        $(document).displayTask(data);
    });
    
    // Search

    $(document).on('input', '#taskSearch', function () {
        $(document).getTask().done(function(data){
            $(document).searchTask(data, $('#taskSearch').val());
        });
    });

    // Load Modal

    $(document).on('click', '[data-target="#taskCreateModal"], [href="#taskCreateModal"]', function() {
        $('#taskCreateModal').find('form')[0].reset();

        $('#taskCreateModal').find('.task-tag-list').find('span.label').remove();
        $('#taskCreateModal').find('.task-tag-list').siblings('input').remove();
    });


    $(document).on('click', '[data-target="#taskUpdateModal"], [href="#taskUpdateModal"]', function () {
        $('#taskUpdateModal').find('form')[0].reset();

        $(document).getTask($(this).attr('data-value')).done(function (data) {
            $('#taskUpdateModal').find('form').attr('data-value', data['id']);
            $('#taskUpdateModal').find('[name="title"]').val(data['title']);
            $('#taskUpdateModal').find('[name="description"]').val(data['description']);
            $('#taskUpdateModal').find('[name="date"]').val(data['due_date']);
            $('#taskUpdateModal').find('[name="color"]').val(data['color']);

            $('#taskUpdateModal').find('.task-tag-list').find('span.label').remove();
            $('#taskUpdateModal').find('.task-tag-list').siblings('input').remove();
            $(document).displayTag($('#taskUpdateModal').find('.task-tag-list'), data['tags'], true);
            
            $('#taskUpdateModal').find('.modal-content').css('background-color', data['color']);
            $('#taskUpdateModal').find('.btn-color').find('span').removeClass('glyphicon glyphicon-ok');
            $('#taskUpdateModal').find(`button[data-value="${data['color']}"] span`).addClass('glyphicon glyphicon-ok');
        });
    });


    $(document).on('click', '[data-target="#taskViewModal"], [href="#taskViewModal"]', function () {
        $('#taskViewModal').find('form')[0].reset();

        $(document).getTask($(this).attr('data-value')).done(function (data) {
            $('#taskViewModal').find('.dropdown a').attr('data-value', data['id']);
            
            $('#taskViewModal').find('form').attr('data-value', data['id']);
            $('#taskViewModal').find('[id="title"]').html(data['title']);
            $('#taskViewModal').find('[id="description"]').html(data['description']);
            $('#taskViewModal').find('[id="date"] span').html(data['due_date']);
            
            $('#taskViewModal').find('.task-tag-list').html('');

            if(data['tags'].length != 0) 
                $(document).displayTag($('#taskViewModal').find('.task-tag-list'), data['tags']);
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
            $(document).postTask(task).done(function(data){
                $(document).getTask().done(function(data){
                    $(document).displayTask(data);
                });
            });
        }

        else if($(this).closest('form').attr('id') == 'taskUpdateForm') {
            $(document).postTask(task, $(this).closest('form').attr('data-value')).done(function(data) {
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