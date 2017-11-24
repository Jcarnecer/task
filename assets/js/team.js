$(function () {


// Load Modal
$(document).on('click', '.team-create', function () {

    $('#teamModifyModal form')[0].reset();
    $('#teamModifyModal form').attr('id', 'teamCreateForm');
    $('#teamModifyModal form').children('input').remove();
    $('#teamModifyModal .team-button-text').html('Create Team');
    $('#teamModifyModal').find('.team-member').siblings('span.badge').remove();
});


$(document).on('click', '.team-edit', function () {
    
    $('#teamModifyModal form')[0].reset();
    $('#teamModifyModal form').attr('id', 'teamUpdateForm');
    $('#teamModifyModal form').children('input').remove();
    $('#teamModifyModal .team-button-text').html('Edit Team');
    $('#teamModifyModal').find('.team-member').siblings('span.badge').remove();

    $(document).getTeam($(this).attr('data-value')).always(function(data) {

        $('#teamModifyModal').find('form').attr('data-value', data['id']);
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

        e.preventDefault();

        var result = $(document).validateMember($(this).val().toLowerCase(), null, true).responseJSON;
        
        if(result['exist']) {

            if(!$(this).closest('form').has(`input[name="members[]"][value="${$(this).val().toLowerCase()}"]`).length){

                $(this).before(
                    `<span class="badge badge-dark mx-1">${result['first_name']} ${result['last_name']} <a class="team-member-remove" data-value="${$(this).val().toLowerCase()}">&times;</a></span>`
                );

                $(this).closest('form').append(
                    `<input type="hidden" name="members[]" value="${$(this).val().toLowerCase()}" />`
                );
            }
        } else {

            alert('User does not exist in the company');
        }

        $(this).val('');
    }
});


$(document).on('click', '.team-member-remove', function () {

    $(this).closest('form').find(`input[name="members[]"][value="${$(this).attr('data-value')}"]`).remove();
    $(this).parent().remove();
});


// Submit
$(document).on('submit', 'form#teamCreateForm, form#teamUpdateForm', function (e) {

    var team = $(this).serializeArray();

    e.preventDefault();

    if($(this).find('input[required]').val() != '') {
        
        if($(this).has('.close-modal')) {
            
            $(this).find('.close-modal').click();
        }

        if($(this).attr('id') == 'teamCreateForm') {
            

            $(document).postTeam(team).always(function(data) {
                
                var boardDetails = new Object();
                boardDetails.name = "Default";
                $(document).postBoard(boardDetails, data['team_id'], null, true);

                if($(this).has('.close-modal')) {
                    
                    $(this).find('.close-modal').click();
                }

                window.location.href = `${baseUrl}team/${data['team_id']}`;
            });
        } else if($(this).attr('id') == 'teamUpdateForm') {
        
            $(document).postTeam(team, $(this).attr('data-value')).always(function() {
                location.reload();
            });
        }
    }
});

});