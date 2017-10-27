
    <div class="container-fluid text-center" style="margin-bottom: 50px;">
        <h1 style="margin: 30px auto;">Welcome, <?= $user_name ?>!</h1>
    </div>

    <div class="container-fluid" >
        <div id="personalCreate" class="task-container container-fluid w3-card-2 w3-hover-shadow">

            <form id="taskCreateForm" method="post">

                <input type="text" data-target="#createCollapse" data-toggle="collapse" class="input-tag" name="title" placeholder="What's your plan, <?= $user_name ?>?">

                <div id="createCollapse" class="collapse">
                    <textarea id="addTask" rows="2" class="body lead" name="description" placeholder="Description"></textarea>

                    <div id="dateTaskSettings" class="collapse">    
                        <hr>
                        <div class="container-fluid">
                            <label>Due Date: </label>
                            <input type="date" name="due_date">
                        </div>
                        <div class="container-fluid">    
                            <div class="task-tag-list">
                                <label style="display:inline-block;">Tags: </label>
                                <input type="text" class="task-tag" placeholder="Add Tags" style="display:inline-block;"/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="container-fluid" style="padding-top: 20px; padding-bottom: 20px; overflow:auto;">
                        <?php foreach($colors as $color): ?>
                        <button type="button" class="btn btn-circle btn-color" style="background-color:<?= $color ?>;" data-value="<?= $color ?>">
                            <?php if($color == '#ffffff'): ?>
                            <i class="fa fa-check"></i>
                            <?php else: ?>
                            <i></i>
                            <?php endif; ?>
                        </button>
                        <?php endforeach; ?>
                        <input type="hidden" name="color" value="#ffffff"/>
                        <button type="submit" form="taskCreateForm" id="taskSubmit" class="btn btn-primary pull-right" data-toggle="collapse" data-target="#createCollapse" style="margin: 0px 5px;">
                            <i class="fa fa-floppy-o fa-lg"></i> Save
                        </button>
                        <!-- <input type="submit" class="btn btn-primary float-right" value="Submit"> -->
                        <button type="button" class="btn btn-primary pull-right" data-target="#dateTaskSettings" data-toggle="collapse" style="margin: 0px 5px;">
                            <i class="fa fa-cog fa-lg"></i> More
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>


    <div class="container-fluid task-tag-board">
        <div id="taskTileList" class="row">

        </div>
    </div>
