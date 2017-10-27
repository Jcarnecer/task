<!-- Team Create Modal -->
<div id="teamModifyModal" class="modal fade" role="dialog" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="transition:0.2s;">
            <div class="modal-body">
                <form method="post">
                    <input type="text" class="heading" name="name" placeholder="Team Name" maxlength="20" required>
                    <hr/>
                    <div class="form-group">
                        <div class="team-member-list">
                            <span class="team-member-label">Members: </span>
                            <input type="text" class="team-member" placeholder="Add Member's Email Address" size="32" style="display:inline-block;"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" id="teamSubmit" class="btn btn-primary pull-right" data-dismiss="modal"><i class="fa fa-users"></i> Create Team</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Task Modify Modal -->
<div id="taskModifyModal" class="modal fade" role="dialog" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="task-container modal-content" style="transition:0.2s;">
            <div class="modal-body">
                <form method="post">
                    <input type="text" class="heading" name="title" placeholder="Title" maxlength="20" required>
                    <hr/>
                    <textarea rows="5" class="body lead" name="description" placeholder="Description"></textarea>
                    <?php if($task_type == 'team'): ?>
                    <div class="form-group">
                        <div class="task-actor-list">
                            <label style="display:inline-block;">Contributors: </label>
                            <input type="text" class="task-actor" placeholder="Add Contributor" style="display:inline-block;"/>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div id="createTaskSetting" class="collapse">
                        <!-- <hr/> -->
                        <div class="form-group">
                            <label>Due Date:</label>
                            <input type="date" name="due_date">
                        </div>
                        <div class="form-group">
                            <div class="task-tag-list">
                                <label style="display:inline-block;">Tags: </label>
                                <input type="text" class="task-tag" placeholder="Add Tags" style="display:inline-block;"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php foreach($colors as $color): ?>
                        <button type="button" class="btn btn-circle btn-color" style="background-color:<?= $color ?>;" data-value="<?= $color ?>">
                        <?php if($color == '#ffffff'): ?>
                            <i class="fa fa-check fa-lg"></i>
                        <?php else: ?>
                            <i></i>
                        <?php endif; ?>
                        </button>
                        <?php endforeach; ?>
                        <input type="hidden" name="color" value="#ffffff" />
                        <button type="submit" class="btn btn-link pull-right"><i class="fa fa-floppy-o fa-2x"></i></button>
                        <button type="button" id="taskClose" style="display:none;" data-dismiss="modal">
                        <button type="button" class="btn btn-link pull-right" data-target="#createTaskSetting" data-toggle="collapse"><i class="fa fa-cog fa-2x"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Task View Modal -->
<div id="taskViewModal" class="modal fade" role="dialog" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="task-container modal-content" style="transition:0.2s;">
            <div class="modal-body">
                <form id="taskViewForm">
                    <div class="dropdown">
                        <button type="button" class="btn btn-link dropdwon-toggle pull-right" data-toggle="dropdown" id ="taskModalDropdown" style="padding:5px 15px;"><span class="fa fa-ellipsis-v" aria-hidden="false"></span></button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <div class="dropdown-item"><a class="task-edit" href="#taskModifyModal" data-toggle="modal" data-dismiss="modal">Edit Task</a></div>
                            <div class="dropdown-item"><a href="#" class="task-mark-done" data-dismiss="modal">Mark as Done</a></div>
                        </div>
                    </div>
                    
                    <h1 id="title" class="heading"><b></b></h1>
                    <textarea id="description" class="body lead" disabled></textarea>
                    <?php if($task_type == 'team'): ?>
                    <h4 style="display:inline-block;"><b>Contributors: </b>
                        <div class="task-actor-list" style="display:inline-block;"></div>
                    </h4>
                    <?php endif; ?>
                    <hr/>
                    <div class="row">
                        <div class="col-md-6">
                            <h5 id="date"><b>Due Date: </b><span class="body"></span></h5>
                        </div>
                        <div class="col-md-6">
                            <h5 id="countdown" class="body"></h5>
                        </div>
                    </div>
                    <div>
                        <h5 style="display:inline-block;"><b>Tags: </b>
                            <div class="task-tag-list" style="display:inline-block;"></div>
                        </h5>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <span class="task-note-label">Notes</span>
                    </div>
                    <div class="row task-note-create">
                        <div class="col-md-2">
                            <i class="fa fa-user-circle fa-3x task-note-user"></i>
                        </div>
                        <div class="col-md-10">
                            <div class="task-note-box">
                                <textarea class="task-note" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row task-note-list">

                    </div>
                    <input type="hidden" name="notes" />
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Task Search Modal -->
<div id="searchTaskModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <input type="text" id="taskSearch" placeholder="Search"/>
            <ul id="taskSearchQuery" class="list-group" style="margin: 0px;">

            </ul>
        </div>
    </div>
</div>

<!-- Add Task (Search Modal) -->
<div id="addTaskModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="transition:0.2s;">
            <div class="modal-body">
                <form method="post">
                    <input type="text" class="heading" name="title" placeholder="Title" required>
                    <hr/>
                    <textarea rows="5" class="body lead" name="description" placeholder="Description" required></textarea>
                    <div id="createTaskSetting" class="collapse">
                        <hr/>
                        <div class="form-group">
                            <label>Due Date:</label>
                            <input type="date" name="due_date">
                        </div>
                        <div class="form-group">
                            <div class="task-tag-list">
                                <label style="display:inline-block;">Tags: </label>
                                <input type="text" class="task-tag" placeholder="Add Tags" style="display:inline-block;"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php foreach($colors as $color): ?>
                        <button type="button" class="btn btn-circle btn-color" style="background-color:<?= $color ?>;" data-value="<?= $color ?>">
                            <?php if($color == '#ffffff'): ?>
                            <span class="glyphicon glyphicon-ok"></span>
                            <?php else: ?>
                            <span></span>
                            <?php endif; ?>
                        </button>
                        <?php endforeach; ?>
                        <input type="hidden" name="color" value="#ffffff" />
                    </div>
                    <div class="d-flex flex-row-reverse">
                        <div class="p-2"></div>
                        <div class="p-2">
                            <button type="button" id="taskSubmit" class="btn btn-default pull-right" data-dismiss="modal" style="margin: 0 1px;"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                        </div>
                        <div class="p-2">
                            <button type="button" class="btn btn-default pull-right" data-target="#createTaskSetting" data-toggle="collapse" style="margin: 0 1px;"><span class="glyphicon glyphicon-cog"></span> Settings</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>