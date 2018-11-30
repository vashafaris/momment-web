$(document).ready(function(){
    $('#save-subscriber').click(function (event) {
        event.preventDefault();

        $('.card .body').waitMe(loading);

        var data = {
            company: $('#company').val(),
            fullname: $('#fullname').val(),
            username: $('#username').val(),
            email: $('#email').val()
        };

        axios.post(baseUrl + 'api/account/subscribe', data).then(function (response) {
            $('.card .body').waitMe('hide');
            if(response.data.success) {
                window.location = baseUrl + 'setting/subscriber';
            } else {
                console.log(response.data)

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