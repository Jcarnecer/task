<!DOCTYPE html>
<html>
<head>
	<title>Task</title>
    <link rel="stylesheet" href="https://bootswatch.com/cosmo/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/task/css/task.css" />
</head>
<body>
        <script src="/task/node_modules/jquery/dist/jquery.min.js"></script>
        <script src="/task/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/task/script/task.js"></script>

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
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#" data-toggle="modal" data-target="#createTaskModal"><span class="glyphicon glyphicon-plus"></span> Add</a></li>
                <li><a href="#" data-toggle="modal" data-target="#searchTaskModal"><span class="glyphicon glyphicon-search"></span> Search</a></li>
            </ul>
        </div>
    </nav>