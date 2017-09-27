<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/> 
        <title>Task</title>

        <link rel="stylesheet" href="https://bootswatch.com/cosmo/bootstrap.min.css" />  
        <link rel="stylesheet" type="text/css" href="/task/css/task.css" />      
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/flavored-reset-and-normalize.css" />
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/font-awesome.min.css" />
        <link rel="stylesheet" ztype="text/css" href="<?= base_url(); ?>assets/css/styles.css" />
    </head>
    <body>

        <div id="sidebar" style="overflow-y: auto; margin-left: -210px;">

            <!-- sidebar menu start-->
            <div id="nav-icon-close" class="custom-toggle">
                <span></span>
                <span></span>
            </div>

            <ul class="sidebar-menu">		
                <li class="">
                    <a class="task-create" href="#taskModifyModal" data-toggle="modal">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        <span>Add Task</span>
                    </a>
                </li>
                <li class="">
                    <a class="task-create" href="#searchTaskModal" data-toggle="modal">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <span>Search</span>
                    </a>
                </li>
                <li class="">
                    <a class="" href="<?= base_url('tasks'); ?>">
                        <i class="fa fa-tasks" aria-hidden="true"></i>
                        <span>Personal Task</span>
                    </a>    
                </li>
                <li class="sub-menu">
                    <a data-toggle="collapse" href="#UIElementsSub1" aria-expanded="false" aria-controls="UIElementsSub1" >
                        <i class="fa fa-users" aria-hidden="true"></i>
                        <span>Team Task</span>
                    </a>
                    <ul class="sub collapse" id="UIElementsSub1">
                        <?php foreach($teams as $team): ?>
                        <li><a href="<?= base_url('tasks/team/' . $team->id); ?>"><?=$team->name?></a></li>
                        <?php endforeach; ?>
                        <li><a class="team-create" href="#teamModifyModal" data-toggle="modal">Create Team</a></li>
                    </ul>
                </li>
                <li class="">
                    <a class="" href="<?= base_url('users/logout'); ?>">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
            <!-- sidebar menu end-->
        </div>

        <div class="main-content animation">
            <div class="topbar">
                <nav class="navbar navbar-custom">
                    <div id="nav-icon-open" class="custom-toggle hidden-toggle" style="display: block;">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <a class="navbar-brand" href="<?= base_url('tasks'); ?>">Task</a>

<!--
                    
<div class="box">
<div class="container-1">
<span class="icon"><i class="fa fa-search"></i></span>
<input type="search" id="search" placeholder="Search" />
</div>
</div>
-->


                    <!--                <a href="#"><span class="float-right"><i class="fa fa-user-circle fa-3x" aria-hidden="true"></i></span></a>-->

                    <!--
<div class="row">
<ul class="main-nav">
<li><a href="#"data-toggle="tooltip" title="Notifications" style="margin:5px;"><i class="fa fa-bell fa-2x" aria-hidden="true"></i></a></li>
<li><a href="#" data-toggle="popover" data-placement="bottom"  data-content="user@astridtechonologies.com"><i class="fa fa-user-circle fa-2x" aria-hidden="true"></i></a></li>
</ul>
</div>
-->

                </nav>
            </div>

            <!--  Title  -->
            <div class="container-fluid">
                <div class="d-flex flex-row">
                    <section class="long-copy">
                        <h1>My Task</h1>
                    </section>
                </div>
            </div>

<!--
            <div class="d-flex flex-row-reverse">
                <div class="row">
                    <div class="col-md-4">
                        <div class="p-4"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTaskModal"> Add Task</button></div>      
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                </div>
            </div>
-->
            <!-- List View Buttons  -->

    