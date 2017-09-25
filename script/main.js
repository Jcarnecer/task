const baseUrl = window.location.origin + '/task/';
var authorId = null;

function setAuthorId(id) {
    author_id = id;
}


function getAuthorId() {
    return author_id;
}


// jQuery


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
    $.ajax({
        type: 'POST',
        url: `${baseUrl}api/note/${taskId}`,
        data: details,
        dataType: 'json'
    })
}


$.fn.getTeam = function(id = null) {
    return $.ajax({
        type: 'GET',
        url: `${baseUrl}api/team` + (id != null ? `/${id}` : ''),
        dataType: 'json'
    });
};


$.fn.postTeam = function(details, id = null) {
    return $.ajax({
        type: 'POST',
        url: `${baseUrl}api/team` + (id != null ? `/${id}` : ''),
        dataType: 'json',
        data: details
    });
};

// Team

$.fn.displayMember = function(items, edit = false) {
    $.each(items, function(i, item) {

        if(edit)
            $('.team-member-list').find('.team-member').before(
                `<span class="label label-default">${item['first_name']} ${item['last_name']} <a class="team-member-remove" data-value="${item['email_address']}">&times;</a></span>`
            );
        else
            $('.team-member-list').append(
                `<span class="label label-default">${item['first_name']} ${item['last_name']}</span>`
            );
        if(edit)
            $('.team-member-list').parent().append(
                `<input type="hidden" name="members[]" value="${item['email_address']}" />`
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

        if(edit)
            $('.task-tag-list').find('.task-tag').before(
                `<span class="label label-default">${item['name']} <a class="task-tag-remove" data-value="${item['name']}">&times;</a></span>`
            );
        else
            $('.task-tag-list').append(
                `<span class="label label-default">${item['name']}</span>`
            );
        if(edit)
            $('.task-tag-list').parent().append(
                `<input type="hidden" name="tags[]" value="${item['name']}" />`
            );
    });
};


$.fn.displayNote = function(items) {
    $.each(items, function(i, item){
        $('.task-note-list').append(
            // `<div class="row task-note-list-item">
                `<div class="col-md-2">
                    <div class="task-note-user circle"></div>
                </div>
                <div class="col-md-10 well well-sm task-note-text">
                    ${item['body']}
                </div>`
            // </div>`
        );
    });
}


$.fn.displayTask = function(items, rowNumber = 4) {
    $('#taskTileList').html('');

    rowNumber = 12/rowNumber;

    $.each(items, function(i, item) {
        $('#taskTileList').append(
            `<div class="col-md-${rowNumber}" style="padding:3px;">
                <div class="task-tile container-fluid" style="background-color:` + (item['status'] == 1 ? item['color'] : '#808080') + `;">
                    <div class="row">
                        <div class="col-md-2" style="padding-top:5%;">
                            <a class="task-mark-done" data-value="${item['id']}"><span class="glyphicon glyphicon-` + (item['status'] == 1 ? `unchecked` : `check`) + ` pull-right lead" "></span></a>
                        </div>
                        <div class="col-md-10 task-view" data-toggle="modal" data-target="#taskViewModal" data-value="${item['id']}">
                            <span class="tile-title">${item['title']}</span>
                            <br/>
                            <span class="tile-description">${item['description']}</span>
                        </div>
                    </div>
                </div>
            </div>`
        );
    });

    $('#taskTileList').append(
        `<div class="col-md-${rowNumber}" style="padding:3px;">
            <div class="task-tile container-fluid" style="background-color:#ffffff; padding: 5%">
                <a href="#taskModifyModal" data-toggle="modal" class="task-create" style="color:#000000;">
                    <h4 class="heading"><span class="glyphicon glyphicon-plus" style="color:#2780e3;"></span> Create Task</h4>
                </a>
            </div>
        </div>`
    );
};


$.fn.searchTask = function(items, keyword) {
    $('#taskSearchQuery').html('');

    if(keyword == '')
        return;

    $.each(items, function(i, item) {
        if(item['title'].toLowerCase().indexOf(keyword.toLowerCase()) != -1) {
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
        }
    });
};