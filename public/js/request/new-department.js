$(document).ready(function(){
    $('#save-department').click(function (event) {
        event.preventDefault();

        $('.card .body').waitMe(loading);

        var data = {
            name: $('#name').val(),
        };

        axios.post(baseUrl + 'api/department/add', data).then(function (response) {
            $('.card .body').waitMe('hide');
            if(response.data.success) {
                window.location = baseUrl + 'setting/department';
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