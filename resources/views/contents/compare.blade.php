@extends('layouts.main')

@section('content')
  <section>
    <div id="compare-container">
      <div class="row">
        <div class="col s12 m12">
          <div class="card-panel  background-none z-depth-0">
            <h5 class="black-text">Profil Akun Twitter Kompetitor</h5>
            <hr>
            <div class="row">
              <div class="col s12">

                <div id="competitor-result">

                </div>

                <div id="comparison">
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div id="btn-back" class="fixed-action-btn" style="bottom: 50px; right: 50px;">
        <a href="{{url('compare')}}" class="btn-floating btn waves-effect waves-light red modal-trigger" style="font-size:30px"><i class="material-icons">arrow_back</i></a>
      </div>
    </section>
  @endsection

  @section('custom-style')
    <style>
    .tabs .indicator {
      background: color(#5F0F4E alpha(75%) blackness(20%));
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
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 1)), url('{{asset('images/bg4.jpg')}}');
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

    .background-none {
      background: none;
    }

    /* label focus color */
    .input-field input[type=text]:focus + label {
      color: #000;
    }
    /* label underline focus color */
    .input-field input[type=text]:focus {
      border-bottom: 1px solid #000;
      box-shadow: 0 1px 0 0 #000;
    }

    </style>
  @endsection

  @section('custom-script')
    <script>
    $(document).ready(function(){
      document.getElementById("header").innerHTML = "Detail Perbandingan Aktivitas";
      var id = "{{$competitor->twitter_id}}";
      console.log(id);
      var spinner =
      '<div class="card white">' +
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
      '</div>';
      var resultContainer = $('#competitor-result');
      resultContainer.hide();
      resultContainer.html(spinner);
      resultContainer.fadeIn(500);
      $.ajax({
        type: 'GET',
        url: '{{ url('/compare/showCompetitor')  . '/' }}' + id,
        data: '_token = {{ csrf_token() }}',
        success: function(data) {

          var banner = (data.response.banner_url !== null) ?
          'style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4)), url(\'' + data.response.banner_url + '\');height: 200px;width: 100%;background-size: cover;background-position: center;"' :
          'style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4)), url(\'{{ asset('images/default -background.jpg ') }}\');height: 200px;width: 100%;background-size: cover;background-position: center;"';
          var photo = (data.response.photo_url !== null) ?
          '<img src="' + data.response.photo_url + '" style="height: 64px;width: 64px;object-fit: cover;border: 2px solid white;position: absolute;border-radius: 50%;top: 70px;left: 24px;">' :
          '<img src="{{ asset('images/default -photo.png ') }}" style="height: 64px;width: 64px;object-fit: cover;border: 2px solid white;position: absolute;border-radius: 50%;top: 70px;left: 24px;">';
          var location = (data.response.location !== null) ?
          '<div class="divider" style="margin: 10px 0;"></div>' +
          '<span style="font-size: 10pt;margin: 10px 0;"><i class="fas fa-map-marker-alt"></i> &nbsp; ' + data.response.location + '</span>' :
          '';
          var since = (data.response.created !== null) ?
          '<div class="divider" style="margin: 10px 0;"></div>' +
          '<span style="font-size: 10pt;margin: 10px 0;"><i class="far fa-calendar-alt"></i> &nbsp; Terdaftar Sejak ' + formatDate(new Date(data.response.created)) + '</span>' :
          '';

          resultContainer.html(
            '<div class="card white card-profile">' +
            '<div class="card-image" ' + banner + '>' +
            photo +
            '<span class="card-title">' + data.response.name + '</span>' +
            '<span class="card-title" style="font-size: 9pt;top: 145px;">@' + data.response.screen_name + '</span>' +
            '</div>' +
            '<div class="card-content">' +
            '<blockquote style="font-size: 10pt; margin-top: 5px;"><i class="fas fa-quote-right fa-xs"></i> ' + data.response.description + ' <i class="fas fa-quote-left fa-xs"></i></blockquote>' +
            '<div class="divider" style="margin: 10px 0;"></div>' +
            '<div class="row" style="margin-bottom: 0px !important;">' +
            '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
            '<span style="font-weight: bold;">Tweet</span><br/>' +
            '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.statuses_count) + '</span>' +
            '</div>' +
            '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
            '<span style="font-weight: bold;">Followers</span><br/>' +
            '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.followers_count) + '</span>' +
            '</div>' +
            '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
            '<span style="font-weight: bold;">Following</span><br/>' +
            '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.friends_count) + '</span>' +
            '</div>' +
            '</div>' +
            location +
            since +
            '<div class="divider" style="margin: 10px 0;"></div>' +
            '</div>' +
            '</div>'
          );
        },
        error: function() {
          resultContainer.html(
            '<div class="card red darken-1">' +
            '<div class="card-content white-text">' +
            '<p><i class="fas fa-book"></i> Mohon maaf data sedang kami kumpulkan, silahkan coba kembali besok</p>' +
            '</div>' +
            '</div>'
          );
          resultContainer.fadeIn(600);
        }
      });
    });

    $(document).ready(function(){
      var id = "{{$competitor->twitter_id}}";
      var spinner =
      '<div class="card white">' +
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
      '</div>';
      var resultContainer = $('#comparison');
      resultContainer.hide();
      resultContainer.html(spinner);
      resultContainer.fadeIn(500);
      $.ajax({
        type: 'GET',
        url: '{{ url('/compare/showComparison')  . '/' }}' + id,
        data: '_token = {{ csrf_token() }}',
        success: function(data) {

          var likes = '?';
          if (parseFloat(data.likes) > parseFloat(data.likesComp)) {
            likes =   '<td style="color:green;font-weight:bold"><center>' + data.likes + '</center></td><td style="color:red;font-weight:bold"><center>' + data.likesComp + '</center></td>';
          } else if (parseFloat(data.likes) < parseFloat(data.likesComp)) {
            likes =  '<td style="color:red;font-weight:bold"><center>' + data.likes + '</center></td><td style="color:green;font-weight:bold"><center>' + data.likesComp + '</center></td>';
          } else {
            likes = '<td style="color:grey;font-weight:bold"><center>' + data.likes + '</center></td><td style="color:grey;font-weight:bold"><center>' + data.likesComp + '</center></td>';
          }

          var followers = '?';
          if (parseFloat(data.followers) > parseFloat(data.followersComp)) {
            followers =   '<td style="color:green;font-weight:bold"><center>' + data.followers + '</center></td><td style="color:red;font-weight:bold"><center>' + data.followersComp + '</center></td>';
          } else if (parseFloat(data.followers) < parseFloat(data.followersComp)) {
            followers =  '<td style="color:red;font-weight:bold"><center>' + data.followers + '</center></td><td style="color:green;font-weight:bold"><center>' + data.followersComp + '</center></td>';
          } else {
            followers = '<td style="color:grey;font-weight:bold"><center>' + data.followers + '</center></td><td style="color:grey;font-weight:bold"><center>' + data.followersComp + '</center></td>';
          }

          var tweets = '?';
          if (parseFloat(data.posts) > parseFloat(data.postsComp)) {
            tweets =   '<td style="color:green;font-weight:bold"><center>' + data.posts + '</center></td><td style="color:red;font-weight:bold"><center>' + data.postsComp + '</center></td>';
          } else if (parseFloat(data.posts) < parseFloat(data.postsComp)) {
            tweets =  '<td style="color:red;font-weight:bold"><center>' + data.posts + '</center></td><td style="color:green;font-weight:bold"><center>' + data.postsComp + '</center></td>';
          } else {
            tweets = '<td style="color:grey;font-weight:bold"><center>' + data.posts + '</center></td><td style="color:grey;font-weight:bold"><center>' + data.postsComp + '</center></td>';
          }

          var retweets = '?';
          if (parseFloat(data.retweets) > parseFloat(data.retweetsComp)) {
            retweets =   '<td style="color:green;font-weight:bold"><center>' + data.retweets + '</center></td><td style="color:red;font-weight:bold"><center>' + data.retweetsComp + '</center></td>';
          } else if (parseFloat(data.retweets) < parseFloat(data.retweetsComp)) {
            retweets =  '<td style="color:red;font-weight:bold"><center>' + data.retweets + '</center></td><td style="color:green;font-weight:bold"><center>' + data.retweetsComp + '</center></td>';
          } else {
            retweets = '<td style="color:grey;font-weight:bold"><center>' + data.retweets + '</center></td><td style="color:grey;font-weight:bold"><center>' + data.retweetsComp + '</center></td>';
          }

          var replies = '?';
          if (parseFloat(data.replies) > parseFloat(data.repliesComp)) {
            replies =   '<td style="color:green;font-weight:bold"><center>' + data.replies + '</center></td><td style="color:red;font-weight:bold"><center>' + data.repliesComp + '</center></td>';
          } else if (parseFloat(data.replies) < parseFloat(data.repliesComp)) {
            replies =  '<td style="color:red;font-weight:bold"><center>' + data.replies + '</center></td><td style="color:green;font-weight:bold"><center>' + data.repliesComp + '</center></td>';
          } else {
            replies = '<td style="color:grey;font-weight:bold"><center>' + data.replies + '</center></td><td style="color:grey;font-weight:bold"><center>' + data.repliesComp + '</center></td>';
          }

          resultContainer.html(

            '<br><h5>Tabel Komparasi</h5><hr>' +
            '<div class="card-panel white background-none">' +
            '<table class="highlight">' +
            '<thead>' +
            '<tr>' +
            '<th></th>' +
            '<th style="font-weight:bold"><center>@' + data.accountData.screen_name + '<center></th>' +
            '<th style="font-weight:bold"><center>@' + data.accountDataComp.screen_name + '<center></th>' +
            '</tr>' +
            '</thead>' +

            '<tbody>' +
            '<tr>' +
            '<td><i class="fas fa-users"></i>&ensp;Peningkatan Followers</td>' +
            followers +
            '</tr>' +
            '<tr>' +
            '<td><i class="fab fa-twitter-square"></i>&ensp;&ensp;Posting Tweet</td>' +
            tweets +
            '</tr>' +
            '<tr>' +
            '<td><i class="fas fa-retweet"></i></i>&ensp;Total Retweet</td>' +
            retweets +
            '</tr>' +
            '<tr>' +
            '<td><i class="fas fa-heart"></i>&ensp;&ensp;Total Likes</td>' +
            likes +
            '</tr>' +
            '<tr>' +
            '<td><i class="fas fa-reply"></i>&ensp;&ensp;Total Replies</td>' +
            replies +
            '</tr>' +
            '</tbody>' +
            '</table>' +
            '</div>' +

            '<br><h5>Detail Grafik Komparasi</h5><hr>' +
            '<div class="card-panel white background-none">' +
            '<div class="row">' +
            '<div class="col s12 m6">' +
            '<div class="card-panel z-depth-0">' +
            '<h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Peningkatan Followers<i class="fas fa-users right"></i></h5>' +
            '<hr>' +
            '<canvas id="chartFollowers" width="200" height="200"></canvas>' +
            '</div>' +
            '</div>' +

            '<div class="col s12 m6">' +
            '<div class="card-panel z-depth-0">' +
            '<h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Posting Tweet<i class="fab fa-twitter-square right"></i></h5>' +
            '<hr>' +
            '<canvas id="chartPosting" width="200" height="200"></canvas>' +
            '</div>' +
            '</div>' +

            '<div class="col s12 m6">' +
            '<div class="card-panel z-depth-0">' +
            '<h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Retweet<i class="fas fa-retweet right"></i></h5>' +
            '<hr>' +
            '<canvas id="chartRetweet" width="200" height="200"></canvas>' +
            '</div>' +
            '</div>' +

            '<div class="col s12 m6">' +
            '<div class="card-panel z-depth-0">' +
            '<h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Likes<i class="fas fa-heart right"></i></h5>' +
            '<hr>' +
            '<canvas id="chartLikes" width="200" height="200"></canvas>' +
            '</div>' +
            '</div>' +

            '<div class="col s12 m6 offset-m3">' +
            '<div class="card-panel z-depth-0">' +
            '<h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Replies<i class="fas fa-reply right"></i></h5>' +
            '<hr>' +
            '<canvas id="chartReplies" width="200" height="200"></canvas>' +
            '</div>' +
            '</div>' +

            '</div>' +
            '</div>'
          );

          //Chart

          var followersDay0 = data.followersChart[0];
          var followersDay1 = data.followersChart[1];
          var followersDay2 = data.followersChart[2];
          var followersDay3 = data.followersChart[3];
          var followersDay4 = data.followersChart[4];
          var followersDay5 = data.followersChart[5];
          var followersDay6 = data.followersChart[6];
          var followersDay7 = data.followersChart[7];

          var followersDay0Comp = data.followersCompChart[0];
          var followersDay1Comp = data.followersCompChart[1];
          var followersDay2Comp = data.followersCompChart[2];
          var followersDay3Comp = data.followersCompChart[3];
          var followersDay4Comp = data.followersCompChart[4];
          var followersDay5Comp = data.followersCompChart[5];
          var followersDay6Comp = data.followersCompChart[6];
          var followersDay7Comp = data.followersCompChart[7];

          var postingDay0 = data.postingChart[0];
          var postingDay1 = data.postingChart[1];
          var postingDay2 = data.postingChart[2];
          var postingDay3 = data.postingChart[3];
          var postingDay4 = data.postingChart[4];
          var postingDay5 = data.postingChart[5];
          var postingDay6 = data.postingChart[6];
          var postingDay7 = data.postingChart[7];

          var postingDay0Comp = data.postingCompChart[0];
          var postingDay1Comp = data.postingCompChart[1];
          var postingDay2Comp = data.postingCompChart[2];
          var postingDay3Comp = data.postingCompChart[3];
          var postingDay4Comp = data.postingCompChart[4];
          var postingDay5Comp = data.postingCompChart[5];
          var postingDay6Comp = data.postingCompChart[6];
          var postingDay7Comp = data.postingCompChart[7];

          var retweetDay0 = data.retweetChart[0];
          var retweetDay1 = data.retweetChart[1];
          var retweetDay2 = data.retweetChart[2];
          var retweetDay3 = data.retweetChart[3];
          var retweetDay4 = data.retweetChart[4];
          var retweetDay5 = data.retweetChart[5];
          var retweetDay6 = data.retweetChart[6];
          var retweetDay7 = data.retweetChart[7];

          var retweetDay0Comp = data.retweetCompChart[0];
          var retweetDay1Comp = data.retweetCompChart[1];
          var retweetDay2Comp = data.retweetCompChart[2];
          var retweetDay3Comp = data.retweetCompChart[3];
          var retweetDay4Comp = data.retweetCompChart[4];
          var retweetDay5Comp = data.retweetCompChart[5];
          var retweetDay6Comp = data.retweetCompChart[6];
          var retweetDay7Comp = data.retweetCompChart[7];

          var likesDay0 = data.likesChart[0];
          var likesDay1 = data.likesChart[1];
          var likesDay2 = data.likesChart[2];
          var likesDay3 = data.likesChart[3];
          var likesDay4 = data.likesChart[4];
          var likesDay5 = data.likesChart[5];
          var likesDay6 = data.likesChart[6];
          var likesDay7 = data.likesChart[7];

          var likesDay0Comp = data.likesCompChart[0];
          var likesDay1Comp = data.likesCompChart[1];
          var likesDay2Comp = data.likesCompChart[2];
          var likesDay3Comp = data.likesCompChart[3];
          var likesDay4Comp = data.likesCompChart[4];
          var likesDay5Comp = data.likesCompChart[5];
          var likesDay6Comp = data.likesCompChart[6];
          var likesDay7Comp = data.likesCompChart[7];

          var repliesDay0 = data.repliesChart[0];
          var repliesDay1 = data.repliesChart[1];
          var repliesDay2 = data.repliesChart[2];
          var repliesDay3 = data.repliesChart[3];
          var repliesDay4 = data.repliesChart[4];
          var repliesDay5 = data.repliesChart[5];
          var repliesDay6 = data.repliesChart[6];
          var repliesDay7 = data.repliesChart[7];

          var repliesDay0Comp = data.repliesCompChart[0];
          var repliesDay1Comp = data.repliesCompChart[1];
          var repliesDay2Comp = data.repliesCompChart[2];
          var repliesDay3Comp = data.repliesCompChart[3];
          var repliesDay4Comp = data.repliesCompChart[4];
          var repliesDay5Comp = data.repliesCompChart[5];
          var repliesDay6Comp = data.repliesCompChart[6];
          var repliesDay7Comp = data.repliesCompChart[7];

          var ctx = document.getElementById("chartFollowers");
          var chartFollowers = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ["H - 7", "H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1", "H - 0"],
              datasets: [{
                fill:false,
                borderColor: 'rgba(0,23,153,0.5)',
                label: '@' + data.accountData.screen_name,
                data: [followersDay7, followersDay6,followersDay5,followersDay4,followersDay3,followersDay2,followersDay1,followersDay0],
                backgroundColor: [
                  'white'
                ],
                borderWidth: 4
              }, {
                fill:false,
                borderColor: 'rgba(255,0,0, 0.5)',
                label: '@' + data.accountDataComp.screen_name,
                data: [followersDay7Comp, followersDay6Comp,followersDay5Comp,followersDay4Comp,followersDay3Comp,followersDay2Comp,followersDay1Comp,followersDay0Comp],
                backgroundColor: [
                  'white'
                ],
                borderWidth: 4
              }
            ]
            },
            options: {
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero:true
                  }
                }]
              }
            }
          });

          var ctx = document.getElementById("chartPosting");
          var chartPosting = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ["H - 7", "H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1", "H - 0"],
              datasets: [{
                fill:false,
                borderColor: 'rgba(0,23,153,0.5)',
                label: '@' + data.accountData.screen_name,
                data: [postingDay7, postingDay6,postingDay5,postingDay4,postingDay3,postingDay2,postingDay1,postingDay0],
                backgroundColor: [
                  'white'
                ],
                borderWidth: 4
              }, {
                fill:false,
                borderColor: 'rgba(255,0,0, 0.5)',
                label: '@' + data.accountDataComp.screen_name,
                data: [postingDay7Comp, postingDay6Comp,postingDay5Comp,postingDay4Comp,postingDay3Comp,postingDay2Comp,postingDay1Comp,postingDay0Comp],
                backgroundColor: [
                  'white'
                ],
                borderWidth: 4
              }
            ]
            },
            options: {
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero:true
                  }
                }]
              }
            }
          });


          var ctx = document.getElementById("chartLikes");
          var chartLikes = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ["H - 7", "H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1", "H - 0"],
              datasets: [{
                fill:false,
                borderColor: 'rgba(0,23,153,0.5)',
                label: '@' + data.accountData.screen_name,
                data: [likesDay7, likesDay6,likesDay5,likesDay4,likesDay3,likesDay2,likesDay1,likesDay0],
                backgroundColor: [
                  'white'
                ],
                borderWidth: 4
              }, {
                fill:false,
                borderColor: 'rgba(255,0,0, 0.5)',
                label: '@' + data.accountDataComp.screen_name,
                data: [likesDay7Comp, likesDay6Comp,likesDay5Comp,likesDay4Comp,likesDay3Comp,likesDay2Comp,likesDay1Comp,likesDay0Comp],
                backgroundColor: [
                  'white'
                ],
                borderWidth: 4
              }
            ]
            },
            options: {
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero:true
                  }
                }]
              }
            }
          });

          var ctx = document.getElementById("chartRetweet");
          var chartRetweet = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ["H - 7", "H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1", "H - 0"],
              datasets: [{
                fill:false,
                borderColor: 'rgba(0,23,153,0.5)',
                label: '@' + data.accountData.screen_name,
                data: [retweetDay7, retweetDay6,retweetDay5,retweetDay4,retweetDay3,retweetDay2,retweetDay1,retweetDay0],
                backgroundColor: [
                  'white'
                ],
                borderWidth: 4
              }, {
                fill:false,
                borderColor: 'rgba(255,0,0, 0.5)',
                label: '@' + data.accountDataComp.screen_name,
                data: [retweetDay7Comp, retweetDay6Comp,retweetDay5Comp,retweetDay4Comp,retweetDay3Comp,retweetDay2Comp,retweetDay1Comp,retweetDay0Comp],
                backgroundColor: [
                  'white'
                ],
                borderWidth: 4
              }
            ]
            },
            options: {
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero:true
                  }
                }]
              }
            }
          });

          var ctx = document.getElementById("chartReplies");
          var chartReplies = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ["H - 7", "H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1", "H - 0"],
              datasets: [{
                fill:false,
                borderColor: 'rgba(0,23,153,0.5)',
                label: '@' + data.accountData.screen_name,
                data: [repliesDay7, repliesDay6,repliesDay5,repliesDay4,repliesDay3,repliesDay2,repliesDay1,repliesDay0],
                backgroundColor: [
                  'white'
                ],
                borderWidth: 4
              }, {
                fill:false,
                borderColor: 'rgba(255,0,0, 0.5)',
                label: '@' + data.accountDataComp.screen_name,
                data: [repliesDay7Comp, repliesDay6Comp,repliesDay5Comp,repliesDay4Comp,repliesDay3Comp,repliesDay2Comp,repliesDay1Comp,repliesDay0Comp],
                backgroundColor: [
                  'white'
                ],
                borderWidth: 4
              }
            ]
            },
            options: {
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero:true
                  }
                }]
              }
            }
          });
          //end Chart


        },
        error: function() {
          resultContainer.html(
            '<div class="card red darken-1">' +
            '<div class="card-content white-text">' +
            '<p><i class="fas fa-book"></i>  Mohon maaf data sedang kami kumpulkan, silahkan coba kembali besok</p>' +
            '</div>' +
            '</div>'
          );
          resultContainer.fadeIn(600);
        }

      });
    });

  </script>
@endsection
