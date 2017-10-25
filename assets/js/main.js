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


// AJAX
$.fn.getUser = function(userId) {

    return $.ajax({
        
        type: 'GET',
        url: `${baseUrl}api/user/${userId}`,
        dataType: 'json'
    });
}


$.fn.getTask = function(taskId = null) {

    return $.ajax({

        type: 'GET',
        url: `${baseUrl}api/task/${getAuthorId()}` + (taskId != null ? `/${taskId}` : ''),
        dataType: 'json'
    });
};


$.fn.postTask = function(details, taskId = null) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/task/${getAuthorId()}` + (taskId != null ? `/${taskId}` : ''),
        data: details,
        dataType: 'json'
    });
};


$.fn.getTaskNote = function(taskId) {

    return $.ajax({

        type: 'GET',
        url: `${baseUrl}api/note/${taskId}`,
        dataType: 'json'
    });
}


$.fn.postTaskNote = function(details, taskId) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/note/${taskId}`,
        data: details,
        dataType: 'json'
    })
}


$.fn.getTeam = function(teamId = null) {

    return $.ajax({

        type: 'GET',
        url: `${baseUrl}api/team` + (teamId != null ? `/${teamId}` : ''),
        dataType: 'json'
    });
};


$.fn.postTeam = function(details, teamId = null) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/team` + (teamId != null ? `/${teamId}` : ''),
        dataType: 'json',
        data: details
    });
};


$.fn.changeColumn = function(details, taskId) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/change_column/${taskId}`,
        datType: 'json',
        data: details
    });
}


$.fn.getUserTeamTask = function(userId) {

    return $.ajax({

        type: 'GET',
        url: `${baseUrl}api/get_user_team_task/${userId}`,
        dataType: 'json'
    });
}


// Team
$.fn.displayMember = function(items, edit = false) {

    $.each(items, function(i, item) {

        if(edit) {

            $('.team-member-list').find('.team-member').before(
                `<span class="badge badge-default">${item['first_name']} ${item['last_name']} <a class="team-member-remove" data-value="${item['email_address']}">&times;</a></span>`
            );
            $('.team-member-list').parent().append(
                `<input type="hidden" name="members[]" value="${item['email_address']}" />`
            );
        } else

            $('.team-member-list').append(
                `<span class="badge badge-default">${item['first_name']} ${item['last_name']}</span>`
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
                `<span class="badge badge-default">${item['first_name'] + ' ' + item['last_name']} <a class="task-actor-remove" data-value="${item['email_address']}">&times;</a></span>`
            );

            $('.task-actor-list').parent().append(
                `<input type="hidden" name="actors[]" value="${item['email_address']}" />`
            );
        } else

            $('.task-actor-list').append(
                `<span class="badge badge-default">${item['first_name'] + ' ' + item['last_name']}</span>`
            );
    });
};
    

$.fn.displayTag = function(items, edit = false) {

    $.each(items, function(i, item) {

        if(edit) {
                
            $('.task-tag-list').find('.task-tag').before(
                `<span class="badge badge-default">${item['name']} <a class="task-tag-remove" data-value="${item['name']}">&times;</a></span>`
            );
            $('.task-tag-list').parent().append(
                `<input type="hidden" name="tags[]" value="${item['name']}" />`
            );
        } else

            $('.task-tag-list').append(
                `<span class="badge badge-default">${item['name']}</span>`
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
            $containers.push($('#todoPanel>.panel-content'));
            $containers.push($('#doingPanel>.panel-content'));
            $containers.push($('#donePanel>.panel-content'));
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
                    `<div data-order="${j}" class="col-md-${colNumber}">

                        <div class="task-tile task-view w3-card-2 w3-hover-shadow" 
                        data-toggle="modal" data-target="#taskViewModal" data-value="${item['id']}" 
                        draggable="true" ondragstart="drag(event)" 
                        style="background-color:${item['color']};">

                            <div class="container" ${getTaskType() == 'team' ? contributorAppend : ''}>
                                <span class="tile-title">
                                    ${getTaskType() == 'team' ? 
                                        item['actors'].length ? 
                                            item['actors'].length > 1 ? 
                                                '<i class="fa fa-users"></i>' : 
                                                '<i class="fa fa-user"></i>' : 
                                            '<i class="fa fa-user-o"></i>' : 
                                        ''} 
                                    ${item['title']}
                                </span>
                            </div>

                        </div>
                        
                    </div>`
                );
            }
        });

        if($container.is('#todoPanel>.panel-content')) {

            $container.append(
                `<div class="col-md-${colNumber}">
                
                    <div class="task-tile task-create w3-card-2 w3-hover-shadow" data-target="#taskModifyModal" data-toggle="modal">
                        <div class="container"><span class="tile-title"><i class="fa fa-plus fa-lg"></i>&nbsp;&nbsp;&nbsp;Add Task</span></div>
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

            if(item['title'].toLowerCase().indexOf(keyword.toLowerCase()) != -1)

                $('#taskSearchQuery').append(
                    `<li class="list-group-item task-search-item" data-dismiss="modal" style="background-color:${item['color']};">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-1"><a class="task-mark-done" data-value="${item['id']}"><span class="glyphicon glyphicon-` + (item['status'] == 1 ? `unchecked` : `check`) + `"></span></a></div>
                                <div class="col-md-10" data-target="#taskViewModal" data-toggle="modal" data-value="${item['id']}">${item['title']}</div>
                                <div class="col-md-1"><a class="task-edit" href="#taskModifyModal" data-toggle="modal" data-value="${item['id']}"><span class="glyphicon glyphicon-edit"></span></a></div>
                            </div>
                        </div>
                    </li>`
                );
        });
    }
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