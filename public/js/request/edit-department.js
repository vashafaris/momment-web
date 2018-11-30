$(document).ready(function(){

    const editItem = JSON.parse(localStorage.getItem('editDepartment'));

    $('#name').val(editItem.name).parent().addClass('focused');

    $('#save-department').click(function (event) {
        event.preventDefault();
        localStorage.removeItem('editDepartment');

        $('.card .body').waitMe(loading);

        try {
            $('label.error').html('').parents('.form-line').removeClass('error');
        } catch (e) {}

        var data = {
            name: $('#name').val(),
        };

        axios.post(baseUrl + 'api/department/edit?d='+editItem.id, data).then(function (response) {
            $('.card .body').waitMe('hide');
            if(response.data.success) {
                window.location = baseUrl + 'setting/department';
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