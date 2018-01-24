<div id="deleteTaskModal" ondrop="deleteTask(event)" ondragover="allowDrop(event)" class="d-none card position-fixed bg-dark text-white rounded w-50" style="z-index: 9999; top: 10%; left: 25%; height: 15%">
    <div class="card-body d-flex justify-content-center align-items-center">
        <h1 class="card-title">
            <i class="fa fa-archive"></i> Archive Task
        </h1>
    </div>
</div>

<div class="container-fluid text-center text-light bg-primary m-0 p-3" style="height: 160px;">
    <div class="row justify-content-center">
        <div class="col-12">
            <h1 class="text-center"><?= $team->name ?></h1>
        </div>
        <div class="w-100"></div>
        <div class="col-12">
            <h6>
            <?php foreach($team->members as $team_member): ?>
                <span class="badge badge-dark"><?= $team_member->first_name . ' ' . $team_member->last_name ?></span>
            <?php endforeach; ?>
            </h6>
        </div>
        <div class="w-100"></div>
        <div class="col-12">
            <div class="btn-group btn-group-sm">
                <button id="highlightBtn" type="button" class="btn btn-success">
                    <i class="fa fa-eye"></i> Highlight Tasks
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
</div>

<div id="kanbanBoard" class="w-100 m-0 p-0" style="height: calc(100% - 160px); overflow-x: auto;">
    <div class="card-group h-100 m-0 p-0"></div>
</div>