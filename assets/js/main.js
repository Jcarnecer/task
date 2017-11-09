const baseUrl = window.location.origin + '/task/';

var userId = null;
var authorId = null;
var taskType = null;


function setAuthorId(id) { authorId = id; }


function getAuthorId() { return authorId; }


function setTaskType(type) { taskType = type; }


function getTaskType() { return taskType; }


function setUserId(id) { userId = id; }


function getUserId() { return userId; }


// Team
$.fn.displayMember = function(items, edit = false) {

    $.each(items, function(i, item) {

        if(edit) {

            $('.team-member-list').find('.team-member').before(
                `<span class="badge badge-secondary">${item['first_name']} ${item['last_name']} <a class="team-member-remove" data-value="${item['email_address']}">&times;</a></span>`
            );
            $('.team-member-list').parent().append(
                `<input type="hidden" name="members[]" value="${item['email_address']}" />`
            );
        } else

            $('.team-member-list').append(
                `<span class="badge badge-secondary">${item['first_name']} ${item['last_name']}</span>`
            );
    });
};


// Task
$.fn.resetForm = function() {
    
    $('#taskModifyModal').find('form')[0].reset();

    $('.task-container').find('.task-actor-list').siblings('input').remove();
    $('.task-container').find('.task-actor-list').find('span.badge').remove();
    $('.task-container').find('.task-tag-list').siblings('input').remove();
    $('.task-container').find('.task-tag-list').find('span.badge').remove();
    $('.task-container').find('.btn-color').find('i').removeClass('fa fa-check fa-lg');
    $('.task-container').find(`button[data-value="#ffffff"] i`).addClass('fa fa-check fa-lg');
    $('.task-container').css('background-color', '#ffffff');
};


$.fn.displayActor = function(items, edit = false) {

    $.each(items, function(i, item) {

        if(edit) {

            $('.task-actor-list').find('.task-actor').before(
                `<span class="badge badge-secondary">${item['first_name'] + ' ' + item['last_name']} <a class="task-actor-remove" data-value="${item['email_address']}">&times;</a></span>`
            );

            $('.task-actor-list').parent().append(
                `<input type="hidden" name="actors[]" value="${item['email_address']}" />`
            );
        } else

            $('.task-actor-list').append(
                `<span class="badge badge-secondary">${item['first_name'] + ' ' + item['last_name']}</span>`
            );
    });
};
    

$.fn.displayTag = function(items, edit = false) {

    $.each(items, function(i, item) {

        if(edit) {
                
            $('.task-tag-list').find('.task-tag').before(
                `<span class="badge badge-secondary">${item['name']} <a class="task-tag-remove" data-value="${item['name']}">&times;</a></span>`
            );
            $('.task-tag-list').parent().append(
                `<input type="hidden" name="tags[]" value="${item['name']}" />`
            );
        } else

            $('.task-tag-list').append(
                `<span class="badge badge-secondary">${item['name']}</span>`
            );
    });
};


$.fn.displayNote = function(items) {

    $.each(items, function(i, item){

        $(document).getUser(item['user_id']).always(function(data) {

            $('.task-note-list').append(
                `<div class="col-md-2 task-note-list-item">
                    <i class="fa fa-user-circle fa-2x task-note-user" 
                    data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="${data['first_name'] + ' ' + data['last_name']}">
                    </i>
                    </div>
                </div>
                <div class="col-md-10 card card-sm task-note-text task-note-list-item">
                    ${item['body']}
                </div>`
            );
        });
    });
}


// Task
function taskBuilder(task) {
    
    var taskString = "";
    var actorsAppend = "";
    var contributorsAppend = "";
    var iconAppend = "";

    var actors = task['actors'];
    
    if (actors != null) {

        actorsAppend = "<strong>Contributor</strong><br/>";

        if(actors.length) {

            $.each(actors, function (i, actor) {
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
        style="background-color:${task['color']};">
        
        <div class="card-body" ${contributorsAppend}
            draggable="true" ondragstart="drag(event)">
            <h3 class="card-title font-weight-bold">${iconAppend + task['title']}</h3>
        </div>

    </div>`;

    return taskString;
}


$.fn.displayTask = function(items) {

    $('.kanban-column .task-create').prevAll().remove();
    
    $.each(items, function(i, item) {
        
        $(`.kanban-column[data-value="${item['column_id']}"]>.card-body`).prepend(taskBuilder(item));
    });
};


$.fn.searchTask = function(items, keyword) {

    $('#taskSearchQuery').html('');

    if(keyword != ''){
        $.each(items, function(i, item) {

            if(item['title'].toLowerCase().indexOf(keyword.toLowerCase()) != -1) {

                $('#taskSearchQuery').append(`
                    <li class="list-group-item task-search-item" data-dismiss="modal" style="background-color:${item['color']};">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-1"><a class="task-mark-done" data-value="${item['id']}"><span class="glyphicon glyphicon-` + (item['status'] == 1 ? `unchecked` : `check`) + `"></span></a></div>
                                <div class="col-md-10" data-target="#taskViewModal" data-toggle="modal" data-value="${item['id']}">${item['title']}</div>
                                <div class="col-md-1"><a class="task-edit" href="#taskModifyModal" data-toggle="modal" data-value="${item['id']}"><span class="glyphicon glyphicon-edit"></span></a></div>
                            </div>
                        </div>
                    </li>
                `);
            }
        });
    }
};


// Board
$.fn.displayBoard = function(board) {

    $('#kanbanBoard .card-group').html('');

    $('#kanbanBoard .card-group').css(`width`,  `${(board['columns'].length + 1) * 25}%`);

    $.each(board['columns'], function(i, column) {

        $('#kanbanBoard .card-group').append(columnBuilder(column));
    });
    
    $('#kanbanBoard .card-group').append(`
        <div id="addColumn" class="card h-100 w-25">
            <h2 class="card-header w-100">
                <i class="fa fa-plus mx-1"></i>
                <span id="addColumnName" contenteditable="true">Type Here</span>
            </h2>
            <div class="card-body"></div>
        </div>
    `);
};


// Column
function columnBuilder(column) {
    var columnString = 
    `<div class="card h-100 w-25 kanban-column" 
        ondrop="drop(event)" ondragover="allowDrop(event)" 
        data-value="${column['id']}" data-position="${column['position']}">
        <h2 class="card-header clearfix"
            draggable="true" ondragstart="drag(event)">

            <span class="kanban-column-title float-left" contenteditable="false">
                ${column['name']}
            </span>

            <span class="float-right">
                <a class="kanban-column-edit" href="#"><i class="fa fa-pencil mx-1"></i></a>
                <a class="kanban-column-delete" href="#"><i class="fa fa-trash mx-1"></i></a>
            </span>

        </h2>
        <div class="card-body text-center" style="overflow-y: auto;">
            <button type="button" class="btn btn-primary btn-lg my-2 task-create"
                data-toggle="modal" data-target="#taskModifyModal" data-parent="${column['id']}">
                <i class="fa fa-plus"></i> Add Task
            </button>
        </div>
    </div>`;

    return columnString;
}


$.fn.addColumn = function(column) {
    
    $('#kanbanBoard .card-group').css(`width`,  `${(column['position'] + 1) * 25}%`);
    
    $('#addColumn').before(columnBuilder(column));
};


// Kanban
$.fn.highlightTask = function(userId) {
    
    userId = userId == null ? getUserId() : userId;

    $(document).getUserTeamTask(userId).done(function (data) {

        $.each(data, function(i, item) {
            $(`#kanbanBoard .kanban-task[data-value="${item['id']}"]`).toggleClass('active');
        })
    }).always(function () {

        $('#kanbanBoard').toggleClass('highlight');
    });
};  