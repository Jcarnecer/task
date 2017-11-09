$.fn.getUser = function(userId) {

    return $.ajax({
        
        type: 'GET',
        url: `${baseUrl}api/user/${userId}`,
        dataType: 'json'
    });
};



$.fn.getTask = function(taskId = null, syncToggle = false) {

    return $.ajax({

        async: !syncToggle,
        type: 'GET',
        url: `${baseUrl}api/task/${getAuthorId()}` + (taskId != null ? `/${taskId}` : ''),
        dataType: 'json'
    });
};


$.fn.postTask = function(details, taskId = null, syncToggle = false) {

    return $.ajax({

        async: !syncToggle,
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
};


$.fn.postTaskNote = function(details, taskId) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/note/${taskId}`,
        data: details,
        dataType: 'json'
    })
};


$.fn.getTeam = function(teamId = null) {

    return $.ajax({

        type: 'GET',
        url: `${baseUrl}api/board` + (teamId != null ? `/${teamId}` : ''),
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


$.fn.getBoard = function(userId, boardId = null, syncToggle = false) {

    return $.ajax({

        async: !syncToggle,
        type: 'GET',
        url: `${baseUrl}api/board/${userId}` + (boardId != null ? `/${boardId}` : ''),
        dataType: 'json'
    });
};


$.fn.postBoard = function(details, userId, boardId = null, syncToggle = false) {
    
    return $.ajax({

        async: !syncToggle,
        type: 'POST',
        url: `${baseUrl}api/board/${userId}` + (boardId != null ? `/${boardId}` : ''),
        dataType: 'json',
        data: details
    });
};


$.fn.getColumn = function(boardId, columnId = null, syncToggle = false) {

    return $.ajax({

        async: !syncToggle,
        type: 'GET',
        url: `${baseUrl}api/column/${boardId}` + (columnId != null ? `/${columnId}` : ''),
        dataType: 'json'
    });
};


$.fn.postColumn = function(details, boardId, columnId = null, syncToggle = false) {

    return $.ajax({

        async: !syncToggle,
        type: 'POST',
        url: `${baseUrl}api/column/${boardId}` + (columnId != null ? `/${columnId}` : ''),
        dataType: 'json',
        data: details
    });
};


$.fn.deleteColumn = function(columnId, syncToggle = false) {

    return $.ajax({

        async: !syncToggle,
        type: 'POST',
        url: `${baseUrl}api/delete_column/${columnId}`,
        dataType: 'json'        
    });
};


$.fn.changeColumn = function(column, taskId) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/change_column/${taskId}`,
        datType: 'json',
        data: {
            column_id: column
        }
    });
};


$.fn.updatePositions = function(details, syncToggle = false) {

    return $.ajax({

        async: !syncToggle,
        type: 'POST',
        url: `${baseUrl}api/update_columns`,
        dataType: 'json',
        data: details
    });
}


$.fn.getUserTeamTask = function(userId) {

    return $.ajax({

        type: 'GET',
        url: `${baseUrl}api/get_user_team_task/${userId}`,
        dataType: 'json'
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