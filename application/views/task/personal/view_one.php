<!DOCTYPE html>
<html>
<head>
	<title>Task</title>
    <link rel="stylesheet" href="https://bootswatch.com/cosmo/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/task.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- <link rel="stylesheet" type="text/css" href="css/mystyle.css"/>
    <link rel="stylesheet" type="text/css" href="css/mystyle2.css"/>
    <link rel="stylesheet" type="text/css" href="css/mystyle3.css"/> -->
</head>

<body>
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
            <form class="navbar-form navbar-right">
                <div class="form-group">
                    <input type="text" class="form-control" id="task-search" placeholder="Search"/>
                </div>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" data-toggle="modal" data-target="#createTaskModal"><span class="glyphicon glyphicon-plus"></span> Add</a></li>
            </ul>
            <!-- <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul> -->
        </div>
    </nav>

    <div class="container-fluid">
        <div class="col-md-10">
            <div class="w3-editor">
                <h1>Your Task:</h1>
            </div>
            <div class="w3-card-4 card" style="width: 70%;">
                <header class="w3-container w3-grey">
                    <div class="row">
                        <div class="col-xs-6"><h2><?=$task_details[0]->title;?></h2></div>  
                        <div class="col-xs-6" style="position: absolute; right: -50px;">
                           <li class="dropdown" style="list-style-type: none;">
                               <a class="dropdown-toggle w3-button w3-grey" style="position: absolute; right: 400px;" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-option-horizontal"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?= base_url('tasks/done/' . $task_details[0]->id) ?>">Mark as Done</a></li>
                                    </ul>
                           </li>
                           
<!--                            <a class="w3-button w3-black" href="<?= base_url('tasks/done/' . $task_details[0]->id) ?>">Mark as done</a>-->
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-xs-4"></div>
                        <div class="col-xs-4"></div>
                    </div>
                </header>
                <div class="w3-container">
                    <div class="row">
                        <div class="col-xs-6">Task Date <button type="button"><span class="glyphicon glyphicon-edit"></span></button></div>
                        <div class="col-xs-6" style="position: absolute; right: -50px;"><?=$task_details[0]->due_date ;?> <button type="button"><span class="glyphicon glyphicon-edit"></span></button></div>
                    </div>
                    
                    <hr>
                    <p>
                        <?=$task_details[0]->description;?>
                    </p>
                    <button class="w3-button w3-block w3-black" data-toggle="modal" data-target="#createTaskModal1">Add task...</button>
                </div>
            </div>
        </div>  
        
        <!--Add task bottom button sa cards -->
        <div id="createTaskModal1" class="modal fade" role="dialog">
            <div class="modal-dialog">
               <div class="modal-content" style="background-color:#ffffff; transition:0.2s;">
                   <form action="<?php echo base_url('tasks/create'); ?>" method="post">
                      <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                           <h4 class="modal-title">Add a Card</h4>
                      </div>
                       <div class="modal-body">
                           <div class="form-group">
                               <label for="title">Title:</label>
                                <input type="text" class="form-control" name="title" required>
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea class="form-control" rows="5" name="description" style="resize: none;"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="Date and Time:"></label>
                                    <div class="input-group">                                       
                                        <input type="date" class="form-control" name="due_date" value="<?php echo date('Y-m-d'); ?>">
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
                                    <input type="hidden" name="color" value="#fffff" />
                                </div>
                           </div>
                       </div>
                       <div class="modal-footer">
                            <input type="submit" class="btn btn-default" value="Add Task">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                       </div>      
                   </form>
               </div>                
            </div>
        </div>

        <div class="row" style="height:100%;">
            <div class="col-md-2" style="height:100%;">
                <div class="panel panel-default" style="height:100%;">
                    <div class="panel-heading">
                        Search
                    </div>
                    <div class="panel-body">
                        <div class="list-group task-list" style="overflow-y:auto;">

                        </div>
                    </div>
                    <div class="panel-footer">
                        &copy;Astrid
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="createTaskModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color:#ffffff; transition:0.2s;">
                <form action="<?php echo base_url('tasks/create'); ?>" method="post">    
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create Task</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" name="title" required>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" rows="5" name="description" style="resize:none;" required></textarea>
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
                            <input type="hidden" name="color" value="#fffff" />
                        </div>
                    </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-default" value="Add Task">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script src="/task/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/task/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- <script src="/task/node_modules/bootstrap/dist/css/bootstrap.min.css"></script> -->
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


        $(document).on('click', 'task-item', function(){

        });


        }); 
    </script>
</body>
</html>