<div class="container-fluid text-center m-0 p-4 bg-primary" style="height: 160px;">
    <h1 class="my-2 font-weight-bold">Welcome, <?= $first_name ?>!</h1>
    <h5>You have <span class="h4 font-weight-bold task-count"></span> task to do.</h5>
</div>

<div id="kanbanMdBoard" class="d-none d-md-block w-100 m-0 p-0" style="height: calc(100% - 160px); overflow-x: auto;">
    <!-- <div id="kanbanColumnHolder" class="card-group h-100 m-0 p-0"></div> -->
    <div class="kanban-column-holder d-flex flex-nowrap h-100 p-0 m-0"></div>
</div>

<div id="kanbanSmBoard" class="d-md-none d-block h-100 w-100 m-0 p-0" style="overflow-x: auto;">
    <!-- <div id="kanbanColumnHolder" class="card-group h-100 m-0 p-0"></div> -->
    <div class="kanban-column-holder d-flex flex-nowrap h-100 p-0 m-0"></div>
</div>