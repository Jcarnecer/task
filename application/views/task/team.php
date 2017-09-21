    <div class="jumbotron text-center">
        <h1 style="font-weight:800;"><?= $team->name; ?> <a class="team-edit" href="#teamModifyModal" data-toggle="modal" data-value="<?= $team->id; ?>"><span class="glyphicon glyphicon-edit"></span></a></h1>
        <p style="font-weight:500;">
            <?php foreach($team->members as $team_member): ?>
                <?= $team_member->first_name . ' ' . $team_member->last_name ?>
            <?php endforeach; ?>
        </p> 
    </div>

    <div class="container-fluid task-tag-board"> 
        <div id="taskTileList" class="row">

        </div>
    </div>