$(document).ready(function(){
    $('#trends-content').parent().parent().css('margin-left', '15px');

    $('#accordion_twit').parent().waitMe(loading);
    axios.get(baseUrl + 'api/trends/twitter').then(function(response) {
        $('#accordion_twit').parent().waitMe('hide');
        $('#accordion_twit').html('');

        if(response.data.success && response.data.message.length > 0) {
            var trends = _.chain(response.data.message).map(function(item) {
                return {
                    id: 'twitter-'+item.id,
                    trend: item.trend,
                    count: item.count+' hours ago',
                    value: ''
                }
            }).uniqBy(function(item){
                return item.id
            }).value();

            _.forEach(response.data.message, function (item) {
                var image = '';
                if(item.tweet_pic !== null) {
                    image = '<img src="'+item.tweet_pic+'" class="tweet-image">';
                }

                var trend = _.find(trends, ['id', 'twitter-'+item.id]);
                trend.value += '    <div class="row">\n' +
                    '        <div class="col-md-3">\n' +
                    '            <img class="tweet-photo" src="'+item.photo_url+'" alt="">\n' +
                    '        </div>\n' +
                    '        <div class="col-md-9">\n' +
                    '            <h5 class="tweet-username">'+item.name+'</h5>\n' +
                    '            <span>'+item.username+'</span>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '    <div class="row tweet-body-container">\n' +
                    '        <div class="col-md-12 tweet-body">\n' +
                    '            '+image+'\n' +
                    '            '+item.tweet+'\n' +
                    '        </div>\n' +
                    '    </div>\n';
            });

            _.forEach(trends, function (item, key) {
                var expanded = false;
                if(key === 0) {
                    expanded = true;
                }

                $('#accordion_twit').append(buildAccordionPanel('accordion_twit',
                    item.id,
                    item.trend,
                    item.count,
                    '    <h5 class="related-tweet">Related Tweets</h5>\n' +
                    '    <div class="container-fluid">\n' +
                    '        '+item.value+'\n' +
                    '    </div>\n',
                    expanded));
            })
        }
    });

    $('#accordion_goo').parent().waitMe(loading);
    axios.get(baseUrl + 'api/trends/google').then(function(response) {
        $('#accordion_goo').parent().waitMe('hide');
        $('#accordion_goo').html('');
        if(response.data.success && response.data.message.length > 0) {
            _.forEach(response.data.message, function (item, key) {
                var expanded = false;
                if(key === 0) {
                    expanded = true;
                }
                $('#accordion_goo').append(buildAccordionPanel('accordion_goo',
                    'google-'+item.google_id,
                    item.trending_title,
                    item.approx_traffic + ' searches',
                    '<div class="google-trend"><h5>Related News</h5><a href="'+item.related_news+'" target="_blank" data-toggle="tooltip" title="' + item.related_news + '">' + truncateText(item.related_news, 50) + '</a></div>',
                    expanded));
            })
        }
    });

    $('#accordion_you').parent().waitMe(loading);
    axios.get(baseUrl + 'api/trends/youtube').then(function(response) {
        $('#accordion_you').parent().waitMe('hide');
        $('#accordion_you').html('');
        if(response.data.success && response.data.message.length > 0) {
            _.forEach(response.data.message, function (item, key) {
                var expanded = false;
                if(key === 0) {
                    expanded = true;
                }
                $('#accordion_you').append(buildAccordionPanel('accordion_you',
                    'youtube-'+item.video_id,
                    item.video_title,
                    item.video_uploaded_watched+'+ views',
                    '<iframe width="100%" height="315" src="'+item.video_url+'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>',
                    expanded));
            })
        }
    });
});

function buildAccordionPanel(panel, id, title, subTitle, body, expanded) {
    var expand = '';
    var expandin = '';
    if(expanded) {
        expand = 'aria-expanded="true"';
        expandin = ' in';
    }
    return '<div class="panel panel-default">\n' +
        '    <div class="panel-heading" role="tab" id="heading-'+ id +'">\n' +
        '        <h4 class="panel-title">\n' +
        '            <a role="button" data-toggle="collapse" data-parent="#' + panel + '" href="#collapse-' + id + '" ' + expand + ' aria-controls="collapse-' + id + '">\n' +
        '                <span class="trending-title" data-toggle="tooltip" title="'+  title +'">' + truncateText(title, 20) + '</span> <span class="trending-subtitle col-orange">'+ subTitle +'</span>\n' +
        '            </a>\n' +
        '        </h4>\n' +
        '    </div>\n' +
        '    <div id="collapse-' + id + '" class="panel-collapse collapse'+expandin+'" role="tabpanel" aria-labelledby="heading-'+ id +'">\n' +
        '        <div class="panel-body">\n' +
        '            ' + body + '\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>'
}