$(function () {
    
    const baseUrl = window.location.origin + '/task/';

    // Functions

    $.fn.postTeam = function(details, id = null) {
        return $.ajax({
            type: 'POST',
            url: `${baseUrl}api/team` + (id != null ? `/${id}` : ''),
            dataType: 'json',
            data: details
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
    
    // Team Member

    $('.team-member').keypress(function (e) {
        if(e.which == 13 || e.which == 32) {
            var result = $(document).validateMember($(this).val().toLowerCase());
            
            if(result['exist']) {
                if(!$(this).closest('.team-member-list').parent().has(`input[name="members[]"][value="${$(this).val().toLowerCase()}"]`).length){

                    $(this).before(
                        `<span class="label label-default">${result['first_name']} ${result['last_name']} <a class="team-member-remove" data-value="${$(this).val().toLowerCase()}">&times;</a></span>`
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


    $(document).on('click', '.team-member-remove', function() {
        $(this).closest('.team-member-list').parent().find(`input[name="members[]"][value="${$(this).attr('data-value')}"]`).remove();
        $(this).parent().remove();
    });

    // Submit

    $(document).on('click', '#teamCreateButton', function () {
        var team = $('#teamCreateForm').serializeArray();

        $(document).postTeam(team);
    });
});