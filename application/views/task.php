    <!DOCTYPE html>
<html>
<head>
	<title>Task</title>
    <link rel="stylesheet" href="https://bootswatch.com/cosmo/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/task.css" />
</head>
<body>
    <script src="/task/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/task/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        $(function() {
            

        const baseUrl = "<?= base_url() ?>";

        $.fn.getTask = function(){
            return $.ajax({
                type: 'GET',
                url: 'api/task',
                dataType: 'json'
            });
        };

        
        $.fn.displayList = function(items, keyword){
            $('#taskSearchQuery').html('');

            $.each(items, function(i, item) {
                if(item['title'].toLowerCase().indexOf(keyword.toLowerCase()) != -1 || keyword == '') {
                    $('#taskSearchQuery').append(
                        // '<div class="form-group">' +
                            `<a href="#" class="list-group-item" style="background-color:${item['color']}; color:#000000;">` +
                                `<span class="glyphicon glyphicon-unchecked task-mark-done" data-value="${item['id']}"></span>` + 
                                ` ${item['title']}` +
                                `<span class="glyphicon glyphicon-pencil pull-right" data-target="#updateTaskModal" data-toggle="modal" data-value="${item['id']}" data-value="${item['id']}"></span>` + 
                            `</a>`
                        // `</div>`
                    );
                }
            });
        };


        $.fn.displayTiles = function(items) {
            $('#taskTile').html('');

            $.each(items, function(i, item) {
                if(i%4 == 0) {
                    $('#taskTile').append('<div id="#tileRowActive" class="row" style="height: 100px;></div>');
                }
                $('#taskTile').append(
                    `<div class="col-md-3" style="padding:2px;">` +
                        `<div style="background-color:${item['color']}; color:#000000; padding:10px; min-height:100px">` +
                            `<span class="glyphicon glyphicon-unchecked task-mark-done pull-top pull-right" data-value="${item['id']}"></span>` + 
                            `<h3><b>${item['title']}<b></h3>` +
                            `<span class="glyphicon glyphicon-pencil pull-bottom pull-right" data-target="#updateTaskModal" data-toggle="modal" data-value="${item['id']}" data-value="${item['id']}"></span>` + 
                        `</div>` +
                    `</div>`
                );
                if(i%4 == 3) {
                    $('#taskTile').find('div.row').removeAttr('id');
                }
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


        });
    </script>


    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Task</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Personal</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Team <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Team 1</a></li>
                        <li><a href="#">Team 2</a></li>
                        <li><a href="#">Team 3</a></li>
                        <li><a href="#">Team 4</a></li>
                        <li><a href="#">Team 5</a></li>
                        <li><a href="#">Team 6</a></li>
                        <li><a href="#">Team 7</a></li>
                    </ul>
                </li>
            </ul>
            <!-- <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul> -->
            <form class="navbar-form navbar-right">
                <div class="form-group">
                    <input type="text" class="form-control" id="taskSearch" list="task-list" value="" placeholder="Search"/>
                    <!-- <datalist id="task-list" class="list-group task-list">

                    </datalist> -->
                </div>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" data-toggle="modal" data-target="#createTaskModal"><span class="glyphicon glyphicon-plus"></span> Add</a></li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class=" col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading">Board</div>
                    <div id="taskTile" class="panel-body container-fluid">
                        
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Search
                    </div>
                    <div class="panel-body">
                        <div id="taskSearchQuery" class="list-group">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="createTaskModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#ffffff;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create Task</h4>
                    <!-- <ul class="nav nav-pills">
                        <li class="active"><a href="#personal" data-toggle="pill">Personal</a></li>
                        <li><a href="#team" data-toggle="pill">Team</a></li>
                    </ul> -->
                </div>
                <div class="modal-body" style="background-color:#ffffff; transition:0.2s;">
                    <!-- <div class="tab-content">
                        <div id="personal" class="tab-pane fade in active" style="overflow-y:auto;"> -->
                    <form id="taskCreateForm">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" rows="5" name="description" style="resize:none;" required></textarea>
                        </div>
                        <div class="form-group" style="overflow-x:none;">
                            <label>Deadline:</label>
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="date" class="form-control" name="due_date" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-4">
                                    <input type="time" class="form-control" name="due_time" value="<?php echo date('h:i'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Notes:</label>
                            <input type="text" id="taskCreateNote" class="form-control"/>
                            <div id="taskCreateNoteList" class="list-group" style="color:#000000;">

                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tags:</label>
                            <input type="text" id="taskCreateTag" class="form-control"/>
                            <div id="taskCreateTagList" class="list-group" style="color:#000000;">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="color">Color: </label>
                            <button type="button" class="btn btn-default btn-circle btn-color" style="background-color:#FFFFFF;" data-color="#FFFFFF" data-accent="#000000"><i style="color:#000000;" class="glyphicon glyphicon-ok"></i></button>
                            <button type="button" class="btn btn-default btn-circle btn-color" style="background-color:#2196f3;" data-color="#2196f3" data-accent="#FFFFFF"><i style="color:#000000;"></i></button>
                            <button type="button" class="btn btn-default btn-circle btn-color" style="background-color:#f44336;" data-color="#f44336" data-accent="#FFFFFF"><i style="color:#000000;"></i></button>
                            <button type="button" class="btn btn-default btn-circle btn-color" style="background-color:#4caf50;" data-color="#4caf50" data-accent="#FFFFFF"><i style="color:#000000;"></i></button>
                            <button type="button" class="btn btn-default btn-circle btn-color" style="background-color:#ffeb3b;" data-color="#ffeb3b" data-accent="#000000"><i style="color:#000000;"></i></button>
                            <button type="button" class="btn btn-default btn-circle btn-color" style="background-color:#ff9800;" data-color="#ff9800" data-accent="#000000"><i style="color:#000000;"></i></button>
                            <input type="hidden" name="color" value="#ffffff" />
                        </div>
                    </form>
                        <!-- </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" id="taskCreate" class="btn btn-default" data-dismiss="modal">Add Task</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div id="updateTaskModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#ffffff;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Task</h4>
                </div>
                <div class="modal-body" style="background-color:#ffffff; transition:0.2s;">
                    <!-- <div class="tab-content">
                        <div id="personal" class="tab-pane fade in active" style="overflow-y:auto;"> -->
                    <form id="taskUpdateForm">
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" rows="5" name="description" style="resize:none;" required></textarea>
                        </div>
                        <div class="form-group" style="overflow-x:none;">
                            <label>Deadline:</label>
                            <div class="row">
                                <div class="col-md-8">
                                    <input type="date" class="form-control" name="due_date" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-4">
                                    <input type="time" class="form-control" name="due_time" value="<?php echo date('h:i'); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Notes:</label>
                            <input type="text" id="taskUpdateNote" class="form-control"/>
                            <div id="taskUpdateNoteList" class="list-group" style="color:#000000;">

                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tags:</label>
                            <input type="text" id="taskUpdateTag" class="form-control"/>
                            <div id="taskUpdateTagList" class="list-group" style="color:#000000;">

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="color">Color: </label>
                            <button type="button" class="btn btn-default btn-circle btn-color" style="background-color:#ffffff;" data-color="#ffffff"><i style="color:#000000;" class="glyphicon glyphicon-ok"></i></button>
                            <button type="button" class="btn btn-default btn-circle btn-color" style="background-color:#2196f3;" data-color="#2196f3"><i style="color:#000000;"></i></button>
                            <button type="button" class="btn btn-default btn-circle btn-color" style="background-color:#f44336;" data-color="#f44336"><i style="color:#000000;"></i></button>
                            <button type="button" class="btn btn-default btn-circle btn-color" style="background-color:#4caf50;" data-color="#4caf50"><i style="color:#000000;"></i></button>
                            <button type="button" class="btn btn-default btn-circle btn-color" style="background-color:#ffeb3b;" data-color="#ffeb3b"><i style="color:#000000;"></i></button>
                            <button type="button" class="btn btn-default btn-circle btn-color" style="background-color:#ff9800;" data-color="#ff9800"><i style="color:#000000;"></i></button>
                            <input type="hidden" name="color" value="#ffffff" />
                        </div>
                    </form>
                        <!-- </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" id="taskUpdate" class="btn btn-default" data-dismiss="modal">Add Task</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(function () {


        $(document).getTask().done(function(data) {
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


        $(document).on('click', 'span[data-target="#updateTaskModal"]', function () {
            $('#taskUpdateForm')[0].reset();
            $.ajax({
                type: 'GET',
                url: `api/task/${$(this).attr('data-value')}`,
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

            $.ajax({
                type: 'POST',
                url: 'api/task',
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
                url: `api/task/${$('#taskUpdateForm').attr('data-value')}`,
                data: task
            }).done(function(data) {
                $(document).getTask().done(function(data){
                    $(document).displayList(data,'');
                });
            });
        });

        $(document).on('click', '.task-mark-done', function () {
            $(this).toggleClass('glyphicon-check');
            $(this).toggleClass('glyphicon-unchecked');
        });

        }); 
    </script>
</body>
</html>