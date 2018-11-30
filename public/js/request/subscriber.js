$(document).ready(function(){

    $('.card .body').waitMe(loading);

    var subscriber = [];
    axios.get(baseUrl + 'api/account').then(function(response) {
        var users = response.data;

        if(users.success) {

            $('.card .body').waitMe('hide');

            subscriber = users.data.account;

            $('#subscriber-table').DataTable({
                data: subscriber,
                columns: [
                    {
                        data: 'company_name',
                        title: 'Company Name'
                    },
                    {
                        data: 'owner.fullname',
                        title: 'Admin'
                    },
                    {
                        data: 'owner.username',
                        title: 'Username'
                    },
                    {
                        data: 'owner.email',
                        title: 'E-Mail'
                    },
                    {
                        data: 'entities_count',
                        title: 'Objects Count'
                    },
                    {
                        data: 'users_count',
                        title: 'Users Count'
                    },
                    {
                        data: 'id',
                        title: 'Action'
                    },
                ],
                columnDefs: [
                    {
                        targets: 6,
                        data: 'id',
                        render: function ( data, type, row, meta ) {
                            return '<button type="button" class="button-edit btn btn-xs btn-primary waves-effect" data-id="' + data + '" data-toggle="tooltip" title="Edit Subscriber">' +
                                '   <i class="fas fa-edit"></i>' +
                                '</button> ' +
                                '<button type="button" data-id="' + data + '" data-name="' + row.fullname + '" class="button-reset btn btn-xs btn-warning waves-effect" data-toggle="tooltip" title="Reset Password Subscriber">'+
                                '   <i class="fas fa-redo"></i>' +
                                '</button>'
                        }
                    }
                ]
            })
        }
    });

    $('#subscriber-table').on('click', '.button-edit', function(e){
        var filter = $(this).data('id');
        var data = _.find(subscriber, function (item) {
            return parseInt(item.id) === parseInt(filter);
        });

        localStorage.setItem('editSubscriber', JSON.stringify(data));

        window.location = baseUrl + 'setting/subscriber/edit';
    });

    $('#subscriber-table').on('click', '.button-reset', function(e){
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
                axios.get(baseUrl + 'api/account/reset?a=' + $(this).data('id')).then(function(response) {
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
});