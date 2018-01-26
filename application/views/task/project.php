<div id="deleteTaskModal" ondrop="deleteTask(event)" ondragover="allowDrop(event)" class="d-none card position-fixed bg-dark text-white rounded w-50" style="z-index: 9999; top: 10%; left: 25%; height: 15%">
    <div class="card-body d-flex justify-content-center align-items-center">
        <h1 class="card-title">
            <i class="fa fa-archive"></i> Archive Task
        </h1>
    </div>
</div>

<div id="kanbanBoard" class="d-flex flex-column bg-primary h-100 w-100 m-0 p-0">
    <div class="d-flex w-100">
        <button class="btn btn-primary  rounded-0" data-target="#taskSearchModal" data-toggle="modal" style="width: 20%;">
            <i class="fa fa-search"></i> Search Tasks
        </button>

        <button id="highlightBtn" class="btn btn-primary  rounded-0" style="width: 20%;">
            <i class="fa fa-lightbulb"></i> Highlight Tasks
        </button>

        <button class="team-edit btn btn-primary  rounded-0" data-target="#teamModifyModal" data-toggle="modal" data-value="<?= $project->id; ?>" style="width: 20%;">
            <i class="fa fa-edit"></i> Edit Project
        </button>

        <!-- <div class="dropdown rounded-0 border-0 h-100" style="width: 20%;"> -->
        <button class="btn btn-primary  rounded-0" data-toggle="dropdown" style="width: 20%">
            <i class="fa fa-users"></i> Project Members
        </button>

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
        <!-- </div> -->

        <button class="team-leave btn btn-primary  rounded-0" data-value="<?= $project->id; ?>" style="width: 20%;">
            <i class="fa fa-sign-out-alt"></i> Leave Project
        </button>
    </div>

    <div class="h-100 bg-light border-top" style="overflow-x: auto; box-shadow: 0 -3px 6px rgba(0, 0, 0, 0.1);">
        <div class="card-group h-100 m-0 p-0"></div>
    </div>
</div>