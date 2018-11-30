$(document).ready(function(){
    $('.card .body').waitMe(loading);
    var companyId = '';

    axios.get(baseUrl + 'api/setting').then(function(response) {
        var profile = response.data;

        if(profile.success) {
            $('.card .body').waitMe('hide');
            var data = profile.data.account;
            companyId = data.account.id;

            $('#company').val(data.account.company_name).parent().addClass('focused');
        }
    });

    $('#save-subscriber').click(function (event) {
        event.preventDefault();

        $('.card .body').waitMe(loading);

        try {
            $('label.error').html('').parents('.form-line').removeClass('error');
        } catch (e) {}

        var data = {
            company: $('#company').val(),
        };

        axios.post(baseUrl + 'api/account/edit?a='+companyId, data).then(function (response) {
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