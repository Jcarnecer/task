<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/> 
    <link rel="shortcut icon" href="payakapps.com/assets/images/favicon.png" type="image/x-icon">
    
    <title>Task</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Slabo+27px">

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/flavored-reset-and-normalize.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap.css'); ?>" />
    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/font-awesome.min.css'); ?>" /> -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/styles.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/paper.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/kanban.css'); ?>" />     
    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/modal.css'); ?>" /> -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/task.css'); ?>" />

</head>

<body>

<div id="sidebar" style="overflow-y: auto;">

    <div id="nav-icon-close" class="custom-toggle">
        <span></span>
        <span></span>
    </div>

    <ul class="sidebar-menu">
        <li class="">
            <a class="font-weight-bold text-warning" href="#tutorialModal" data-toggle="modal">
                <i class="fa fa-star" aria-hidden="true"></i>
                <span>Get Started</span>
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
                <i class="fa fa-folder" aria-hidden="true"></i>
                <span>Projects</span>
            </a>
            <ul class="sub collapse" id="UIElementsSub1">
                <?php foreach($projects as $project_instance): ?>
                <li><a href="<?= base_url('project/' . $project_instance->id); ?>"><i class="fa fa-file"></i> <?=$project_instance->name?></a></li>
                <?php endforeach; ?>
                <li>
                    <a class="team-create" href="#teamModifyModal" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i> Add Project</a>
                </li>
            </ul>
        </li>
        
        <li class="">
            <a class="" href="<?= ENVIRONMENT === 'development' ? 'http://localhost/main/users/logout' : 'http://payakapps.com/users/logout' ?>">
                <i class="fa fa-sign-out-alt" aria-hidden="true"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>

</div>

<div class="main-content h-100">

    <div class="topbar">
        <nav class="navbar navbar-custom clearfix">
            <div id="nav-icon-open" class="custom-toggle hidden-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <a class="navbar-brand font-weight-bold text-uppercase" href="<?= base_url('tasks'); ?>">
                <?= $task_type == 'personal' ? 'Tasks' : $project->name ?>
            </a>
            
            <span class="ml-auto">
                <a href="#" data-toggle="popover" data-placement="bottom"  data-content="<?= $email ?>" data-trigger="hover">
                    <img class="img-avatar mr-2" src="<?= $avatar_url ?>"><?= $user_name ?>
                </a>
            </span>
        </nav>
    </div>
    
    <div class="inner-content d-flex flex-column">
        <?php if($task_type == 'project'): ?>
        <!-- <div class="d-flex w-100 project-buttons">
            <a href="http://localhost/task/project/<?= $project->id ?>" class="btn btn-lg project-button w-50 rounded-0 active"><i class="fa fa-tasks"></i> Tasks</a>
            <a href="http://localhost/forum/project/<?= $project->id ?>" class="btn btn-lg project-button w-50 rounded-0"><i class="fa fa-exchange-alt"></i> Discussion</a>
        </div> -->
        <!-- <div class="dropdown show float-right">
                <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-angle-down fa-lg"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item kanban-column-edit" href="#">Edit</a>
                    <a class="dropdown-item kanban-column-delete" href="#">Delete</a>
                </div>
            </div> -->
        <ul class="nav nav-tabs d-flex flex-nowrap project-buttons">
            <li class="nav-item dropdown w-100">
                <a href="http://localhost/task/project/<?= $project->id ?>" class="nav-link dropdown-toggle project-button active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-tasks"></i> Tasks</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" id="highlightBtn"><i class="fa fa-lightbulb"></i> Highlight Tasks</a>
                    <a class="dropdown-item team-edit" data-target="#teamModifyModal" data-toggle="modal" data-value="<?= $project->id; ?>"><i class="fa fa-edit"></i> Edit Project</a>
                    <a class="dropdown-item" data-toggle="dropdown"><i class="fa fa-users"></i> Project Members <i class="fas fa-caret-right"></i></a>
                        <div class="dropdown-menu">
                            <?php foreach($project->members as $member): ?>
                            <a class="dropdown-item" href="#">
                                <?php if($project->admin == $member->id): ?>
                                <i class="fa fa-star"></i> 
                                <?php else: ?>
                                <i class="fa fa-user"></i> 
                                <?php endif; ?>
                                <?= $member->first_name.' '.$member->last_name ?>
                            </a>
                            <?php endforeach; ?>
                        </div>   
                    <a class="dropdown-item" data-value="<?= $project->id; ?>"><i class="fa fa-sign-out-alt"></i> Leave Project</a>
                </div>
            </li>
            <li class="nav-item w-100">
                <a href="<?= ENVIRONMENT === 'development' ? 'http://localhost/forum/project/' . $project->id : 'http://forum.payakapps.com/project/' . $project->id ?>" class="nav-link secondary-button"><i class="fa fa-exchange-alt"></i> Discussion</a>
            </li>
            <li class="nav-item w-100">
                <a href="<?= ENVIRONMENT === 'development' ? 'http://localhost/file/project/' . $project->id : 'http://file.payakapps.com/project/' . $project->id ?>" class="nav-link secondary-button"><i class="fa fa-file"></i> Files</a>
            </li>
        </ul>
        <?php endif; ?>
