@extends('layouts.main')

@section('content')
  <section>
    <div id="compare-container">
      <div class="row">
        <div class="col s12 m12">
          <div class="card-panel ">
            <h5 class="center black-text">Akun Twitter Kompetitor</h5>
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
      var id = {{$competitor->twitter_id}}
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

          var banner = (data.response[0].banner_url !== null) ?
          'style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4)), url(\'' + data.response[0].banner_url + '\');height: 200px;width: 100%;background-size: cover;background-position: center;"' :
          'style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4)), url(\'{{ asset('images/default -background.jpg ') }}\');height: 200px;width: 100%;background-size: cover;background-position: center;"';
          var photo = (data.response[0].photo_url !== null) ?
          '<img src="' + data.response[0].photo_url + '" style="height: 64px;width: 64px;object-fit: cover;border: 2px solid white;position: absolute;border-radius: 50%;top: 70px;left: 24px;">' :
          '<img src="{{ asset('images/default -photo.png ') }}" style="height: 64px;width: 64px;object-fit: cover;border: 2px solid white;position: absolute;border-radius: 50%;top: 70px;left: 24px;">';
          var location = (data.response[0].location !== null) ?
          '<div class="divider" style="margin: 10px 0;"></div>' +
          '<span style="font-size: 10pt;margin: 10px 0;"><i class="fas fa-map-marker-alt"></i> &nbsp; ' + data.response[0].location + '</span>' :
          '';
          var since = (data.response[0].created !== null) ?
          '<div class="divider" style="margin: 10px 0;"></div>' +
          '<span style="font-size: 10pt;margin: 10px 0;"><i class="far fa-calendar-alt"></i> &nbsp; Terdaftar Sejak ' + formatDate(new Date(data.response[0].created)) + '</span>' :
          '';

          resultContainer.html(
            '<div class="card white card-profile">' +
            '<div class="card-image" ' + banner + '>' +
            photo +
            '<span class="card-title">' + data.response[0].name + '</span>' +
            '<span class="card-title" style="font-size: 9pt;top: 145px;">@' + data.response[0].screen_name + '</span>' +
            '</div>' +
            '<div class="card-content">' +
            '<blockquote style="font-size: 10pt; margin-top: 5px;"><i class="fas fa-quote-right fa-xs"></i> ' + data.response[0].description + ' <i class="fas fa-quote-left fa-xs"></i></blockquote>' +
            '<div class="divider" style="margin: 10px 0;"></div>' +
            '<div class="row" style="margin-bottom: 0px !important;">' +
            '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
            '<span style="font-weight: bold;">Tweet</span><br/>' +
            '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response[0].statuses_count) + '</span>' +
            '</div>' +
            '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
            '<span style="font-weight: bold;">Followers</span><br/>' +
            '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response[0].followers_count) + '</span>' +
            '</div>' +
            '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
            '<span style="font-weight: bold;">Following</span><br/>' +
            '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response[0].friends_count) + '</span>' +
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
      var id = {{$competitor->twitter_id}}
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

          resultContainer.html(
            '<div class="card-panel white background-none">' +
            '<br><hr><h4><center>Tabel Komparasi</center></h4><hr><br>' +
            '<table class="highlight">' +
            '<thead>' +
            '<tr>' +
            '<th></th>' +
            '<th style="font-weight:bold"><center>@' + data.accountData[0].screen_name + '<center></th>' +
            '<th style="font-weight:bold"><center>@' + data.accountDataComp[0].screen_name + '<center></th>' +
            '</tr>' +
            '</thead>' +

            '<tbody>' +
            '<tr>' +
            '<td>Peningkatan Followers</td>' +
            followers +
            '</tr>' +
            '<tr>' +
            '<td>Posting Tweet</td>' +
            tweets +
            '</tr>' +
            '<tr>' +
            '<td>Total Retweet</td>' +
            retweets +
            '</tr>' +
            '<tr>' +
            '<td>Total Likes</td>' +
            likes +
            '</tr>' +
            '</tbody>' +
            '</table>' +
            '<br><hr><h4><center>Detail Komparasi</center></h4><hr><br>' +
            '<div class="row">' +
            '<div class="col s12 m6 vertical-divider">' +
            '<h6 style="font-weight:bold"><center>@' + data.accountData[0].screen_name + '</center></h6>' +
            '</div>' +

            '<div class="col s12 m6">' +
            '<h6 style="font-weight:bold"><center>@' + data.accountDataComp[0].screen_name + '</center></h6>' +
            '</div>' +

            '<div class="col s12 m6 vertical-divider">' +
            '<div class="card-panel">' +
            '<h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Peningkatan Followers<i class="fab fa-twitter right"></i></h5>' +
            '<hr>' +
            '<canvas id="followersChart" width="200" height="200"></canvas>' +
            '</div>' +
            '</div>' +

            '<div class="col s12 m6">' +
            '<div class="card-panel">' +
            '<h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Peningkatan Followers<i class="fab fa-twitter right"></i></h5>' +
            '<hr>' +
            '<canvas id="followersChartComp" width="200" height="200"></canvas>' +
            '</div>' +
            '</div>' +

            '<div class="col s12 m6 vertical-divider">' +
            '<div class="card-panel">' +
            '<h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Posting<i class="fab fa-twitter right"></i></h5>' +
            '<hr>' +
            '<canvas id="postingChart" width="200" height="200"></canvas>' +
            '</div>' +
            '</div>' +

            '<div class="col s12 m6">' +
            '<div class="card-panel">' +
            '<h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Posting<i class="fab fa-twitter right"></i></h5>' +
            '<hr>' +
            '<canvas id="postingCompChart" width="200" height="200"></canvas>' +
            '</div>' +
            '</div>' +

            '<div class="col s12 m6 vertical-divider">' +
            '<div class="card-panel">' +
            '<h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Retweet<i class="fab fa-twitter right"></i></h5>' +
            '<hr>' +
            '<canvas id="retweetChart" width="200" height="200"></canvas>' +
            '</div>' +
            '</div>' +

            '<div class="col s12 m6">' +
            '<div class="card-panel">' +
            '<h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Retweet<i class="fab fa-twitter right"></i></h5>' +
            '<hr>' +
            '<canvas id="retweetChartComp" width="200" height="200"></canvas>' +
            '</div>' +
            '</div>' +

            '<div class="col s12 m6 vertical-divider">' +
            '<div class="card-panel">' +
            '<h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Likes<i class="fab fa-twitter right"></i></h5>' +
            '<hr>' +
            '<canvas id="likesChart" width="200" height="200"></canvas>' +
            '</div>' +
            '</div>' +

            '<div class="col s12 m6">' +
            '<div class="card-panel">' +
            '<h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Likes<i class="fab fa-twitter right"></i></h5>' +
            '<hr>' +
            '<canvas id="likesChartComp" width="200" height="200"></canvas>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
          );

          //Chart

          var followersDay0 = data.followersDay0;
          var followersDay1 = data.followersDay1;
          var followersDay2 = data.followersDay2;
          var followersDay3 = data.followersDay3;
          var followersDay4 = data.followersDay4;
          var followersDay5 = data.followersDay5;
          var followersDay6 = data.followersDay6;
          var followersDay7 = data.followersDay7;

          var ctx = document.getElementById("followersChart");
          var followersChart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ["H - 7", "H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1", "H - 0"],
              datasets: [{
                label: '= Jumlah Peningkatan Followers',
                data: [followersDay7, followersDay6,followersDay5,followersDay4,followersDay3,followersDay2,followersDay1,followersDay0],
                backgroundColor: [
                  'rgba(0,23,153, 0.2)'
                ],
                borderWidth: 1
              }]
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

          var followersDay0Comp = data.followersDay0Comp;
          var followersDay1Comp = data.followersDay1Comp;
          var followersDay2Comp = data.followersDay2Comp;
          var followersDay3Comp = data.followersDay3Comp;
          var followersDay4Comp = data.followersDay4Comp;
          var followersDay5Comp = data.followersDay5Comp;
          var followersDay6Comp = data.followersDay6Comp;
          var followersDay7Comp = data.followersDay7Comp;

          var ctx = document.getElementById("followersChartComp");
          var followersChartComp = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ["H - 7", "H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1", "H - 0"],
              datasets: [{
                label: '= Jumlah Peningkatan Followers',
                data: [followersDay7Comp, followersDay6Comp,followersDay5Comp,followersDay4Comp,followersDay3Comp,followersDay2Comp,followersDay1Comp,followersDay0Comp],
                backgroundColor: [
                  'rgba(0,23,153,0.2)'
                ],
                borderWidth: 1
              }]
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

          var postingDay0 = data.postingDay0;
          var postingDay1 = data.postingDay1;
          var postingDay2 = data.postingDay2;
          var postingDay3 = data.postingDay3;
          var postingDay4 = data.postingDay4;
          var postingDay5 = data.postingDay5;
          var postingDay6 = data.postingDay6;
          var postingDay7 = data.postingDay7;

          var ctx = document.getElementById("postingChart");
          var postingChart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ["H - 7", "H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1", "H - 0"],
              datasets: [{
                label: '= Jumlah Tweet',
                data: [postingDay7, postingDay6,postingDay5,postingDay4,postingDay3,postingDay2,postingDay1,postingDay0],
                backgroundColor: [
                  'rgba(0,255,255, 0.2)'
                ],
                borderWidth: 1
              }]
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

          var postingDay0Comp = data.postingDay0Comp;
          var postingDay1Comp = data.postingDay1Comp;
          var postingDay2Comp = data.postingDay2Comp;
          var postingDay3Comp = data.postingDay3Comp;
          var postingDay4Comp = data.postingDay4Comp;
          var postingDay5Comp = data.postingDay5Comp;
          var postingDay6Comp = data.postingDay6Comp;
          var postingDay7Comp = data.postingDay7Comp;

          var ctx = document.getElementById("postingCompChart");
          var postingCompChart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ["H - 7", "H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1", "H - 0"],
              datasets: [{
                label: '= Jumlah Tweet',
                data: [postingDay7Comp, postingDay6Comp,postingDay5Comp,postingDay4Comp,postingDay3Comp,postingDay2Comp,postingDay1Comp,postingDay0Comp],
                backgroundColor: [
                  'rgba(0,255,255, 0.2)'
                ],
                borderWidth: 1
              }]
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

          var retweetDay0 = data.retweetDay0;
          var retweetDay1 = data.retweetDay1;
          var retweetDay2 = data.retweetDay2;
          var retweetDay3 = data.retweetDay3;
          var retweetDay4 = data.retweetDay4;
          var retweetDay5 = data.retweetDay5;
          var retweetDay6 = data.retweetDay6;
          var retweetDay7 = data.retweetDay7;

          var ctx = document.getElementById("retweetChart");
          var retweetChart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ["H - 7", "H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1", "H - 0"],
              datasets: [{
                label: '= Jumlah Retweet',
                data: [retweetDay7, retweetDay6,retweetDay5,retweetDay4,retweetDay3,retweetDay2,retweetDay1,retweetDay0],
                backgroundColor: [
                  'rgba(255,0,0, 0.2)'
                ],
                borderWidth: 1
              }]
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

          var retweetDay0Comp = data.retweetDay0Comp;
          var retweetDay1Comp = data.retweetDay1Comp;
          var retweetDay2Comp = data.retweetDay2Comp;
          var retweetDay3Comp = data.retweetDay3Comp;
          var retweetDay4Comp = data.retweetDay4Comp;
          var retweetDay5Comp = data.retweetDay5Comp;
          var retweetDay6Comp = data.retweetDay6Comp;
          var retweetDay7Comp = data.retweetDay7Comp;

          var ctx = document.getElementById("retweetChartComp");
          var retweetChartComp = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ["H - 7", "H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1", "H - 0"],
              datasets: [{
                label: '= Jumlah Retweet',
                data: [retweetDay7Comp, retweetDay6Comp,retweetDay5Comp,retweetDay4Comp,retweetDay3Comp,retweetDay2Comp,retweetDay1Comp,retweetDay0Comp],
                backgroundColor: [
                  'rgba(255,0,0, 0.2)'
                ],
                borderWidth: 1
              }]
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

          var likesDay0 = data.likesDay0;
          var likesDay1 = data.likesDay1;
          var likesDay2 = data.likesDay2;
          var likesDay3 = data.likesDay3;
          var likesDay4 = data.likesDay4;
          var likesDay5 = data.likesDay5;
          var likesDay6 = data.likesDay6;
          var likesDay7 = data.likesDay7;

          var ctx = document.getElementById("likesChart");
          var likesChart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ["H - 7","H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1", "H - 0"],
              datasets: [{
                label: '= Jumlah Likes',
                data: [likesDay7,likesDay6,likesDay5,likesDay4,likesDay3,likesDay2,likesDay1,likesDay0],
                backgroundColor: [
                  'rgba(255,255,0, 0.2)'
                ],
                borderWidth: 1
              }]
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

          var likesDay0Comp = data.likesDay0Comp;
          var likesDay1Comp = data.likesDay1Comp;
          var likesDay2Comp = data.likesDay2Comp;
          var likesDay3Comp = data.likesDay3Comp;
          var likesDay4Comp = data.likesDay4Comp;
          var likesDay5Comp = data.likesDay5Comp;
          var likesDay6Comp = data.likesDay6Comp;
          var likesDay7Comp = data.likesDay7Comp;

          var ctx = document.getElementById("likesChartComp");
          var likesChartComp = new Chart(ctx, {
            type: 'line',
            data: {
              labels: ["H - 7", "H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1", "H - 0"],
              datasets: [{
                label: '= Jumlah Likes',
                data: [likesDay7Comp,likesDay6Comp,likesDay5Comp,likesDay4Comp,likesDay3Comp,likesDay2Comp,likesDay1Comp,likesDay0Comp],
                backgroundColor: [
                  'rgba(255,255,0, 0.2)'
                ],
                borderWidth: 1
              }]
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
