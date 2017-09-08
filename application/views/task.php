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
            Task List <a href="#" style="pull-right glyphicon glyphicon-plus" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span></a>
        </div>
        <div class="panel-body">
            <input type="text" class="form-control" id="task-search" placeholder="Search"/>
            <div class="list-group task-container" style="overflow-y:auto;">
            </div>
        </div>
    </div>


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
                    <label>Date and Time:</label>
                    <div class="input-group">
                        <!-- <label for="due_date">Date:</label> -->
                        <input type="date" class="form-control" id="due_date" value="<?php echo date('Y-m-d'); ?>">
                        <span class="input-group-addon">-</span>
                        <!-- <label for="due_time">Date:</label> -->
                        <input type="time" class="form-control" id="due_time" value="<?php echo strtotime(date('Y-m-d')); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="color">Color:</label>
                    <button type="button" name="color" class="btn btn-default btn-circle btn-color" style="background-color:#FFFFFF;" data-color="#FFFFFF" data-accent="#000000"><i></i></button>
                    <button type="button" name="color" class="btn btn-default btn-circle btn-color" style="background-color:#AA3939;"data-color="#AA3939" data-accent="#FFFFFF"><i></i></button>
                    <button type="button" name="color" class="btn btn-default btn-circle btn-color" style="background-color:#226666;"data-color="#226666" data-accent="#FFFFFF"><i></i></button>
                    <button type="button" name="color" class="btn btn-default btn-circle btn-color" style="background-color:#2D882D;"data-color="#2D882D" data-accent="#FFFFFF"><i></i></button>
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
                    `<a href="${baseUrl}tasks/view/${item['id']}" class="list-group-item task-item" style="background-color:#${item['color']}; margin: 2px 0px;">
                        ${item['title']}
                     </a>`;

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

        $(document).on('click', '.btn-color', function(){
            $(this).closest('.modal-content').css('background-color', $(this).attr('data-color'));
            $(this).closest('.modal-content').css('color', $(this).attr('data-accent'));
            $(this).css('background-color', $(this).attr('data-color'));
            $(this).find('i').addClass('glyphicon glyphicon-ok');
            $(this).siblings().find('i').removeClass('glyphicon glyphicon-ok');
        });


        $(document).on('click', 'task-item', function(){

        });


        }); 
    </script>
</body>
</html>