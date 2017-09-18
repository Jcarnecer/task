    <script>
    $(function () {

    const baseUrl = "<?= base_url() ?>";

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
                    `<div class="task-tile  container-fluid" style="background-color:` + (item['status'] == 1 ? item['color'] : '#777777') + `;">` +
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
        // $element.find('input -webkit-input-placeholder').css('color', accent);
    };


    $.fn.displayTags = function($element, items) {
        $.each(items, function(i, item) {

        });
    };

    // Initialize

    $(document).getTask().done(function (data) {
        $(document).displayTiles(data);
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
            $(this).before(
                `<span class="label label-default">${$(this).val()} <a class="task-tag-remove">&times;</a></span>`
            );
            $(this).parent().append(
                `<input type="hidden" name="tags[]" value="${$(this).val()}" />`
            );
            $(this).val('');
            return false;
        }
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

    $(document).on('click', '[data-target="#updateTaskModal"], [href="#updateTaskModal"]', function () {
        $('#taskUpdateForm')[0].reset();
        $.ajax({
            type: 'GET',
            url: `${baseUrl}api/task/${$(this).attr('data-value')}`,
            dataType: 'json'
        }).done(function (data) {
            $('#updateTaskModal').attr('data-value', data['id']);
            $('#updateTaskModal').find('[name="title"]').val(data['title']);
            $('#updateTaskModal').find('[name="description"]').val(data['description']);
            $('#updateTaskModal').find('[name="date"]').val(data['due_date']);
            $('#updateTaskModal').find('[name="color"]').val(data['color']);
            
            $('#updateTaskModal').find('.modal-content').css('background-color', data['color']);
            $('#updateTaskModal').find('.btn-color').find('span').removeClass('glyphicon glyphicon-ok');
            $('#updateTaskModal').find(`button[data-color="${data['color']}"]`).find('span').addClass('glyphicon glyphicon-ok');
        });
    });


    $(document).on('click', '[data-target="#viewTaskModal"], [href="#viewTaskModal"]', function () {
        $('#taskViewForm')[0].reset();

        $.ajax({
            type: 'GET',
            url: `${baseUrl}api/task/${$(this).attr('data-value')}`,
            dataType: 'json'
        }).done(function (data) {
            $('#viewTaskModal').find('.dropdown a').attr('data-value', data['id']);
            
            $('#viewTaskModal').attr('data-value', data['id']);
            $('#viewTaskModal').find('[id="title"] b').html(data['title']);
            $('#viewTaskModal').find('[id="description"] b').html(data['description']);
            $('#viewTaskModal').find('[id="date"]').html(data['due_date']);

            $(document).changeColor($('#taskViewForm').closest('.modal-content'), data['color']);
        });
    });


    $(document).on('click', '.btn-color', function () {
        $(this).find('span').addClass('glyphicon glyphicon-ok');
        $(this).siblings('.btn-color').find('span').removeClass('glyphicon glyphicon-ok');
        $(this).siblings('input[name="color"]').attr('value', $(this).attr('data-color'));
        
        $(this).closest('.modal-content').css('background-color', $(this).attr('data-color'));
    });

    // Submit

    $(document).on('click', '#taskCreateButton, #taskUpdateButton', function () {
        var task = $(`#${$(this).attr('id')}Form`).serializeArray();

        $(`#${$(this).attr('id')}Form`).find('.task-tag-list').html('');

        $.ajax({
            type: 'POST',
            url: `${baseUrl}api/task` + ($(this).attr('id') == 'taskUpdate' ? `/${$('#taskUpdateForm').attr('data-value')}` : ''),
            data: task
        }).done(function(data) {
            $(document).getTask().done(function(data){
                $(document).displayTiles(data);
            });
        });
    });

    // Mark as Done

    $(document).on('click', '.task-mark-done', function () {
        if($(this).is('.glyphicon')){
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
    </script>