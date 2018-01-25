<div id="deleteTaskModal" ondrop="deleteTask(event)" ondragover="allowDrop(event)" class="d-none card position-fixed bg-dark text-white rounded w-50" style="z-index: 9999; top: 10%; left: 25%; height: 15%">
    <div class="card-body d-flex justify-content-center align-items-center">
        <h1 class="card-title">
            <i class="fa fa-archive"></i> Archive Task
        </h1>
    </div>
</div>

<div id="kanbanBoard" class="d-flex flex-column bg-primary w-100 m-0 p-0" style="height: 100%;">
    <h1 class="font-weight-bold text-center mb-2 mt-3">Welcome, <?= $first_name ?>!</h1>
    <h5 class=" text-center mb-3">You have <span class="h4 font-weight-bold task-count"></span> task to do.</h5>
    <div class="h-100" style="overflow-x: auto;">
        <div class="card-group rounded-0 h-100 m-0 p-0"></div>
    </div>
</div>