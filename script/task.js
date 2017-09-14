$(function () {


    const baseUrl = "<?= base_url() ?>";

    
    $.fn.getTask = function(){
        return $.ajax({
            type: 'GET',
            url: `${baseUrl}api/task`,
            dataType: 'json'
        });
    };

    
    $.fn.displayList = function(items, keyword){
        $('#taskSearchQuery').html('');

        $.each(items, function(i, item) {
            if(item['title'].toLowerCase().indexOf(keyword.toLowerCase()) != -1 || keyword == '') {
                $('#taskSearchQuery').append(
                    `<a href="#viewTaskModal" data-toggle="modal" data-value="${item['id']}" class="list-group-item" style="background-color:${item['color']}; color:#000000;">` +
                        `<span class="glyphicon glyphicon-unchecked task-mark-done" data-value="${item['id']}"></span>` + 
                        ` ${item['title']}` +
                        `<span class="glyphicon glyphicon-pencil pull-right" data-target="#updateTaskModal" data-toggle="modal" data-value="${item['id']}" data-value="${item['id']}"></span>` + 
                    `</a>`
                );
            }
        });
    };


    $.fn.displayTiles = function(items, rowNumber = 3) {
        $('#taskTile').html('');

        rowNumber = 12/rowNumber;

        $.each(items, function(i, item) {
            $('#taskTile').append(
                `<div class="col-md-${rowNumber}" style="padding:3px;">` +
                    `<div class="task-tile" data-toggle="modal" data-target="#viewTaskModal" data-value="${item['id']}" style="background-color:${item['color']};">` +
                        `<h4><b>` + 
                            `<span class="glyphicon glyphicon-unchecked task-mark-done pull-top" data-value="${item['id']}"></span>` +
                            ` ${item['title']}` +
                            `<span class="glyphicon glyphicon-pencil pull-bottom pull-right" data-target="#updateTaskModal" data-toggle="modal" data-value="${item['id']}" data-value="${item['id']}"></span>` + 
                        `</b></h4>` +
                        `<p class="small task-tile-description task-justify">${item['description']}</p>` +
                    `</div>` +
                `</div>`
            );
        });
    };


    $.fn.changeColor = function($element, color){
        $element.css('background-color', color);
        switch(color.toLowerCase()){
            case '#ffffff': $element.css('color', '#000000'); break;
            case '#2196f3': $element.css('color', '#ffffff'); break;
            case '#f44336': $element.css('color', '#ffffff'); break;
            case '#4caf50': $element.css('color', '#ffffff'); break;
            case '#ffeb3b': $element.css('color', '#000000'); break;
            case '#ff9800': $element.css('color', '#000000'); break;
        }
    };


    
    $(document).getTask().done(function (data) {
        $(document).displayList(data,'');
        $(document).displayTiles(data);
    });


    $('#taskSearchQuery').find('span[data-target="#updateTaskModal"]').hide();


    $('#taskSearchQuery').find('a.list-group-item').on('mouseover', function () {
        $(this).filter('span[data-target="#updateTaskModal"]').show(200);
    });


    $('#taskSearch').keypress(function (e) {
        if(e.which == 13) {
            $(document).getTask().done(function(data){
                $(document).displayList(data, $('#taskSearch').val());
            });
            return false;
        }    
    });


    $('#taskCreateTag').keypress(function (e) {
        if(e.which == 13) {
            $(this).parent().find('#taskCreateTagList').append(
                `<li class="list-group-item">${$(this).val()}</li>`
            );
            $(this).parent().append(
                `<input type="hidden" name="task_tags[]" value="${$(this).val()}" />`
            );
            $(this).val('');
            return false;
        }
    });
    

    $('#taskCreateNote').keypress(function (e) {
        if(e.which == 13) {
            $(this).parent().find('#taskCreateNoteList').append(
                `<li class="list-group-item">${$(this).val()}</li>`
            );
            $(this).parent().append(
                `<input type="hidden" name="taske_notes[]" value="${$(this).val()}" />`
            );
            $(this).val('');
            return false;
        }
    });


    $('#taskUpdateTag').keypress(function (e) {
        if(e.which == 13) {
            $(this).parent().find('#taskUpdateTagList').append(
                `<li class="list-group-item">${$(this).val()}</li>`
            );
            $(this).parent().append(
                `<input type="hidden" name="task_tags[]" value="${$(this).val()}" />`
            );
            $(this).val('');
            return false;
        }
    });
    

    $('#taskUpdateNote').keypress(function (e) {
        if(e.which == 13) {
            $(this).parent().find('#taskUpdateNoteList').append(
                `<li class="list-group-item">${$(this).val()}</li>`
            );
            $(this).parent().append(
                `<input type="hidden" name="task_notes[]" value="${$(this).val()}" />`
            );
            $(this).val('');
            return false;
        }
    });


    $(document).on('click', '[data-target="#updateTaskModal"], [href="#updateTaskModal"]', function () {
        $('#taskUpdateForm')[0].reset();
        $.ajax({
            type: 'GET',
            url: `${baseUrl}api/task/${$(this).attr('data-value')}`,
            dataType: 'json'
        }).done(function (data) {
            $('#taskUpdateForm').attr('data-value', data[0]['id']);
            $('#taskUpdateForm').find('input[name="title"]').val(data[0]['title']);
            $('#taskUpdateForm').find('textarea[name="description"]').val(data[0]['description']);
            $('#taskUpdateForm').find('input[name="date"]').val(data[0]['due_date']);
            $('#taskUpdateForm').find('input[name="color"]').val(data[0]['color']);

            $(document).changeColor($('#taskUpdateForm').closest('.modal-body'), data[0]['color']);
            $('#taskUpdateForm').find('.btn-color').find('i').removeClass('glyphicon glyphicon-ok');
            $('#taskUpdateForm').find(`button[data-color="${data[0]['color']}"]`).find('i').addClass('glyphicon glyphicon-ok');
        });
    });


    $(document).on('click', '[data-target="#viewTaskModal"]', function () {
        $('#taskViewForm')[0].reset();
        $.ajax({
            type: 'GET',
            url: `${baseUrl}api/task/${$(this).attr('data-value')}`,
            dataType: 'json'
        }).done(function (data) {
            $('#viewTaskModal').find('a[href="#updateTaskModal"]').attr('data-value', data[0]['id']);

            $('#taskViewForm').attr('data-value', data[0]['id']);
            $('#taskViewForm').find('[id="title"]').html(data[0]['title']);
            $('#taskViewForm').find('[id="description"]').html(data[0]['description']);
            $('#taskViewForm').find('[id="date"]').html(data[0]['due_date']);

            $(document).changeColor($('#taskViewForm').closest('.modal-body'), data[0]['color']);
        });
    });


    $(document).on('click', '.btn-color', function () {
        $(this).parent().find('audio').remove();
        $(this).parent().append('<audio src=" http://ring2mob.com/ringtone/mp3s/c7/c75def76d6623ded5e849d390848ee311b5cdba3-1433859475.9334.mp3" autoplay></audio>');
        $(document).changeColor($(this).closest('.modal-body'), $(this).attr('data-color'));
        $(this).find('i').addClass('glyphicon glyphicon-ok');
        $(this).siblings().find('i').removeClass('glyphicon glyphicon-ok');
        $(this).parent().find('input[name="color"]').attr('value', $(this).attr('data-color'));
    });


    $(document).on('click', '#taskCreate', function () {
        var task = $('#taskCreateForm').serializeArray();

        console.log(task);

        $.ajax({
            type: 'POST',
            url: `${baseUrl}api/task`,
            data: task
        }).done(function(data) {
            $(document).getTask().done(function(data){
                $(document).displayList(data,'');
            });
        });
    });


    $(document).on('click', '#taskUpdate', function () {
        var task = $('#taskUpdateForm').serializeArray();

        $.ajax({
            type: 'POST',
            url: `${baseUrl}api/task/${$('#taskUpdateForm').attr('data-value')}`,
            data: task
        }).done(function(data) {
            $(document).getTask().done(function(data){
                $(document).displayList(data,'');
                $(document).displayTiles(data);
            });
        });
    });


    $(document).on('click', '.task-mark-done', function () {
        $(this).toggleClass('glyphicon-check');
        $(this).toggleClass('glyphicon-unchecked');

        $.ajax({
            type: 'POST',
            url: `${baseUrl}api/done/${$(this).attr('data-value')}`,
        }).done(function(data) {
            $(document).getTask().done(function(data){
                $(document).displayList(data,'');
                $(document).displayTiles(data);
            });
        });
    });

}); 