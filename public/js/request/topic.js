$(document).ready(function() {
    $('#topic-filter-list, #topic-compare-list').parent().waitMe(loading);

    axios.get(baseUrl + 'api/topic').then(function (response) {
        window.topics = _.chain(response.data.data.topics).map(function(item) {
            return {
                id: parseInt(item.id),
                name: item.name,
                entities: item.entities
            }
        }).value();

        if(window.topics.length === 0) {
            $('#topic-filter-list, #topic-compare-list').parent().css('overflow', 'hidden');
            $('#empty-topic, #empty-topic-text').show()
        }

        _.forEach(window.topics, function (item) {
            $('#topic-filter-list').append('<li class="topic-filter-item topic-'+item.id+'" data-id="'+item.id+'" data-search="'+item.name+'"> ' +
                '   <span class="badge bg-blue" data-toggle="tooltip" title="total members">' + item.entities.length + '</span> ' +
                '   <span class="text">' + truncateText(item.name, 20) + '</span> ' +
                '   <a href="javascript: void(0)" class="view-btn view-topic" data-topic="'+item.id+'"><i class="far fa-file"></i></a>' +
                '</li>');

            $('#topic-compare-list').append('<li class="topic-filter-item topic-'+item.id+'" data-id="'+item.id+'" data-search="'+item.name+'"> ' +
                '   <label class="btn btn-default btn-block">\n' +
                '       <input type="checkbox" name="objects" class="topics-compare" autocomplete="off" value="'+item.id+'"> ' +
                '       <span class="badge bg-blue" data-toggle="tooltip" title="total members">' + item.entities.length + '</span> ' +
                '       <span class="text">' + truncateText(item.name, 20) + '</span> ' +
                '       <i class="fas fa-check check"></i>\n'+
                '   </label>\n' +
                '</li>');
        });

        $('#topic-filter-list, #topic-compare-list').parent().waitMe('hide')
    });

    $('#save-topic').click(function () {

        $('#modal-new-topic .modal-content').waitMe(loading);
        $('#topic-input').parents('.form-line').removeClass('error');
        $('#topic-error, #objects-error').html('');

        var topicData = {
            name: $('#topic-input').val(),
            objects: []
        };

        $('.objects-input:checked').each(function (i, elm) {
            topicData.objects.push($(elm).val())
        });

        if($(this).data('topic') !== undefined) {
            axios.post(baseUrl + 'api/topic/edit?t=' + $(this).data('topic').id, topicData).then(function (response) {
                var data = response.data.message;

                if (response.data.success) {
                    $('#modal-new-topic').modal('hide');
                    $('#modal-new-topic .modal-content').waitMe('hide');
                    swal("Success", 'Topic ' + data.name + ' has been successfully edited', "success");

                    $('#empty-topic, #empty-topic-text').hide();

                    $('li.topic-' + data.id).data('search', data.name);
                    $('li.topic-' + data.id + ' .text').html(truncateText(data.name, 20));
                    $('li.topic-' + data.id + ' .badge').html(data.entities.length);

                    var edited = _.find(window.topics, ['id', parseInt(data.id)]);
                    edited.name = data.name;
                    edited.entities = data.entities;

                    $('#topic-input').val('');
                    $('#search-object-topic-input').val('');
                    $('.objects-input').removeProp('checked');
                    $('.search-object-topic label').removeClass('active');
                    $('.search-object-topic').show();

                    loadDashboard($('li.topic-' + data.id), 't')
                } else {
                    $('#modal-new-topic .modal-content').waitMe('hide');
                    _.forEach(data.message, function (item, key) {
                        var errors = "<ul>";
                        switch (key) {
                            case 'name':
                                $('#topic-input').parents('.form-line').addClass('error');
                                _.forEach(item, function (error) {
                                    errors += '<li>' + String(error).replace('name', 'Topic') + '</li>'
                                });
                                errors += '</ul>';
                                $('#topic-error').html(errors);
                                break;
                            case 'object':
                                _.forEach(item, function (error) {
                                    errors += '<li>' + error + '</li>'
                                });
                                errors += '</ul>';
                                $('#objects-error').html(errors)
                        }
                    })
                }
            })
        } else {
            axios.post(baseUrl + 'api/topic/add', topicData).then(function (response) {
                var data = response.data.message;

                if (response.data.success) {
                    $('#modal-new-topic').modal('hide');
                    $('#modal-new-topic .modal-content').waitMe('hide');
                    swal("Success", 'Topic ' + data.name + ' has been successfully added', "success");

                    $('#empty-topic, #empty-topic-text').hide();

                    $('#topic-filter-list').append('<li class="topic-filter-item topic-' + data.id + '" data-id="'+data.id+'" data-search="' + data.name + '">' +
                        '   <span class="badge bg-blue" data-toggle="tooltip" title="total members">' + data.entities.length + '</span> ' +
                        '   <span class="text">' + truncateText(data.name, 20) + '</span> ' +
                        '   <a href="javascript: void(0)" class="view-btn view-topic" data-topic="' + data.id + '"><i class="far fa-file"></i></a>' +
                        '</li>');

                    window.topics.push({
                        id: parseInt(data.id),
                        name: data.name,
                        entities: data.entities
                    });

                    $('#topic-input').val('');
                    $('#search-object-topic-input').val('');
                    $('.objects-input').removeProp('checked');
                    $('.search-object-topic label').removeClass('active');
                    $('.search-object-topic').show()
                } else {
                    $('#modal-new-topic .modal-content').waitMe('hide');
                    _.forEach(data.message, function (item, key) {
                        var errors = "<ul>";
                        switch (key) {
                            case 'name':
                                $('#topic-input').parents('.form-line').addClass('error');
                                _.forEach(item, function (error) {
                                    errors += '<li>' + String(error).replace('name', 'Topic') + '</li>'
                                });
                                errors += '</ul>';
                                $('#topic-error').html(errors);
                                break;
                            case 'object':
                                _.forEach(item, function (error) {
                                    errors += '<li>' + error + '</li>'
                                });
                                errors += '</ul>';
                                $('#objects-error').html(errors)
                        }
                    })
                }
            })
        }
    });

    $('#topic-filter-input').on('input', function () {
        var search = String($(this).val()).toLowerCase();
        $('.topic-filter-item').each(function (i, elm) {
            var data = String($(elm).data('search')).toLowerCase();
            if(search !== '') {
                if(!data.includes(search)){
                    $(elm).hide()
                } else {
                    $(elm).show()
                }
            } else {
                $(elm).show()
            }
        })
    })

    $('#topic-filter-list').on('click', '.view-topic', function(e) {
        e.preventDefault();
        var topic = _.find(window.topics, ['id', $(this).data('topic')]);

        $('#modal-view-topic-label').html(topic.name);
        $('#view-topic-member').html('');

        _.forEach(topic.entities, function (item) {
            var member = _.find(window.objects, ['id', parseInt(item.id)]);
            if(member !== undefined) {
                $('#view-topic-member').append('<div class="col-md-6 m-t-10">\n' +
                    '    <label class="btn btn-default btn-block align-left">\n' +
                    '        <img data-toggle="tooltip" title="'+  member.media +'" height="25px" src="' + baseUrl + member.icon + '"> ' + truncateText(member.name, 20) + '\n' +
                    '        <span class="badge bg-blue" data-toggle="tooltip" title="' + member.type + '"><i class="fas fa-'+member.type_icon+'"></i></span>\n' +
                    '    </label>\n' +
                    '</div>')
            }
        });

        $('#button-edit-topic').data('topic', topic);
        $('#button-del-topic').data('topic', topic);

        $('#modal-view-topic').modal();
    });

    $('#button-del-topic').click(function () {
        $('#modal-view-topic .modal-content').waitMe(loading);
        var data = $(this).data('topic');
        swal({
            title: "Warning !",
            text: "Are you sure to delete Topic " + data.name,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                axios.get(baseUrl + 'api/topic/delete?t=' + data.id).then(function(response) {
                    if(response.data.success) {
                        $('#modal-view-topic').modal('hide');
                        $('.topic-' + data.id).remove();
                        _.remove(window.topics, function(n) {
                            return n.id === data.id;
                        });

                        swal("Topic " + data.name + " successfully deleted!", {
                            icon: "success",
                        });

                        $('#data-ready').hide();
                        $('#data-not-ready').show();
                    } else {
                        swal(response.data.message.topic.join(', '), {
                            icon: "error",
                        });
                    }
                    $('#modal-view-topic .modal-content').waitMe('hide');
                });
            } else {
                $('#modal-view-topic .modal-content').waitMe('hide');
            }
        });
    })

    $('#button-edit-topic').click(function () {
        var data = $(this).data('topic');
        $('#save-topic').html('EDIT TOPIC').data('topic', data);
        $('#modal-new-topic-label').html('Edit Topic ' + data.name);
        $('#modal-view-topic').modal('hide');

        $('#topic-input').val(data.name);
        _.forEach(data.entities, function (item) {
            $('div.object-' + item.id + ' input').prop('checked', true);
            $('div.object-' + item.id + ' label').addClass('active');
        })

        $('#modal-new-topic').modal()
    })

    $('#modal-new-topic').on('hidden.bs.modal', function () {
        $('#modal-new-topic-label').html('Add New Topic');
        $('#save-topic').html('SAVE TOPIC').removeData('topic');
        $('#topic-input').val('');
        $('.objects-input').removeProp('checked');
        $('.search-object-topic label').removeClass('active');
        $('.search-object-topic').show()
    })

    $('#topic-filter-list').on('click', '.topic-filter-item', function () {
        loadDashboard($(this), 't')
    });

    $('#topic-compare-list').on('click', '.topic-filter-item .btn', function () {
        if($(this).find('.topics-compare:checked')) {
            if($(this).is('.active')) {
                $(this).find('.topics-compare:checked').removeProp('checked');
                $(this).removeClass('active');
                return false;
            } else {
                if($('.topics-compare:checked').length < 2) {
                    $(this).find('.topics-compare').prop('checked', 'true');
                    $(this).addClass('active');
                    return false;
                } else {
                    return false;
                }
            }
        } else {
            if($('.topics-compare:checked').length < 2) {
                $(this).find('.topics-compare').prop('checked', 'true');
                $(this).addClass('active');
                return false;
            } else {
                return false;
            }
        }
    });

    $('#compare-topics').click(function() {
        var t = [];
        _.forEach($('.topics-compare:checked'), function (item) {
            t.push($(item).val());
        });

        loadCompare('t', t.join(','));
    });
});