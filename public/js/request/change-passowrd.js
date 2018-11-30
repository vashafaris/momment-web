$(document).ready(function(){
    $('#change-password').click(function (event) {
        event.preventDefault();

        $('.card .body').waitMe(loading);

        try {
            $('label.error').html('').parents('.form-line').removeClass('error');
        } catch (e) {}

        var new_pass = $('#new_password').val();
        var new_pass_conf = $('#new_password_confirm').val();

        if (new_pass === new_pass_conf) {
            var data = {
                old_password: $('#old_password').val(),
                new_password: new_pass
            };

            axios.post(baseUrl + 'api/setting/password', data).then(function (response) {
                $('.card .body').waitMe('hide');
                if (response.data.success) {
                    window.location = baseUrl + 'setting/profile';
                } else {
                    _.forEach(response.data.message, function (item, key) {
                        try {
                            $('#' + key).parents('.form-line').addClass('error');
                        } catch (e) {
                        }

                        var errors = "<ul>";
                        _.forEach(item, function (error) {
                            errors += '<li>' + error + '</li>'
                        });
                        errors += '</ul>';
                        $('#' + key + '-error').html(errors);
                    })
                }
            });
        } else {
            $('.card .body').waitMe('hide');
            $('#new_password_confirm').parents('.form-line').addClass('error');
            $('#new_password_confirm-error').html('<ul>' +
                '<li>Password doesn\'t match</li>' +
            '</ul>');
        }
    });
});