@extends('layouts.main')

@section('content')
  <section>
    <div class="row">
      <div class="col s12 m12">
        <div class="card-panel background-none z-depth-0">
          <h5 class="black-text" style="font-weight:200">Profil Akun Twitter</h5>
          <hr>
          <div id="search-result">

          </div>
        </div>
      </div>
      <div class="col s12 m12">
        <div class="card-panel  background-none z-depth-0" style="padding-top:0px!important">
          <h5 class="black-text" style="font-weight:200">Laporan Aktivitas</h5>
          <hr>
          <div class="row">
            <div class="col s12 m12">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">Rekomendasi<i class="fas fa-lightbulb right"></i></h5>
                <hr>
                <div class="row">
                  <div class="col m8 offset-m4">
                    <span style="display:{{$recommended1}}"><i class="fas fa-lightbulb"></i> Posting tweet hari ini</span><br>
                    <span><i class="fas fa-lightbulb"></i> Sebaiknya hari ini anda post 2 tweet lagi</span><br>
                    <span><i class="fas fa-lightbulb"></i> Menanggapi mention masuk kepada anda</span><br>
                    <span><i class="fas fa-lightbulb"></i> Menanggapi tren topik hari ini</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col s12 m3">
              <div class="card">
                <div class="card-content" style="background-color:#27c24c">
                  <h5 class="white-text activator card-title" style="font-size:14px;font-weight:200">Rata - Rata Followers<i class="fas fa-users right"></i></h5>
                  <hr>
                  <center class="activator"><span style="font-size:30px;color:white;">{{$avgFollowers}}
                  </span><span style="font-size:10px;color:white;">followers/hari</span></center>

                </div>
                <div class="card-reveal">
                  <h5 class="black-text card-title" style="font-size:14px;font-weight:200">Kompetitor<i class="fas fa-users right"></i></h5>
                  <hr>
                  @if($avgFollowersComp != "null")
                    <center class="activator"><span style="font-size:30px;color:#F49227;">{{$avgFollowersComp}}
                    </span><span style="font-size:10px;color:#F49227;">followers/hari</span></center>
                  @else
                    <center class="activator"><span style="font-size:14px;color:#F49227;">Kompetitor tidak ditemukan
                    </span></center>
                  @endif
                </div>
              </div>
            </div>
            <div class="col s12 m3">
              <div class="card">
                <div class="card-content" style="background-color:#23b7e5">
                  <h5 class="white-text activator card-title" style="font-size:14px;font-weight:200">Rata - Rata Posting<i class="fab fa-twitter right"></i></i></h5>
                  <hr>
                  <center class="activator"><span style="font-size:30px;color:white;">{{$avgPosts}}
                  </span><span style="font-size:10px;color:white;">tweet/hari</span></center>

                </div>
                <div class="card-reveal">
                  <h5 class="black-text card-title" style="font-size:14px;font-weight:200">Kompetitor<i class="fas fa-users right"></i></h5>
                  <hr>
                  @if($avgPostsComp != "null")
                    <center class="activator"><span style="font-size:30px;color:#F49227;">{{$avgPostsComp}}
                    </span><span style="font-size:10px;color:#F49227;">tweet/hari</span></center>
                  @else
                    <center class="activator"><span style="font-size:14px;color:#F49227;">Kompetitor tidak ditemukan
                    </span></center>
                  @endif
                </div>
              </div>
            </div>
            <div class="col s12 m3">
              <div class="card">
                <div class="card-content" style="background-color:#6254b2">
                  <h5 class="white-text activator card-title" style="font-size:14px;font-weight:200">Rata - Rata Retweet<i class="fas fa-retweet right"></i></h5>
                  <hr>
                  <center class="activator"><span style="font-size:30px;color:white;">{{$avgRetweets}}
                  </span><span style="font-size:10px;color:white;">retweet/hari</span></center>

                </div>
                <div class="card-reveal">
                  <h5 class="black-text card-title" style="font-size:14px;font-weight:200">Kompetitor<i class="fas fa-users right"></i></h5>
                  <hr>
                  @if($avgRetweetsComp != "null")
                    <center class="activator"><span style="font-size:30px;color:#F49227;">{{$avgRetweetsComp}}
                    </span><span style="font-size:10px;color:#F49227;">retweet/hari</span></center>
                  @else
                    <center class="activator"><span style="font-size:14px;color:#F49227;">Kompetitor tidak ditemukan
                    </span></center>
                  @endif
                </div>
              </div>
            </div>
            <div class="col s12 m3">
              <div class="card">
                <div class="card-content" style="background-color:#fad733">
                  <h5 class="white-text activator card-title" style="font-size:14px;font-weight:200">Rata - Rata Likes<i class="fas fa-heart right"></i></h5>
                  <hr>
                  <center class="activator"><span style="font-size:30px;color:white;">{{$avgLikes}}
                  </span><span style="font-size:10px;color:white;">likes/hari</span></center>

                </div>
                <div class="card-reveal">
                  <h5 class="black-text card-title" style="font-size:14px;font-weight:200">Kompetitor<i class="fas fa-users right"></i></h5>
                  <hr>
                  @if($avgLikesComp != "null")
                    <center class="activator"><span style="font-size:30px;color:#F49227;">{{$avgLikesComp}}
                    </span><span style="font-size:10px;color:#F49227;">likes/hari</span></center>
                  @else
                    <center class="activator"><span style="font-size:14px;color:#F49227;">Kompetitor tidak ditemukan
                    </span></center>
                  @endif
                </div>
              </div>
            </div>
            <div class="col s12 m12">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">Analisis Sentimen<i class="fas fa-comments right"></i></h5>
                <hr>
                <center><canvas id="chartSentiment"></canvas></center>
              </div>
            </div>
            {{-- <div class="col s12 m6">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">Analisis Sentimen Positif<i class="fas fa-comments right"></i></h5>
                <hr>
                <center style="top:20px"><span style="font-size:70px;color:#F49227;top:20px">70
                </span><span style="font-size:40px;color:#F49227;">%</span></center>
              </div>
            </div>
            <div class="col s12 m6">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">Analisis Sentimen Negatif<i class="fas fa-comments right"></i></h5>
                <hr>
                <center style="top:20px"><span style="font-size:70px;color:#F49227;top:20px">30
                </span><span style="font-size:40px;color:#F49227;">%</span></center>
              </div>
            </div> --}}
          </div>
        </div>
      </div>
      <div class="col s12 m12">
        <div class="card-panel background-none z-depth-0" style="padding-top:0px">
          <h5 class="black-text" style="font-weight:200">5 Tweet Terbaik Anda</h5>
          <hr>
          <div class="card-panel">
            <div class="row">
              <div class="col m2">
                <center><img src="{{$twitter_account_log->photo_url}}" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>
              </div>
              <div class="col m10">
                <span>{{$twitter_account_log->name}}</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">{{$twitter_account_log->screen_name}}</span><span style="color:grey">)</span>
                <blockquote><i class="fas fa-quote-left"></i> {{$topTweets[0]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
                <center><img class="responsive-img materialboxed" src="{{$topTweets[0]->tweet_media}}"></center>
                <br>

              </div>
              <div class="chip">
                Mendapatkan {{$topTweets[0]->retweet_count}} retweet
              </div>
            </div>
          </div>
          <div class="card-panel">
            <div class="row">
              <div class="col m2">
                <center><img src="{{$twitter_account_log->photo_url}}" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>
              </div>
              <div class="col m10">
                <span>{{$twitter_account_log->name}}</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">{{$twitter_account_log->screen_name}}</span><span style="color:grey">)</span>
                <blockquote><i class="fas fa-quote-left"></i> {{$topTweets[1]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
                <center><img class="responsive-img materialboxed" src="{{$topTweets[1]->tweet_media}}"></center>
                <br>

              </div>
              <div class="chip">
                Mendapatkan {{$topTweets[1]->retweet_count}} retweet
              </div>
            </div>
          </div>
          <div class="card-panel">
            <div class="row">
              <div class="col m2">
                <center><img src="{{$twitter_account_log->photo_url}}" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>
              </div>
              <div class="col m10">
                <span>{{$twitter_account_log->name}}</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">{{$twitter_account_log->screen_name}}</span><span style="color:grey">)</span>
                <blockquote><i class="fas fa-quote-left"></i> {{$topTweets[2]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
                <center><img class="responsive-img materialboxed" src="{{$topTweets[2]->tweet_media}}"></center>
                <br>

              </div>
              <div class="chip">
                Mendapatkan {{$topTweets[2]->retweet_count}} retweet
              </div>
            </div>
          </div>
          <div class="card-panel">
            <div class="row">
              <div class="col m2">
                <center><img src="{{$twitter_account_log->photo_url}}" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>
              </div>
              <div class="col m10">
                <span>{{$twitter_account_log->name}}</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">{{$twitter_account_log->screen_name}}</span><span style="color:grey">)</span>
                <blockquote><i class="fas fa-quote-left"></i> {{$topTweets[3]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
                <center><img class="responsive-img materialboxed" src="{{$topTweets[3]->tweet_media}}"></center>
                <br>

              </div>
              <div class="chip">
                Mendapatkan {{$topTweets[3]->retweet_count}} retweet
              </div>
            </div>
          </div>
          <div class="card-panel">
            <div class="row">
              <div class="col m2">
                <center><img src="{{$twitter_account_log->photo_url}}" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>
              </div>
              <div class="col m10">
                <span>{{$twitter_account_log->name}}</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">{{$twitter_account_log->screen_name}}</span><span style="color:grey">)</span>
                <blockquote><i class="fas fa-quote-left"></i> {{$topTweets[4]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
                <center><img class="responsive-img materialboxed" src="{{$topTweets[4]->tweet_media}}"></center>
                <br>

              </div>
              <div class="chip">
                Mendapatkan {{$topTweets[4]->retweet_count}} retweet
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @php

    @endphp
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
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0)), url('{{asset('images/bg4.jpg')}}');
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

  .responsive-img {
    max-height: 400px;
    border-radius: 5%;
  }

  </style>
@endsection

@section('custom-script')
  <script>

  $(document).ready(function(){
    $('.collapsible').collapsible();
    $('.materialboxed').materialbox();
    document.getElementById("header").innerHTML = "Dashboard";
  });

  $(document).ready(function () {

    var ctx = document.getElementById("chartSentiment");
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: [
          'Red',
          'Yellow',
          'Blue'
        ],
        datasets: [{
          data: [10, 20, 30]
        }],
        borderColor: [
          'rgba(0,23,153,1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
        ]
      }
    });
  });
  $( document ).ready(function() {
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
    var resultContainer = $('#search-result');
    resultContainer.hide();
    resultContainer.html(spinner);
    resultContainer.fadeIn(500);
    $.ajax({
      type: 'GET',
      url: '{{ url('/engage/account') }}',
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
          '<p><i class="fas fa-book"></i> Im sorry, magician might be sick. Trying to recover..</p>' +
          '</div>' +
          '</div>'
        );
        resultContainer.fadeIn(600);
      }
    });
  });

  </script>
@endsection
