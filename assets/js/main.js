const baseUrl = window.location.origin + '/task/';
var authorId = null;
var taskType = null;


function setAuthorId(id) { authorId = id; }


function getAuthorId() { return authorId; }


function setTaskType(type) { taskType = type; }


function getTaskType() { return taskType; }


// AJAX
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


// Team
$.fn.displayMember = function(items, edit = false) {

    $.each(items, function(i, item) {

        if(edit) {

            $('.team-member-list').find('.team-member').before(
                `<span class="label label-default">${item['first_name']} ${item['last_name']} <a class="team-member-remove" data-value="${item['email_address']}">&times;</a></span>`
            );
            $('.team-member-list').parent().append(
                `<input type="hidden" name="members[]" value="${item['email_address']}" />`
            );
        } else

            $('.team-member-list').append(
                `<span class="label label-default">${item['first_name']} ${item['last_name']}</span>`
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
$.fn.displayTag = function(items, edit = false) {

    $.each(items, function(i, item) {

        if(edit) {

            $('.task-tag-list').find('.task-tag').before(
                `<span class="label label-default">${item['name']} <a class="task-tag-remove" data-value="${item['name']}">&times;</a></span>`
            );
            $('.task-tag-list').parent().append(
                `<input type="hidden" name="tags[]" value="${item['name']}" />`
            );
        } else

            $('.task-tag-list').append(
                `<span class="label label-default">${item['name']}</span>`
            );
    });
};


$.fn.displayNote = function(items) {

    $.each(items, function(i, item){

        $('.task-note-list').append(
            `<div class="col-md-2">
                <div class="task-note-user circle"></div>
            </div>
            <div class="col-md-10 well well-sm task-note-text">
                ${item['body']}
            </div>`
        );
    });
}


$.fn.displayTask = function($container, items, colNumber = 3) {
    
    colNumber = 12/colNumber;
    
    $container.html('');

    $.each(items, function(i, item) {

        $container.append(
            `<div data-order=${i} class="col-md-${colNumber}">

                <div id="${item['id']}" draggable="true" ondragstart="drag(event)" style="background-color:` + (item['status'] == 1 ? item['color'] : '#808080') + `; padding: 20px;">
                    <div class="container">    
                        <div class="row">
                            <div class="col-md-2">
                                <a class="task-mark-done" data-value="${item['id']}"><span class="glyphicon glyphicon-` + (item['status'] == 1 ? `unchecked` : `check`) + ` pull-right lead" "></span></a>
                            </div>
                            <div class="col-md-10 task-view" data-toggle="modal" data-target="#taskViewModal" data-value="${item['id']}">
                                <span class="tile-title">${item['title']}</span>
                                <br/>
                                <span class="tile-description">${item['description']}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>`
        );

        // ondrop="drop(event)" ondragover="allowDrop(event)"
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