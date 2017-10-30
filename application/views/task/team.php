<!-- <div class="jumbotron text-center">
    <h1 style="font-weight:800;"><?= $team->name; ?></h1>
    <h4 style="font-weight:500;">
        <?php foreach($team->members as $team_member): ?>
            &lt;<?= $team_member->first_name . ' ' . $team_member->last_name ?> /&gt;
        <?php endforeach; ?>
            
    </h4> 
    <h5 style="font-weight:500;"><a class="team-edit" style="color:#101010;" href="#teamModifyModal" data-toggle="modal" data-value="<?= $team->id; ?>"><span class="glyphicon glyphicon-edit"></span> Edit Group</a></h5>
    <h5 style="font-weight:500;"><a class="team-leave" style="color:#101010;" href="#" data-value="<?= $team->id; ?>"><span class="glyphicon glyphicon-log-out"></span> Leave Group</a></h5>
</div> -->

<!-- <div class="addTaskSearch" >
    <a class="task-create" href="#taskModifyModal" data-toggle="modal" style="color: inherit;">
        <input type="text" id="taskSearch" placeholder="Add Task...">  
    </a>
</div> -->

<div class="container-fluid text-center text-light h-25 bg-info m-0 p-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="text-center"><?= $team->name ?></h2>
        </div>
        <div class="w-100"></div>
        <div class="col-12">
            <h5>
            <?php foreach($team->members as $team_member): ?>
                <span class="badge badge-dark"><?= $team_member->first_name . ' ' . $team_member->last_name ?></span>
            <?php endforeach; ?>
            </h5>
        </div>
        <div class="w-100"></div>
        <div class="col-12">
            <button id="highlightBtn" type="button" class="btn btn-success">
                <i class="fa fa-eye"></i> My Tasks
            </button>

            <button type="button" class="team-edit btn btn-warning" data-target="#teamModifyModal" data-toggle="modal" data-value="<?= $team->id; ?>">
                <i class="fa fa-edit"></i> Edit Group
            </button>

            <button type="button" class="team-leave btn btn-danger" data-value="<?= $team->id; ?>">
                <i class="fa fa-sign-out"></i> Leave Group
            </button>
        </div>
    </div>
</div>

<div id="kanbanBoard" class="container-fluid h-75 m-0 p-0">
    <div class="row h-100">
        <div class="col-4 h-100 p-0">
            <div id="todoTask" class="card h-100 border-0 rounded-0 bg-warning">
                <h2 class="card-header text-center">Pending</h2>
                <div class="card-body" style="overflow-y: auto;">
                </div>
            </div>
        </div>
        <div class="col-4 h-100 p-0">
            <div id="doingTask" class="card h-100 border-0 rounded-0 bg-danger">
                <h2 class="card-header text-center">In Progress</h2>
                <div class="card-body" style="overflow-y: auto;">

                </div>
            </div>
        </div>
        <div class="col-4 h-100 p-0">
            <div id="doneTask" class="card h-100 border-0 rounded-0 bg-success">
                <h2 class="card-header text-center">Done</h2>
                <div class="card-body" style="overflow-y: auto;">
                    
                </div>
            </div>
        </div>
    </div>
</div>