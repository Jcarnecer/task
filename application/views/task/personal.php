<div class="container-fluid text-center m-0 p-4 bg-primary" style="height: 160px;">
    <h1 class="my-2 font-weight-bold">Hello, <?= $user_name ?>!</h1>
    <h5>You have <span class="h4 font-weight-bold task-count"></span> task to do.</h5>
</div>

<div id="kanbanBoard" class="w-100 m-0 p-0" style="height: calc(100% - 160px); overflow-x: auto;">
<div class="card-group h-100 m-0 p-0"></div>
</div>