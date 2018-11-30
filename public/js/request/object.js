$(document).ready(function(){
    $('#object-filter-list, #object-compare-list').parent().waitMe(loading);

    axios.get(baseUrl + 'api/object').then(function(response) {
        window.objects = _.chain(response.data.data.objects).map(function(item) {
            return {
                id: parseInt(item.id),
                name: item.name,
                media_id: item.channel.media_id,
                media: item.channel.media.name,
                icon: item.channel.media.icon,
                type_id: item.channel.type_id,
                type: item.channel.crawling_type.name,
                type_icon: getTypeIcon(item.channel.crawling_type.name),
                include: item.pivot.include,
                exclude: item.pivot.exclude,
                editable: parseInt(item.channel.crawling_type.is_editable) === 1,
            }
        }).value();

        if(window.objects.length === 0) {
            $('#object-filter-list, #object-compare-list').parent().css('overflow', 'hidden')
            $('#empty-object, #empty-object-text').show()
        }

        _.forEach(window.objects, function(item){
            $('#object-filter-list').append('<li class="object-filter-item object-'+item.id+'" data-id="'+item.id+'" data-search="'+item.name+'">' +
                '   <img data-toggle="tooltip" title="'+  item.media +'" src="'+baseUrl+item.icon+'"> ' +
                '   <span class="badge bg-blue" data-toggle="tooltip" title="' + item.type + '"><i class="fas fa-'+item.type_icon+'"></i></span> ' +
                '   <span class="text">'+truncateText(item.name, 20)+'</span> ' +
                '   <a href="javascript: void(0)" class="view-btn view-object" data-object="'+item.id+'"><i class="far fa-file"></i></a>' +
                '</li>');

            $('#object-compare-list').append('<li class="object-filter-item object-'+item.id+'" data-id="'+item.id+'" data-search="'+item.name+'">' +
                '   <label class="btn btn-default btn-block">\n' +
                '       <img data-toggle="tooltip" title="'+  item.media +'" src="'+baseUrl+item.icon+'"> ' +
                '       <input type="checkbox" name="objects" class="objects-compare" autocomplete="off" value="'+item.id+'"> ' +
                '       <span class="badge bg-blue" data-toggle="tooltip" title="' + item.type + '"><i class="fas fa-'+item.type_icon+'"></i></span> ' +
                '       <span class="text">'+truncateText(item.name, 20)+'</span> ' +
                '       <i class="fas fa-check check"></i>\n'+
                '   </label>\n' +
                '</li>');

            $('#object-list-topic').append('<div class="col-md-3 search-object-topic object-'+item.id+'" data-search="'+item.name+'">\n' +
                '    <label class="btn btn-default btn-block btn-toggle">\n' +
                '        <input type="checkbox" name="objects" class="objects-input" autocomplete="off" value="'+item.id+'"> ' +
                '           <img data-toggle="tooltip" title="'+  item.media +'" src="'+baseUrl+item.icon+'"> ' +
                '           <span class="badge bg-blue" data-toggle="tooltip" title="' + item.type + '"><i class="fas fa-'+item.type_icon+'"></i></span> ' +
                '           <span class="text">'+truncateText(item.name, 20)+'</span>\n' +
                '        <i class="fas fa-check check"></i>\n'+
                '    </label>\n' +
                '</div>')
        });

        $('#object-filter-list, #object-compare-list').parent().waitMe('hide')
    });

    $('#save-object').click(function(){

        $('#modal-new-object .modal-content').waitMe(loading);

        var objectData = {
            media: $('#media-type').data('category'),
            type: $('#object-type').val(),
            keyword: "",
            include: $('#include').val(),
            exclude: $('#exclude').val()
        };

        var objectType = "";

        switch (parseInt(objectData.type)) {
            case 1 :
                objectData.keyword = $('#keyword-input').val();
                objectType = 'Keyword';
                break;
            case 2 :
                var keyword = $('#hashtag-input').val();
                if(keyword.substring(0,1) !== '#') {
                    keyword = '#' + keyword;
                }
                objectData.keyword = keyword;
                objectType = 'Hashtag';
                break;
            case 3 :
                var person = $('#person-input').val();
                if(person.substring(0,1) !== '@') {
                    person = '@' + person;
                }
                objectData.keyword = person;
                objectType = 'Person';
                break;
            case 4:
                objectData.keyword = $('#tag-input').val();
                objectType = 'Tag';
                break;
            case 5 :
                var fanpage = $('#fanpage-input').val();
                objectData.keyword = fanpage;
                objectType = 'FanPage';
                break;
        }

        $('.object-input label.error').html('').parents('.form-line').removeClass('error');
        $('#channel-error').html('');

        if($(this).data('object') !== undefined) {
            axios.post(baseUrl + 'api/object/edit?o=' + $(this).data('object').id, objectData).then(function (response) {
                var data = response.data.message;

                if (response.data.success) {
                    $('#modal-new-object').modal('hide');
                    $('#modal-new-object .modal-content').waitMe('hide');

                    swal("Success", objectType + ' ' + data.name + ' has been successfully edited', "success");

                    $('#empty-object, #empty-object-text').hide();
                    var type_icon = getTypeIcon(data.channel.crawling_type.name);

                    $('.object-' + data.id).data('search', data.name);
                    $('.object-' + data.id + ' img').prop('src', baseUrl + data.channel.media.icon);
                    $('.object-' + data.id + ' .text').html(truncateText(data.name, 20));
                    $('.object-' + data.id + ' .badge').html('<i class="fas fa-'+type_icon+'">');

                    var edited = _.find(window.objects, ['id', parseInt(data.id)]);
                    edited.include = data.pivot.include;
                    edited.exclude = data.pivot.exclude;

                    $('.object-input input').val('');
                    $('.object-input').hide();
                    $('#media-type').selectpicker('val', '');
                    $('#object-type').html('').selectpicker('render');

                    loadDashboard($('.object-' + data.id), 'o');
                } else {
                    $('#modal-new-object .modal-content').waitMe('hide');
                    _.forEach(data, function (item, key) {
                        var errors = "<ul>";

                        switch (key) {
                            case 'name':
                                $('#' + objectType.toLowerCase() + '-input').parents('.form-line').addClass('error');
                                _.forEach(item, function (error) {
                                    errors += '<li>' + String(error).replace('name', objectType) + '</li>'
                                });
                                errors += '</ul>';
                                $('#' + objectType.toLowerCase() + '-error').html(errors);
                                break;
                            case 'channel':
                                _.forEach(item, function (error) {
                                    errors += '<li>' + error + '</li>'
                                });
                                errors += '</ul>';
                                $('#channel-error').html(errors);
                                break;
                            case 'exclude':
                                $('#exclude').parents('.form-line').addClass('error');
                                _.forEach(item, function (error) {
                                    errors += '<li>' + error + '</li>'
                                });
                                errors += '</ul>';
                                $('#exclude-error').html(errors);
                                break;
                        }
                    })
                }
            })
        } else {
            axios.post(baseUrl + 'api/object/add', objectData).then(function (response) {
                var data = response.data.message;
                console.log(response);
                if (response.data.success) {
                    $('#modal-new-object').modal('hide');
                    $('#modal-new-object .modal-content').waitMe('hide');

                    swal("Success", objectType + ' ' + data.name + ' has been successfully added', "success");

                    $('#empty-object, #empty-object-text').hide();

                    var type_icon = getTypeIcon(data.channel.crawling_type.name);

                    $('#object-filter-list').append('<li class="object-filter-item object-' + data.id + '" data-id="'+data.id+'" data-search="' + data.name + '">' +
                        '   <img data-toggle="tooltip" title="'+  data.channel.media.name +'" src="' + baseUrl + data.channel.media.icon + '"> ' +
                        '   <span class="badge bg-blue" data-toggle="tooltip" title="' + data.channel.crawling_type.name + '"><i class="fas fa-'+type_icon+'"></i></span> ' +
                        '   <span class="text">' + truncateText(data.name, 20) + '</span> ' +
                        '   <a href="javascript: void(0)" class="view-btn view-object" data-object="' + data.id + '"><i class="far fa-file"></i></a>' +
                        '</li>');

                    $('#object-list-topic').append('<div class="col-md-3 search-object-topic  object-' + data.id + '" data-search="' + data.name + '">\n' +
                        '    <label class="btn btn-default btn-block btn-toggle">\n' +
                        '        <input type="checkbox" name="objects" class="objects-input" autocomplete="off" value="' + data.id + '"> ' +
                        '           <img data-toggle="tooltip" title="'+  data.channel.media.name +'" src="' + baseUrl + data.channel.media.icon + '"> ' +
                        '           <span class="badge bg-blue" data-toggle="tooltip" title="' + data.channel.crawling_type.name + '"><i class="fas fa-'+type_icon+'"></i></span> ' +
                        '           <span class="text">' + truncateText(data.name, 20) + '</span>\n' +
                        '        <i class="fas fa-check check"></i>\n' +
                        '    </label>\n' +
                        '</div>');

                    window.objects.push({
                        id: parseInt(data.id),
                        name: data.name,
                        media_id: data.channel.media_id,
                        media: data.channel.media.name,
                        icon: data.channel.media.icon,
                        type_id: data.channel.type_id,
                        type: data.channel.crawling_type.name,
                        type_icon: type_icon,
                        include: data.pivot.include,
                        exclude: data.pivot.exclude,
                        editable: parseInt(data.channel.crawling_type.is_editable) === 1,
                    });

                    $('.object-input input').val('');
                    $('.object-input').hide();
                    $('#media-type').selectpicker('val', '');
                    $('#object-type').html('').selectpicker('render')
                } else {
                    $('#modal-new-object .modal-content').waitMe('hide');
                    _.forEach(data, function (item, key) {
                        var errors = "<ul>";

                        switch (key) {
                            case 'name':
                                $('#' + objectType.toLowerCase() + '-input').parents('.form-line').addClass('error');
                                _.forEach(item, function (error) {
                                    errors += '<li>' + String(error).replace('name', objectType) + '</li>'
                                });
                                errors += '</ul>';
                                $('#' + objectType.toLowerCase() + '-error').html(errors);
                                break;
                            case 'channel':
                                _.forEach(item, function (error) {
                                    errors += '<li>' + error + '</li>'
                                });
                                errors += '</ul>';
                                $('#channel-error').html(errors);
                                break;
                            case 'exclude':
                                $('#exclude').parents('.form-line').addClass('error');
                                _.forEach(item, function (error) {
                                    errors += '<li>' + error + '</li>'
                                });
                                errors += '</ul>';
                                $('#exclude-error').html(errors);
                                break;
                        }
                    })
                }
            })
        }
    });

    $('#search-object-topic-input').on('input', function () {
        var search = String($(this).val()).toLowerCase();
        $('.search-object-topic').each(function (i, elm) {
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
    });

    $('#object-filter-input').on('input', function () {
        var search = String($(this).val()).toLowerCase();
        $('.object-filter-item').each(function (i, elm) {
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

    $('#object-filter-list').on('click', '.view-object', function(e){
        e.preventDefault();
        var object = _.find(window.objects, ['id', $(this).data('object')]);

        $('#modal-view-object-label').html('<img style="height: 20px;" src="'+baseUrl+object.icon+'"> '+object.name);
        $('#view-object-type').html(object.type);
        $('#view-object-name').html(object.name);
        $('#view-object-media').html(object.media);
        if(!$('#button-edit-object').data('disabled') && object.editable) {
            $('#view-object-include').html(object.include);
            $('#view-object-exclude').html(object.exclude);
            $('.view-object-keyword').show();
            $('#button-edit-object').prop('disabled', false);
        } else {
            $('#view-object-include').html('');
            $('#view-object-exclude').html('');
            $('.view-object-keyword').hide();
            $('#button-edit-object').prop('disabled', true);
        }

        $('#button-edit-object').data('object', object);
        $('#button-del-object').data('object', object);

        $('#modal-view-object').modal()
    });

    $('#button-del-object').click(function () {
        $('#modal-view-object .modal-content').waitMe(loading);
        var data = $(this).data('object');
        swal({
            title: "Warning !",
            text: "Are you sure to delete " + data.type + " " + data.name,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                axios.get(baseUrl + 'api/object/delete?o=' + data.id).then(function(response) {
                    if(response.data.success) {
                        $('#modal-view-object').modal('hide');
                        $('.object-'+data.id).remove();
                        _.remove(window.objects, function(n) {
                            return n.id === data.id;
                        });

                        var deleted = _.filter(window.topics, function (o) {
                            return _.find(o.entities, ['id', String(data.id)]) !== undefined
                        })

                        _.forEach(deleted, function(val) {
                            _.remove(val.entities, function(n) {
                                return parseInt(n.id) === data.id;
                            });
                            $('li.topic-' + val.id + ' .badge').html(val.entities.length);
                        });

                        if(response.data.deleted_topic.length > 0) {
                            var alsoDeleted = _.filter(window.topics, function(o) {
                                return _.find(response.data.deleted_topic, function (n) {
                                    return parseInt(n) === o.id
                                }) !== undefined;
                            });

                            _.forEach(alsoDeleted, function (o) {
                                $('.topic-' + o.id).remove();
                                _.remove(window.topics, function(n) {
                                    return n.id === o.id;
                                });
                            });

                            var deletedTopics = _.map(alsoDeleted, function (o) {
                                return o.name
                            }).join(', ');

                            swal(data.type + " " + data.name + " successfully deleted! \nTopics " + deletedTopics + " also deleted !", {
                                icon: "success",
                            });
                        } else {
                            swal(data.type + " " + data.name + " successfully deleted!", {
                                icon: "success",
                            });
                        }

                        $('#data-ready').hide();
                        $('#data-not-ready').show();
                    } else {
                        swal(response.data.message.topic.join(', '), {
                            icon: "error",
                        });
                    }
                    $('#modal-view-object .modal-content').waitMe('hide');
                });
            } else {
                $('#modal-view-object .modal-content').waitMe('hide');
            }
        });
    });

    $('#button-edit-object').click(function () {
        var data = $(this).data('object');
        $('#save-object').html('EDIT OBJECT').data('object', data);
        $('#modal-new-object-label').html('Edit ' + data.type + ' ' + data.name);
        $('#modal-view-object').modal('hide');

        $('#media-type').selectpicker('val', data.media_id).trigger('change').prop('disabled', true);
        $('#object-type').selectpicker('val', data.type_id).trigger('change').prop('disabled', true);
        $('#keyword-input').val(data.name).prop('disabled', true);
        $('#include').val(data.include);
        $('#exclude').val(data.exclude);
        $('#modal-new-object').modal();
    })

    $('#modal-new-object').on('hidden.bs.modal', function () {
        $('#preview-body').css('background-color', '#efefef');
        $('#preview-container').html('<h2 id="preload-preview" class="align-center">Stream Preview</h2>');
        $('#media-type').removeProp('disabled').selectpicker('val', '');
        $('#object-type').html('').removeProp('disabled').selectpicker('render');
        $('#keyword-input').val('').removeProp('disabled');
        $('#include').val('');
        $('#exclude').val('');
        $('#modal-new-object-label').html('Add New Object');
        $('#save-object').html('SAVE OBJECT').removeData('object');
        $('.object-input').hide();
        $('.object-category').hide();
    })

    $('#object-filter-list').on('click', '.object-filter-item', function () {
        loadDashboard($(this), 'o');
    });

    $('#object-compare-list').on('click', '.object-filter-item .btn', function () {
        if($(this).find('.objects-compare:checked')) {
            if($(this).is('.active')) {
                $(this).find('.objects-compare:checked').removeProp('checked');
                $(this).removeClass('active');
                return false;
            } else {
                if($('.objects-compare:checked').length < 2) {
                    $(this).find('.objects-compare').prop('checked', 'true');
                    $(this).addClass('active');
                    return false;
                } else {
                    return false;
                }
            }
        } else {
            if($('.objects-compare:checked').length < 2) {
                $(this).find('.objects-compare').prop('checked', 'true');
                $(this).addClass('active');
                return false;
            } else {
                return false;
            }
        }
    });

    $('#preview').click(function () {
        $('#preview-body').css('background-color', '#ffffff').waitMe(loading);

        var objectData = {
            media: $('#media-type').val(),
            type: $('#object-type').val(),
            keyword: "",
            include: $('#include').val(),
            exclude: $('#exclude').val()
        };

        switch (parseInt(objectData.type)) {
            case 1 :
                objectData.keyword = $('#keyword-input').val();
                break;
            case 2 :
                var keyword = $('#hashtag-input').val();
                if(keyword.substring(0,1) !== '#') {
                    keyword = '#' + keyword;
                }
                objectData.keyword = keyword;
                break;
            case 3 :
                var person = $('#person-input').val();
                if(person.substring(0,1) !== '@') {
                    person = '@' + person;
                }
                objectData.keyword = person;
                break;
            case 4:
                objectData.keyword = $('#tag-input').val();
                break
        }

        axios.post(baseUrl + 'api/channel/preview', objectData).then(function (response) {
            if(response.data.message.length > 0) {
                $('#preview-container').html('');
                switch ($('#media-type').find(':selected').data('layout')) {
                    case 'news':
                        _.forEach(response.data.message, function (data) {
                            $('#preview-container').append('<div class="row post">\n' +
                                '    <div class="row">\n' +
                                '        <div class="col-md-12">\n' +
                                '            <p class="title"><a class="col-blue" href="' + data.news_url + '"><b>' + truncateText(data.news_header, 75) + '</b></a></p>\n' +
                                '            <p class="link"><a class="col-orange" href="' + data.news_url + '">' + truncateText(data.news_url, 75) + '</a></p>\n' +
                                '        </div>\n' +
                                '    </div>\n' +
                                '    <div class="row">\n' +
                                '        <div class="col-md-12">\n' +
                                '            <p><span class="col-grey">'+data.news_timestamp+'</span> - ' + truncateText(data.news_article, 200) + '</p>\n' +
                                '        </div>\n' +
                                '    </div>\n' +
                                '</div>')
                        })
                        break;
                    default:
                        console.log(response.data.message);
                        break;
                }
            } else {
                $('#preview-container').html('<h2 id="preload-preview" class="align-center">No Preview Found !</h2>');
            }

            $('#preview-body').waitMe('hide');
        })
    });

    $('#compare-objects').click(function() {
        var o = [];
        _.forEach($('.objects-compare:checked'), function (item) {
            o.push($(item).val());
        });

        loadCompare('o', o.join(','));
    });
});

function getTypeIcon(type) {
    var type_icon = '';
    switch (type) {
        case 'Keyword':
            type_icon = 'font';
            break;
        case 'Tag':
            type_icon = 'tag';
            break;
        case 'Hashtag':
            type_icon = 'hashtag';
            break;
        case 'Person':
            type_icon = 'user';
            break;
        case 'FanPage':
            type_icon = 'flag';
            break;
    }
    return type_icon;
}