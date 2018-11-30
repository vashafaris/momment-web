$(document).ready(function () {
    $('.max-chart-button').click(function () {
        showMaxChart($(this).data('type'), rawData);
    })
});

function showMaxChart(type, data, filter = false) {
    if(type !== 'max-chart') {
        maxChart = type;
    }
    var label = $('#modal-max-chart-label');
    var chartContainer = $('#max-chart');

    $('.max-chart-tab, .max-chart-pane').removeClass('active');
    if(filter === false) {
        $('#max-chart').addClass('in');
        $('#max-chart-tab-chart, #max-chart').addClass('active');
    } else {
        $('#chart-data').addClass('in');
        $('#max-chart-tab-table, #chart-data').addClass('active');
    }

    switch (type) {
        case 'object-activity':
            label.html('Object Activity');
            renderActivityChart('max-chart', widgetCharts.objectActivity, 'large');
            break;
        case 'peak-time':
            label.html('Peak Time');
            renderPeakTime('max-chart', widgetCharts.peakTime);
            break;
        case 'word-cloud':
            label.html('Word Cloud');
            renderWordcloud('max-chart', widgetCharts.wordCloud, 'large');
            break;
        case 'locations':
            label.html('Locations');
            renderPie('max-chart', 'Locations', widgetCharts.locations, 'large');
            break;
        case 'top-influencer':
            label.html('Top Influencer');
            renderList('max-chart', widgetCharts.topInfluencer, 'Account', 'Influencer');
            break;
        case 'media':
            label.html('Media');
            renderPie('max-chart', 'Media', widgetCharts.media, 'large');
            break;
        case 'most-posting':
            label.html('Most Posting Account');
            renderList('max-chart', widgetCharts.mostPosting, 'Account', 'TotalPost');
            break;
        case 'sentiment':
            label.html('Sentiment Analysis');
            renderPie('max-chart', 'Sentiment Analysis', widgetCharts.sentimentAnalysis, 'large');
            break;
        case 'likes':
            label.html('Likes');
            renderList('max-chart', widgetCharts.likes, 'Account', 'Likes');
            break;
    }

    showRawData(data);

    if(type !== 'max-chart') {
        $('#modal-max-chart').modal('show');
    } else {
        $('.max-chart-tab, .max-chart-pane').removeClass('active');
        $('#chart-data').addClass('in');
        $('#max-chart-tab-table, #chart-data').addClass('active');
    }
}

function showRawData(data) {
    $('#raw-data-table').DataTable({
        destroy: true,
        data: data,
        columns: [
            {
                data: 'Channel',
                title: 'Channel'
            },
            {
                data: 'UserName',
                title: 'Username'
            },
            {
                data: 'Header',
                title: 'Title'
            },
            {
                data: 'Article',
                title: 'Article'
            },
            {
                data: 'Hari',
                title: 'Day'
            },
            {
                data: 'TanggalJam',
                title: 'Date'
            },
            {
                data: 'Kota',
                title: 'City'
            },
            {
                data: 'Follower',
                title: 'Follower'
            },
            {
                data: 'Likes',
                title: 'Likes'
            },
            {
                data: 'URL',
                title: 'URL'
            },
        ],
        columnDefs: [
            {
                targets: [2, 3],
                data: 'Article',
                render: function ( data, type, row, meta ) {
                    var short = truncateText(data, 100);
                    var readMore = '';
                    if(short.length === 100) {
                        readMore = '<a href="javascript:void(0);" class="data-read-more" data-id="' + meta.row + '-' + meta.col + '">Read More</a>';
                    }
                    return '<span id="short-' + meta.row + '-' + meta.col + '" class="data-short show">' + short + ' ' + readMore + '</span>' +
                        '<span id="long-' + meta.row + '-' + meta.col + '" class="data-long hide">' + data + ' ' +
                        '   <a href="javascript:void(0);" class="data-show-less" data-id="' + meta.row + '-' + meta.col + '">Show Less</a> ' +
                        '</span>';
                }
            },
            {
                targets: 9,
                data: 'URL',
                render: function ( data, type, row, meta ) {
                    return '<a href="'+data+'" target="_blank"><i class="fas fa-external-link-alt"></i></a>';
                }
            }
        ]
    });
}

$('#raw-data-table').on('click', '.data-read-more', function(e){
    $('#short-' + $(this).data('id')).removeClass('show').addClass('hide');
    $('#long-' + $(this).data('id')).removeClass('hide').addClass('show');
});

$('#raw-data-table').on('click', '.data-show-less', function(e){
    $('#long-' + $(this).data('id')).removeClass('show').addClass('hide');
    $('#short-' + $(this).data('id')).removeClass('hide').addClass('show');
});

function loadDashboard(source, type) {
    if(call){
        call.cancel();
    }

    call = axios.CancelToken.source();

    $('#display-text-filter').html(source.data('search'));

    $('.object-filter-item, .topic-filter-item').removeClass('bg-light-grey');
    source.addClass('bg-light-grey');

    var id = source.data('id');

    axios({
        url: baseUrl + 'api/dashboard/export?' + type + '=' + id + '&date=' + window.dateRangeFilter,
        method: 'GET',
        responseType: 'blob',
        cancelToken: call.token
    }).then((response) => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        $('#export-link').prop('href', url);
        $('#export-link').attr('download', 'mysights-export-' + source.data('search') + '-' + moment().format('DD-MM-YYYY') + '.xlsx');
    }).catch(function (err) {});

    $('#chart-data').waitMe(loading);
    axios.get(baseUrl + 'api/dashboard/raw-data/data?' + type + '=' + id + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;
        $('#chart-data').waitMe('hide');
        if(data.success && data.message.length > 0) {
            showRawData(data);
            rawData = data.message;
        }
    }).catch(function (err) {});

    $('#engaged-account').parent().parent().waitMe(miniLoading);
    axios.get(baseUrl + 'api/dashboard/engaged-account?' + type + '=' + id + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;
        if(data.success) {
            $('#engaged-account').html(data.message.EngagedAccount);
        } else {
            $('#engaged-account').html(0);
        }
        $('#engaged-account').parent().parent().waitMe('hide');
    }).catch(function (err) {});

    $('#total-post').parent().parent().waitMe(miniLoading);
    axios.get(baseUrl + 'api/dashboard/total-post?' + type + '=' + id + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;
        if(data.success) {
            $('#total-post').html(data.message.TotalPost);
        } else {
            $('#total-post').html(0);
        }
        $('#total-post').parent().parent().waitMe('hide');
    }).catch(function (err) {});

    $('#average-daily').parent().parent().waitMe(miniLoading);
    axios.get(baseUrl + 'api/dashboard/average-daily-growth?' + type + '=' + id + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;
        if(data.success) {
            $('#average-daily').html(data.message.RAVG + '%');
        } else {
            $('#average-daily').html('No Media');
        }
        $('#average-daily').parent().parent().waitMe('hide');
    }).catch(function (err) {});

    $('#top-media').parent().parent().waitMe(miniLoading);
    axios.get(baseUrl + 'api/dashboard/top-media?' + type + '=' + id + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;
        if(data.success) {
            $('#top-media').html(data.message.Media);
        } else {
            $('#top-media').html('No Media');
        }
        $('#top-media').parent().parent().waitMe('hide');
    }).catch(function (err) {});

    $('#object-activity').waitMe(miniLoading);
    axios.get(baseUrl + 'api/dashboard/object-activity?' + type + '=' + id + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;
        if(data.success && data.message.length > 0) {
            if(type === 'o') {
                widgetCharts.objectActivity = [{
                    name: 'Total',
                    data: _.map(data.message, function (item) {
                        return [
                            moment(item.Tanggal, 'YYYY-MM-DD').valueOf(),
                            parseInt(item.Total)
                        ]
                    })
                }];
            } else {
                widgetCharts.objectActivity = _.chain(data.message).map(function (item) {
                    return {
                        name: item.Media,
                        data: []
                    }
                }).uniqBy(function(item){
                    return item.name
                }).value();

                _.forEach(widgetCharts.objectActivity, function (item) {
                    item.data = _.chain(data.message)
                        .filter(['Media', item.name])
                        .map(function (seriesData) {
                            return [
                                moment(seriesData.Tanggal, 'YYYY-MM-DD').valueOf(),
                                parseInt(seriesData.Total)
                            ]
                        }).value();
                });
            }

            renderActivityChart('object-activity', widgetCharts.objectActivity);
        } else {
            $('#object-activity').html('<h3 class="align-center widget-no-data">No Data !</h3>');
        }
        $('#object-activity').waitMe('hide');
    }).catch(function (err) {});

    $('#peak-time').waitMe(miniLoading);
    axios.get(baseUrl + 'api/dashboard/peak-time?' + type + '=' + id + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;
        if(data.success && data.message.length > 0) {
            widgetCharts.peakTime = [];
            for (var i = 0; i < 7; i++) {
                for (var j = 0; j < 24; j++) {
                    widgetCharts.peakTime.push([i, j, 0]);
                }
            }

            _.forEach(data.message, function (item) {
                var mapItem = _.find(widgetCharts.peakTime, function (o) {
                    return o[0] === parseInt(moment(item.Tanggal, 'dddd').format('d')) &&
                        o[1] === parseInt(item.Jam)
                });
                mapItem[2] = parseInt(item.Total);
            });

            renderPeakTime('peak-time', widgetCharts.peakTime);
        } else {
            $('#peak-time').html('<h3 class="align-center widget-no-data">No Data !</h3>');
        }
        $('#peak-time').waitMe('hide');
    }).catch(function (err) {});

    $('#word-cloud').waitMe(miniLoading);
    axios.get(baseUrl + 'api/dashboard/word-cloud?' + type + '=' + id + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;
        if(data.success && data.message.length > 0) {
            widgetCharts.wordCloud = _.chain(data.message).map(function (item) {
                return {
                    name: item.Keywords,
                    weight: parseInt(item.Total)
                }
            }).sortBy([function(o) { return -o.weight; }]).take(20).value();

            renderWordcloud('word-cloud', widgetCharts.wordCloud);
        } else {
            $('#word-cloud').html('<h3 class="align-center widget-no-data">No Data !</h3>');
        }
        $('#word-cloud').waitMe('hide');
    }).catch(function (err) {});

    $('#top-influencer').waitMe(miniLoading);
    axios.get(baseUrl + 'api/dashboard/top-influencer?' + type + '=' + id + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;
        if(data.success && data.message.length > 0) {
            widgetCharts.topInfluencer = data.message;
            renderList('top-influencer', widgetCharts.topInfluencer, 'Account', 'Influencer');
        } else {
            $('#top-influencer').html('<h3 class="align-center widget-no-data">No Data !</h3>');
        }
        $('#top-influencer').waitMe('hide');
    }).catch(function (err) {});

    $('#most-posting').waitMe(miniLoading);
    axios.get(baseUrl + 'api/dashboard/most-posting?' + type + '=' + id + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;
        if(data.success && data.message.length > 0) {
            widgetCharts.mostPosting = data.message;
            renderList('most-posting', widgetCharts.mostPosting, 'Account', 'TotalPost');
        } else {
            $('#most-posting').html('<h3 class="align-center widget-no-data">No Data !</h3>');
        }
        $('#most-posting').waitMe('hide');
    }).catch(function (err) {});

    $('#locations').waitMe(miniLoading);
    axios.get(baseUrl + 'api/dashboard/location?' + type + '=' + id + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;
        if(data.success && data.message.length > 0) {
            widgetCharts.locations = _.map(data.message, function (item) {
                return {
                    name: item.Kota.replace(' ', '<br>'),
                    y: parseFloat(item.Jumlah)
                }
            })
            renderPie('locations', 'Locations', widgetCharts.locations);
        } else {
            $('#locations').html('<h3 class="align-center widget-no-data">No Data !</h3>');
        }
        $('#locations').waitMe('hide');
    }).catch(function (err) {});

    $('#media').waitMe(miniLoading);
    axios.get(baseUrl + 'api/dashboard/media?' + type + '=' + id + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;
        if(data.success && data.message.length > 0) {
            widgetCharts.media = _.map(data.message, function (item) {
                var name = item.Media;
                return {
                    name: name,
                    y: parseFloat(item.TotalPost)
                }
            })
            renderPie('media', 'Media', widgetCharts.media);
        } else {
            $('#media').html('<h3 class="align-center widget-no-data">No Data !</h3>');
        }
        $('#media').waitMe('hide');
    }).catch(function (err) {});

    $('#likes').waitMe(miniLoading);
    axios.get(baseUrl + 'api/dashboard/likes?' + type + '=' + id + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;
        if(data.success && data.message.length > 0) {
            widgetCharts.likes = data.message;
            renderList('likes', widgetCharts.likes, 'Account', 'Likes');
        } else {
            $('#likes').html('<h3 class="align-center widget-no-data">No Data !</h3>');
        }
        $('#likes').waitMe('hide');
    }).catch(function (err) {});

    $('#data-not-ready').hide();
    $('#data-ready').show();
}

function loadCompare(type, ids) {
    if(call){
        call.cancel();
    }

    call = axios.CancelToken.source();

    $('#compare-activity').parent().waitMe(miniLoading);
    axios.get(baseUrl + 'api/compare/activities?' + type + '=' + ids + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;

        $('#compare-activity').parent().waitMe('hide');

        var compareActivityPie = _.map(data.message, function (item) {
            return {
                name: item.name,
                y: parseInt(item.totalPost.TotalPost)
            };
        });

        var compareActivity = _.map(data.message, function (item) {
            return {
                type: 'line',
                name: item.name,
                data: []
            }
        });

        _.forEach(data.message, function (item, key) {
            compareActivity[key].data = _.map(item.objectActivity, function (activity) {
                return [
                    moment(activity.Tanggal, 'YYYY-MM-DD').valueOf(),
                    parseInt(activity.Total)
                ]
            })
        });

        compareActivity.push({
            type: 'pie',
            center: [80, 50],
            size: 150,
            showInLegend: false,
            dataLabels: {
                enabled: false
            },
            data: compareActivityPie
        });

        renderCompareActivity('compare-activity', compareActivity);
    }).catch(function (err) {});

    $('#compare-engaged-user-pie').parent().waitMe(miniLoading);
    axios.get(baseUrl + 'api/compare/engaged-user?' + type + '=' + ids + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;

        $('#compare-engaged-user-pie').parent().waitMe('hide');

        var x = _.map(data.message, 'name');

        var compareUserPie = _.map(data.message, function (item) {
            return {
                name: item.name,
                y: parseInt(item.engagedAccount.EngagedAccount)
            };
        });

        var mediaBar = [];
        var mediaTable = [];
        var mediaColumn = [];
        var totalColumn = [];

        if(type === 'o') {
            totalColumn = [
                {
                    data: 'object',
                    title: 'Object'
                },
                {
                    data: 'engaged',
                    title: 'Engaged'
                },
            ];
            mediaColumn = [
                {
                    data: 'object',
                    title: 'Object'
                },
                {
                    data: 'media',
                    title: 'Media'
                },
                {
                    data: 'engaged',
                    title: 'Engaged'
                },
            ];

            _.forEach(data.message, function (item) {
                mediaBar.push({
                    type: 'column',
                    name: item.engagedAccountByMedia.Media,
                    data: []
                });

                mediaTable.push({
                    object: item.name,
                    media: item.engagedAccountByMedia.Media,
                    engaged: item.engagedAccountByMedia.EngagedAccount,
                    top: false
                });
            });

            mediaBar = _.uniqBy(mediaBar, 'name');

            _.forEach(mediaBar, function (media) {
                _.forEach(data.message, function (item, key) {
                    if (item.engagedAccountByMedia.Media === media.name) {
                        media.data[key] = parseInt(item.engagedAccountByMedia.EngagedAccount);
                    } else {
                        media.data[key] = 0;
                    }
                })
            });
        } else {
            totalColumn = [
                {
                    data: 'topic',
                    title: 'Topic'
                },
                {
                    data: 'engaged',
                    title: 'Engaged'
                },
            ];
            mediaColumn = [
                {
                    data: 'topic',
                    title: 'Topic'
                },
                {
                    data: 'media',
                    title: 'Media'
                },
                {
                    data: 'engaged',
                    title: 'Engaged'
                },
            ];

            _.forEach(data.message, function (item) {
                _.forEach(item.engagedAccountByMedia, function (media) {
                    mediaBar.push({
                        type: 'column',
                        name: media.Media,
                        data: []
                    });

                    mediaTable.push({
                        topic: item.name,
                        media: media.Media,
                        engaged: media.EngagedAccount,
                        top: false
                    });
                })
            });

            mediaBar = _.uniqBy(mediaBar, 'name');

            _.forEach(mediaBar, function (media) {
                _.forEach(data.message, function (item, key) {
                    var itemMedia = _.find(item.engagedAccountByMedia, ['Media', media.name]);

                    if (itemMedia !== undefined) {
                        media.data[key] = parseInt(itemMedia.EngagedAccount);
                    } else {
                        media.data[key] = 0;
                    }
                })
            });
        }

        var totalTable = _.map(data.message, function(item) {
            if (type === 'o') {
                return {
                    object: item.name,
                    engaged: item.engagedAccount.EngagedAccount,
                    top: false
                }
            } else {
                return {
                    topic: item.name,
                    engaged: item.engagedAccount.EngagedAccount,
                    top: false
                }
            }
        });

        var max = _.maxBy(totalTable, 'engaged');
        max.top = true;

        max = _.maxBy(mediaTable, 'engaged');
        max.top = true;

        $('#table-engaged-user-total').DataTable({
            destroy: true,
            data: totalTable,
            paging: false,
            info: false,
            searching: false,
            columns: totalColumn,
            columnDefs: [
                {
                    targets: 1,
                    data: 'URL',
                    render: function ( data, type, row, meta ) {
                        if (row.top) {
                            return '<b>'+data+'</b> <span class="badge bg-amber pull-right">Top Rated</span>'
                        } else {
                            return data;
                        }
                    }
                }
            ]
        });

        $('#table-engaged-user-media').DataTable({
            destroy: true,
            data: mediaTable,
            paging: false,
            info: false,
            searching: false,
            columns: mediaColumn,
            columnDefs: [
                {
                    targets: 2,
                    data: 'URL',
                    render: function ( data, type, row, meta ) {
                        if (row.top) {
                            return '<b>'+data+'</b> <span class="badge bg-amber pull-right">Top Rated</span>'
                        } else {
                            return data;
                        }
                    }
                }
            ]
        });

        renderPie('compare-engaged-user-pie', 'Compare by Total', compareUserPie, 'medium');
        renderCompareBar('compare-engaged-user-column', x, mediaBar);
    }).catch(function (err) {});

    $('#compare-influencer-pie').parent().waitMe(miniLoading);
    axios.get(baseUrl + 'api/compare/influencer?' + type + '=' + ids + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;

        $('#compare-influencer-pie').parent().waitMe('hide');

        var x = _.map(data.message, 'name');

        var compareInfluencerPie = _.map(data.message, function (item) {
            return {
                name: item.name,
                y: parseInt(item.totalInfluencer.Influencer)
            };
        });

        var mediaBar = [];
        var mediaTable = [];
        var mediaColumn = [];
        var totalColumn = [];

        if(type === 'o') {
            totalColumn = [
                {
                    data: 'object',
                    title: 'Object'
                },
                {
                    data: 'influencer',
                    title: 'Influencer'
                },
            ];
            mediaColumn = [
                {
                    data: 'object',
                    title: 'Object'
                },
                {
                    data: 'media',
                    title: 'Media'
                },
                {
                    data: 'influencer',
                    title: 'Influencer'
                },
            ];

            _.forEach(data.message, function (item) {
                mediaBar.push({
                    type: 'column',
                    name: item.totalInfluencerByMedia.Media,
                    data: []
                });

                mediaTable.push({
                    object: item.name,
                    media: item.totalInfluencerByMedia.Media,
                    influencer: item.totalInfluencerByMedia.Influencer,
                    top: false
                });
            });

            mediaBar = _.uniqBy(mediaBar, 'name');

            _.forEach(mediaBar, function (media) {
                _.forEach(data.message, function (item, key) {
                    if (item.totalInfluencerByMedia.Media === media.name) {
                        media.data[key] = parseInt(item.totalInfluencerByMedia.Influencer);
                    } else {
                        media.data[key] = 0;
                    }
                })
            });
        } else {
            totalColumn = [
                {
                    data: 'topic',
                    title: 'Topic'
                },
                {
                    data: 'influencer',
                    title: 'Influencer'
                },
            ];
            mediaColumn = [
                {
                    data: 'topic',
                    title: 'Topic'
                },
                {
                    data: 'media',
                    title: 'Media'
                },
                {
                    data: 'influencer',
                    title: 'Influencer'
                },
            ];

            _.forEach(data.message, function (item) {
                _.forEach(item.totalInfluencerByMedia, function (media) {
                    mediaBar.push({
                        type: 'column',
                        name: media.Media,
                        data: []
                    });

                    mediaTable.push({
                        topic: item.name,
                        media: media.Media,
                        influencer: media.Influencer,
                        top: false
                    });
                })
            });

            mediaBar = _.uniqBy(mediaBar, 'name');

            _.forEach(mediaBar, function (media) {
                _.forEach(data.message, function (item, key) {
                    var itemMedia = _.find(item.totalInfluencerByMedia, ['Media', media.name]);

                    if (itemMedia !== undefined) {
                        media.data[key] = parseInt(itemMedia.Influencer);
                    } else {
                        media.data[key] = 0;
                    }
                })
            });
        }

        var totalTable = _.map(data.message, function(item) {
            if (type === 'o') {
                return {
                    object: item.name,
                    influencer: item.totalInfluencer.Influencer,
                    top: false
                }
            } else {
                return {
                    topic: item.name,
                    influencer: item.totalInfluencer.Influencer,
                    top: false
                }
            }
        });

        var max = _.maxBy(totalTable, 'influencer');
        max.top = true;

        max = _.maxBy(mediaTable, 'influencer');
        max.top = true;

        $('#table-influencer-total').DataTable({
            destroy: true,
            data: totalTable,
            paging: false,
            info: false,
            searching: false,
            columns: totalColumn,
            columnDefs: [
                {
                    targets: 1,
                    data: 'URL',
                    render: function ( data, type, row, meta ) {
                        if (row.top) {
                            return '<b>'+data+'</b> <span class="badge bg-amber pull-right">Top Rated</span>'
                        } else {
                            return data;
                        }
                    }
                }
            ]
        });

        $('#table-influencer-media').DataTable({
            destroy: true,
            data: mediaTable,
            paging: false,
            info: false,
            searching: false,
            columns: mediaColumn,
            columnDefs: [
                {
                    targets: 2,
                    data: 'URL',
                    render: function ( data, type, row, meta ) {
                        if (row.top) {
                            return '<b>'+data+'</b> <span class="badge bg-amber pull-right">Top Rated</span>'
                        } else {
                            return data;
                        }
                    }
                }
            ]
        });

        renderPie('compare-influencer-pie', 'Compare by Total', compareInfluencerPie, 'medium');
        renderCompareBar('compare-influencer-column', x, mediaBar);
    }).catch(function (err) {});

    $('#compare-likes-pie').parent().waitMe(miniLoading);
    axios.get(baseUrl + 'api/compare/comp-likes?' + type + '=' + ids + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;

        $('#compare-likes-pie').parent().waitMe('hide');

        var x = _.map(data.message, 'name');

        var compareLikesPie = _.map(data.message, function (item) {
            return {
                name: item.name,
                y: parseInt(item.totalLikes.Likes)
            };
        });

        var mediaBar = [];
        var mediaTable = [];
        var mediaColumn = [];
        var totalColumn = [];

        if(type === 'o') {
            totalColumn = [
                {
                    data: 'object',
                    title: 'Object'
                },
                {
                    data: 'likes',
                    title: 'Likes'
                },
            ];
            mediaColumn = [
                {
                    data: 'object',
                    title: 'Object'
                },
                {
                    data: 'media',
                    title: 'Media'
                },
                {
                    data: 'likes',
                    title: 'Likes'
                },
            ];

            _.forEach(data.message, function (item) {
                mediaBar.push({
                    type: 'column',
                    name: item.totalLikesByMedia.Media,
                    data: []
                });

                mediaTable.push({
                    object: item.name,
                    media: item.totalLikesByMedia.Media,
                    likes: item.totalLikesByMedia.Likes,
                    top: false
                });
            });

            mediaBar = _.uniqBy(mediaBar, 'name');

            _.forEach(mediaBar, function (media) {
                _.forEach(data.message, function (item, key) {
                    if (item.totalLikesByMedia.Media === media.name) {
                        media.data[key] = parseInt(item.totalLikesByMedia.Likes);
                    } else {
                        media.data[key] = 0;
                    }
                })
            });
        } else {
            totalColumn = [
                {
                    data: 'topic',
                    title: 'Topic'
                },
                {
                    data: 'likes',
                    title: 'Likes'
                },
            ];
            mediaColumn = [
                {
                    data: 'topic',
                    title: 'Topic'
                },
                {
                    data: 'media',
                    title: 'Media'
                },
                {
                    data: 'likes',
                    title: 'Likes'
                },
            ];

            _.forEach(data.message, function (item) {
                _.forEach(item.totalLikesByMedia, function (media) {
                    mediaBar.push({
                        type: 'column',
                        name: media.Media,
                        data: []
                    });

                    mediaTable.push({
                        topic: item.name,
                        media: media.Media,
                        likes: media.Likes,
                        top: false
                    });
                })
            });

            mediaBar = _.uniqBy(mediaBar, 'name');

            _.forEach(mediaBar, function (media) {
                _.forEach(data.message, function (item, key) {
                    var itemMedia = _.find(item.totalLikesByMedia, ['Media', media.name]);

                    if (itemMedia !== undefined) {
                        media.data[key] = parseInt(itemMedia.Likes);
                    } else {
                        media.data[key] = 0;
                    }
                })
            });
        }

        var totalTable = _.map(data.message, function(item) {
            if (type === 'o') {
                return {
                    object: item.name,
                    likes: item.totalLikes.Likes,
                    top: false
                }
            } else {
                return {
                    topic: item.name,
                    likes: item.totalLikes.Likes,
                    top: false
                }
            }
        });

        var max = _.maxBy(totalTable, 'likes');
        max.top = true;

        max = _.maxBy(mediaTable, 'likes');
        max.top = true;

        $('#table-likes-total').DataTable({
            destroy: true,
            data: totalTable,
            paging: false,
            info: false,
            searching: false,
            columns: totalColumn,
            columnDefs: [
                {
                    targets: 1,
                    data: 'URL',
                    render: function ( data, type, row, meta ) {
                        if (row.top) {
                            return '<b>'+data+'</b> <span class="badge bg-amber pull-right">Top Rated</span>'
                        } else {
                            return data;
                        }
                    }
                }
            ]
        });

        $('#table-likes-media').DataTable({
            destroy: true,
            data: mediaTable,
            paging: false,
            info: false,
            searching: false,
            columns: mediaColumn,
            columnDefs: [
                {
                    targets: 2,
                    data: 'URL',
                    render: function ( data, type, row, meta ) {
                        if (row.top) {
                            return '<b>'+data+'</b> <span class="badge bg-amber pull-right">Top Rated</span>'
                        } else {
                            return data;
                        }
                    }
                }
            ]
        });

        renderPie('compare-likes-pie', 'Compare by Total', compareLikesPie, 'medium');
        renderCompareBar('compare-likes-column', x, mediaBar);
    }).catch(function (err) {});

    $('#compare-metrics').parent().waitMe(miniLoading);
    axios.get(baseUrl + 'api/compare/metrics?' + type + '=' + ids + '&date=' + window.dateRangeFilter, {
        cancelToken: call.token
    }).then(function(response) {
        var data = response.data;

        $('#compare-metrics').parent().waitMe('hide');

        var metrics = _.map(data.message, function (item) {
            return {
                x: item.metrics.EngagedAccount,
                y: item.metrics.Influencer,
                z: item.metrics.Likes,
                name: item.name
            }
        });

        renderBubble('compare-metrics', metrics, 'Engaged User', 'Influencer', 'Likes');
    });

    $('#data-not-ready').hide();
    $('#data-ready').show();
}