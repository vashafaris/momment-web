$(document).ready(function(){

    const editItem = JSON.parse(localStorage.getItem('editSubscriber'));

    $('#company').val(editItem.company_name).parent().addClass('focused');

    $('#save-subscriber').click(function (event) {
        event.preventDefault();
        localStorage.removeItem('editSubscriber');

        $('.card .body').waitMe(loading);

        try {
            $('label.error').html('').parents('.form-line').removeClass('error');
        } catch (e) {}

        var data = {
            company: $('#company').val(),
        };

        axios.post(baseUrl + 'api/account/edit?a='+editItem.id, data).then(function (response) {
            $('.card .body').waitMe('hide');
            if(response.data.success) {
                window.location = baseUrl + 'setting/subscriber';
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