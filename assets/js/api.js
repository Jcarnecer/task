function getUser(userId) {

    return $.ajax({
         
        async: false,
        type: 'GET',
        url: `${baseUrl}api/user/${userId}`,
        dataType: 'json'
    });
};

// Task
// Task Fetch
function getTask(taskId) {

    return $.ajax({

        type: 'GET',
        url: `${baseUrl}api/task/get`,
        data: {
            id: taskId
        },
        dataType: 'json'
    });
};


// Task Fetch All
function getAllTask(asyncMode = true) {

    return $.ajax({

        async: asyncMode,
        type: 'GET',
        url: `${baseUrl}api/task/get_all`,
        data: {
            author_id: getAuthorId()
        },
        dataType: 'json'
    });
};


// Task Create
function addTask(details) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/task/insert`,
        data: details,
        dataType: 'json'
    });
};


// Task Update
function updateTask(details) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/task/update`,
        data: details,
        dataType: 'json'
    });
};


// Task Archive
function archiveTask(taskId) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/task/archive`,
        data: {
            id: taskId
        },
        dataType: 'json'
    });
}


// Task Add Note
function addNote(message, taskId) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/note/${taskId}`,
        data: {
            notes: message
        },
        dataType: 'json'
    })
};


// Task Fetch User Task
function getActorTask(userId) {

    return $.ajax({

        type: 'GET',
        url: `${baseUrl}api/task/get_user_task`,
        data: {
            actor_id: userId
        },
        dataType: 'json'
    });
};


// Task Change Column
function changeTaskColumn(details) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/task/change_column`,
        data: details,
        datType: 'json'
    });
};

// Board
// Board Fetch
function getBoard() {

    return $.ajax({

        async: false,
        type: 'GET',
        url: `${baseUrl}api/board/get`,
        data: {
            author_id: getAuthorId()
        },
        dataType: 'json'
    });
};


// Board Create
function createBoard(details) {
    
    return $.ajax({

        async: false,
        type: 'POST',
        url: `${baseUrl}api/board/insert`,
        data: details,
        dataType: 'json'
    });
};


// Column
// Column Fetch
function getColumn(columnId) {

    return $.ajax({

        type: 'GET',
        url: `${baseUrl}api/column/get`,
        data: {
            id: columnId
        },
        dataType: 'json'
    });
};


// Column Fetch All
function getAllColumn(boardId) {

    return $.ajax({

        async: false,
        type: 'GET',
        url: `${baseUrl}api/column/get_all`,
        data: {
            board_id: boardId
        },
        dataType: 'json'
    });
};


// Column Create
function createColumn(details) {

    return $.ajax({

        async: false,
        type: 'POST',
        url: `${baseUrl}api/column/insert`,
        data: details,
        dataType: 'json'
    });
};


// Column Update
function updateColumn(details) {

    return $.ajax({

        async: false,
        type: 'POST',
        url: `${baseUrl}api/column/update`,
        data: details,
        dataType: 'json'
    });
};


// Column Delete
function deleteColumn(details) {

    return $.ajax({

        async: false,
        type: 'POST',
        url: `${baseUrl}api/column/delete`,
        data: details,
        dataType: 'json'        
    });
};


// Column Change Position
function changeColumnsPosition(details) {

    return $.ajax({

        async: false,
        type: 'POST',
        url: `${baseUrl}api/column/change_position`,
        dataType: 'json',
        data: details
    });
}


// Project
// Project Fetch
function getProject(projectId) {

    return $.ajax({

        type: 'GET',
        url: `${baseUrl}api/project/get`,
        data: {
            id: projectId
        },
        dataType: 'json'
    });
};


// Project Create
function createProject(details, teamId = null) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/project/insert`,
        data: details,
        dataType: 'json'
    });
};


// Project Update
function updateProject(details) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/project/update`,
        data: details,
        dataType: 'json'
    });
};


// Project Leave
function leaveProject(details) {

    return $.ajax({

        type: 'POST',
        url: `${baseUrl}api/project/leave`,
        data: details,
        dataType: 'json'
    });
};


function getMember(details) {

    return $.ajax({
         
        async: false,
        type: 'GET',
        url: `${baseUrl}api/project/get_member`,
        data: details,
        dataType: 'json'
    });
};


// Project Validate Member
function validateMember(details) {

    return $.ajax({

        async: false,
        type: 'POST',
        url: `${baseUrl}api/project/validate_member`,
        data: details,
        dataType: 'json'
    });
};