<div id="kanbanBoard" class="d-flex flex-column h-100 w-100 m-0 p-0">
    <!-- <div class="d-flex w-100 mb-4">
        <button class="btn secondary-button rounded-0" data-target="#taskSearchModal" data-toggle="modal" style="width: 20%;">
            <i class="fa fa-search"></i> Search Tasks
        </button>

        <button id="highlightBtn" class="btn secondary-button rounded-0" style="width: 20%;">
            <i class="fa fa-lightbulb"></i> Highlight Tasks
        </button>

        <button class="team-edit btn secondary-button rounded-0" data-target="#teamModifyModal" data-toggle="modal" data-value="<?= $project->id; ?>" style="width: 20%;">
            <i class="fa fa-edit"></i> Edit/View Project
        </button>

        
        <button class="btn secondary-button rounded-0" data-toggle="dropdown" style="width: 20%">
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
        

        <button class="team-leave btn secondary-button rounded-0" data-value="<?= $project->id; ?>" style="width: 20%;">
            <i class="fa fa-sign-out-alt"></i> Leave Project
        </button>
    </div> -->

    <div class="h-100 bg-light border-top" style="overflow-x: auto;">
        <div class="card-group h-100 m-0 p-0"></div>
    </div>
</div>