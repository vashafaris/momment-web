@extends('layouts.main')

@section('content')
    <section>
      <div class="row">
        {{-- <div class="col s0 m3"></div> --}}
        <div class="col s12 m12">
          <div class="card-panel background1">
            <h5 class="center white-text">Laporan Aktivitas</h5>
            <hr>
            <div class="row">
              <div class="col s12 m3">
                <div class="card-panel">
                  <h5 class="black-text" style="font-size:16px;font-weight:200">Rekomendasi<i class="far fa-lightbulb right"></i></h5>
                  <hr>
                  <center><span class="center" style="font-size:70px"><i class="material-icons">sentiment_very_dissatisfied</i></span></center><br>
                  <span class="black-text">Kami rekomendasikan anda untuk melakukan <span style="color:#5F0F4E">5 kali Tweet</span>
                  </span>
                </div>
              </div>
              <div class="col s12 m3">
                <div class="card-panel">
                  <h5 class="black-text" style="font-size:16px;font-weight:200">Tweet/Hari<i class="fab fa-twitter right"></i></h5>
                  <hr>
                  <center style="top:20px"><span style="font-size:70px;color:#5F0F4E;top:20px">30 </span><span style="font-size:20px;color:#5F0F4E;">tweet/hari</span></center>
                </div>
              </div>
              <div class="col s12 m3">
                <div class="card-panel">
                  <h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Followers<i class="material-icons right">people</i></h5>
                  <hr>
                  <center style="top:20px"><span style="font-size:70px;color:#5F0F4E;top:20px">0.29
                  </span><span style="font-size:40px;color:#5F0F4E;">%</span></center>
                </div>
              </div>
              <div class="col s12 m3">
                <div class="card-panel">
                  <h5 class="black-text" style="font-size:16px;font-weight:200">Analisis Sentimen<i class="material-icons right">face</i></h5>
                  <hr>
                  <center style="top:20px"><span style="font-size:70px;color:#5F0F4E;top:20px">0.29
                  </span><span style="font-size:40px;color:#5F0F4E;">%</span></center>
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- <div class="col s12 m12">
          <div class="card-panel background2">
            <h5 class="center white-text">Laporan Aktivitas</h5>
            <hr>
            <span class="white-text">I am a very simple card. I am good at containing small bits of information.
            I am convenient because I require little markup to use effectively. I am similar to what is called a panel in other frameworks.
            </span>
          </div>
        </div> --}}
      </div>
    </section>
@endsection

@section('custom-style')
    <style>
        .tabs .indicator {
            background: color(#871145 alpha(75%) blackness(20%));
            height: 60px;
            opacity: 0.3;
        }

        ul.user-sekilas {
            list-style-type: disc !important;
            margin-left: 10px;
        }

        li.user-sekilas {
            list-style-type: disc !important;
        }

        .background1 {
          /* position: fixed; */
          z-index: -1;
          /* width: 100vw;
          height: 100vh; */
          /* filter: grayscale(100%); /* Current draft standard */
          background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 1)), url('{{asset('images/bg9.jpg')}}');
          background-size: cover;
          background-position: center;
          background-repeat: no-repeat;
        }

        .background2 {
          /* position: fixed; */
          z-index: -1;
          /* width: 100vw;
          height: 100vh; */
          filter: grayscale(100%); /* Current draft standard */
          background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0)), url('{{asset('images/bg4.jpg')}}');
          background-size: cover;
          background-position: center;
          background-repeat: no-repeat;
        }

        .background-custom {
          background: #DA4453;  /* fallback for old browsers */
          background: -webkit-linear-gradient(to right, #89216B, #DA4453);  /* Chrome 10-25, Safari 5.1-6 */
          background: linear-gradient(to right, #89216B, #DA4453); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
          margin-bottom:0px;
        }

        .background-insight {
          background: #76b852;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #8DC26F, #76b852);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #8DC26F, #76b852); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }

        .background-insight2 {
          background: #FF416C;  /* fallback for old browsers */
          background: -webkit-linear-gradient(to right, #FF4B2B, #FF416C);  /* Chrome 10-25, Safari 5.1-6 */
          background: linear-gradient(to right, #FF4B2B, #FF416C); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }

    </style>
@endsection

@section('custom-script')
    <script>
        $(document).ready(function () {
            var container = $('#profile-result');

            $('#social-media').children('option').not('[disabled]').first().attr('selected', 'selected');

            $('select').material_select();
            $('select').siblings('input').css('margin-bottom', '3px');

            var oldState = '';
            $('#social-media').on('change', function () {
                var newState = $(this).val();
                if (oldState !== newState) {
                    if (newState !== null) {
                        container.html(
                            '<div class="card white" style="margin-top: 0px;">' +
                            '<div class="card-content" align="center">' +
                            '<div class="preloader-wrapper small active">' +
                            '<div class="spinner-layer spinner-blue-only">' +
                            '<div class="circle-clipper left">' +
                            '<div class="circle"></div>' +
                            '</div><div class="gap-patch">' +
                            '<div class="circle"></div>' +
                            '</div><div class="circle-clipper right">' +
                            '<div class="circle"></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );

                        // TODO:: To be develop if system had a new social media to be linked
                        switch (newState) {
                            case 'twitter':
                                $.ajax({
                                    type: 'GET',
                                    url: '{{ url('/social-media/twitter/get-profile') }}',
                                    data: '_token = {{ csrf_token() }}',
                                    success: function(data) {
                                        var photo_url = (data.response.person.photo_url !== null) ? data.response.person.photo_url : '{{ asset('images/default-photo.png') }}';
                                        var banner_url = (data.response.person.banner_url !== null) ? data.response.person.banner_url : '{{ asset('images/default-background.jpg') }}';
                                        var location = (data.response.person.location !== null) ? '<div class="divider" style="margin: 10px 0;"></div><span style="font-size: 10pt;margin: 10px 0;"><i class="fas fa-map-marker-alt"></i> &nbsp; ' + data.response.person.location + '</span>' : '';
                                        var created = (data.response.person.created !== null) ? '<div class="divider" style="margin: 10px 0;"></div><span style="font-size: 10pt;margin: 10px 0;"><i class="far fa-calendar-alt"></i> &nbsp; Member since ' + formatDate(new Date(data.response.person.created)) + '</span>' : '';

                                        var topPost = '';
                                        $.each(data.response.topPost, function(index, value){
                                            if(value.topic1 !== null && value.topic2 !== null){
                                                topPost +=
                                                    '<div class="row" style="border: 1px solid #871145;border-radius: 5px;padding: 10px 0px;">' +
                                                    '<div class="col s12">' +
                                                    '<p class="right" style="font-size: 8pt;color: #999999;font-weight: bold;"><i class="far fa-clock"></i> ' + formatDate(new Date(value.created)) + '</p>' +
                                                    '</div>' +
                                                    '<div class="col s3">' +
                                                    '<center class"valign-wrapper"><img src="' + photo_url + '" style="height: 40px;width: 40px;object-fit: cover;border-radius: 50%;margin: auto;"></center>' +
                                                    '</div>' +
                                                    '<div class="col s9">' +
                                                    '<p style="font-size: 10pt;">' + value.article + '</p>' +
                                                    '<p style="font-size: 8pt;color: #999999;font-weight: bold;">Retweeted ' + value.retweet + ' times</p>' +
                                                    '</div>' +
                                                    '<div class="col s12">' +
                                                    // 1 topik
                                                    '<p class="right" style="display:inline-block;position:relative;font-size: 8pt;color: #fff;font-weight: bold;background-color: #a60c5d;margin: 5px 0px;padding: 3px 12px;border-radius: 1em;">' + value.topic1 + '</p>' +
                                                    // 2 topik
                                                    '<p class="right" style="display:inline-block;position:relative;font-size: 8pt;color: #fff;font-weight: bold;background-color: #a60c5d;margin: 5px 5px;padding: 3px 10px;border-radius: 1em;">' + value.topic2 + '</p>' +
                                                    '</div>'+
                                                    '</div>'
                                            }else if(value.topic1 !== null){
                                                topPost +=
                                                    '<div class="row" style="border: 1px solid #871145;border-radius: 5px;padding: 10px 0px;">' +
                                                    '<div class="col s12">' +
                                                    '<p class="right" style="font-size: 8pt;color: #999999;font-weight: bold;"><i class="far fa-clock"></i> ' + formatDate(new Date(value.created)) + '</p>' +
                                                    '</div>' +
                                                    '<div class="col s3">' +
                                                    '<center class"valign-wrapper"><img src="' + photo_url + '" style="height: 40px;width: 40px;object-fit: cover;border-radius: 50%;margin: auto;"></center>' +
                                                    '</div>' +
                                                    '<div class="col s9">' +
                                                    '<p style="font-size: 10pt;">' + value.article + '</p>' +
                                                    '<p style="font-size: 8pt;color: #999999;font-weight: bold;">Retweeted ' + value.retweet + ' times</p>' +
                                                    '</div>' +
                                                    '<div class="col s12">' +
                                                    // 1 topik
                                                    '<p class="right" style="display:inline-block;position:relative;font-size: 8pt;color: #fff;font-weight: bold;background-color: #a60c5d;margin: 5px 0px;padding: 3px 12px;border-radius: 1em;">' + value.topic1 + '</p>' +
                                                    '</div>'+
                                                    '</div>';
                                            }else{
                                                topPost +=
                                                    '<div class="row" style="border: 1px solid #871145;border-radius: 5px;padding: 10px 0px;">' +
                                                    '<div class="col s12">' +
                                                    '<p class="right" style="font-size: 8pt;color: #999999;font-weight: bold;"><i class="far fa-clock"></i> ' + formatDate(new Date(value.created)) + '</p>' +
                                                    '</div>' +
                                                    '<div class="col s3">' +
                                                    '<center class"valign-wrapper"><img src="' + photo_url + '" style="height: 40px;width: 40px;object-fit: cover;border-radius: 50%;margin: auto;"></center>' +
                                                    '</div>' +
                                                    '<div class="col s9">' +
                                                    '<p style="font-size: 10pt;">' + value.article + '</p>' +
                                                    '<p style="font-size: 8pt;color: #999999;font-weight: bold;">Retweeted ' + value.retweet + ' times</p>' +
                                                    '</div>' +
                                                    '</div>';
                                            }
                                        });

                                        var profileCard =
                                            '<div class="card white" style="margin-top: 0px;">' +
                                            '<div class="card-image" style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4)), url(\'' + banner_url + '\');height: 200px;width: 100%;background-size: cover;background-position: center;">' +
                                            '<img src="' + photo_url + '" style="height: 64px;width: 64px;object-fit: cover;border: 2px solid white;position: absolute;border-radius: 50%;top: 70px;left: 24px;">' +
                                            '<span class="new badge blue" data-badge-caption="" style="position: absolute; top: 8px; right: 8px;">Twitter</span>' +
                                            '<span class="card-title">' + data.response.person.name + '</span>' +
                                            '<span class="card-title" style="font-size: 9pt;top: 150px;">@' + data.response.person.screen_name + '</span>' +
                                            '</div>' +
                                            '<ul class="tabs row" style="background-color: #871145; margin-left: 0 !important;">' +
                                            '<li class="tab col s2.4"><a class="white-text" href="#profile-tab-user"><span style="font-size: 16pt;"><i class="far fa-user"></i></span></a></li>' +
                                            '<li class="tab col s2.4"><a class="white-text" href="#profile-tab-tweet"><span style="font-size: 16pt;"><i class="far fa-comments"></i></span></a></li>' +
                                            '<li class="tab col s2.4"><a class="white-text" href="#profile-tab-toptweet"><span style="font-size: 16pt;"><i class="far fa-star"></i></span></a></li>' +
                                            '<li class="tab col s2.4"><a class="white-text" href="#profile-tab-activetime"><span style="font-size: 16pt;"><i class="far fa-clock"></i></span></a></li>' +
                                            '<li class="tab col s2.4"><a class="white-text" href="#profile-tab-location"><span style="font-size: 16pt;"><i class="fas fa-globe-asia"></i></span></a></li>' +
                                            '</ul>' +
                                            '<div id="profile-tab-user" class="card-content">' +
                                            '<blockquote style="font-size: 10pt; margin-top: 5px;"><i class="fas fa-quote-right fa-xs"></i> ' + data.response.person.description + ' <i class="fas fa-quote-left fa-xs"></i></blockquote>' +
                                            '<div class="divider" style="margin: 10px 0;"></div>' +
                                            '<div class="row" style="margin-bottom: 0px !important;">' +
                                            '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
                                            '<span style="font-weight: bold;">Tweet</span><br/>' +
                                            '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.person.statuses_count) + '</span>' +
                                            '</div>' +
                                            '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
                                            '<span style="font-weight: bold;">Followers</span><br/>' +
                                            '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.person.follower_log.followers) + '</span>' +
                                            '</div>' +
                                            '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
                                            '<span style="font-weight: bold;">Following</span><br/>' +
                                            '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.person.friends_count) + '</span>' +
                                            '</div>' +
                                            '</div>' +
                                            location +
                                            created +
                                            '</div>' +
                                            '<div id="profile-tab-tweet" class="card-content">' +
                                            '<span class="card-title">Tweet & Retweet</span>' +
                                            '<div id="profile-bar-chart">' +
                                            '</div>' +
                                            '</div>' +
                                            '<div id="profile-tab-toptweet" class="card-content">' +
                                            '<span class="card-title">Top 5 Tweet</span>' +
                                            '<div id="profile-top-tweet">' +
                                            topPost +
                                            '</div>' +
                                            '</div>' +
                                            '<div id="profile-tab-activetime" class="card-content">' +
                                            '<span class="card-title">Active Time</span>' +
                                            '<div id="profile-active-time">' +
                                            '</div>' +
                                            '</div>' +
                                            '<div id="profile-tab-location" class="card-content">' +
                                            '<span class="card-title">Location Based On Potential Influencer</span>' +
                                            '<div id="profile-location">' +
                                            '</div>' +
                                            '<table id="profile-location-table" class="display" width="100%">' +
                                            '</table>' +
                                            '</div>' +
                                            '</div>';

                                        container.html(profileCard);
                                        $('ul.tabs').tabs();

                                        //Location table
                                        // var userList;
                                        // var users=data.response;
                                        // userList=users.location.jumlah;
                                        // console.log(userList);
                                        //
                                        // $('#profile-location-table').DataTable({
                                        //     data: userList,
                                        //     columns: [
                                        //         {
                                        //             // data: 'xAxis',
                                        //             title: 'Kota'
                                        //         }
                                        //         // {
                                        //         //     data: 'jumlah',
                                        //         //     title: 'Jumlah'
                                        //         // }
                                        //     ]
                                        // });

                                        //Location CHART
                                        Highcharts.chart('profile-location', {
                                            chart: {
                                                type: 'column'
                                            },
                                            title: {
                                                text: ''
                                            },
                                            xAxis: {
                                                categories: data.response.location.xAxis,
                                                crosshair: true
                                            },
                                            yAxis: {
                                                min: 0,
                                                title: {
                                                    text: 'Count'
                                                }
                                            },
                                            tooltip: {
                                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                                                footerFormat: '</table>',
                                                shared: true,
                                                useHTML: true
                                            },
                                            plotOptions: {
                                                column: {
                                                    pointPadding: 0.2,
                                                    borderWidth: 0
                                                }
                                            },
                                            credits: {
                                                enabled: false
                                            },
                                            series: [{

                                                color: '#871145',
                                                data: data.response.location.jumlah
                                            }]
                                        });

                                        // BAR CHART
                                        Highcharts.chart('profile-bar-chart', {
                                            chart: {
                                                type: 'column'
                                            },
                                            title: {
                                                text: ''
                                            },
                                            xAxis: {
                                                categories: data.response.tweetNRetweet.xAxis,
                                                crosshair: true
                                            },
                                            yAxis: {
                                                min: 0,
                                                title: {
                                                    text: 'Count'
                                                }
                                            },
                                            tooltip: {
                                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                                                footerFormat: '</table>',
                                                shared: true,
                                                useHTML: true
                                            },
                                            plotOptions: {
                                                column: {
                                                    pointPadding: 0.2,
                                                    borderWidth: 0
                                                }
                                            },
                                            credits: {
                                                enabled: false
                                            },
                                            series: [{
                                                name: 'Tweet',
                                                color: '#871145',
                                                data: data.response.tweetNRetweet.data.tweet
                                            }, {
                                                name: 'Retweet',
                                                color: '#F49227',
                                                data: data.response.tweetNRetweet.data.retweet
                                            }]
                                        });

                                        // HEATMAP ACTIVE TIME CHART
                                        Highcharts.chart('profile-active-time', {
                                            chart: {
                                                type: 'heatmap',
                                                marginTop: 40,
                                                marginBottom: 80,
                                                height: 500
                                            },
                                            title: {
                                                text: ''
                                            },
                                            xAxis: {
                                                categories: data.response.postTime.xAxis
                                            },
                                            yAxis: {
                                                categories: data.response.postTime.yAxis,
                                                title: null
                                            },
                                            colorAxis: {
                                                min: 0,
                                                minColor: '#E5E5E5',
                                                //maxColor: '#871145'
                                                maxColor: Highcharts.getOptions().colors[0]
                                            },
                                            legend: {
                                                align: 'right',
                                                layout: 'vertical',
                                                margin: 0,
                                                verticalAlign: 'top',
                                                y: 25,
                                                symbolHeight: 380
                                            },
                                            tooltip: {
                                                formatter: function () {
                                                    if (this.point.value === 0) {
                                                        return '<b>' + data.response.person.name + '</b> didnt tweet <br> on <br><b>' + this.series.xAxis.categories[this.point.x] + ' at ' + this.series.yAxis.categories[this.point.y] + '</b>';
                                                    } else {
                                                        return '<b>' + data.response.person.name + '</b> tweet <br><b>' +
                                                            this.point.value + '</b> times on <br><b>' + this.series.xAxis.categories[this.point.x] + ' ' + this.series.yAxis.categories[this.point.y] + '</b>';
                                                    }
                                                }
                                            },
                                            credits: {
                                                enabled: false
                                            },
                                            series: [{
                                                name: 'Active Time',
                                                data: data.response.postTime.data,
                                                borderWidth: 2,
                                                borderColor: '#FFFFFF'
                                            }]

                                        });
                                    },
                                    error: function () {
                                        container.html(
                                            '<div class="card red darken-1" style="margin-top: 0px;">' +
                                            '<div class="card-content white-text">' +
                                            '<p><i class="fas fa-book"></i> Im sorry, magician might be sick. Trying to recover..</p>' +
                                            '</div>' +
                                            '</div>'
                                        );
                                    }
                                });
                                break;
                            case 'instagram':
                                $.ajax({
                                    type: 'GET',
                                    url: '{{ url('/social-media/instagram/get-profile') }}',
                                    data: '_token = {{ csrf_token() }}',
                                    success: function(data) {
                                        var photo_url = (data.response.person.user_profile_picture !== null) ? data.response.person.user_profile_picture : '{{ asset('images/default-photo.png') }}';
                                        var banner_url = (data.response.person.banner_url !== null) ? data.response.person.banner_url : '{{ asset('images/default-background.jpg') }}';
                                        var location = (data.response.person.location !== null) ? '<div class="divider" style="margin: 10px 0;"></div><span style="font-size: 10pt;margin: 10px 0;"><i class="fas fa-map-marker-alt"></i> &nbsp; ' + data.response.person.location + '</span>' : '';
                                        var created = (data.response.person.created !== null) ? '<div class="divider" style="margin: 10px 0;"></div><span style="font-size: 10pt;margin: 10px 0;"><i class="far fa-calendar-alt"></i> &nbsp; Member since ' + formatDate(new Date(data.response.person.created)) + '</span>' : '';

                                        var topPost = '';
                                        $.each(data.response.topPost, function(index, value){
                                            if(value.topic1 !== null && value.topic2 !== null){
                                                topPost +=
                                                    '<div class="row" style="border: 1px solid #871145;border-radius: 5px;padding: 10px 0px;">' +
                                                    '<div class="col s12">' +
                                                    '<p class="right" style="font-size: 8pt;color: #999999;"><i class="far fa-clock"></i> ' + formatDate(new Date(value.post_timestamp)) + '</p>' +
                                                    '</div>' +
                                                    '<div class="col s3">' +
                                                    '<center class"valign-wrapper"><img src="' + photo_url + '" style="height: 40px;width: 40px;object-fit: cover;border-radius: 50%;margin: auto;"></center>' +
                                                    '</div>' +
                                                    '<div class="col s9">' +
                                                    '<p style="font-size: 10pt;">' + value.post + '</p>' +
                                                    '<p style="font-size: 8pt;color: #999999;">Liked ' + value.post_likes + ' times</p>' +
                                                    '</div>' +
                                                    '<div class="col s12">' +
                                                    // 1 topik
                                                    '<p class="right" style="display:inline-block;position:relative;font-size: 8pt;color: #fff;font-weight: bold;background-color: #a60c5d;margin: 5px 0px;padding: 3px 12px;border-radius: 1em;">' + value.topic1 + '</p>' +
                                                    // 2 topik
                                                    '<p class="right" style="display:inline-block;position:relative;font-size: 8pt;color: #fff;font-weight: bold;background-color: #a60c5d;margin: 5px 5px;padding: 3px 10px;border-radius: 1em;">' + value.topic2 + '</p>' +
                                                    '</div>'+
                                                    '</div>';
                                            }else if(value.topic1 !== null){
                                                topPost +=
                                                    '<div class="row" style="border: 1px solid #871145;border-radius: 5px;padding: 10px 0px;">' +
                                                    '<div class="col s12">' +
                                                    '<p class="right" style="font-size: 8pt;color: #999999;"><i class="far fa-clock"></i> ' + formatDate(new Date(value.post_timestamp)) + '</p>' +
                                                    '</div>' +
                                                    '<div class="col s3">' +
                                                    '<center class"valign-wrapper"><img src="' + photo_url + '" style="height: 40px;width: 40px;object-fit: cover;border-radius: 50%;margin: auto;"></center>' +
                                                    '</div>' +
                                                    '<div class="col s9">' +
                                                    '<p style="font-size: 10pt;">' + value.post + '</p>' +
                                                    '<p style="font-size: 8pt;color: #999999;">Liked ' + value.post_likes + ' times</p>' +
                                                    '</div>' +
                                                    '<div class="col s12">' +
                                                    // 1 topik
                                                    '<p class="right" style="display:inline-block;position:relative;font-size: 8pt;color: #fff;font-weight: bold;background-color: #a60c5d;margin: 5px 0px;padding: 3px 12px;border-radius: 1em;">' + value.topic1 + '</p>' +
                                                    '</div>'+
                                                    '</div>';
                                            }else{
                                                topPost +=
                                                    '<div class="row" style="border: 1px solid #871145;border-radius: 5px;padding: 10px 0px;">' +
                                                    '<div class="col s12">' +
                                                    '<p class="right" style="font-size: 8pt;color: #999999;"><i class="far fa-clock"></i> ' + formatDate(new Date(value.post_timestamp)) + '</p>' +
                                                    '</div>' +
                                                    '<div class="col s3">' +
                                                    '<center class"valign-wrapper"><img src="' + photo_url + '" style="height: 40px;width: 40px;object-fit: cover;border-radius: 50%;margin: auto;"></center>' +
                                                    '</div>' +
                                                    '<div class="col s9">' +
                                                    '<p style="font-size: 10pt;">' + value.post + '</p>' +
                                                    '<p style="font-size: 8pt;color: #999999;">Liked ' + value.post_likes + ' times</p>' +
                                                    '</div>' +
                                                    '</div>';
                                            }
                                        });

                                        var profileCard =
                                            '<div class="card white" style="margin-top: 0px;">' +
                                            '<div class="card-image" style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4)), url(\'{{ asset('images/default-background.jpg') }}\');height: 200px;width: 100%;background-size: cover;background-position: center;">' +
                                            '<img src="' + photo_url + '" style="height: 64px;width: 64px;object-fit: cover;border: 2px solid white;position: absolute;border-radius: 50%;top: 70px;left: 24px;">' +
                                            '<span class="new badge" data-badge-caption="" style="background-color:#ffc273;position: absolute; top: 8px; right: 8px;">Instagram</span>' +
                                            '<span class="card-title" style="font-size: 14pt;">' + data.response.person.full_name + '</span>' +
                                            '<span class="card-title" style="font-size: 9pt;top: 150px;">@' + data.response.person.post_username + '</span>' +
                                            '</div>' +
                                            '<ul class="tabs row" style="background-color: #871145; margin-left: 0 !important;">' +
                                            '<li class="tab col s3"><a class="white-text" href="#profile-tab-user"><span style="font-size: 16pt;"><i class="far fa-user"></i></span></a></li>' +
                                            '<li class="tab col s3"><a class="white-text" href="#profile-tab-tweet"><span style="font-size: 16pt;"><i class="far fa-comments"></i></span></a></li>' +
                                            '<li class="tab col s3"><a class="white-text" href="#profile-tab-toptweet"><span style="font-size: 16pt;"><i class="far fa-star"></i></span></a></li>' +
                                            '<li class="tab col s3"><a class="white-text" href="#profile-tab-activetime"><span style="font-size: 16pt;"><i class="far fa-clock"></i></span></a></li>' +
                                            '</ul>' +
                                            '<div id="profile-tab-user" class="card-content">' +
                                            '<blockquote style="font-size: 10pt; margin-top: 5px;"><i class="fas fa-quote-right fa-xs"></i> ' + data.response.person.user_bio + ' <i class="fas fa-quote-left fa-xs"></i></blockquote>' +
                                            '<div class="divider" style="margin: 10px 0;"></div>' +
                                            '<div class="row" style="margin-bottom: 0px !important;">' +
                                            '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
                                            '<span style="font-weight: bold;">Posts</span><br/>' +
                                            '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.person.user_posts) + '</span>' +
                                            '</div>' +
                                            '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
                                            '<span style="font-weight: bold;">Followers</span><br/>' +
                                            '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.person.user_followers) + '</span>' +
                                            '</div>' +
                                            '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
                                            '<span style="font-weight: bold;">Following</span><br/>' +
                                            '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.person.user_following) + '</span>' +
                                            '</div>' +
                                            '</div>' +

                                            '</div>' +
                                            '<div id="profile-tab-tweet" class="card-content">' +
                                            '<span class="card-title">Post & Like</span>' +
                                            '<div id="profile-bar-chart-instagram">' +
                                            '</div>' +
                                            '</div>' +
                                            '<div id="profile-tab-toptweet" class="card-content">' +
                                            '<span class="card-title">Top 5 Post</span>' +
                                            '<div id="profile-top-tweet">' +
                                            topPost +
                                            '</div>' +
                                            '</div>' +
                                            '<div id="profile-tab-activetime" class="card-content">' +
                                            '<span class="card-title">Active Time</span>' +
                                            '<div id="profile-active-time-instagram">' +
                                            '</div>' +
                                            '</div>' +
                                            '</div>';

                                        container.html(profileCard);
                                        $('ul.tabs').tabs();

                                        // BAR CHART
                                        Highcharts.chart('profile-bar-chart-instagram', {
                                            chart: {
                                                type: 'column'
                                            },
                                            title: {
                                                text: ''
                                            },
                                            xAxis: {
                                                categories: data.response.postNLike.xAxis,
                                                crosshair: true
                                            },
                                            yAxis: {
                                                min: 0,
                                                title: {
                                                    text: 'Count'
                                                }
                                            },
                                            tooltip: {
                                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                                                footerFormat: '</table>',
                                                shared: true,
                                                useHTML: true
                                            },
                                            plotOptions: {
                                                column: {
                                                    pointPadding: 0.2,
                                                    borderWidth: 0
                                                }
                                            },
                                            credits: {
                                                enabled: false
                                            },
                                            series: [{
                                                name: 'Post',
                                                color: '#871145',
                                                data: data.response.postNLike.data.post
                                            }, {
                                                name: 'Like',
                                                color: '#F49227',
                                                data: data.response.postNLike.data.like
                                            }]
                                        });

                                        // HEATMAP ACTIVE TIME CHART
                                        Highcharts.chart('profile-active-time-instagram', {
                                            chart: {
                                                type: 'heatmap',
                                                marginTop: 40,
                                                marginBottom: 80,
                                                height: 500
                                            },
                                            title: {
                                                text: ''
                                            },
                                            xAxis: {
                                                categories: data.response.postTime.xAxis
                                            },
                                            yAxis: {
                                                categories: data.response.postTime.yAxis,
                                                title: null
                                            },
                                            colorAxis: {
                                                min: 0,
                                                minColor: '#E5E5E5',
                                                //maxColor: '#871145'
                                                maxColor: Highcharts.getOptions().colors[0]
                                            },
                                            legend: {
                                                align: 'right',
                                                layout: 'vertical',
                                                margin: 0,
                                                verticalAlign: 'top',
                                                y: 25,
                                                symbolHeight: 380
                                            },
                                            tooltip: {
                                                formatter: function () {
                                                    if (this.point.value === 0) {
                                                        return '<b>' + data.response.person.full_name + '</b> didnt post <br> on <br><b>' + this.series.xAxis.categories[this.point.x] + ' at ' + this.series.yAxis.categories[this.point.y] + '</b>';
                                                    } else {
                                                        return '<b>' + data.response.person.full_name + '</b> post <br><b>' +
                                                            this.point.value + '</b> times on <br><b>' + this.series.xAxis.categories[this.point.x] + ' ' + this.series.yAxis.categories[this.point.y] + '</b>';
                                                    }
                                                }
                                            },
                                            credits: {
                                                enabled: false
                                            },
                                            series: [{
                                                name: 'Active Time',
                                                data: data.response.postTime.data,
                                                borderWidth: 2,
                                                borderColor: '#FFFFFF'
                                            }]

                                        });
                                    },
                                    error: function () {
                                        container.html(
                                            '<div class="card red darken-1" style="margin-top: 0px;">' +
                                            '<div class="card-content white-text">' +
                                            '<p><i class="fas fa-book"></i> Im sorry, magician might be sick. Trying to recover..</p>' +
                                            '</div>' +
                                            '</div>'
                                        );
                                    }
                                });
                                    break;
                            case 'youtube':
                                $.ajax({
                                    type: 'GET',
                                    url: '{{ url('/social-media/youtube/get-profile') }}',
                                    data: '_token = {{ csrf_token() }}',
                                    success: function(data) {
                                      var photo_url = (data.response.person.profile_picture !== null) ? data.response.person.profile_picture : '{{ asset('images/default-photo.png') }}';
                                      var banner_url = (data.response.person.banner_url !== null) ? data.response.person.banner_url : '{{ asset('images/default-background.jpg') }}';
                                      var location = (data.response.person.country !== null) ? '<div class="divider" style="margin: 10px 0;"></div><span style="font-size: 10pt;margin: 10px 0;"><i class="fas fa-map-marker-alt"></i> &nbsp; ' + data.response.person.country + '</span>' : '';
                                      var created = (data.response.person.register_date !== null) ? '<div class="divider" style="margin: 10px 0;"></div><span style="font-size: 10pt;margin: 10px 0;"><i class="far fa-calendar-alt"></i> &nbsp; Member since ' + formatDate(new Date(data.response.person.register_date)) + '</span>' : '';

                                      var topPost = '';
                                      $.each(data.response.topPost, function(index, value){
                                          if(value.topic1 !== null && value.topic2 !== null){
                                              topPost +=
                                                  '<div class="row" style="border: 1px solid #871145;border-radius: 5px;padding: 10px 0px;">' +
                                                  '<div class="col s12">' +
                                                  '<p class="right" style="font-size: 8pt;color: #999999;font-weight: bold;"><i class="far fa-clock"></i> ' + formatDate(new Date(value.published_at)) + '</p>' +
                                                  '</div>' +
                                                  '<div class="col s3">' +
                                                  '<center class"valign-wrapper"><img src="' + photo_url + '" style="height: 40px;width: 40px;object-fit: cover;border-radius: 50%;margin: auto;"></center>' +
                                                  '</div>' +
                                                  '<div class="col s9">' +
                                                  '<p style="font-size: 10pt;">' + value.title + '</p>' +
                                                  '<p style="font-size: 8pt;color: #999999;font-weight: bold;">Liked ' + value.like_count + ' times</p>' +
                                                  '</div>' +
                                                  '<div class="col s12">' +
                                                  // 1 topik
                                                  '<p class="right" style="display:inline-block;position:relative;font-size: 8pt;color: #fff;font-weight: bold;background-color: #a60c5d;margin: 5px 0px;padding: 3px 12px;border-radius: 1em;">' + 'Technologies' + '</p>' +
                                                  // 2 topik
                                                  '<p class="right" style="display:inline-block;position:relative;font-size: 8pt;color: #fff;font-weight: bold;background-color: #a60c5d;margin: 5px 5px;padding: 3px 10px;border-radius: 1em;">' + 'Education' + '</p>' +
                                                  '</div>'+
                                                  '</div>'
                                          }else if(value.topic1 !== null){
                                              topPost +=
                                                  '<div class="row" style="border: 1px solid #871145;border-radius: 5px;padding: 10px 0px;">' +
                                                  '<div class="col s12">' +
                                                  '<p class="right" style="font-size: 8pt;color: #999999;font-weight: bold;"><i class="far fa-clock"></i> ' + formatDate(new Date(value.published_at)) + '</p>' +
                                                  '</div>' +
                                                  '<div class="col s3">' +
                                                  '<center class"valign-wrapper"><img src="' + photo_url + '" style="height: 40px;width: 40px;object-fit: cover;border-radius: 50%;margin: auto;"></center>' +
                                                  '</div>' +
                                                  '<div class="col s9">' +
                                                  '<p style="font-size: 10pt;">' + value.title + '</p>' +
                                                  '<p style="font-size: 8pt;color: #999999;font-weight: bold;">Liked ' + value.like_count + ' times</p>' +
                                                  '</div>' +
                                                  '<div class="col s12">' +
                                                  // 1 topik
                                                  '<p class="right" style="display:inline-block;position:relative;font-size: 8pt;color: #fff;font-weight: bold;background-color: #a60c5d;margin: 5px 0px;padding: 3px 12px;border-radius: 1em;">' + value.topic1 + '</p>' +
                                                  '</div>'+
                                                  '</div>';
                                          }else{
                                              topPost +=
                                                  '<div class="row" style="border: 1px solid #871145;border-radius: 5px;padding: 10px 0px;">' +
                                                  '<div class="col s12">' +
                                                  '<p class="right" style="font-size: 8pt;color: #999999;font-weight: bold;"><i class="far fa-clock"></i> ' + formatDate(new Date(value.published_at)) + '</p>' +
                                                  '</div>' +
                                                  '<div class="col s3">' +
                                                  '<center class"valign-wrapper"><img src="' + photo_url + '" style="height: 40px;width: 40px;object-fit: cover;border-radius: 50%;margin: auto;"></center>' +
                                                  '</div>' +
                                                  '<div class="col s9">' +
                                                  '<p style="font-size: 10pt;">' + value.title + '</p>' +
                                                  '<p style="font-size: 8pt;color: #999999;font-weight: bold;">Liked ' + value.like_count + ' times</p>' +
                                                  '</div>' +
                                                  '</div>';
                                          }
                                      });

                                      var profileCard =
                                          '<div class="card white" style="margin-top: 0px;">' +
                                          '<div class="card-image" style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4)), url(\'{{ asset('images/youtube-background.jpg') }}\');height: 200px;width: 100%;background-size: cover;background-position: center;">' +
                                          '<img src="' + photo_url + '" style="height: 64px;width: 64px;object-fit: cover;border: 2px solid white;position: absolute;border-radius: 50%;top: 70px;left: 24px;">' +
                                          '<span class="new badge red" data-badge-caption="" style="position: absolute; top: 8px; right: 8px;">Youtube</span>' +
                                          '<span class="card-title">' + data.response.person.username + '</span>' +
                                          '<span class="card-title" style="font-size: 9pt;top: 150px;">@' + data.response.person.username_for_show + '</span>' +
                                          '</div>' +
                                          '<ul class="tabs row" style="background-color: #871145; margin-left: 0 !important;">' +
                                          '<li class="tab col s3"><a class="white-text" href="#profile-tab-user"><span style="font-size: 16pt;"><i class="far fa-user"></i></span></a></li>' +
                                          '<li class="tab col s3"><a class="white-text" href="#profile-tab-tweet"><span style="font-size: 16pt;"><i class="far fa-comments"></i></span></a></li>' +
                                          '<li class="tab col s3"><a class="white-text" href="#profile-tab-toptweet"><span style="font-size: 16pt;"><i class="far fa-star"></i></span></a></li>' +
                                          '<li class="tab col s3"><a class="white-text" href="#profile-tab-activetime"><span style="font-size: 16pt;"><i class="far fa-clock"></i></span></a></li>' +
                                          '</ul>' +
                                          '<div id="profile-tab-user" class="card-content">' +
                                          '<blockquote style="font-size: 10pt; margin-top: 5px;"><i class="fas fa-quote-right fa-xs"></i> ' + data.response.person.description + ' <i class="fas fa-quote-left fa-xs"></i></blockquote>' +
                                          '<div class="divider" style="margin: 10px 0;"></div>' +
                                          '<div class="row" style="margin-bottom: 0px !important;">' +
                                          '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
                                          '<span style="font-weight: bold;">Subscriber</span><br/>' +
                                          '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.person.subscriber_count) + '</span>' +
                                          '</div>' +
                                          '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
                                          '<span style="font-weight: bold;">Video</span><br/>' +
                                          '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.person.video_count) + '</span>' +
                                          '</div>' +
                                          '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
                                          '<span style="font-weight: bold;">View</span><br/>' +
                                          '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.person.view_count) + '</span>' +
                                          '</div>' +
                                          '</div>' +
                                          location +
                                          created +
                                          '</div>' +
                                          '<div id="profile-tab-tweet" class="card-content">' +
                                          '<span class="card-title">Video Stats</span>' +
                                          '<div id="profile-bar-chart">' +
                                          '</div>' +
                                          '</div>' +
                                          '<div id="profile-tab-toptweet" class="card-content">' +
                                          '<span class="card-title">Top 5 Video </span>' +
                                          '<div id="profile-top-tweet">' +
                                          topPost +
                                          '</div>' +
                                          '</div>' +
                                          '<div id="profile-tab-activetime" class="card-content">' +
                                          '<span class="card-title">Active Time</span>' +
                                          '<div id="profile-active-time">' +
                                          '</div>' +
                                          '</div>' +
                                          '</div>';

                                      container.html(profileCard);
                                      $('ul.tabs').tabs();

                                      // BAR CHART
                                      Highcharts.chart('profile-bar-chart', {
                                          chart: {
                                              type: 'column'
                                          },
                                          title: {
                                              text: ''
                                          },
                                          xAxis: {
                                              categories: data.response.video.xAxis,
                                              crosshair: true
                                          },
                                          yAxis: {
                                              min: 0,
                                              title: {
                                                  text: 'Count'
                                              }
                                          },
                                          tooltip: {
                                              headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                              pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                              '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                                              footerFormat: '</table>',
                                              shared: true,
                                              useHTML: true
                                          },
                                          plotOptions: {
                                              column: {
                                                  pointPadding: 0.2,
                                                  borderWidth: 0
                                              }
                                          },
                                          credits: {
                                              enabled: false
                                          },
                                          series: [{
                                              name: 'Video',
                                              color: '#66CCFF',
                                              data: data.response.video.data.video
                                          }, {
                                              name: 'View',
                                              color: '#F49227',
                                              data: data.response.video.data.view
                                          }, {
                                              name: 'Comment',
                                              color: '#871145',
                                              data: data.response.video.data.comment
                                          }, {
                                              name: 'Like',
                                              color: '#92CD00',
                                              data: data.response.video.data.like
                                          }, {
                                              name: 'Dislike',
                                              color: '#CC0000',
                                              data: data.response.video.data.dislike
                                          }]
                                      });

                                      // HEATMAP ACTIVE TIME CHART
                                      Highcharts.chart('profile-active-time', {
                                          chart: {
                                              type: 'heatmap',
                                              marginTop: 40,
                                              marginBottom: 80,
                                              height: 500
                                          },
                                          title: {
                                              text: ''
                                          },
                                          xAxis: {
                                              categories: data.response.postTime.xAxis
                                          },
                                          yAxis: {
                                              categories: data.response.postTime.yAxis,
                                              title: null
                                          },
                                          colorAxis: {
                                              min: 0,
                                              minColor: '#E5E5E5',
                                              //maxColor: '#871145'
                                              maxColor: Highcharts.getOptions().colors[0]
                                          },
                                          legend: {
                                              align: 'right',
                                              layout: 'vertical',
                                              margin: 0,
                                              verticalAlign: 'top',
                                              y: 25,
                                              symbolHeight: 380
                                          },
                                          tooltip: {
                                              formatter: function () {
                                                  if (this.point.value === 0) {
                                                      return '<b>' + data.response.person.username_for_show + '</b> didnt upload <br> on <br><b>' + this.series.xAxis.categories[this.point.x] + ' at ' + this.series.yAxis.categories[this.point.y] + '</b>';
                                                  } else {
                                                      return '<b>' + data.response.person.username_for_show + '</b> upload <br><b>' +
                                                          this.point.value + '</b> times on <br><b>' + this.series.xAxis.categories[this.point.x] + ' ' + this.series.yAxis.categories[this.point.y] + '</b>';
                                                  }
                                              }
                                          },
                                          credits: {
                                              enabled: false
                                          },
                                          series: [{
                                              name: 'Active Time',
                                              data: data.response.postTime.data,
                                              borderWidth: 2,
                                              borderColor: '#FFFFFF'
                                          }]

                                      });
                                  },
                                  error: function () {
                                      container.html(
                                          '<div class="card red darken-1" style="margin-top: 0px;">' +
                                          '<div class="card-content white-text">' +
                                          '<p><i class="fas fa-book"></i> Im sorry, magician might be sick. Trying to recover..</p>' +
                                          '</div>' +
                                          '</div>'
                                      );
                                  }
                              });
                                    break;
                            case 'facebook':
                                $.ajax({
                                    type: 'GET',
                                    url: '{{ url('/social-media/facebook/get-profile') }}',
                                    data: '_token = {{ csrf_token() }}',
                                    success: function(data) {
                                        var photo_url = (data.response.person.profile_picture !== null) ? data.response.person.profile_picture : '{{ asset('images/default-photo.png') }}';
                                        var banner_url = (data.response.person.banner_url !== null) ? data.response.person.banner_url : '{{ asset('images/default-background.jpg') }}';
                                        var location = (data.response.person.location !== null) ? '<div class="divider" style="margin: 10px 0;"></div><span style="font-size: 10pt;margin: 10px 0;"><i class="fas fa-map-marker-alt"></i> &nbsp; ' + data.response.person.location + '</span>' : '';
                                        var created = (data.response.person.created !== null) ? '<div class="divider" style="margin: 10px 0;"></div><span style="font-size: 10pt;margin: 10px 0;"><i class="far fa-calendar-alt"></i> &nbsp; Member since ' + formatDate(new Date(data.response.person.created)) + '</span>' : '';
                                        var topPost = '';
                                        var myStr = "penyelidik di HCR, Penanam modal di Global Century Limited. Ltd Malaysia dan Komisaris di CV Putra Adhi KaryaPernah bekerja di: PT.cakra buanaJurusan Pendidikan Umum di Universitas Pendidikan IndonesiaPernah belajar di: Universitas Sebelas Maret dan SMA Negeri 1 KebumenTinggal di Kebumen, Jawa Tengah, IndonesiaDari Jepara, Jepara1 anggota keluargaTelepon0822-4225-7493";
                                        // var strArray = data.response.person.user_sekilas.split("Pernah");
                                        var strArray = data.response.person.user_sekilas.split(/\s?Pernah\s?|\s?Jurusan\s?|\s?Tinggal\s?|\s?Dari\s?|\s?Telepon\s?|\s?Situs\s?|\s?http\:\/\/\s?/);
                                        var user_sekilas = '';
                                        $.each(strArray, function(index, value){
                                            user_sekilas +=
                                            '<li class="user-sekilas">' + value + '</li>'
                                        });

                                        $.each(data.response.topPost, function(index, value){
                                            if(value.topic1 !== null && value.topic2 !== null){
                                                topPost +=
                                                    '<div class="row" style="border: 1px solid #871145;border-radius: 5px;padding: 10px 0px;">' +
                                                    '<div class="col s12">' +
                                                    '<p class="right" style="font-size: 8pt;color: #999999;"><i class="far fa-clock"></i> ' + formatDate(new Date(value.post_postedAt)) + '</p>' +
                                                    '</div>' +
                                                    '<div class="col s3">' +
                                                    '<center class"valign-wrapper"><img src="' + photo_url + '" style="height: 40px;width: 40px;object-fit: cover;border-radius: 50%;margin: auto;"></center>' +
                                                    '</div>' +
                                                    '<div class="col s9">' +
                                                    '<p style="font-size: 10pt;">' + value.post + '</p>' +
                                                    '<p style="font-size: 8pt;color: #999999;">Total comment, like, & share ' + value.totalTop + ' times</p>' +
                                                    '</div>' +
                                                    '<div class="col s12">' +
                                                    // 1 topik
                                                    '<p class="right" style="display:inline-block;position:relative;font-size: 8pt;color: #fff;font-weight: bold;background-color: #a60c5d;margin: 5px 0px;padding: 3px 12px;border-radius: 1em;">' + 'Politik' + '</p>' +
                                                    // 2 topik
                                                    '<p class="right" style="display:inline-block;position:relative;font-size: 8pt;color: #fff;font-weight: bold;background-color: #a60c5d;margin: 5px 5px;padding: 3px 10px;border-radius: 1em;">' + 'Pendidikan' + '</p>' +
                                                    '</div>'+
                                                    '</div>';
                                            }else if(value.topic1 !== null){
                                                topPost +=
                                                    '<div class="row" style="border: 1px solid #871145;border-radius: 5px;padding: 10px 0px;">' +
                                                    '<div class="col s12">' +
                                                    '<p class="right" style="font-size: 8pt;color: #999999;"><i class="far fa-clock"></i> ' + formatDate(new Date(value.post_postedAt)) + '</p>' +
                                                    '</div>' +
                                                    '<div class="col s3">' +
                                                    '<center class"valign-wrapper"><img src="' + photo_url + '" style="height: 40px;width: 40px;object-fit: cover;border-radius: 50%;margin: auto;"></center>' +
                                                    '</div>' +
                                                    '<div class="col s9">' +
                                                    '<p style="font-size: 10pt;">' + value.post+ '</p>' +
                                                    '<p style="font-size: 8pt;color: #999999;">Total comment, like, & share  ' + value.totalTop + ' times</p>' +
                                                    '</div>' +
                                                    '<div class="col s12">' +
                                                    // 1 topik
                                                    '<p class="right" style="display:inline-block;position:relative;font-size: 8pt;color: #fff;font-weight: bold;background-color: #a60c5d;margin: 5px 0px;padding: 3px 12px;border-radius: 1em;">' + 'dummy' + '</p>' +
                                                    '</div>'+
                                                    '</div>';
                                            }else{
                                                topPost +=
                                                    '<div class="row" style="border: 1px solid #871145;border-radius: 5px;padding: 10px 0px;">' +
                                                    '<div class="col s12">' +
                                                    '<p class="right" style="font-size: 8pt;color: #999999;"><i class="far fa-clock"></i> ' + formatDate(new Date(value.post_postedAt)) + '</p>' +
                                                    '</div>' +
                                                    '<div class="col s3">' +
                                                    '<center class"valign-wrapper"><img src="' + photo_url + '" style="height: 40px;width: 40px;object-fit: cover;border-radius: 50%;margin: auto;"></center>' +
                                                    '</div>' +
                                                    '<div class="col s9">' +
                                                    '<p style="font-size: 10pt;">' + value.post + '</p>' +
                                                    '<p style="font-size: 8pt;color: #999999;">Total comment, like, & share  ' + value.totalTop + ' times</p>' +
                                                    '</div>' +
                                                    '</div>';
                                            }
                                        });

                                        var profileCard =
                                            '<div class="card white" style="margin-top: 0px;">' +
                                            '<div class="card-image" style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4)), url(\'{{ asset('images/default-background.jpg') }}\');height: 200px;width: 100%;background-size: cover;background-position: center;">' +
                                            '<img src="' + photo_url + '" style="height: 64px;width: 64px;object-fit: cover;border: 2px solid white;position: absolute;border-radius: 50%;top: 70px;left: 24px;">' +
                                            '<span class="new badge" data-badge-caption="" style="background-color:#3b5998;position: absolute; top: 8px; right: 8px;">Facebook</span>' +
                                            '<span class="card-title" style="font-size: 14pt;">' + data.response.person.user_fullname + '</span>' +
                                            '<span class="card-title" style="font-size: 9pt;top: 150px;">@' + data.response.person.user_name + '</span>' +
                                            '</div>' +
                                            '<ul class="tabs row" style="background-color: #871145; margin-left: 0 !important;">' +
                                            '<li class="tab col s3"><a class="white-text" href="#profile-tab-user"><span style="font-size: 16pt;"><i class="far fa-user"></i></span></a></li>' +
                                            '<li class="tab col s3"><a class="white-text" href="#profile-tab-tweet"><span style="font-size: 16pt;"><i class="far fa-comments"></i></span></a></li>' +
                                            '<li class="tab col s3"><a class="white-text" href="#profile-tab-toptweet"><span style="font-size: 16pt;"><i class="far fa-star"></i></span></a></li>' +
                                            '<li class="tab col s3"><a class="white-text" href="#profile-tab-activetime"><span style="font-size: 16pt;"><i class="far fa-clock"></i></span></a></li>' +
                                            '</ul>' +
                                            '<div id="profile-tab-user" class="card-content">' +
                                            '<blockquote style="font-size: 10pt; margin-top: 5px;"><i class="fas fa-quote-left fa-xs"></i> '  + data.response.person.user_about
                                              +
                                            ' <i class="fas fa-quote-right fa-xs"></i>'+'<ul class="user-sekilas">' + user_sekilas  + '</ul></blockquote>' +
                                            '<div class="divider" style="margin: 10px 0;"></div>' +
                                            '<div class="row" style="margin-bottom: 0px !important;">' +
                                            '<div class="col s7" style="text-align: center;font-size: 10pt;">' +
                                            '<span style="font-weight: bold;">Posts</span><br/>' +
                                            '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.post[0].post) + '</span>' +
                                            '</div>' +
                                            '<div class="col s2" style="text-align: center;font-size: 10pt;">' +
                                            '<span style="font-weight: bold;">Friends</span><br/>' +
                                            '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.person.user_friends) + '</span>' +
                                            '</div>' +
                                            '</div>' +

                                            '</div>' +
                                            '<div id="profile-tab-tweet" class="card-content">' +
                                            '<span class="card-title">Post, Like, Comment, & Share</span>' +
                                            '<div id="profile-bar-chart-facebook">' +
                                            '</div>' +
                                            '</div>' +
                                            '<div id="profile-tab-toptweet" class="card-content">' +
                                            '<span class="card-title">Top 5 Post</span>' +
                                            '<div id="profile-top-tweet">' +
                                            topPost +
                                            '</div>' +
                                            '</div>' +
                                            '<div id="profile-tab-activetime" class="card-content">' +
                                            '<span class="card-title">Active Time</span>' +
                                            '<div id="profile-active-time-facebook">' +
                                            '</div>' +
                                            '</div>' +
                                            '</div>';

                                        container.html(profileCard);
                                        $('ul.tabs').tabs();

                                        // BAR CHART
                                        Highcharts.chart('profile-bar-chart-facebook', {
                                            chart: {
                                                type: 'column'
                                            },
                                            title: {
                                                text: ''
                                            },
                                            xAxis: {
                                              title: {
                                                  text: 'Last 7 Days'
                                              }
                                            },
                                            yAxis: {
                                                min: 0,
                                                title: {
                                                    text: 'Count'
                                                }
                                            },
                                            tooltip: {
                                                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                                                footerFormat: '</table>',
                                                shared: true,
                                                useHTML: true
                                            },
                                            plotOptions: {
                                                column: {
                                                    pointPadding: 0.2,
                                                    borderWidth: 0
                                                }
                                            },
                                            credits: {
                                                enabled: false
                                            },
                                            series: [{
                                                name: 'Post',
                                                color: '#871145',
                                                data: data.response.fbPost.data.post
                                            }, {
                                                name: 'Like',
                                                color: '#F49227',
                                                data: data.response.fbPost.data.like
                                            }, {
                                                name: 'Comment',
                                                color: '#7DE2B0',
                                                data: data.response.fbPost.data.comment
                                            }, {
                                                name: 'Share',
                                                color: '#8b9dc3',
                                                data: data.response.fbPost.data.share

                                            }

                                          ]
                                        });

                                        // HEATMAP ACTIVE TIME CHART
                                        Highcharts.chart('profile-active-time-facebook', {
                                            chart: {
                                                type: 'heatmap',
                                                marginTop: 40,
                                                marginBottom: 80,
                                                height: 500
                                            },
                                            title: {
                                                text: ''
                                            },
                                            xAxis: {
                                                categories: data.response.postTime.xAxis
                                            },
                                            yAxis: {
                                                categories: data.response.postTime.yAxis,
                                                title: null
                                            },
                                            colorAxis: {
                                                min: 0,
                                                minColor: '#E5E5E5',
                                                //maxColor: '#871145'
                                                maxColor: Highcharts.getOptions().colors[0]
                                            },
                                            legend: {
                                                align: 'right',
                                                layout: 'vertical',
                                                margin: 0,
                                                verticalAlign: 'top',
                                                y: 25,
                                                symbolHeight: 380
                                            },
                                            tooltip: {
                                                formatter: function () {
                                                    if (this.point.value === 0) {
                                                        return '<b>' + data.response.person.user_fullname + '</b> didnt post <br> on <br><b>' + this.series.xAxis.categories[this.point.x] + ' at ' + this.series.yAxis.categories[this.point.y] + '</b>';
                                                    } else {
                                                        return '<b>' + data.response.person.user_fullname + '</b> post <br><b>' +
                                                            this.point.value + '</b> times on <br><b>' + this.series.xAxis.categories[this.point.x] + ' ' + this.series.yAxis.categories[this.point.y] + '</b>';
                                                    }
                                                }
                                            },
                                            credits: {
                                                enabled: false
                                            },
                                            series: [{
                                                name: 'Active Time',
                                                data: data.response.postTime.data,
                                                borderWidth: 2,
                                                borderColor: '#FFFFFF'
                                            }]

                                        });
                                    },
                                    error: function () {
                                        container.html(
                                            '<div class="card red darken-1" style="margin-top: 0px;">' +
                                            '<div class="card-content white-text">' +
                                            '<p><i class="fas fa-book"></i> Im sorry, magician might be sick. Trying to recover..</p>' +
                                            '</div>' +
                                            '</div>'
                                        );
                                    }
                                });
                                    break;
                            default:
                                break;
                        }
                    } else {
                        container.html(
                            '<div class="card yellow darken-3" style="margin-top: 0px;">' +
                            '<div class="card-content white-text">' +
                            '<p><i class="fas fa-book"></i> You are not engaged to any social media. Try to engage one..</p>' +
                            '</div>' +
                            '</div>'
                        );
                    }

                    oldState = newState;
                }
            });

            $('#social-media').trigger('change');
        });
    </script>
@endsection
