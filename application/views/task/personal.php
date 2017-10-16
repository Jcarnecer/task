
<!--  Title  -->
<div class="container-fluid" style="margin-bottom: 50px;">
    <div class="d-flex flex-row">
        <section class="long-copy">
            <h1>My Task</h1>
        </section>
    </div>
</div>


<div class="container">
    <form>
        <!-- <a  href="#taskCreate" data-toggle="collapse" style="color: inherit;"> -->
        <input type="text" data-target="#taskCreateCollapse" data-toggle="collapse" class="input-tag" name="title"  placeholder="Title">
        <!-- </a> -->

        <div id="taskCreateCollapse" class="collapse" style="background-color: #ffffff;">
            <hr>
            <textarea id="addTask" rows="2" class="body lead" name="description" placeholder="Add Task"></textarea>
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
                <input type="hidden" name="color" value="#ffffff" style="border-radius: 10px;" />
            </div>
            <hr> 
            <div class="container-fluid">
                <div id="dateTaskSettings" class="collapse">    
                    <div class="form-group">
                        <label>Due Date:</label>
                        <input type="date" name="due_date">
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="task-tag-list">
                            <label style="display:inline-block;">Tags: </label>
                            <input type="text" class="task-tag" placeholder="Add Tags" style="display:inline-block;"/>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>  
            <div class="d-flex justify-content-start">
                <div class="p-2">
                    <a class="btn btn-calendar" href="#dateTaskSettings" data-toggle="collapse" style="color: inherit;"><i class="fa fa-calendar" aria-hidden="true"></i></a>
                </div>
                <div class="ml-auto p-2">
                    <a class="btn btn-save" href="#" style="color: inherit; text-decoration: none;"><span class="icon"><i class="fa fa-cog" aria-hidden="true"></i></span> Save</a>
                </div>
            </div>
        </div>
    </form>
</div>


<div class="container-fluid task-tag-board">
    <div id="taskTileList" class="row">

    </div>
</div>