$(document).ready(function(){

    $('.card .body').waitMe(loading);

    var userList = [];
    axios.get(baseUrl + 'api/user').then(function(response) {
        var users = response.data;

        if(users.success) {

            $('.card .body').waitMe('hide');

            var company = users.data.account;

            $('#company-name').html(company.company_name);

            userList = company.users;

            $('#user-table').DataTable({
                data: userList,
                columns: [
                    {
                        data: 'fullname',
                        title: 'Name'
                    },
                    {
                        data: 'username',
                        title: 'Username'
                    },
                    {
                        data: 'email',
                        title: 'E-Mail'
                    },
                    {
                        data: 'department.name',
                        title: 'Department',
                        defaultContent: '<span class="col-red">Not Set</span>'
                    },
                    {
                        data: 'role.name',
                        title: 'Role'
                    },
                    {
                        data: 'id',
                        title: 'Action'
                    },
                ],
                columnDefs: [
                    {
                        targets: 5,
                        data: 'id',
                        render: function ( data, type, row, meta ) {
                            if(row.role.name !== 'SA') {
                                return '<button type="button" data-toggle="tooltip" title="Edit User" data-id="' + data + '" class="button-edit btn btn-xs btn-primary waves-effect">' +
                                    '   <i class="fas fa-edit"></i>' +
                                    '</button> ' +
                                    '<button type="button" data-id="' + data + '" data-name="' + row.fullname + '" class="button-reset btn btn-xs btn-warning waves-effect" data-toggle="tooltip" title="Reset Password User">' +
                                    '   <i class="fas fa-redo"></i>' +
                                    '</button> ' +
                                    '<button type="button" data-id="' + data + '" data-name="' + row.fullname + '" class="button-delete btn btn-xs btn-danger waves-effect" data-toggle="tooltip" title="Delete User">'+
                                    '   <i class="far fa-trash-alt"></i>' +
                                    '</button>';
                            } else {
                                return '';
                            }
                        }
                    }
                ]
            })
        }
    });

    $('#user-table').on('click', '.button-edit', function(e){
        var filter = $(this).data('id');
        var data = _.find(userList, function (item) {
            return parseInt(item.id) === parseInt(filter);
        });

        localStorage.setItem('editUser', JSON.stringify(data));

        window.location = baseUrl + 'setting/user/edit';
    });

    $('#user-table').on('click', '.button-reset', function(e){
        $('.card .body').waitMe(loading);
        var name = $(this).data('name');
        swal({
            title: "Warning !",
            text: "Are you sure to reset " + name + "'s password",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((reset) => {
            if(reset) {
                axios.get(baseUrl + 'api/user/reset?u=' + $(this).data('id')).then(function(response) {
                    $('.card .body').waitMe('hide');
                    var data = response.data;
                    if(data.success) {
                        swal("Success", data.message, "success");
                    } else {
                        console.log(response)
                    }
                });
            } else {
                $('.card .body').waitMe('hide');
            }
        });
    });

    $('#user-table').on('click', '.button-delete', function(e){
        $('.card .body').waitMe(loading);
        var name = $(this).data('name');
        swal({
            title: "Warning !",
            text: "Are you sure to delete " + name + " user ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((reset) => {
            if(reset) {
                axios.get(baseUrl + 'api/user/delete?u=' + $(this).data('id')).then(function(response) {
                    $('.card .body').waitMe('hide');
                    var data = response.data;
                    if(data.success) {
                        swal("Success", data.message.user[0], "success").then(function (val) {
                            window.location = baseUrl + 'setting/user';
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