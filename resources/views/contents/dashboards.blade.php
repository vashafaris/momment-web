@extends('layouts.main')

@section('content')
  <section>
    <div class="row">
      <div class="col s12 m12">
        <div class="card-panel ">
          <h5 class="center white-text">Akun Twitter</h5>
          <hr>
          <div id="search-result">

          </div>
        </div>
      </div>
      <div class="col s12 m12">
        <div class="card-panel  ">
          <h5 class="center white-text">Laporan Aktivitas</h5>
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
              {{-- <div class="card-panel">
              <h5 class="black-text" style="font-size:14px;font-weight:200">Rata - Rata Followers<i class="fas fa-users right"></i></h5>
              <hr>
              <center><span style="font-size:30px;color:#5F0F4E;">{{$avgFollowers}}
            </span><span style="font-size:10px;color:#5F0F4E;">followers/hari</span></center>
            <span></span>
          </div> --}}

          <div class="card">
            <div class="card-content">
              {{-- <span class="card-title activator grey-text text-darken-4">Card Title<i class="material-icons right">more_vert</i></span> --}}
              <h5 class="black-text activator card-title" style="font-size:14px;font-weight:200">Rata - Rata Followers<i class="fas fa-users right"></i></h5>
              <hr>
              <center class="activator"><span style="font-size:30px;color:#F49227;">{{$avgFollowers}}
              </span><span style="font-size:10px;color:#F49227;">followers/hari</span></center>

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
          {{-- <div class="card-panel">
          <h5 class="black-text" style="font-size:14px;font-weight:200">Rata - Rata Posting<i class="fab fa-twitter right"></i></h5>
          <hr>
          <center><span style="font-size:30px;color:#5F0F4E;">{{$avgPosts}}
        </span><span style="font-size:10px;color:#5F0F4E;">tweet/hari</span></center>
      </div> --}}
      <div class="card">
        <div class="card-content">
          {{-- <span class="card-title activator grey-text text-darken-4">Card Title<i class="material-icons right">more_vert</i></span> --}}
          <h5 class="black-text activator card-title" style="font-size:14px;font-weight:200">Rata - Rata Posting<i class="fab fa-twitter right"></i></i></h5>
          <hr>
          <center class="activator"><span style="font-size:30px;color:#F49227;">{{$avgPosts}}
          </span><span style="font-size:10px;color:#F49227;">tweet/hari</span></center>

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
      {{-- <div class="card-panel">
      <h5 class="black-text" style="font-size:14px;font-weight:200">Rata - Rata Retweet<i class="fas fa-retweet right"></i></h5>
      <hr>
      <center><span style="font-size:30px;color:#5F0F4E;">{{$avgRetweets}}
    </span><span style="font-size:10px;color:#5F0F4E;">retweet/hari</span></center>
  </div> --}}
  <div class="card">
    <div class="card-content">
      {{-- <span class="card-title activator grey-text text-darken-4">Card Title<i class="material-icons right">more_vert</i></span> --}}
      <h5 class="black-text activator card-title" style="font-size:14px;font-weight:200">Rata - Rata Retweet<i class="fas fa-retweet right"></i></h5>
      <hr>
      <center class="activator"><span style="font-size:30px;color:#F49227;">{{$avgRetweets}}
      </span><span style="font-size:10px;color:#F49227;">retweet/hari</span></center>

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
  {{-- <div class="card-panel">
  <h5 class="black-text" style="font-size:14px;font-weight:200">Rata - Rata Likes<i class="fas fa-heart right"></i></h5>
  <hr>
  <center><span style="font-size:30px;color:#F49227;">{{$avgLikes}}
</span><span style="font-size:10px;color:#F49227;">like/hari</span></center>
</div> --}}
<div class="card">
  <div class="card-content">
    {{-- <span class="card-title activator grey-text text-darken-4">Card Title<i class="material-icons right">more_vert</i></span> --}}
    <h5 class="black-text activator card-title" style="font-size:14px;font-weight:200">Rata - Rata Likes<i class="fas fa-heart right"></i></h5>
    <hr>
    <center class="activator"><span style="font-size:30px;color:#F49227;">{{$avgLikes}}
    </span><span style="font-size:10px;color:#F49227;">likes/hari</span></center>

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
<div class="col s12 m6">
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
</div>
<div class="col s12 m12">
  <div class="card-panel z-depth-0">
    <h5 class="black-text" style="font-size:16px;font-weight:200">5 Tweet mendapatkan retweet terbanyak<i class="material-icons right">face</i></h5>
    <hr>
    <div class="card-panel">
      {{-- <img src="{{$photo_url}}" style="position:absolute;height: 50px;width: 50px;object-fit: cover;border: 2px solid white;border-radius: 50%;">
      <span style="left:20%"> </span> --}}
      <blockquote><i class="fas fa-quote-left"></i> {{$topTweets[0]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
      <div class="chip">
        Mendapatkan {{$topTweets[0]->retweet_count}} retweet
      </div>
    </div>
    <div class="card-panel">
      <blockquote><i class="fas fa-quote-left"></i> {{$topTweets[1]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
      <div class="chip">
        Mendapatkan {{$topTweets[1]->retweet_count}} retweet
      </div>
    </div>
    <div class="card-panel">
      <blockquote><i class="fas fa-quote-left"></i> {{$topTweets[2]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
      <div class="chip">
        Mendapatkan {{$topTweets[2]->retweet_count}} retweet
      </div>
    </div>
    <div class="card-panel">
      <blockquote><i class="fas fa-quote-left"></i> {{$topTweets[3]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
      <div class="chip">
        Mendapatkan {{$topTweets[3]->retweet_count}} retweet
      </div>
    </div>
    <div class="card-panel">
      <blockquote><i class="fas fa-quote-left"></i> {{$topTweets[4]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
      <div class="chip">
        Mendapatkan {{$topTweets[4]->retweet_count}} retweet
      </div>
    </div>
  </div>
</div>
{{-- <div class="col s12 m6">
<div class="card-panel">
<h5 class="black-text" style="font-size:16px;font-weight:200">5 Tweet mendapatkan likes terbanyak<i class="material-icons right">face</i></h5>
<hr>
<div class="card-panel">
<blockquote><i class="fas fa-quote-left"></i> {{$topLikes[0]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
<div class="chip">
Mendapatkan {{$topLikes[0]->favorite_count}} like
</div>
</div>
<div class="card-panel">
<blockquote><i class="fas fa-quote-left"></i> {{$topLikes[1]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
<div class="chip">
Mendapatkan {{$topLikes[1]->favorite_count}} like
</div>
</div>
<div class="card-panel">
<blockquote><i class="fas fa-quote-left"></i> {{$topLikes[2]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
<div class="chip">
Mendapatkan {{$topLikes[2]->favorite_count}} like
</div>
</div>
<div class="card-panel">
<blockquote><i class="fas fa-quote-left"></i> {{$topLikes[3]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
<div class="chip">
Mendapatkan {{$topLikes[3]->favorite_count}} like
</div>
</div>
<div class="card-panel">
<blockquote><i class="fas fa-quote-left"></i> {{$topLikes[4]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
<div class="chip">
Mendapatkan {{$topLikes[4]->favorite_count}} like
</div>
</div>
</div>
</div> --}}

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

  </style>
@endsection

@section('custom-script')
  <script>

  $(document).ready(function(){
    $('.collapsible').collapsible();
  });

  $(document).ready(function () {

    var postingDay0 = {{$postingDay0[0]->count}};
    var postingDay1 = {{$postingDay1[0]->count}};
    var postingDay2 = {{$postingDay2[0]->count}};
    var postingDay3 = {{$postingDay3[0]->count}};
    var postingDay4 = {{$postingDay4[0]->count}};
    var postingDay5 = {{$postingDay5[0]->count}};
    var postingDay6 = {{$postingDay6[0]->count}};

    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1"],
        datasets: [{
          label: '= Tweet Posted',
          data: [postingDay0,postingDay1,postingDay2,postingDay3,postingDay4,postingDay5,postingDay6],
          backgroundColor: [
            'rgba(0,255,255, 0.2)'
          ],
          borderColor: [
            'rgba(0,192,255,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
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

    var ctx2 = document.getElementById("myChart2");
    var myChart = new Chart(ctx2, {
      type: 'line',
      data: {
        labels: ["H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1"],
        datasets: [{
          label: '= Grafik Retweet',
          data: [4200, 700, 2530, 3203, 1529, 2832],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)'
          ],
          borderColor: [
            'rgba(255,99,132,1)'
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

    var ctx3 = document.getElementById("myChart3");
    var myChart = new Chart(ctx3, {
      type: 'line',
      data: {
        labels: ["H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1"],
        datasets: [{
          label: '= Grafik Likes',
          data: [4200, 700, 2530, 3203, 1529, 2832],
          backgroundColor: [
            'rgba(255, 255, 0, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
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
