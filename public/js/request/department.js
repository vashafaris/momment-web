$(document).ready(function(){

    $('.card .body').waitMe(loading);

    var departmentList = [];
    axios.get(baseUrl + 'api/department').then(function(response) {
        var department = response.data;

        if(department.success) {

            $('.card .body').waitMe('hide');

            departmentList = department.data.departments;

            $('#department-table').DataTable({
                data: departmentList,
                columns: [
                    {
                        data: 'name',
                        title: 'Name'
                    },
                    {
                        data: 'id',
                        title: 'Action'
                    },
                ],
                columnDefs: [
                    {
                        targets: 1,
                        data: 'id',
                        render: function ( data, type, row, meta ) {
                            return '<button type="button" data-toggle="tooltip" title="Edit Department" data-id="' + data + '" class="button-edit btn btn-xs btn-primary waves-effect">' +
                                '   <i class="fas fa-edit"></i>' +
                                '</button> ' +
                                '<button type="button" data-id="' + data + '" data-name="' + row.name + '" class="button-delete btn btn-xs btn-danger waves-effect" data-toggle="tooltip" title="Delete Department">'+
                                '   <i class="far fa-trash-alt"></i>' +
                                '</button>'
                        }
                    }
                ]
            })
        }
    });

    $('#department-table').on('click', '.button-edit', function(e){
        var filter = $(this).data('id');
        var data = _.find(departmentList, function (item) {
            return parseInt(item.id) === parseInt(filter);
        });

        localStorage.setItem('editDepartment', JSON.stringify(data));

        window.location = baseUrl + 'setting/department/edit';
    });

    $('#department-table').on('click', '.button-delete', function(e){
        $('.card .body').waitMe(loading);
        var name = $(this).data('name');
        swal({
            title: "Warning !",
            text: "Are you sure to delete " + name + " department ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((reset) => {
            if(reset) {
                axios.get(baseUrl + 'api/department/delete?d=' + $(this).data('id')).then(function(response) {
                    $('.card .body').waitMe('hide');
                    var data = response.data;
                    if(data.success) {
                        swal("Success", data.message.department[0], "success").then(function (val) {
                            window.location = baseUrl + 'setting/department';
                        })
                    } else {
                        console.log(response)
                    }
                });
            } else {
                $('.card .body').waitMe('hide');
            }
        });
    });
});