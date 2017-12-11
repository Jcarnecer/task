const baseUrl = window.location.origin + '/task/';

var userId = null;
var authorId = null;
var taskType = null;
var userName = null;

function setAuthorId(id) { authorId = id; }


function getAuthorId() { return authorId; }


function setTaskType(type) { taskType = type; }


function getTaskType() { return taskType; }


function setUserId(id) { userId = id; }


function getUserId() { return userId; }


// Initiate
$(function() {

$(document).getUser(getUserId(), true).done(function(data) {
    userName = data['first_name'] + ' ' + data['last_name'];
});

});

// Store
function storeTask() {

    return $(document).getTask(null, true).responseJSON;
}


// Builder
function taskBuilder(task, actorIcon = true, modalDismiss = false) {
    
    var taskString = "";
    var actorsAppend = "";
    var contributorsAppend = "";
    var iconAppend = "";
    var modalDismissAppend = modalDismiss ? 'data-dismiss="modal"': '';

    
    if (actorIcon) {
        
        var actors = task['actors'];

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
        ${modalDismissAppend} 
        style="background-color:${task['color']};">
        
        <div class="card-body" ${contributorsAppend}
            draggable="true" ondragstart="drag(event)">
            <h5 class="card-title font-weight-bold">${iconAppend + task['title']}</h5>
        </div>

    </div>`;

    return taskString;
}


function columnMdBuilder(column) {
    
    var columnMdString = 
    `<div class="d-inline-block card border-0 h-100 w-25 kanban-column" 
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
            <button type="button" class="btn btn-primary btn-lg btn-block my-2 task-create"
                data-toggle="modal" data-target="#taskModifyModal" data-parent="${column['id']}">
                <i class="fa fa-plus"></i> Add Task
            </button>
        </div>
    </div>`;

    return columnMdString;
}


function columnSmBuilder(column) {

    var columnSmString = 
    `<div class="d-inline-block card border-0 h-100 w-100 kanban-column" 
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
            <button type="button" class="btn btn-primary btn-lg btn-block my-2 task-create"
                data-toggle="modal" data-target="#taskModifyModal" data-parent="${column['id']}">
                <i class="fa fa-plus"></i> Add Task
            </button>
        </div>
    </div>`;

    return columnSmString;
}


// Team
$.fn.displayMember = function(items, edit = false) {

    $.each(items, function(i, item) {

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
$.fn.resetForm = function() {
    
    $('#taskModifyModal').find('form')[0].reset();

    $('#taskModifyModal form').children('input').remove();
    $('#taskModifyModal').find('.task-tag').siblings('span.badge').remove();
    $('#taskModifyModal').find('.task-actor').siblings('span.badge').remove();
    $('#taskModifyModal').find('.btn-color').find('i').removeClass('fa fa-check fa-lg');
    $('#taskModifyModal').find(`button[data-value="#ffffff"] i`).addClass('fa fa-check fa-lg');
    $('#taskModifyModal .card').css('background-color', '#ffffff');
};


$.fn.displayTask = function(items) {

    $('.kanban-column .task-create').prevAll().remove();
    
    $.each(items, function(i, item) {
        
        $(`.kanban-column[data-value="${item['column_id']}"]>.card-body`).prepend(taskBuilder(item, getTaskType() == 'team'));
    });
};


$.fn.displayActor = function(items, edit = false) {

    $.each(items, function(i, item) {

        if(edit) {

            $('#taskModifyModal .task-actor').before(
                `<span class="badge badge-dark mx-1">${item['first_name'] + ' ' + item['last_name']} <a class="task-actor-remove" data-value="${item['email_address']}">&times;</a></span>`
            );

            $('#taskModifyModal form').append(
                `<input type="hidden" name="actors[]" value="${item['email_address']}" />`
            );
        } else

            $('.task-actor-list').append(
                `<span class="badge badge-dark mx-1">${item['first_name'] + ' ' + item['last_name']}</span>`
            );
    });
};
    

$.fn.displayTag = function(items, edit = false) {

    $.each(items, function(i, item) {

        if(edit) {
                
            $('#taskModifyModal .task-tag').before(
                `<span class="badge badge-dark badge-pill mx-1">${item['name']} <a class="task-tag-remove" data-value="${item['name']}">&times;</a></span>`
            );
            $('#taskModifyModal .task-tag').append(
                `<input type="hidden" name="tags[]" value="${item['name']}" />`
            );
        } else

            $('.task-tag-list').append(
                `<span class="badge badge-dark badge-pill mx-1">${item['name']}</span>`
            );
    });
};


$.fn.displayNote = function(items) {

    $.each(items, function(i, item){

        var user = $(document).getUser(item['user_id'], true).responseJSON;

        $('.task-note-list').append(
            `<div class="col-2">
                <h4 class="text-center"><i class="fa fa-user-circle" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="left" data-content="${user['first_name'] + ' ' + user['last_name']}"></i></h4>
            </div>
            </div>
            <div class="col-10 d-flex align-self-stretch my-1 rounded border border-secondary bg-white text-dark">
                ${item['body']}
            </div>`
        );
    });
}


$.fn.searchTask = function(items, keyword) {

    $('#taskSearchList').html('');

    if(keyword != '') {

        $.each(items, function(i, item) {
            
            if(item['title'].toLowerCase().indexOf(keyword.toLowerCase()) != -1) {
                
                $('#taskSearchList').append(taskBuilder(item, getTaskType() == 'team', true));
            }
        });
    }
};


// Kanban
$.fn.displayBoard = function(board) {

    $('#kanbanSmBoard .kanban-column-holder').html('');
    $('#kanbanMdBoard .kanban-column-holder').html('');

    var newSmWidth = (board['columns'].length + 1) * 100;
    var newMdWidth = (board['columns'].length + 1) * 25;

    newSmWidth = Number(newSmWidth) < 100 ? '100' : newSmWidth;
    newMdWidth = Number(newMdWidth) < 100 ? '100' : newMdWidth;

    $('#kanbanSmBoard .kanban-column-holder').css(`width`, `${newSmWidth}%`);
    $('#kanbanMdBoard .kanban-column-holder').css(`width`, `${newMdWidth}%`);

    $.each(board['columns'], function(i, column) {

        $('#kanbanSmBoard .kanban-column-holder').append(columnSmBuilder(column));
        $('#kanbanMdBoard .kanban-column-holder').append(columnMdBuilder(column));
    });
    
    $('#kanbanSmBoard .kanban-column-holder').append(`
        <div id="addSmColumn" class="card border-0 h-100 w-100">
            <h4 class="card-header w-100">
                <i class="fa fa-plus mx-1"></i>
                <span class="add-column-name" contenteditable="true">Type Here</span>
            </h4>
            <div class="card-body"></div>
        </div>
    `);

    $('#kanbanMdBoard .kanban-column-holder').append(`
        <div id="addMdColumn" class="card border-0 h-100 w-25">
            <h4 class="card-header w-100">
                <i class="fa fa-plus mx-1"></i>
                <span class="add-column-name" contenteditable="true">Type Here</span>
            </h4>
            <div class="card-body"></div>
        </div>
    `);
};


$.fn.addColumn = function(column) {
    
    $('#kanbanSmBoard .kanban-column-holder').css(`width`,  `${(column['position'] + 1) * 100}%`);
    $('#kanbanMdBoard .kanban-column-holder').css(`width`,  `${(column['position'] + 1) * 25}%`);
    
    $('#addSmColumn').before(columnSmBuilder(column));
    $('#addMdColumn').before(columnMdBuilder(column));
};


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