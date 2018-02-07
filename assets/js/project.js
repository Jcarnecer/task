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

    getProject($(this).attr('data-value')).always(function(data) {

        $('#teamModifyModal').find('form').attr('data-value', data['id']);
        $('#teamModifyModal').find('[name="name"]').val(data['name']);
        
        if(data['admin'] == getUserId()) {
            
            $('#teamModifyModal').find('[name="name"]').prop('readonly', false);
        } else {
            
            $('#teamModifyModal').find('[name="name"]').prop('readonly', true);
            $('#teamModifyModal').find('input.team-member').removeClass('d-inline-block');
            $('#teamModifyModal').find('input.team-member').addClass('d-none');
            $('#teamModifyModal').find('button[type="submit"]').addClass('d-none');
        }

        displayMember(data['members'], data['admin'] == getUserId());
    });
});


$(document).on('click', '.team-leave', function () {

    if(confirm('Are you sure you want to leave this project?')) {

        var project_details = {
            proj_id: getAuthorId()
        }
    
        leaveProject(project_details).always(function () {
    
            window.location.href = `${baseUrl}tasks`;
        });
    }
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

    var $elem = $(this);
    var memberDetail = {
        email_address: $(this).attr('data-value')
    };

    getMember(memberDetail).done(function(data) {

        if(confirm(`Are you sure you want to remove ${data['first_name']} ${data['last_name']} from your project?`)) {
            
            $elem.closest('form').find(`input[name="members[]"][value="${$elem.attr('data-value')}"]`).remove();
            $elem.parent().remove();
        }
    });
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
                    author_id:  data['project_id']
                };

                createBoard(boardDetails);

                if($(this).has('.close-modal')) {
                    
                    $(this).find('.close-modal').click();
                }

                window.location.href = `${baseUrl}project/${data['project_id']}`;
            });
        } else if($(this).attr('id') == 'teamUpdateForm') {
        
            teamDetails.push({name: 'id', value: $(this).attr('data-value')});

            updateProject(teamDetails).always(function() {

                location.reload();
            });
        }
    }
});

});