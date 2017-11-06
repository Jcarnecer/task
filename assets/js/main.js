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


$.fn.validateMember = function(value) {

    return $.ajax({

        async: false,
        type: 'POST',
        url: `${baseUrl}api/validate_member`,
        data: {
            email: value
        },
        dataType: 'json'
    }).responseJSON;
};


$.fn.leaveTeam = function(teamId, userId) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/leave_team/${teamId}`,
        dataType: 'json'
    });
};


// Task
$.fn.resetForm = function() {
    
    // $('#taskModifyModal').find('form')[0].reset();
    // $('#taskModifyModal').find('.task-actor-list').siblings('input').remove();
    // $('#taskModifyModal').find('.task-actor-list').find('span.badge').remove();
    // $('#taskModifyModal').find('.task-tag-list').siblings('input').remove();
    // $('#taskModifyModal').find('.task-tag-list').find('span.badge').remove();
    // $('#taskModifyModal').find('.modal-content').css('background-color', '#ffffff');
    // $('#taskModifyModal').find('.btn-color').find('i').removeClass('fa fa-check fa-lg');
    // $('#taskModifyModal').find(`button[data-value="#ffffff"] i`).addClass('fa fa-check fa-lg');

    if(getTaskType() == 'personal')
    
        $('#personalCreate').find('form')[0].reset();
    else if(getTaskType() == 'team')
        
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


$.fn.displayTask = function(type, items, column = 3) {
    
    var $containers = [];
    var status = [1, 4, 2];

    switch(type) {
        case 'personal':
            $containers.push($('#taskTileList'));
            column = 4;
            break;

        case 'team':
            $containers.push($('#todoTask .card-body'));
            $containers.push($('#doingTask .card-body'));
            $containers.push($('#doneTask .card-body'));
            column = 2;
            break;
    }

    colNumber = 12/column;

    $.each($containers, function(i, $container) {
        $container.html('');
        
        $.each(items, function(j, item) {
            
            var actorsAppend = "<strong>Contributor</strong><br/>";

            if(item['actors'].length) {

                $.each(item['actors'], function (i, actor) {
                    actorsAppend = actorsAppend + actor['first_name'] + " " + actor['last_name'] + "<br/>";
                });
            } else {
                
                actorsAppend = "No Contributor";
            }

            var contributorAppend = `data-toggle="popover" data-trigger="hover" data-html="true" data-placement="right" data-content="${actorsAppend}"`;

            if(status[i] == item['status']) {

                $container.prepend(
                    `<div class="card my-1 rounded task-view" 
                        draggable="true" ondragstart="drag(event)" 
                        data-toggle="modal" data-target="#taskViewModal" data-value="${item['id']}" 
                        style="background-color:${item['color']};">
                        
                        <div class="card-body" ${getTaskType() == 'team' ? contributorAppend : ''}>
                            <h5 class="card-title">
                                ${getTaskType() == 'team' ? 
                                    item['actors'].length ? 
                                        item['actors'].length > 1 ? 
                                            '<i class="fa fa-users"></i>' : 
                                            '<i class="fa fa-user"></i>' : 
                                        '<i class="fa fa-user-o"></i>' : 
                                    ''} 

                                ${item['title']}
                            </h5>
                        </div>

                    </div>`
                );
            }
        });

        if($container.is('#todoTask .card-body')) {

            $container.append(
                `<div class="card my-1 rounded task-create" 
                data-toggle="modal" data-target="#taskModifyModal">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fa fa-plus"></i> Add Task
                        </h5>
                    </div>
                </div>`
            );
        }
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


{/* <div class="card task-create" data-value="${id}">
    <div class="card-body">
        <h2 class="card-title">Add Task</h2>
    </div>
</div> */}

// Column Builder
function columnBuilder(id, name, position) {
    var columnString = 
    `<div class="card h-100 w-25" data-value="${id} data-position="${position}">
        <h2 class="card-header clearfix">
            <span class="float-left">${name}</span>
            <span>
                <div class="dropdown">
                    <a class="btn btn-link dropdown-toggle float-right" id="columnMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                    <div class="dropdown-menu" aria-labelledby="columnMenuButton">
                        <a class="dropdown-item" href="#">Rename</a>
                        <a class="dropdown-item" href="#">Delete</a>
                    </div>
                </div>
            </span>
        </h2>
        <div class="card-body text-center" style="overflow-y: auto;">
            <button type="button" class="btn btn-primary btn-lg task-create"
                data-toggle="modal" data-target="#taskModifyModal" data-parent="${id}">
                <i class="fa fa-plus"></i> Add Task
            </button>
        </div>
    </div>`;

    return columnString;
}


// Board
$.fn.displayBoard = function(board) {

    $('#kanbanBoard .card-group').html('');

    $('#kanbanBoard .card-group').css(`width`,  `${(board['columns'].length + 1) * 25}%`);

    $.each(board['columns'], function(i, column) {

        $('#kanbanBoard .card-group').append(columnBuilder(column['id'], column['name'], column['position']));
    });
    
    $('#kanbanBoard .card-group').append(`
        <div id="addColumn" class="card h-100 w-25">
            <h2 class="card-header text-center">
                <i class="fa fa-plus"></i>
                <span id="addColumnName" contenteditable="true">Add Column</span>
            </h2>
            <div class="card-body"></div>
        </div>
    `);
};


// Column
$.fn.addColumn = function(column) {
    
    $('#kanbanBoard .card-group').css(`width`,  `${(column['position'] + 1) * 25}%`);
    
    $('#addColumn').before(columnBuilder(column['id'], column['name'], column['position']));
};


// Kanban
$.fn.highlightTask = function(userId) {
    
    userId = userId == null ? getUserId() : userId;

    $(document).getUserTeamTask(userId).done(function (data) {

        $.each(data, function(i, item) {
            $(`#kanbanBoard .task-tile[data-value="${item['id']}"]`).toggleClass('active');
        })
    }).always(function () {

        $('#kanbanBoard').toggleClass('highlight');
    });
};  