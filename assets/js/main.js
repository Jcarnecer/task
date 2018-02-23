switch(window.location.origin){
    case 'http://task.payakapps.com': var baseUrl = 'http://task.payakapps.com/'; break;
    case 'http://stage.payakapps.com': var baseUrl = 'http://stage.payakapps.com/'; break;
    default: var baseUrl = 'http://localhost/task/'; break;
}

var userId = null;
var authorId = null;
var taskType = null;
var userName = null;
var avatarUrl = null;


function setAuthorId(id) { authorId = id; }

function getAuthorId() { return authorId; }


function setTaskType(type) { taskType = type; }

function getTaskType() { return taskType; }


function setUserId(id) { userId = id; }

function getUserId() { return userId; }


function checkEmployee($emailField) {
    data = {
        email: $emailField.val().toLowerCase()
    };

    var result = validateMember(data).responseJSON;
    
    if(result['exists']) {

        if(!$emailField.closest('form').has(`input[name="members[]"][value="${$emailField.val().toLowerCase()}"]`).length){

            $emailField.before(
                `<span class="badge badge-dark m-1">${result['first_name']} ${result['last_name']} <a class="team-member-remove" data-value="${$emailField.val().toLowerCase()}">&times;</a></span>`
            );

            $emailField.closest('form').append(
                `<input type="hidden" name="members[]" value="${$emailField.val().toLowerCase()}" />`
            );
        }
    } else {

        alert('User does not exist in the company');
    }
}


function checkTeamMember($emailField) {
    
    var data = {
        email: $emailField.val().toLowerCase(),
        proj_id: getAuthorId()
    };

    var result = validateMember(data).responseJSON;
    
    if(result['exists']) {
        
        if(!$emailField.closest('form').has(`input[name="actors[]"][value="${$emailField.val().toLowerCase()}"]`).length){

            $emailField.before(
                `<span class="badge badge-dark m-1">${result['first_name'] + ' ' + result['last_name']} <a class="task-actor-remove" data-value="${$emailField.val().toLowerCase()}">&times;</a></span>`
            );

            $emailField.closest('form').append(
                `<input type="hidden" name="actors[]" value="${$emailField.val().toLowerCase()}" />`
            );
        }
    } else {
        
        alert('User does not exist in the team');
    }
}


// Task Builder
function taskBuilder(task, actorIcon = true, modalDismiss = false) {
    
    var taskString          = "";
    var actorsAppend        = "";
    var contributorsAppend  = "";
    var iconAppend          = "";
    var modalDismissAppend  = modalDismiss ? 'data-dismiss="modal"': '';

    
    if (actorIcon) {
        
        var actors      = task['actors'];
        actorsAppend    = "<strong>Contributor</strong><br/>";

        if(actors.length) {

            actors.forEach(function(actor) {

                actorsAppend += actor['first_name'] + " " + actor['last_name'] + "<br/>";
            });
        } else {
            
            actorsAppend = "No Contributor";
        }

        contributorsAppend = `data-toggle="popover" data-trigger="hover" data-html="true" data-placement="right" data-content="${actorsAppend}"`;
    
        if (actors.length == 0) {

            iconAppend = '<i class="far fa-user"></i> ';
        } else if (actors.length == 1) {

            iconAppend = '<i class="fa fa-user"></i> ';
        } else if (actors.length > 1) {

            iconAppend = '<i class="fa fa-users"></i> ';
        }
    }

    var taskString = 
    `<div class="card my-1 rounded kanban-task task-view"
         data-value="${task['id']}" data-parent="${task['column_id']}" ${contributorsAppend}
         draggable="true" ondragstart="drag(event)" 
        ${modalDismissAppend}">
        
        <div class="card-body" data-toggle="modal" data-target="#taskViewModal">
            <span class="badge badge-pill" style="background-color:${task['color']};"> </span>
            <h5 class="card-title mb-0 d-inline font-weight-bold">${iconAppend + task['title']}</h5>
        </div>
        <div class="card-footer pt-2 border-top-0">
            <small class="${task['remaining_days'] < 0 ? 'text-danger' : ''}">${task['due_date_long']}</small>
            <button class="float-right task-archive" data-value="${task['id']}"><i class="fa fa-archive"></i></button>
        </div>

    </div>`;

    return taskString;
}


// Column Builder
function columnBuilder(column) {
    var columnString = 
    `<div class="card border h-100 w-100 kanban-column rounded-0" 
        ondrop="drop(event)" ondragover="allowDrop(event)" 
        data-value="${column['id']}" data-position="${column['position']}">
        <div class="card-header clearfix"
            draggable="true" ondragstart="drag(event)">

            <h4 class="kanban-column-title mb-0 float-left" contenteditable="false">
                ${column['name']}
            </h4>

            
            <div class="dropdown show float-right">
                <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-angle-down fa-lg"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item kanban-column-edit" href="#">Edit</a>
                    <a class="dropdown-item kanban-column-delete" href="#">Delete</a>
                </div>
            </div>
                

        </div>
        <div class="card-body" style="overflow-y: auto;">
            <button type="button" class="btn custom-button btn-block my-2 task-create"
                data-toggle="modal" data-target="#taskModifyModal" data-parent="${column['id']}">
                <i class="fa fa-plus"></i> Add Task
            </button>
        </div>
    </div>`;

    return columnString;
}


// Team
function displayMember(items, edit = false) {

    items.forEach(function(item) {

        if(edit) {

            $('.team-member').before(
                `<span class="badge badge-dark m-1">${item['first_name']} ${item['last_name']} <a class="team-member-remove" data-value="${item['email_address']}">&times;</a></span>`
            );

            $('#teamModifyModal form').append(
                `<input type="hidden" name="members[]" value="${item['email_address']}" />`
            );
        } else

            $('.team-member').before(
                `<span class="badge badge-dark m-1">${item['first_name']} ${item['last_name']}</span>`
            );
    });
};


// Task
function resetForm() {
    
    $('#taskModifyModal').find('form')[0].reset();

    $('#taskModifyModal form').children('input').remove();
    $('#taskModifyModal').find('.task-tag').siblings('span.badge').remove();
    $('#taskModifyModal').find('.task-actor').siblings('span.badge').remove();
    $('#taskModifyModal').find('.btn-color .fa-check').hide();
    $('#taskModifyModal').find(`button[data-value="#ffffff"] .fa-check`).show();
    $('#taskModifyModal .card .card-header').css('background-color', '#ffffff');
};


function displayTask(items) {

    $('.kanban-column .task-create').prevAll().remove();
    
    items.forEach(function(item) {
        
        $(`.kanban-column[data-value="${item['column_id']}"]>.card-body`).prepend(taskBuilder(item, getTaskType() == 'project'));
    });
};


function displayActor(items, edit = false) {

    items.forEach(function(item) {

        if(edit) {

            $('#taskModifyModal .task-actor').before(
                `<span class="badge badge-dark m-1">${item['first_name'] + ' ' + item['last_name']} <a class="task-actor-remove" data-value="${item['email_address']}">&times;</a></span>`
            );

            $('#taskModifyModal form').append(
                `<input type="hidden" name="actors[]" value="${item['email_address']}" />`
            );
        } else {

            $('.task-actor-list').append(
                `<span class="badge badge-dark m-1">${item['first_name'] + ' ' + item['last_name']}</span>`
            );
        }
    });
};
    

function displayTag(items, edit = false) {

    items.forEach(function(item) {

        if(edit) {
                
            $('#taskModifyModal .task-tag').before(
                `<span class="badge badge-dark badge-pill mx-1">${item['name']} <a class="task-tag-remove" data-value="${item['name']}">&times;</a></span>`
            );
            $('#taskModifyModal .task-tag').append(
                `<input type="hidden" name="tags[]" value="${item['name']}" />`
            );
        } else {

            $('.task-tag-list').append(
                `<span class="badge badge-dark badge-pill mx-1">${item['name']}</span>`
            );
        }
    });
};


function displayNote(items) {

    items.forEach(function(item){

        var user = getUser(item['user_id']).responseJSON;
        
        $('.task-note-list').append(
            `<div class="col-2">
                <h4 class="text-center">
                <img class="img-avatar-sm" src="${user['avatar_url']}" 
                    data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="${user['first_name'] + ' ' + user['last_name']}">
                </h4>
            </div>
            </div>
            <div class="col-10 d-flex align-self-stretch my-1 text-dark">
                ${item['body']}
            </div>`
        );
    });
}


function searchTask(items, keyword) {

    $('#taskSearchList').html('');

    if(keyword != '') {

        items.forEach(function(item) {
            
            if(item['title'].toLowerCase().indexOf(keyword.toLowerCase()) != -1) {
                
                $('#taskSearchList').append(taskBuilder(item, getTaskType() == 'project', true));
            }
        });
    }
};


// Kanban
function displayBoard(board) {

    $('#kanbanBoard #kanbanColumnContainer').html('');

    $('#kanbanBoard #kanbanColumnContainer').css(`width`, `${(board['columns'].length + 1) * 25}%`);
    
    board['columns'].forEach(function(column) {

        $('#kanbanBoard #kanbanColumnContainer').append(columnBuilder(column));
    });
    
    $('#kanbanBoard #kanbanColumnContainer').append(`
        <div id="addColumn" class="card rounded-0 border h-100 w-100">
            <h4 class="card-header w-100">
                <i class="fa fa-plus mx-1"></i>
                <span id="addColumnName" contenteditable="true">New Column</span>
            </h4>
            <div class="card-body"></div>
        </div>
    `);
};


function addColumn(column) {
    
    $('#kanbanBoard #kanbanColumnContainer').css(`width`,  `${(column['position'] + 1) * 25}%`);
    
    $('#addColumn').before(columnBuilder(column));
};


function highlightTask() {
    
    userId = getUserId();

    getActorTask(userId).done(function (data) {

        data.forEach(function(item) {

            $(`#kanbanBoard .kanban-task[data-value="${item['id']}"]`).toggleClass('active');
        });
    }).always(function () {

        $('#kanbanBoard').toggleClass('highlight');
    });
};  