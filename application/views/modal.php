
    <!-- Team Create Modal -->
    
    <div id="teamCreateModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="transition:0.2s;">
                <div class="modal-body">
                    <form id="teamCreateForm">
                        <input type="text" name="name" placeholder="Team Name" required>
                        <hr/>
                        <div class="form-group">
                            <div class="team-member-list">
                                <span class="team-member-label">Members: </span>
                                <input type="text" class="team-member" placeholder="Add Member's Email Address" size="32" style="display:inline-block;"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" id="teamCreateButton" class="btn btn-default pull-right" data-dismiss="modal" style="margin: 0 1px;"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                                <!-- <button type="button" class="btn btn-default pull-right" data-target="#createTaskSetting" data-toggle="collapse" style="margin: 0 1px;"><span class="glyphicon glyphicon-cog"></span> Settings</button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Create Modal -->

    <div id="taskCreateModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="transition:0.2s;">
                <div class="modal-body">
                    <form id="taskCreateForm">
                        <input type="text" class="heading" name="title" placeholder="Title" required>
                        <hr/>
                        <textarea rows="5" class="body lead" name="description" placeholder="Description" required></textarea>
                        <div id="createTaskSetting" class="collapse">
                            <hr/>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label>Due Date:</label>
                                    <input type="date" name="due_date">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="task-tag-list">
                                    <span style="display:inline-block;">Tags: </span>
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

                            <button type="button" id="taskSubmit" class="btn btn-default pull-right" data-dismiss="modal" style="margin: 0 1px;"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                            <button type="button" class="btn btn-default pull-right" data-target="#createTaskSetting" data-toggle="collapse" style="margin: 0 1px;"><span class="glyphicon glyphicon-cog"></span> Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Update Modal -->

    <div id="taskUpdateModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="transition:0.2s;">
                <div class="modal-body">
                    <form id="taskUpdateForm">
                        <input type="text" class="heading" name="title" placeholder="Title" required>
                        <hr/>
                        <textarea  rows="5" class="body lead" name="description" placeholder="Description" required></textarea>
                        <div id="updateTaskSetting" class="collapse">
                            <hr/>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label>Due Date:</label>
                                    <input type="date" name="due_date">
                                </div>
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

                            <button type="button" id="taskSubmit" class="btn btn-default pull-right" data-dismiss="modal" style="margin: 0 1px;"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                            <button type="button" class="btn btn-default pull-right" data-target="#updateTaskSetting" data-toggle="collapse" style="margin: 0 1px;"><span class="glyphicon glyphicon-cog"></span> Settings</button>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Task View Modal -->

    <div id="taskViewModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="transition:0.2s;">
                <div class="modal-body">
                    <form id="taskViewForm">
                        <div class="dropdown">
                            <a class="dropdown-toggle pull-right" data-toggle="dropdown"><span class="glyphicon glyphicon-option-vertical"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#taskUpdateModal" data-toggle="modal" data-dismiss="modal">Edit Task</a></li>
                                <li><a href="#" class="task-mark-done" data-dismiss="modal">Mark as Done</a></li>
                            </ul>
                        </div>
                        <h1 id="title" class="heading"><b></b></h1>
                        <p id="description" class="body lead"></p>
                        <hr/>
                        <div class="row">
                            <div class="col-md-6"><h4 id="date"><b>Due Date: </b><span></span></h4></div>
                        </div>
                        <div>
                            <h4 style="display:inline-block;"><b>Tags: </b>
                                <div class="task-tag-list" style="display:inline-block;"></div>
                            </h4>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label>Notes:</label>
                            <input type="text" id="taskNote" class="form-control"/>
                            <div id="taskNoteList" class="list-group" style="color:#000000;">

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Search Modal -->

    <div id="searchTaskModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- <div class="modal-body"> -->
                    <input type="text" id="taskSearch" placeholder="Search"/>
                    <ul id="taskSearchQuery" class="list-group" style="margin: 0px;">

                    </ul>
                <!-- </div> -->
            </div>
        </div>
    </div>


    <!-- <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <p>Some text in the modal.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> -->