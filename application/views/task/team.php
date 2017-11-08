<div class="container-fluid text-center text-light bg-info m-0 p-4" style="height: 160px;">
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

<div id="kanbanBoard" class="w-100 m-0 p-0" style="height: calc(100% - 160px); overflow-x: auto;">
    <div class="card-group h-100 m-0 p-0"></div>
</div>