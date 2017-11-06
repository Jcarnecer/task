$.fn.getUser = function(userId) {

    return $.ajax({
        
        type: 'GET',
        url: `${baseUrl}api/user/${userId}`,
        dataType: 'json'
    });
};


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


$.fn.getBoard = function(userId, boardId = null) {

    return $.ajax({

        type: 'GET',
        url: `${baseUrl}api/board/${userId}` + (boardId != null ? `/${boardId}` : ''),
        dataType: 'json'
    });
};


$.fn.postBoard = function(details, userId, boardId = null) {
    
    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/board/${userId}` + (boardId != null ? `/${boardId}` : ''),
        dataType: 'json',
        data: details
    });
};


$.fn.getColumn = function(boardId) {

    return $.ajax({

        type: 'GET',
        url: `${baseUrl}api/column/${boardId}`,
        dataType: 'json'
    });
};


$.fn.postColumn = function(boardId, columnName) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/column`,
        dataType: 'json',
        data: {
            name: columnName
        }
    });
};


$.fn.changeColumn = function(details, taskId) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/change_column/${taskId}`,
        datType: 'json',
        data: details
    });
};


$.fn.getUserTeamTask = function(userId) {

    return $.ajax({

        type: 'GET',
        url: `${baseUrl}api/get_user_team_task/${userId}`,
        dataType: 'json'
    });
};