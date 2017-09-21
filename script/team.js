$(function () {
    
    const baseUrl = window.location.origin + '/task/';
    var authorId = $(document).getTeam()

    // Functions

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

    // Load Modal

    $(document).on('click', '.team-create', function(){
        $('#teamModifyModal').find('form')[0].reset();

        $('#teamModifyModal').find('form').attr('id', 'teamCreateForm');
        $('#teamModifyModal').find('.team-member-list').find('span.label').remove();
        $('#teamModifyModal').find('.team-member-list').siblings('input').remove();
    });
    
    
    $(document).on('click', '.team-edit', function() {
        $('#teamModifyModal').find('form')[0].reset();

        $('#teamModifyModal').find('.team-member-list').find('span.label').remove();
        $('#teamModifyModal').find('.team-member-list').siblings('input').remove();

        $(document).getTeam($(this).attr('data-value')).done(function(data) {
            $('#teamModifyModal').find('form').attr('data-value', data['id']);
            $('#teamModifyModal').find('form').attr('id', 'teamUpdateForm');

            $('#teamModifyModal').find('[name="name"]').val(data['name']);
            $(document).displayMember(data['members'], true);
        });
    });
    
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

    $(document).on('click', '#teamSubmit', function () {
        var team = $(this).closest('form').serializeArray();
        
        if($(this).closest('form').attr('id') == 'teamCreateForm')
            $(document).postTeam(team);
        else if($(this).closest('form').attr('id') == 'teamUpdateForm')
            $(document).postTeam(team, $(this).closest('form').attr('data-value'));
    });
});