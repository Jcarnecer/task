<!DOCTYPE html>
<html>
<head>
	<title></title>
    <link rel="stylesheet" href="https://bootswatch.com/cosmo/bootstrap.min.css" />
    <!--<link rel="stylesheet" href="https://bootswatch.com/flatly/bootstrap.min.css"/> -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="css/task.css" />
    <link rel="stylesheet" type="text/css" href="css/mystyle.css"/>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="main-nav">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">To do mo to'</a>
            </div>
        </div>
    </nav>
    <div class="container" style="width:200px; position:fixed; overflow-y: scroll;">
        <h4>Create Task</h4>
        <div class="task-submit-panel">
            <form method="POST" action="<?php echo base_url('tasks/create'); ?>">
                <div>
                    <label>Title</label>
                    <input type="text" name="title" placeholder="Title" />
                </div>
                <div>
                    <label>Description</label>
                    <textarea name="description" placeholder="Description"></textarea>
                </div>
                <div>
                    <label>Due Date</label>
                    <input type="date" name="due_date" value="<?php echo date('Y-m-d'); ?>" />
                </div>
                <div>
                    <label>Color</label>
                    <input type="text" name="color" id="task-color" />
                </div>
                <br/>
                <div>
                    <input type="submit" value="Create" />
                </div>
            </form>
        </div>
        <hr />

        <h4>Task List <a href="#" data-toggle="modal" data-target="#myModal">&plus;</a></h4>
        <input type="text" id="task-search" />
        <div class="list-group task-container" style="overflow-y:scroll; height:400px;">

        </div>
    </div>

    <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Create Task</h4>
            </div>
            <form action="<?php echo base_url('tasks/create'); ?>" method="post">
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" required>
                </dir>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" rows="5" id="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="due_date">Date:</label>
                    <input type="date" class="form-control" id="due_date" required>
                </div>
                <div class="form-group">
                    <label for="color">Color:</label>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-circle btn-color" data-color="#AA3939"></button>
                        <button type="button" class="btn btn-default btn-circle btn-color" data-color="#226666"></button>
                        <button type="button" class="btn btn-default btn-circle btn-color" data-color="#2D882D"></button>
                        <!-- <button type="button" class="btn btn-color" data-value="#"></button> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <input type="submit" class="btn btn-info" value="Add Task">
            </form>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    
        </div>
    </div>

    <script src="/task/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/task/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/task/node_modules/bootstrap/dist?/css/bootstrap.min.css"></script>
    <script>
        $(function () {


        var userTask = <?php echo json_encode($tasks); ?>;


        $.fn.displayList = function(list, keyword){
            $('.task-container').html('');

            $.each(list, function(i, item) {
                if(item['title'].toLowerCase().indexOf(keyword.toLowerCase()) != -1 || keyword == '') {
                    var append = 
                    '<a href="#" class="list-group-item task-item" style="background-color:#' + item['color'] + '; margin: 2px 0px;">' +
                        // '<a href="#"><span class="glyphicon glyphicon-envelope"></span></a>' +
                        item['title'] + 
                        // '<span class="badge"><button type="button" class="btn btn-xs">&times;</button></span>' + 
                    '</a>';

                    $('.task-container').append(append);
                }
            });
        }


        $(document).displayList(userTask, '');


        $(document).on('input', '#task-color', function () {
            $('.task-submit-panel').css('background-color', '#' + $(this).val());
        });


        $(document).on('input', '#task-search', function () {
            $(document).displayList(userTask, $(this).val());
        });
        

        $(document).on('click', '.task-item-delete', function() {
            $(this).parent().remove();
        });


        $(document).on('click', 'task-item', function(){

        });


        }); 
    </script>
</body>
</html>