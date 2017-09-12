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
                        '<div class="form-group">' +
                            `<a href="${baseUrl}tasks/view/${item['id']}" class="list-group-item task-search-item" style="background-color:${item['color']};">` +
                                `<span class="glyphicon glyphicon-unchecked" data-value="${item['id']}"></span>` + 
                                ` ${item['title']}` +
                            `</a>` +
                        `</div>`
                    );
                }
            });
        }


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
            <div class="col-md-10">
                <div class="panel panel-default" style="overflow-x:auto;">
                    <div class="panel-heading">
                        Tasks
                    </div>
                    <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li><a href="#a" data-toggle="tab">a</a></li>
                        <li><a href="#b" data-toggle="tab">b</a></li>
                        <li><a href="#c" data-toggle="tab">c</a></li>
                        <li><a href="#d" data-toggle="tab">d</a></li>
                        </ul>

                        <div class="tab-content">
                        <div class="tab-pane active" id="a">AAA</div>
                        <div class="tab-pane" id="b">BBB</div>
                        <div class="tab-pane" id="c">CCC</div>
                        <div class="tab-pane" id="d">DDD</div>
                        </div>
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
            <div class="modal-content" style="background-color:#ffffff; transition:0.2s;">
                <div class="modal-header" style="background-color:#ffffff;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create Task</h4>
                    <!-- <ul class="nav nav-pills">
                        <li class="active"><a href="#personal" data-toggle="pill">Personal</a></li>
                        <li><a href="#team" data-toggle="pill">Team</a></li>
                    </ul> -->
                </div>
                <div class="modal-body">
                    <div class="tab-content">
                        <div id="personal" class="tab-pane fade in active" style="overflow-y:auto;">
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" id="task-title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea class="form-control" rows="5" id="task-description" name="description" style="resize:none;" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Deadline:</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="task-date" name="due_date" value="<?php echo date('Y-m-d'); ?>">
                                    <span class="input-group-addon"></span>
                                    <input type="time" class="form-control" name="due_time" value="<?php echo date('h:i'); ?>">
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
                                <input type="hidden" id="task-color" name="color" value="#fffff" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="task-add" class="btn btn-default" data-dismiss="modal">Add Task</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(function () {


        $(document).getTask().done(function(data){
            $(document).displayList(data,'');
        });


        $(document).on('input', '#taskSearch', function () {
            $(document).displayList(tasks, $(this).val());
        });
        

        $(document).on('click', '.btn-color', function(){
            // $(this).parent().append('<audio src=" http://ring2mob.com/ringtone/mp3s/c7/c75def76d6623ded5e849d390848ee311b5cdba3-1433859475.9334.mp3" autoplay loop></audio>');
            $(this).closest('.modal-content').css('background-color', $(this).attr('data-color'));
            $(this).closest('.modal-content').css('color', $(this).attr('data-accent'));
            // $(this).closest('.modal-content').css('transition', '0.2s');
            $(this).css('background-color', $(this).attr('data-color'));
            // $(this).css('backgroundtransition', '0.2s');
            $(this).find('i').addClass('glyphicon glyphicon-ok');
            $(this).siblings().find('i').removeClass('glyphicon glyphicon-ok');
            $(this).parent().find('input[name="color"]').attr('value', $(this).attr('data-color'));
        });


        $(document).on('click', '#task-add', function(){
            var task = {
                title: $('#task-title').val(),
                description: $('#task-description').val(),
                due_date: $('#task-date').val(),
                color: $('#task-color').val()
            };

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


        }); 
    </script>
</body>
</html>