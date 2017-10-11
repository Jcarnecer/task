
<!--  Title  -->
<div class="container-fluid" style="margin-bottom: 50px;">
    <div class="d-flex flex-row">
        <section class="long-copy">
            <h1>My Task</h1>
        </section>
    </div>
</div>


<div class="container" >
    <a class="task-create" href="#taskCreate" data-toggle="collapse" style="color: inherit;">
        <input type="text" id="taskSearch" placeholder="Add Task..." style="color: #7f8c8d;">  
    </a>
    <div id="taskCreate" class="collapse" style="background-color: #ffffff;">
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
    </div>
</div>


<div class="container-fluid task-tag-board">
    <div id="taskTileList" class="row">

    </div>
</div>