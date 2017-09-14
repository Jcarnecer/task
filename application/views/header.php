<!DOCTYPE html>
<html>
<head>
	<title>Task</title>
    <link rel="stylesheet" href="https://bootswatch.com/cosmo/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/task.css" />
</head>
<body>
    <script src="/task/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="/task/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

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