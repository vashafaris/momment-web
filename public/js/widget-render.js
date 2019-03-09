const months = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
];

const responsiveRules = {
    rules: [{
        condition: {
            maxWidth: 768
        }
    }, {
        condition: {
            minWidth: 768,
            maxWidth: 992
        }
    }, {
        condition: {
            minWidth: 992,
            maxWidth: 1200
        }
    }, {
        condition: {
            minWidth: 1200
        }
    }]
};

function responsiveChart(chart, selector) {
    if(chart !== undefined && typeof chart !== 'undefined') {
        $('#' + selector).resize(function () {
            try {
                chart.reflow();
            } catch (e) {

            }
        });

        $(window).resize(function () {
            try {
                chart.reflow();
            } catch (e) {

            }
        });

        $('body').bind('classChanged', function (e) {
            var i = 0;
            var intv = setInterval(function () {
                if(chart !== undefined && typeof chart !== 'undefined') {
                    try {
                        chart.reflow();
                    } catch (e) {
                        clearInterval(intv);
                    }
                } else {
                    clearInterval(intv);
                }

                if (i === 15) {
                    clearInterval(intv);
                }

                i++;
            }, 1000);
        });
    }
}

function renderList(selector, data, display, value) {
    var list = '<ul class="list-group">';
    _.forEach(data, function (item) {
        list += '<li class="list-group-item" data-filter="'+item[display]+'" data-type="'+selector+'">' +
            truncateText(item[display], 20)+' ' +
            '   <span class="badge bg-deep-orange">'+item[value]+'</span>' +
        '</li>'
    });
    list += '</ul>';

    $('#'+selector).html(list);
}

$('.list-widget').on('click', '.list-group-item', function(e){
    var filter = $(this).data('filter');
    var type = $(this).data('type');
    var data = rawData;

    if(type === 'max-chart') {
        type = maxChart;
    }

    switch (type) {
        case 'top-influencer':
            data = _.filter(rawData, ['UserName', filter]);
            break;
        case 'most-posting':
            data = _.filter(rawData, ['UserName', filter]);
            break;
        case 'likes':
            data = _.filter(rawData, ['UserName', filter]);
            break;
    }

    showMaxChart(type, data, true);
});

function renderActivityChart(selector, series, size = 'small') {
    var height = 300;
    if(size === 'large') {
        height = 430;
    }

    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    var chart = Highcharts.chart(selector, {
        chart: {
            type: 'line',
            height: height
        },
        title: {
            text: null
        },
        credits: {
            enabled: false
        },
        xAxis: {
            type: 'datetime',
            labels: {
                formatter: function() {
                    return moment(this.value).format("DD MMM YYYY");
                }
            },
            minTickInterval: moment.duration(1, 'days').asMilliseconds()
        },
        series: series,
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                }
            },
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function (e) {
                            var filterDate  = moment(this.category).format('YYYY-MM-DD');
                            var filterMedia = e.point.series.name;
                            var data = rawData;
                            if(filterMedia !== 'Total') {
                                data = _.filter(rawData, function (item) {
                                    return item.Tanggal === filterDate && item.Channel === filterMedia;
                                });
                            } else {
                                data = _.filter(rawData, ['Tanggal', filterDate]);
                            }

                            showMaxChart(selector, data, true);
                        }
                    }
                }
            }
        },
        tooltip: {
            formatter: function () {
                return moment(this.x).format('DD MMM YYYY') +
                    '<br><b>' + this.y + '</b> post';
            }
        },

        responsive: responsiveRules
    });

    responsiveChart(chart, selector);
}

function renderCompareActivity(selector, series, size = 'small') {
    var height = 300;
    if(size === 'large') {
        height = 430;
    }

    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    var chart = Highcharts.chart(selector, {
        chart: {
            height: height
        },
        title: {
            text: null
        },
        credits: {
            enabled: false
        },
        xAxis: {
            type: 'datetime',
            labels: {
                formatter: function() {
                    return moment(this.value).format("DD MMM YYYY");
                }
            },
            minTickInterval: moment.duration(1, 'days').asMilliseconds()
        },
        series: series,
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                }
            },
        },
        tooltip: {
            formatter: function () {
                return moment(this.x).format('DD MMM YYYY') +
                    '<br><b>' + this.y + '</b> post';
            }
        },

        responsive: responsiveRules
    });

    responsiveChart(chart, selector);
}

function renderCompareBar(selector, x, series, size = 'small') {
    var height = 300;
    if(size === 'large') {
        height = 430;
    }

    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    var chart = Highcharts.chart(selector, {
        chart: {
            height: height
        },
        title: {
            text: null
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: x
        },
        yAxis: {
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor)
                }
            }
        },
        series: series,
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor)
                }
            }
        },

        responsive: responsiveRules
    });

    responsiveChart(chart, selector);
}

function renderWordcloud(selector, data, size = 'small') {
    var height = 150;
    if(size === 'large') {
        height = 430;
    }

    var chart = Highcharts.chart(selector, {
        chart: {
            height: height
        },
        series: [{
            type: 'wordcloud',
            data: data,
            name: 'Occurrences'
        }],
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            series: {
                cursor: 'pointer',
                events: {
                    click: function (e) {
                        var filter = e.point.name.toLowerCase();
                        var data = _.filter(rawData, function (item) {
                            return (' ' + item.Article + ' ').toLowerCase().includes(' ' + filter + ' ');
                        });
                        showMaxChart(selector, data, true);
                    }
                }
            }
        },

        responsive: responsiveRules
    });

    responsiveChart(chart, selector);
}

function renderPie(selector, name, data, size = 'small', title = null) {
    var height = 150;
    var diameter = 125;
    var top = 0;

    if(title !== null) {
        top = 50;
        diameter = 100;
    }

    if(size === 'large') {
        height = 430;
        if(title !== null) {
            diameter = 380;
        } else {
            diameter = 400;
        }
    }

    if(size === 'medium') {
        height = 250;
        diameter = 200;
        top = 55;
    }

    var chart = Highcharts.chart(selector, {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie',
            marginRight: diameter,
            marginTop: top,
            height: height
        },
        title: {
            text: title,
            align: 'left'
        },
        series: [{
            name: name,
            colorByPoint: true,
            data: data
        }],
        credits: {
            enabled: false
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                size: diameter,
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true,
                events: {
                    click: function (e) {
                        var filter = e.point.name;
                        var data = rawData;
                        var type = selector;

                        if(type === 'max-chart') {
                            type = maxChart;
                        }

                        switch (type) {
                            case 'locations':
                                filter = filter.toLowerCase();
                                if(filter === 'others') {
                                    filter = null;
                                }
                                data = _.filter(rawData, ['Kota', filter]);
                                break;
                            case 'media':
                                data = _.filter(rawData, ['Channel', filter]);
                                break;
                        }
                        showMaxChart(selector, data, true);
                    }
                }
            }
        },
        legend: {
            floating: true,
            verticalAlign: 'top',
            align:'right',
            layout: 'vertical',
            margin: 0,
            x: 0,
            y: 0
        },

        responsive: responsiveRules
    });

    responsiveChart(chart, selector);
}

function renderBubble(selector, data, x, y, z) {
    var chart = Highcharts.chart(selector, {
        chart: {
            type: 'bubble',
            plotBorderWidth: 1,
            zoomType: 'xy',
            height: 300
        },
        title: {
            text: ''
        },
        xAxis: {
            title: {
                text: x
            }
        },
        yAxis: {
            title: {
                text: y
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: z,
            data: data,
        }],
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        responsive: responsiveRules

    });

    responsiveChart(chart, selector);
}

function renderPeakTime(selector, data) {
    var chart = Highcharts.chart(selector, {
        chart: {
            type: 'heatmap',
            height: 430
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: days
        },
        yAxis: {
            categories: hours,
            title: 'Day Time'
        },
        colorAxis: {
            min: 0,
            minColor: '#E5E5E5',
            maxColor: Highcharts.getOptions().colors[0]
        },
        legend: {
            align: 'right',
            layout: 'vertical',
            margin: 0,
            verticalAlign: 'top',
            symbolHeight: 345
        },
        tooltip: {
            formatter: function () {
                if (this.point.value === 0) {
                    return 'no post on <b>' + this.series.xAxis.categories[this.point.x] + ' at ' + this.series.yAxis.categories[this.point.y] + '</b>';
                } else {
                    return 'posts <br><b>' + this.point.value + '</b> times on <br><b>' + this.series.xAxis.categories[this.point.x] + ' ' + this.series.yAxis.categories[this.point.y] + '</b>';
                }
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Peak Time',
            data: data,
            borderWidth: 2,
            borderColor: '#FFFFFF'
        }],
        plotOptions: {
            series: {
                cursor: 'pointer',
                allowPointSelect: true,
                events: {
                    click: function (e) {
                        var filterDay = e.point.series.xAxis.categories[e.point.x];
                        var filterHour = e.point.series.yAxis.categories[e.point.y];
                        var data = _.filter(rawData, function (item) {
                            return item.Hari === filterDay && parseInt(item.Jam) === parseInt(filterHour);
                        });
                        showMaxChart(selector, data, true)
                    }
                }
            }
        },

        responsive: responsiveRules

    });

    responsiveChart(chart, selector);
}
