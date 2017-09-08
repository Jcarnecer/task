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
    <div class="panel panel-default" style="height:100%; width:20%; position:fixed;">
        <div class="panel-heading">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Task List
                <span class="caret"></span>
                </button>
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span></button>
                <ul class="dropdown-menu">
                    <li><a href="#">Personal</a></li>
                    <li><a href="#">Team</a></li>
                    <!-- <li><a href="#">JavaScript</a></li> -->
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <input type="text" class="form-control" id="task-search" placeholder="Search"/>
            <div class="list-group task-list" style="overflow-y:auto;">
            </div>
        </div>
    </div>


    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content" style="background-color:#ffffff; transition:0.2s;">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Create Task</h4>
            </div>
            <form action="<?php echo base_url('tasks/create'); ?>" method="post">
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" name="title" required>
                </dir>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" rows="5" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label>Date and Time:</label>
                    <div class="input-group">
                        <!-- <label for="due_date">Date:</label> -->
                        <input type="date" class="form-control" name="due_date" value="<?php echo date('Y-m-d'); ?>">
                        <span class="input-group-addon"></span>
                        <!-- <label for="due_time">Date:</label> -->
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
                    <input type="hidden" name="color" />
                </div>
            </div>
            <div class="modal-footer">
            <input type="submit" class="btn btn-default" value="Add Task">
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
        const baseUrl = "<?= base_url() ?>";

        $.fn.displayList = function(list, keyword){
            $('.task-container').html('');

            $.each(list, function(i, item) {
                if(item['title'].toLowerCase().indexOf(keyword.toLowerCase()) != -1 || keyword == '') {
                    var append = 
                    `<a href="${baseUrl}tasks/view/${item['id']}" class="list-group-item task-list-item" style="background-color:${item['color']};">
                        ${item['title']}
                     </a>`;

                    $('.task-list').append(append);
                }
            });
        }


        $(document).displayList(userTask, '');


        $(document).on('input', '#task-color', function () {
            $('.task-submit-panel').css('background-color', '#' + $(this).val());
        });


        $(document).on('input', '#task-search', function () {
            $('.task-list').html('');
            $(document).displayList(userTask, $(this).val());
        });
        

        $(document).on('click', '.task-item-delete', function() {
            $(this).parent().remove();
        });

        $(document).on('click', '.btn-color', function(){
            $(this).closest('.modal-content').css('background-color', $(this).attr('data-color'));
            $(this).closest('.modal-content').css('color', $(this).attr('data-accent'));
            // $(this).closest('.modal-content').css('transition', '0.2s');
            $(this).css('background-color', $(this).attr('data-color'));
            // $(this).css('backgroundtransition', '0.2s');
            $(this).find('i').addClass('glyphicon glyphicon-ok');
            $(this).siblings().find('i').removeClass('glyphicon glyphicon-ok');
            $(this).parent().find('input[name="color"]').attr('value', $(this).attr('data-color'));
        });


        $(document).on('click', 'task-item', function(){

        });


        }); 
    </script>
</body>
</html>