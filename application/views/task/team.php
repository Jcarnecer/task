    <div class="jumbotron text-center">
        <h1><?= $team_name; ?></h1>
        <p>
            <?php foreach($team_members as $team_member): ?>
                <?= $team_member->first_name . ' ' . $team_member->last_name ?>
            <?php endforeach; ?>
        </p> 
    </div>

    <div class="container-fluid"> 
        <div id="taskTileList" class="row">

        </div>
    </div>