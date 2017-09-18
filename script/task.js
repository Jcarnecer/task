    $(function () {

    const baseUrl = window.location.origin + '/task/';

    // Functions

    $.fn.getTask = function() {
        return $.ajax({
            type: 'GET',
            url: `${baseUrl}api/task`,
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
                    `<a href="#viewTaskModal" data-toggle="modal" data-value="${item['id']}" class="list-group-item task-search-item" data-dismiss="modal" style="background-color:${item['color']}; color:#000000;">` +
                        `<h5 class="tile-title"><b>` +
                        // `<span class="glyphicon glyphicon-` + (item['status'] == 1 ? `unchecked` : `check`) + ` task-mark-done pull-top" data-value="${item['id']}"></span>` +
                        ` ${item['title']}` +
                        // `<span class="glyphicon glyphicon-pencil pull-right" data-target="#updateTaskModal" data-toggle="modal" data-value="${item['id']}" data-value="${item['id']}"></span>` + 
                        `</b></h5>` +
                    `</a>`
                );
            }
        });
    };


    $.fn.displayTiles = function(items, rowNumber = 4) {
        $('#taskTileList').html('');

        rowNumber = 12/rowNumber;

        $.each(items, function(i, item) {
            $('#taskTileList').append(
                `<div class="col-md-${rowNumber}" style="padding:3px;">` +
                    `<div class="task-tile  container-fluid" style="background-color:` + (item['status'] == 1 ? item['color'] : '#808080') + `;">` +
                        `<div class="row">` +
                            `<div class="col-md-2">` +
                                `<h4 class="pull-right"><span class="glyphicon glyphicon-` + (item['status'] == 1 ? `unchecked task-mark-done` : `check`) + ` pull-top" data-value="${item['id']}"></span></h4>` +
                            `</div>` +
                            `<div class="col-md-10" data-toggle="modal" data-target="#viewTaskModal" data-value="${item['id']}">` +
                                `<h4 class="tile-title"><b>${item['title']}</b></h4>` +
                                `<p class="tile-description task-justify"><b>${item['description']}</b></p>` +
                            `</div>` +
                        `</div>` +
                    `</div>` +
                `</div>`
            );
        });
    };


    $.fn.changeColor = function($element, color) {
        var accent = "#000000";
        
        switch(color.toLowerCase()){
            case '#ffffff': accent = "#000000"; break;
            case '#2196f3': accent = "#ffffff"; break;
            case '#f44336': accent = "#ffffff"; break;
            case '#4caf50': accent = "#ffffff"; break;
            case '#ffeb3b': accent = "#000000"; break;
            case '#ff9800': accent = "#000000"; break;
        }

        $element.css('background-color', color);
        $element.css('color', accent);
    };


    $.fn.displayTags = function($element, items, edit = false) {
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

    // Initialize

    $(document).getTask().done(function (data) {
        $(document).displayTiles(data);
    });

    // Button Color

    $(document).on('click', '.btn-color', function () {
        $(this).find('span').addClass('glyphicon glyphicon-ok');
        $(this).siblings('.btn-color').find('span').removeClass('glyphicon glyphicon-ok');
        $(this).siblings('[name="color"]').attr('value', $(this).attr('data-value'));
        
        $(this).closest('.modal-content').css('background-color', $(this).attr('data-value'));
    });

    // Search

    $('#taskSearchQuery').find('a.list-group-item').on('mouseover', function () {
        $(this).filter('span[data-target="#updateTaskModal"]').show(200);
    });


    $(document).on('input', '#taskSearch', function () {
        $(document).getTask().done(function(data){
            $(document).searchTask(data, $('#taskSearch').val());
        });
    });

    // Tags

    $('.task-tag').keypress(function (e) {
        if(e.which == 13 || e.which == 32) {
            if(!$(this).closest('.task-tag-list').parent().has(`input[name="tags[]"][value="${$(this).val()}"]`).length){
                $(this).before(
                    `<span class="label label-default">${$(this).val()} <a class="task-tag-remove" data-value="${$(this).val()}">&times;</a></span>`
                );
                $(this).closest('.task-tag-list').parent().append(
                    `<input type="hidden" name="tags[]" value="${$(this).val()}" />`
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

    // Load Modal

    $(document).on('click', '[data-target="#createTaskModal"], [href="#createTaskModal"]', function() {
        $('#createTaskModal').find('form')[0].reset();

        $('#createTaskModal').find('.task-tag-list').find('span.label').remove();
        $('#createTaskModal').find('.task-tag-list').siblings('input').remove();
    });


    $(document).on('click', '[data-target="#updateTaskModal"], [href="#updateTaskModal"]', function () {
        $('#updateTaskModal').find('form')[0].reset();
        $.ajax({
            type: 'GET',
            url: `${baseUrl}api/task/${$(this).attr('data-value')}`,
            dataType: 'json'
        }).done(function (data) {
            $('#updateTaskModal').find('form').attr('data-value', data['id']);
            $('#updateTaskModal').find('[name="title"]').val(data['title']);
            $('#updateTaskModal').find('[name="description"]').val(data['description']);
            $('#updateTaskModal').find('[name="date"]').val(data['due_date']);
            $('#updateTaskModal').find('[name="color"]').val(data['color']);

            $('#updateTaskModal').find('.task-tag-list').find('span.label').remove();
            $('#updateTaskModal').find('.task-tag-list').siblings('input').remove();
            $(document).displayTags($('#updateTaskModal').find('.task-tag-list'), data['tags'], true);
            
            $('#updateTaskModal').find('.modal-content').css('background-color', data['color']);
            $('#updateTaskModal').find('.btn-color').find('span').removeClass('glyphicon glyphicon-ok');
            $('#updateTaskModal').find(`button[data-value="${data['color']}"] span`).addClass('glyphicon glyphicon-ok');

        });
    });


    $(document).on('click', '[data-target="#viewTaskModal"], [href="#viewTaskModal"]', function () {
        $('#viewTaskModal').find('form')[0].reset();

        $.ajax({
            type: 'GET',
            url: `${baseUrl}api/task/${$(this).attr('data-value')}`,
            dataType: 'json'
        }).done(function (data) {
            $('#viewTaskModal').find('.dropdown a').attr('data-value', data['id']);
            
            $('#viewTaskModal').find('form').attr('data-value', data['id']);
            $('#viewTaskModal').find('[id="title"] b').html(data['title']);
            $('#viewTaskModal').find('[id="description"] b').html(data['description']);
            $('#viewTaskModal').find('[id="date"] span').html(data['due_date']);
            
            $('#viewTaskModal').find('.task-tag-list').html('');

            if(data['tags'].length != 0) 
                $(document).displayTags($('#viewTaskModal').find('.task-tag-list'), data['tags']);
            else
                $('#viewTaskModal').find('.task-tag-list').html('None');

            $('#viewTaskModal').find('.modal-content').css('background-color', data['color']);
        });
    });

    // Submit

    $(document).on('click', '#taskCreateButton', function () {
        var task = $(`#taskCreateForm`).serializeArray();

        $.ajax({
            type: 'POST',
            url: `${baseUrl}api/task`,
            data: task
        }).done(function(data) {
            $(document).getTask().done(function(data){
                $(document).displayTiles(data);
            });
        });
    });


    $(document).on('click', '#taskUpdateButton', function () {
        var task = $(`#taskUpdateForm`).serializeArray();

        $.ajax({
            type: 'POST',
            url: `${baseUrl}api/task/${$('#taskUpdateForm').attr('data-value')}`,
            data: task
        }).done(function(data) {
            $(document).getTask().done(function(data){
                $(document).displayTiles(data);
            });
        });
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
                $(document).displayTiles(data);
            });
        });
    });

    }); 