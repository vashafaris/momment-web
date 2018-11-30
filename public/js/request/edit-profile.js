$(document).ready(function(){

    $('.card .body').waitMe(loading);

    axios.get(baseUrl + 'api/department').then(function(res) {
        var department = res.data;

        $('#dept_id').html('<option value="" disabled selected>Select Department</option>');
        _.forEach(department.data.departments, function(dept) {
            $('#dept_id').append('<option value="'+dept.id+'">'+dept.name+'</option>')
        });
        $('#dept_id').selectpicker('destroy').selectpicker('render');

        axios.get(baseUrl + 'api/setting').then(function(response) {
            var profile = response.data;

            if(profile.success) {

                $('.card .body').waitMe('hide');

                var data = profile.data.account;
                $('#fullname').val(data.fullname).parent().addClass('focused');
                $('#username').val(data.username).parent().addClass('focused');
                $('#email').val(data.email).parent().addClass('focused');
                $('#dept_id').selectpicker('val', data.dept_id).trigger('change')
            }
        });
    });

    $('#save-profile').click(function (event) {
        event.preventDefault();

        $('.card .body').waitMe(loading);

        try {
            $('label.error').html('').parents('.form-line').removeClass('error');
        } catch (e) {}

        var data = {
            fullname: $('#fullname').val(),
            email: $('#email').val(),
            dept_id: $('#dept_id').val()
        };

        axios.post(baseUrl + 'api/setting/edit', data).then(function (response) {
            $('.card .body').waitMe('hide');
            if(response.data.success) {
                window.location = baseUrl + 'setting/profile';
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