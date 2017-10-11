    <div class="jumbotron text-center">
        <h1 style="font-weight:800;"><?= $team->name; ?></h1>
        <h4 style="font-weight:500;">
            <?php foreach($team->members as $team_member): ?>
                &lt;<?= $team_member->first_name . ' ' . $team_member->last_name ?> /&gt;
            <?php endforeach; ?>
             
        </h4> 
        <h5 style="font-weight:500;"><a class="team-edit" style="color:#101010;" href="#teamModifyModal" data-toggle="modal" data-value="<?= $team->id; ?>"><span class="glyphicon glyphicon-edit"></span> Edit Group</a></h5>
        <h5 style="font-weight:500;"><a class="team-leave" style="color:#101010;" href="#" data-value="<?= $team->id; ?>"><span class="glyphicon glyphicon-log-out"></span> Leave Group</a></h5>
    </div>
    
    <div class="addTaskSearch" >
        <a class="task-create" href="#taskModifyModal" data-toggle="modal" style="color: inherit;">
            <input type="text" id="taskSearch" placeholder="Add Task...">  
        </a>
    </div>

    <div class="container-fluid kanban-board"> 
        <div id="taskTileList" class="row">
            <div class="col-md-4 container-fluid">
                <div id="thingsToDo" class="row">
                    <div class="col-md-12">
                        <h3>To-Do</h3>
                    </div>
                </div>
            </div>
            <div id="doing" class="col-md-4 container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Doing</h3>
                    </div>
                </div>
            </div>
            <div id="done" class="col-md-4 container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Done</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>