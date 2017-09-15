<!DOCTYPE html>
<html>
<head>
	<title>Tasks</title>
</head>
<body>
	<?php foreach ($tasks as $task): ?>
		<div>
			<b><?= $task->title ?></b>
			<?= $task->due_date ?> /
			<?php if($status==1){ ?>
			<font color ="red"><?= $task->remaining_days ?></font> /
			<a href="<?= base_url('tasks/done/' . $task->id) ?>"> <font color = "black"><u>Mark as Done</u></font></a>
			<?php } else { ?>
			Task Completed
			<?php } ?>
			<br>
			<i><?= $task->description ?></i>
			</form>
			<div>
				<?php foreach ($task->tags as $tag): ?>
					<div>
						<?= $tag->name ?> <form method="POST" action="<?=base_url('tasks/' . $task->id . '/tags/del') ?>">
						<input type="hidden" name="name" value="<?= $tag->name ?>">
						<input type="submit" value="x"/></form>
					</div>
				<?php endforeach; ?>

				<form method="POST" action="<?= base_url('tasks/' . $task->id . '/tags/add' ) ?>">
					<textarea name="name" placeholder="body" required></textarea>
					<input type="submit" value="Add Tag" />
				</form>

				<?php foreach ($task->notes as $note): ?>
					<div>
						<?= $note->body ?>
					</div>
				<?php endforeach; ?>

				<form method="POST" action="<?= base_url('tasks/' . $task->id . '/notes/create') ?>">
					<textarea name="body" placeholder="body" reuired></textarea>
					<input type="submit" value="Create Note" />
				</form>
			</div>
		</div>
		<hr>
	<?php endforeach; ?>



	<script>
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
            if(item['title'].toLowerCase().indexOf(keyword.toLowerCase()) != -1) {
                $('#taskSearchQuery').append(
                    `<a href="#viewTaskModal" data-toggle="modal" data-value="${item['id']}" class="list-group-item task-search-item" style="background-color:${item['color']}; color:#000000;">` +
                        `<h5 class="tile-title"><b>` +
                        `<span class="glyphicon glyphicon-` + (item['status'] == 1 ? `unchecked` : `check`) + ` task-mark-done pull-top" data-value="${item['id']}"></span>` +
                        ` ${item['title']}` +
                        `<span class="glyphicon glyphicon-pencil pull-right" data-target="#updateTaskModal" data-toggle="modal" data-value="${item['id']}" data-value="${item['id']}"></span>` + 
                        `</b></h5>` +
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
                    `<div class="task-tile  container-fluid" data-toggle="modal" data-target="#viewTaskModal" data-value="${item['id']}" style="background-color:${item['color']};">` +
                        `<div class="row">` +
                            `<div class="col-md-2">` +
                                `<h4 class="pull-right"><span class="glyphicon glyphicon-` + (item['status'] == 1 ? `unchecked task-mark-done` : `check`) + ` pull-top" data-value="${item['id']}"></span></h4>` +
                            `</div>` +
                            // `<span class="glyphicon glyphicon-pencil pull-bottom pull-right" data-target="#updateTaskModal" data-toggle="modal" data-value="${item['id']}" data-value="${item['id']}"></span>` + 
                            `<div class="col-md-10">` +
                                `<h4 class="tile-title"><b>${item['title']}</b></h4>` +
                                `<p class="tile-description task-justify"><b>${item['description']}</b></p>` +
                            `</div>` +
                        `</div>` +
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
        $(document).displayTiles(data);
    });


    $('#taskSearchQuery').find('span[data-target="#updateTaskModal"]').hide();


    $('#taskSearchQuery').find('a.list-group-item').on('mouseover', function () {
        $(this).filter('span[data-target="#updateTaskModal"]').show(200);
    });


    $(document).on('input', '#taskSearch', function () {
        $(document).getTask().done(function(data){
            $(document).displayList(data, $('#taskSearch').val());
        });
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
    

    // $('#taskCreateNote').keypress(function (e) {
    //     if(e.which == 13) {
    //         $(this).parent().find('#taskCreateNoteList').append(
    //             `<li class="list-group-item">${$(this).val()}</li>`
    //         );
    //         $(this).parent().append(
    //             `<input type="hidden" name="taske_notes[]" value="${$(this).val()}" />`
    //         );
    //         $(this).val('');
    //         return false;
    //     }
    // });


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
            $('#taskViewForm').find('[id="title"] b').html(data[0]['title']);
            $('#taskViewForm').find('[id="description"] b').html(data[0]['description']);
            $('#taskViewForm').find('[id="date"]').html(data[0]['due_date']);

            $(document).changeColor($('#taskViewForm').closest('.modal-content'), data[0]['color']);
        });
    });


    $(document).on('click', '.btn-color', function () {
        $(document).changeColor($(this).closest('.modal-body'), $(this).attr('data-color'));
        $(this).find('i').addClass('glyphicon glyphicon-ok');
        $(this).siblings().find('i').removeClass('glyphicon glyphicon-ok');
        $(this).parent().find('input[name="color"]').attr('value', $(this).attr('data-color'));
    });


    $(document).on('click', '#taskCreate', function () {
        var task = $('#taskCreateForm').serializeArray();

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


    $(document).on('click', '#taskUpdate', function () {
        var task = $('#taskUpdateForm').serializeArray();

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


    $(document).on('click', '.task-mark-done', function () {
        $(this).toggleClass('glyphicon-check');
        $(this).toggleClass('glyphicon-unchecked');
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
</body>
</html>