const baseUrl = window.location.origin === "http://task.payakapps.com" ? "http://task.payakapps.com/" : "http://localhost/task/";

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

            iconAppend = '<i class="fa fa-user-o"></i> ';
        } else if (actors.length == 1) {

            iconAppend = '<i class="fa fa-user"></i> ';
        } else if (actors.length > 1) {

            iconAppend = '<i class="fa fa-users"></i> ';
        }
    }

    var taskString = 
    `<div class="card my-1 rounded kanban-task task-view"
        data-toggle="modal" data-target="#taskViewModal" data-value="${task['id']}" data-parent="${task['column_id']}" 
        ${modalDismissAppend} 
        style="background-color:${task['color']};">
        
        <div class="card-body" ${contributorsAppend}
            draggable="true" ondragstart="drag(event)" ondragend="closeDeleteModal(event)">
            <h5 class="card-title font-weight-bold">${iconAppend + task['title']}</h5>
        </div>

    </div>`;

    return taskString;
}


// Column Builder
function columnBuilder(column) {
    var columnString = 
    `<div class="card border-0 h-100 w-25 kanban-column" 
        ondrop="drop(event)" ondragover="allowDrop(event)" 
        data-value="${column['id']}" data-position="${column['position']}">
        <h4 class="card-header clearfix"
            draggable="true" ondragstart="drag(event)">

            <span class="kanban-column-title float-left" contenteditable="false">
                ${column['name']}
            </span>

            <span class="float-right">
                <a class="kanban-column-edit" href="#"><i class="fa fa-pencil mx-1"></i></a>
                <a class="kanban-column-delete" href="#"><i class="fa fa-trash mx-1"></i></a>
            </span>

        </h4>
        <div class="card-body text-center" style="overflow-y: auto;">
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
                `<span class="badge badge-dark mx-1">${item['first_name']} ${item['last_name']} <a class="team-member-remove" data-value="${item['email_address']}">&times;</a></span>`
            );

            $('#teamModifyModal form').append(
                `<input type="hidden" name="members[]" value="${item['email_address']}" />`
            );
        } else

            $('.team-member-list').append(
                `<span class="badge badge-secondary">${item['first_name']} ${item['last_name']}</span>`
            );
    });
};


// Task
function resetForm() {
    
    $('#taskModifyModal').find('form')[0].reset();

    $('#taskModifyModal form').children('input').remove();
    $('#taskModifyModal').find('.task-tag').siblings('span.badge').remove();
    $('#taskModifyModal').find('.task-actor').siblings('span.badge').remove();
    $('#taskModifyModal').find('.btn-color').find('i').removeClass('fa fa-check fa-lg');
    $('#taskModifyModal').find(`button[data-value="#ffffff"] i`).addClass('fa fa-check fa-lg');
    $('#taskModifyModal .card').css('background-color', '#ffffff');
};


function displayTask(items) {

    $('.kanban-column .task-create').prevAll().remove();
    
    items.forEach(function(item) {
        
        $(`.kanban-column[data-value="${item['column_id']}"]>.card-body`).prepend(taskBuilder(item, getTaskType() == 'team'));
    });
};


function displayActor(items, edit = false) {

    items.forEach(function(item) {

        if(edit) {

            $('#taskModifyModal .task-actor').before(
                `<span class="badge badge-dark mx-1">${item['first_name'] + ' ' + item['last_name']} <a class="task-actor-remove" data-value="${item['email_address']}">&times;</a></span>`
            );

            $('#taskModifyModal form').append(
                `<input type="hidden" name="actors[]" value="${item['email_address']}" />`
            );
        } else {

            $('.task-actor-list').append(
                `<span class="badge badge-dark mx-1">${item['first_name'] + ' ' + item['last_name']}</span>`
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
                
                $('#taskSearchList').append(taskBuilder(item, getTaskType() == 'team', true));
            }
        });
    }
};


// Kanban
function displayBoard(board) {

    $('#kanbanBoard .card-group').html('');

    $('#kanbanBoard .card-group').css(`width`, `${(board['columns'].length + 1) * 25}%`);

    board['columns'].forEach(function(column) {

        $('#kanbanBoard .card-group').append(columnBuilder(column));
    });
    
    $('#kanbanBoard .card-group').append(`
        <div id="addColumn" class="card border-0 h-100 w-25">
            <h4 class="card-header w-100">
                <i class="fa fa-plus mx-1"></i>
                <span id="addColumnName" contenteditable="true">Type Here</span>
            </h4>
            <div class="card-body"></div>
        </div>
    `);
};


function addColumn(column) {
    
    $('#kanbanBoard .card-group').css(`width`,  `${(column['position'] + 1) * 25}%`);
    
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