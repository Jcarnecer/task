    <div id="createTaskModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="transition:0.2s;">
                <div class="modal-body">
                    <form id="taskCreateForm">
                        <input type="text" name="title" placeholder="Title" required>
                        <hr/>
                        <textarea  rows="5" name="description" style="resize:none;" placeholder="Description" required></textarea>
                        <div id="createTaskSetting" class="collapse">
                            <hr/>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label>Date:</label>
                                    <input type="date" name="due_date">
                                </div>
                                <div class="col-md-6">
                                    <label>Time:</label>
                                    <input type="time" name="due_time">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="task-tag-list">
                                    <label class="display:inline-block;">Tags: </label>
                                    <input type="text" class="task-tag" placeholder="Add Tags" style="display:inline-block;"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-circle btn-color" style="background-color:#ffffff;" data-value="#ffffff"><span class="glyphicon glyphicon-ok"></span></button>
                            <button type="button" class="btn btn-circle btn-color" style="background-color:#ff8a80;" data-value="#ff8a80"><span></span></button>
                            <button type="button" class="btn btn-circle btn-color" style="background-color:#ffd180;" data-value="#ffd180"><span></span></button>
                            <button type="button" class="btn btn-circle btn-color" style="background-color:#ffff8d;" data-value="#ffff8d"><span></span></button>
                            <button type="button" class="btn btn-circle btn-color" style="background-color:#ccff90;" data-value="#ccff90"><span></span></button>
                            <button type="button" class="btn btn-circle btn-color" style="background-color:#a7ffeb;" data-value="#a7ffeb"><span></span></button>
                            <button type="button" class="btn btn-circle btn-color" style="background-color:#80d8ff;" data-value="#80d8ff"><span></span></button>
                            <button type="button" class="btn btn-circle btn-color" style="background-color:#cfd8dc;" data-value="#cfd8dc"><span></span></button>
                            <input type="hidden" name="color" value="#ffffff" />

                            <button type="button" id="taskCreateButton" class="btn btn-default pull-right" data-dismiss="modal" style="margin: 0 1px;"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                            <button type="button" class="btn btn-default pull-right" data-target="#createTaskSetting" data-toggle="collapse" style="margin: 0 1px;"><span class="glyphicon glyphicon-cog"></span> Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div id="updateTaskModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="transition:0.2s;">
                <div class="modal-body">
                    <form id="taskUpdateForm">
                        <input type="text" name="title" placeholder="Title" required>
                        <hr/>
                        <textarea  rows="5" name="description" style="resize:none;" placeholder="Description" required></textarea>
                        <div id="updateTaskSetting" class="collapse">
                            <hr/>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label>Date:</label>
                                    <input type="date" name="due_date">
                                </div>
                                <div class="col-md-6">
                                    <label>Time:</label>
                                    <input type="time" name="due_time">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="task-tag-list">
                                    <label class="display:inline-block;">Tags: </label>
                                    <input type="text" class="task-tag" placeholder="Add Tags" style="display:inline-block;"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <button type="button" class="btn btn-circle btn-color" style="background-color:#ffffff;" data-value="#ffffff"><span class="glyphicon glyphicon-ok"></span></button>
                        <button type="button" class="btn btn-circle btn-color" style="background-color:#ff8a80;" data-value="#ff8a80"><span></span></button>
                        <button type="button" class="btn btn-circle btn-color" style="background-color:#ffd180;" data-value="#ffd180"><span></span></button>
                        <button type="button" class="btn btn-circle btn-color" style="background-color:#ffff8d;" data-value="#ffff8d"><span></span></button>
                        <button type="button" class="btn btn-circle btn-color" style="background-color:#ccff90;" data-value="#ccff90"><span></span></button>
                        <button type="button" class="btn btn-circle btn-color" style="background-color:#a7ffeb;" data-value="#a7ffeb"><span></span></button>
                        <button type="button" class="btn btn-circle btn-color" style="background-color:#80d8ff;" data-value="#80d8ff"><span></span></button>
                        <button type="button" class="btn btn-circle btn-color" style="background-color:#cfd8dc;" data-value="#cfd8dc"><span></span></button>
                        <input type="hidden" name="color" value="#ffffff" />

                        <button type="button" id="taskUpdateButton" class="btn btn-default pull-right" data-dismiss="modal" style="margin: 0 1px;"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
                        <button type="button" class="btn btn-default pull-right" data-target="#updateTaskSetting" data-toggle="collapse" style="margin: 0 1px;"><span class="glyphicon glyphicon-cog"></span> Settings</button>
                    </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div id="viewTaskModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="transition:0.2s;">
                <div class="modal-body">
                    <form id="taskViewForm">
                        <div class="dropdown">
                            <a class="dropdown-toggle pull-right" data-toggle="dropdown"><span class="glyphicon glyphicon-option-vertical"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#updateTaskModal" data-toggle="modal" data-dismiss="modal">Edit Task</a></li>
                                <li><a href="#" class="task-mark-done" data-dismiss="modal">Mark as Done</a></li>
                            </ul>
                        </div>
                        <h1 id="title" class="task-title"><b></b></h1>
                        <h4 id="description" class="task-description pre-scrollable" style="overflow-x:auto; overflow-y:auto;"><b></b></h4>
                        <hr/>
                        <div class="row">
                            <div class="col-md-6"><h4 id="date"><b>Date: </b><span></span></h4></div>
                            <div class="col-md-6"><h4 id="time"><b>Time: </b><span></span></h4></div>
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


    <div id="searchTaskModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="text" id="taskSearch" placeholder="Search"/>
                    <div id="taskSearchQuery" class="list-group">

                    </div>
                </div>
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


    <div class="container-fluid"> 
        <div class="container-fluid">
            <div id="taskTileList" class="row">

            </div>
        </div>
    </div>