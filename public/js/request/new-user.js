$(document).ready(function(){

    $('#permission-field').fadeOut();

    $('#role').change(function (event) {
        if ($('#role').val() === 'user')
            $('#permission-field').fadeIn();
        else
            $('#permission-field').fadeOut();
    });

    $('input#permission-O, input#permission-T').change(function (event) {
        if ($('input#permission-O').is(':checked')) {
            $('input#permission-Oc').prop('disabled', false);
            $('input#permission-Oe').prop('disabled', false);
            $('input#permission-Od').prop('disabled', false);
        } else {
            $('input#permission-Oc').prop('checked', false).prop('disabled', true);
            $('input#permission-Oe').prop('checked', false).prop('disabled', true);
            $('input#permission-Od').prop('checked', false).prop('disabled', true);
        }

        if ($('input#permission-T').is(':checked')) {
            $('input#permission-Tc').prop('disabled', false);
            $('input#permission-Te').prop('disabled', false);
            $('input#permission-Td').prop('disabled', false);
        } else {
            $('input#permission-Tc').prop('checked', false).prop('disabled', true);
            $('input#permission-Te').prop('checked', false).prop('disabled', true);
            $('input#permission-Td').prop('checked', false).prop('disabled', true);
        }
    });
    
    axios.get(baseUrl + 'api/department').then(function(res) {
        var department = res.data;

        $('#dept_id').html('<option value="" disabled selected>Select Department</option>');
        _.forEach(department.data.departments, function(dept) {
            $('#dept_id').append('<option value="'+dept.id+'">'+dept.name+'</option>')
        });
        $('#dept_id').selectpicker('destroy').selectpicker('render');
    });

    axios.get(baseUrl + 'api/user/role').then(function(res) {
        var roles = res.data;

        $('#role').html('<option value="" disabled selected>Select Role</option>');
        _.forEach(roles.data.roles, function(role) {
            $('#role').append('<option value="'+role.value+'">'+role.name+'</option>')
        });
        $('#role').selectpicker('destroy').selectpicker('render');
    });

    $('#save-user').click(function (event) {
        event.preventDefault();

        $('.card .body').waitMe(loading);

        try {
            $('label.error').html('').parents('.form-line').removeClass('error');
        } catch (e) {}

        var permission = [];
        $('input.cb-permission:checked').each(function (index, checkbox) {
            permission.push($(checkbox).val());
        });

        var data = {
            fullname: $('#fullname').val(),
            username: $('#username').val(),
            email: $('#email').val(),
            dept_id: $('#dept_id').val(),
            role: $('#role').val(),
            permission: permission
        };

        axios.post(baseUrl + 'api/user/register', data).then(function (response) {
            $('.card .body').waitMe('hide');
            if(response.data.success) {
                window.location = baseUrl + 'setting/user';
            } else {
                _.forEach(response.data.message, function (item, key) {
                    try {
                        $('#' + key).parents('.form-line').addClass('error');
                    } catch (e) {}

                    var errors = "<ul>";
                    _.forEach(item, function (error) {
                        errors += '<li>' + error + '</li>'
                    });
                    errors += '</ul>';
                    $('#' + key + '-error').html(errors);
                })
            }
        });
    });
});