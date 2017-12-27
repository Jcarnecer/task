<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/> 
    
    <title>Task</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Slabo+27px">

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/flavored-reset-and-normalize.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/font-awesome.min.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/styles.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/paper.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/kanban.css'); ?>" />     
    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/modal.css'); ?>" /> -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/task.css'); ?>" />

</head>

<body>

<div id="sidebar" style="overflow-y: auto; margin-left: -210px;">

    <div id="nav-icon-close" class="custom-toggle">
        <span></span>
        <span></span>
    </div>

    <ul class="sidebar-menu">		
        <li class="">
            <a class="task-create" href="#taskSearchModal" data-toggle="modal">
                <i class="fa fa-search" aria-hidden="true"></i>
                <span>Search</span>
            </a>
        </li>
        
        <li class="">
            <a class="" href="<?= base_url('personal'); ?>">
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
                <li><a href="<?= base_url('team/' . $team->id); ?>"><?=$team->name?></a></li>
                <?php endforeach; ?>
                <li>
                    <a class="team-create" href="#teamModifyModal" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> Create Team</a>
                </li>
            </ul>
        </li>
        
        <li class="">
            <a class="" href="<?= base_url('users/logout') ?>">
                <i class="fa fa-sign-out" aria-hidden="true"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>

</div>

<div class="main-content animation">

    <div class="topbar">
        <nav class="navbar navbar-custom clearfix">
            <div id="nav-icon-open" class="custom-toggle hidden-toggle d-block">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <a class="navbar-brand" href="<?= base_url('tasks'); ?>">Task</a>
            
            <span class="ml-auto">
                <a class="navbar-brand" href="#taskSearchModal" data-toggle="modal"><i class="fa fa-search"></i> Search</a>
                <a class="navbar-brand" href="#" data-toggle="popover" data-placement="bottom"  data-content="<?= $email ?>" data-trigger="hover">
                    <!-- <i class="fa fa-user-circle"></i> <?= $user_name ?> -->
                    <img class="img-avatar" src="<?= $avatar_url ?>"> <?= $user_name ?>
                </a>
            </span>
        </nav>
    </div>
    
    <div class="inner-content">