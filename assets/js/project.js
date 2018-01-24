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

    getProject($(this).data('value')).always(function(data) {

        $('#teamModifyModal').find('form').attr('data-value', data['id']);
        $('#teamModifyModal').find('[name="name"]').val(data['name']);

        displayMember(data['members'], true);
    });
});


$(document).on('click', '.team-leave', function () {

    var project_details = {
        proj_id: getAuthorId()
    }

    leaveProject(project_details).always(function () {

        window.location.href = `${baseUrl}tasks`;
    });
});


// Team Member
$(document).on('keypress', '.team-member', function (e) {

    if(e.which == 13 || e.which == 32) {

        e.preventDefault();

        data = {
            email: $(this).val().toLowerCase()
        };

        var result = validateMember(data).responseJSON;
        
        if(result['exists']) {

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

    $(this).closest('form').find(`input[name="members[]"][value="${$(this).data('value')}"]`).remove();
    $(this).parent().remove();
});


// Submit
$(document).on('submit', 'form#teamCreateForm, form#teamUpdateForm', function (e) {

    var teamDetails = $(this).serializeArray();

    e.preventDefault();

    if($(this).find('input[required]').val() != '') {
        
        if($(this).has('.close-modal')) {
            
            $(this).find('.close-modal').click();
        }

        if($(this).attr('id') == 'teamCreateForm') {
            
            createProject(teamDetails).always(function(data) {
                
                var boardDetails = {
                    name:       "Default",
                    author_id:  data['team_id']
                };

                createBoard(boardDetails);

                if($(this).has('.close-modal')) {
                    
                    $(this).find('.close-modal').click();
                }

                window.location.href = `${baseUrl}project/${data['team_id']}`;
            });
        } else if($(this).attr('id') == 'teamUpdateForm') {
        
            teamDetails.push({name: id, value: $(this).data('value')})

            updateProject(teamDetails).always(function() {

                location.reload();
            });
        }
    }
});

});