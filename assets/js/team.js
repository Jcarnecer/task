$(function () {

// Highlight
$(document).on('click', '#highlightBtn', function () {
    $(document).highlightTask(getUserId());
});


// Initiate
$(document).getBoard(getAuthorId()).done(function(data) {
    $('#kanbanBoard').attr('data-value', data['id']);
    $(document).displayBoard(data);
});


// Load Modal
$(document).on('click', '.team-create', function () {

    $('#teamModifyModal').find('form')[0].reset();
    $('#teamModifyModal').find('form').attr('id', 'teamCreateForm');
    $('#teamModifyModal').find('.team-member-list').find('span.badge.badge-secondary').remove();
    $('#teamModifyModal').find('.team-member-list').siblings('input').remove();
});


$(document).on('click', '.team-edit', function () {

    $('#teamModifyModal').find('form')[0].reset();
    $('#teamModifyModal').find('.team-member-list').find('span.badge.badge-secondary').remove();
    $('#teamModifyModal').find('.team-member-list').siblings('input').remove();

    $(document).getTeam($(this).attr('data-value')).always(function(data) {

        $('#teamModifyModal').find('form').attr('data-value', data['id']);
        $('#teamModifyModal').find('form').attr('id', 'teamUpdateForm');
        $('#teamModifyModal').find('[name="name"]').val(data['name']);

        $(document).displayMember(data['members'], true);
    });
});


$(document).on('click', '.team-leave', function () {

    $(document).leaveTeam(getAuthorId()).always(function () {

        window.location.href = `${baseUrl}tasks`;
    });
});


// Team Member
$(document).on('keypress', '.team-member', function (e) {

    if(e.which == 13 || e.which == 32) {

        var result = $(document).validateMember($(this).val().toLowerCase());
        
        if(result['exist']) {

            if(!$(this).closest('.team-member-list').parent().has(`input[name="members[]"][value="${$(this).val().toLowerCase()}"]`).length){

                $(this).before(
                    `<span class="badge badge-secondary">${result['first_name']} ${result['last_name']} <a class="team-member-remove" data-value="${$(this).val().toLowerCase()}">&times;</a></span>`
                );

                $(this).closest('.team-member-list').parent().append(
                    `<input type="hidden" name="members[]" value="${$(this).val().toLowerCase()}" />`
                );
            }
        } else {

            alert('User does not exist in the company');
        }

        $(this).val('');

        return false;
    }
});


$(document).on('click', '.team-member-remove', function () {

    $(this).closest('.team-member-list').parent().find(`input[name="members[]"][value="${$(this).attr('data-value')}"]`).remove();
    $(this).parent().remove();
});


// Submit
$(document).on('submit', 'form#teamCreateForm, form#teamUpdateForm', function (e) {

    e.preventDefault();
    var team = $(this).serializeArray();
    var teamId = null;
    
    if($(this).attr('id') == 'teamCreateForm')

        $(document).postTeam(team).done(function(data) {
            
            var boardDetails = new Object();
            boardDetails.name = "Default";
            $(document).postBoard(boardDetails, data['team_id']);
        }).always(function(data) {

            window.location.href = `${baseUrl}team/${data['team_id']}`;
        });
    else if($(this).attr('id') == 'teamUpdateForm')
    
        $(document).postTeam(team, $(this).attr('data-value')).always(function() {

            location.reload();
        });
});

}); 