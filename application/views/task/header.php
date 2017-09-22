<!DOCTYPE html>
<html>
<head>
	<title>Task</title>
    <link rel="stylesheet" href="https://bootswatch.com/cosmo/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/task/css/task.css" />
</head>
<body style="padding-top:50px;">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Task</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="<?= base_url('tasks'); ?>">Home</a></li>
                <li><a href="#">Personal</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Team <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach($teams as $team): ?>
                            <li><a href="<?= base_url('tasks/team/' . $team->id); ?>"><?=$team->name?></a></li>
                        <?php endforeach; ?>
                        <li><a href="#teamCreateModal" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span> Create Team</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a class="team-create" href="#teamModifyModal" data-toggle="modal"><span class="glyphicon glyphicon-user"></span> Create Team</a></li>
                <li><a class="task-create" href="#taskModifyModal" data-toggle="modal"><span class="glyphicon glyphicon-plus"></span> Add Task</a></li>
                <li><a href="#searchTaskModal" data-toggle="modal"><span class="glyphicon glyphicon-search"></span> Search</a></li>
            </ul>
        </div>
    </nav>