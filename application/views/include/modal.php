    <!-- Team Create Modal -->
<div id="teamModifyModal" class="modal fade" role="dialog" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0" style="transition:0.2s;">
                <form method="post">
                    <div class="card">
                        <div class="card-header">
                            <input type="text" class="h3 font-weight-bold border-0 h-100 w-100" name="name" placeholder="Team Name" maxlength="20" style="outline: none; background-color: rgba(0, 0, 0, 0);" required>
                        </div>
                        <div class="card-body">
                            <div class="container-fluid p-0">
                                <p class="card-title d-inline-block">Members: </p>
                                <input type="text" class="team-member border-0 d-inline-block" placeholder="Add Member's Email Address" size="32" style="outline: none; background-color: rgba(0, 0, 0, 0);"/>
                            </div>
                            <div class="container-fluid clearfix px-0">
                                <button type="submit" class="btn btn-primary float-right"><i class="fa fa-users"></i> <span class="team-button-text"></span></button>
                                <button type="button" class="close-modal d-none" data-dismiss="modal"></button>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>

<!-- Task Modify Modal -->
<div id="taskModifyModal" class="modal fade" role="dialog" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog model-sm">
        <div class="modal-content border-0" style="transition:0.2s;">
                <form method="post">
                    <div class="card">
                        <div class="card-header">
                            <input type="text" class="h3 font-weight-bold border-0 h-100 w-100" name="title" placeholder="Title" maxlength="20" style="outline: none; background-color: rgba(0, 0, 0, 0);" required>
                        </div>
                        <div class="card-body">
                            <div class="w-100">
                                <textarea rows="5" class="h4 border-0 w-100" name="description" placeholder="Description" style="outline: none; resize: none; background-color: rgba(0, 0, 0, 0);"></textarea>
                            </div>
                            <?php if($task_type == 'team'): ?>
                            <div class="container-fluid p-0">
                                <p class="card-title d-inline-block">Contributors: </p>
                                <input type="text" class="task-actor border-0 d-inline-block" placeholder="Add Contributor" style="outline: none; background-color: rgba(0, 0, 0, 0);"/>
                            </div>
                            <?php endif; ?>
                            <div id="modifyTaskCollapse" class="collapse py-2 px-0">
                                <hr>
                                <div class="form-inline">
                                    <label class="card-text">Due Date: </label>
                                    <input type="date" class="form-control border-0" name="due_date" style="outline: none; background-color: rgba(0, 0, 0, 0);">
                                </div>
                                <div class="container-fluid p-0">
                                    <p class="card-title d-inline-block">Tags: </p>
                                    <input type="text" class="task-tag border-0 d-inline-block" placeholder="Add Tags" style="outline: none; background-color: rgba(0, 0, 0, 0);"/>
                                </div>
                            </div>
                            <div class="container-fluid clearfix py-1 px-0">
                                <span class="float-left">
                                    <?php foreach($colors as $color): ?>
                                    <button type="button" class="btn btn-circle btn-color" style="background-color: <?= $color ?>;" data-value="<?= $color ?>">
                                    <?php if($color == '#ffffff'): ?><i class="fa fa-check fa-lg"></i><?php else: ?><i></i><?php endif; ?>
                                    </button>
                                    <?php endforeach; ?>
                                </span>
                                <div class="btn-group float-right">
                                    <button type="button" class="btn btn-primary" data-target="#modifyTaskCollapse" data-toggle="collapse">
                                        <i class="fa fa-cog"></i> More
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-floppy-o"></i> Save
                                    </button>
                                    <button type="button" class="close-modal d-none" data-dismiss="modal"></button>
                                </div>
                            </div>
                            <input type="hidden" name="color" value="#ffffff">
                            <input type="hidden" name="column_id" required>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>

<!-- Task View Modal -->
<div id="taskViewModal" class="modal fade" role="dialog">
    <div class="modal-dialog model-sm">
        <div class="modal-content border-0" style="transition:0.2s;">
            <div class="card">
                <h2 class="card-header font-weight-bold clearfix">
                    <span class="task-title float-left"></span>
                    <a class="task-edit float-right" href="#taskModifyModal" data-toggle="modal" data-dismiss="modal"><i class="fa fa-pencil mx-1"></i></a>
                </h2>
                <div class="card-body">
                    <h4 class="task-description card-title"></h4>
                    <?php if($task_type == 'team'): ?>
                    <hr>
                    <p class="card-title">Contributors:  <span class="task-actor-list card-text"></span></p>
                    <?php endif; ?>
                    <hr>
                    <p class="card-title">Tags:  <span class="task-tag-list card-text"></span></p>
                    <hr>
                    <h6 class="card-title font-weight-bold">Notes</h6>
                    <div class="container-fluid">
                        <div class="task-note-list row"></div>
                    </div>
                    <div class="container-fluid my-1">
                        <div class="row">
                            <div class="col-2">
                                <h2 class="text-center"><i class="fa fa-user-circle"></i></h2>
                            </div>
                            <div class="col-10 rounded border border-secondary bg-white">
                                <textarea class="task-note border-0 w-100" rows="2" placeholder="Type Here..." style="resize: none; outline: none;"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="notes" />
                </div>
                <div class="card-footer text-center">
                    <small class="float-left">Deadline: <span class="task-date font-weight-bold"></span></small>
                    <small class="float-right text-right"><span class="task-countdown font-weight-bold"></span><span class="task-countdown-text"></span></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Task Search Modal -->
<div id="taskSearchModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            <div class="card">
                <h2 class="card-header p-0">
                    <input type="search" id="taskSearch" class="form-control text-center m-0 font-weight-bold" placeholder="Search"/>
                </h2>
                <div class="card-body">
                    <div id="taskSearchList" class="card-columns"></div>
                </div>
            </div>
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