@extends('layouts.main')

@section('content')
  <section>
    <div class="row">
      <div class="col s12 m12">
        <div class="card-panel " style="background-color:white">
          <h5 class="center black-text">Laporan Aktivitas</h5>
          <hr>
          <div class="row">
            <div class="col s12 m12">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">Rekomendasi<i class="fas fa-lightbulb right"></i></h5>
                <hr>
                <div class="row">
                  <div class="col m8 offset-m4">
                      <span><i class="fas fa-lightbulb"></i> Posting tweet hari ini</span><br>
                      <span><i class="fas fa-lightbulb"></i> Sebaiknya hari ini anda post 2 tweet lagi</span><br>
                      <span><i class="fas fa-lightbulb"></i> Balas mention masuk kepada anda</span><br>
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
                  <center class="activator"><span style="font-size:30px;color:#5F0F4E;">{{$avgFollowers}}
                  </span><span style="font-size:10px;color:#5F0F4E;">followers/hari</span></center>

                </div>
                <div class="card-reveal">
                  <h5 class="black-text card-title" style="font-size:14px;font-weight:200">Kompetitor<i class="fas fa-users right"></i></h5>
                  <hr>
                  <center class="activator"><span style="font-size:30px;color:#5F0F4E;">{{$avgFollowers}}
                  </span><span style="font-size:10px;color:#5F0F4E;">followers/hari</span></center>
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
                  <h5 class="black-text activator card-title" style="font-size:14px;font-weight:200">Rata - Rata Posting<i class="fas fa-users right"></i></h5>
                  <hr>
                  <center class="activator"><span style="font-size:30px;color:#5F0F4E;">{{$avgPosts}}
                  </span><span style="font-size:10px;color:#5F0F4E;">tweet/hari</span></center>

                </div>
                <div class="card-reveal">
                  <h5 class="black-text card-title" style="font-size:14px;font-weight:200">Kompetitor<i class="fas fa-users right"></i></h5>
                  <hr>
                  <center class="activator"><span style="font-size:30px;color:#5F0F4E;">{{$avgPosts}}
                  </span><span style="font-size:10px;color:#5F0F4E;">tweet/hari</span></center>
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
                  <h5 class="black-text activator card-title" style="font-size:14px;font-weight:200">Rata - Rata Retweet<i class="fas fa-users right"></i></h5>
                  <hr>
                  <center class="activator"><span style="font-size:30px;color:#5F0F4E;">{{$avgRetweets}}
                  </span><span style="font-size:10px;color:#5F0F4E;">retweet/hari</span></center>

                </div>
                <div class="card-reveal">
                  <h5 class="black-text card-title" style="font-size:14px;font-weight:200">Kompetitor<i class="fas fa-users right"></i></h5>
                  <hr>
                  <center class="activator"><span style="font-size:30px;color:#5F0F4E;">{{$avgRetweets}}
                  </span><span style="font-size:10px;color:#5F0F4E;">retweet/hari</span></center>
                </div>
              </div>
            </div>
            <div class="col s12 m3">
              {{-- <div class="card-panel">
                <h5 class="black-text" style="font-size:14px;font-weight:200">Rata - Rata Likes<i class="fas fa-heart right"></i></h5>
                <hr>
                <center><span style="font-size:30px;color:#5F0F4E;">{{$avgLikes}}
                </span><span style="font-size:10px;color:#5F0F4E;">like/hari</span></center>
              </div> --}}
              <div class="card">
                <div class="card-content">
                  {{-- <span class="card-title activator grey-text text-darken-4">Card Title<i class="material-icons right">more_vert</i></span> --}}
                  <h5 class="black-text activator card-title" style="font-size:14px;font-weight:200">Rata - Rata Likes<i class="fas fa-users right"></i></h5>
                  <hr>
                  <center class="activator"><span style="font-size:30px;color:#5F0F4E;">{{$avgLikes}}
                  </span><span style="font-size:10px;color:#5F0F4E;">likes/hari</span></center>

                </div>
                <div class="card-reveal">
                  <h5 class="black-text card-title" style="font-size:14px;font-weight:200">Kompetitor<i class="fas fa-users right"></i></h5>
                  <hr>
                  <center class="activator"><span style="font-size:30px;color:#5F0F4E;">{{$avgLikes}}
                  </span><span style="font-size:10px;color:#5F0F4E;">likes/hari</span></center>
                </div>
              </div>
            </div>
            <div class="col s12 m6">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">Analisis Sentimen Positif<i class="fas fa-comments right"></i></h5>
                <hr>
                <center style="top:20px"><span style="font-size:70px;color:#5F0F4E;top:20px">70
                </span><span style="font-size:40px;color:#5F0F4E;">%</span></center>
              </div>
            </div>
            <div class="col s12 m6">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">Analisis Sentimen Negatif<i class="fas fa-comments right"></i></h5>
                <hr>
                <center style="top:20px"><span style="font-size:70px;color:#5F0F4E;top:20px">30
                </span><span style="font-size:40px;color:#5F0F4E;">%</span></center>
              </div>
            </div>
            <div class="col s12 m6">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">5 Tweet mendapatkan retweet terbanyak<i class="material-icons right">face</i></h5>
                <hr>
                  <div class="card-panel">
                    <blockquote><i class="fas fa-quote-left"></i> {{$topTweets[0]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
                    <div class="chip">
                      Diretweet {{$topTweets[0]->retweet_count}} kali
                    </div>
                  </div>
                  <div class="card-panel">
                    <blockquote><i class="fas fa-quote-left"></i> {{$topTweets[1]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
                    <div class="chip">
                      Diretweet {{$topTweets[1]->retweet_count}} kali
                    </div>
                  </div>
                  <div class="card-panel">
                    <blockquote><i class="fas fa-quote-left"></i> {{$topTweets[2]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
                    <div class="chip">
                      Diretweet {{$topTweets[2]->retweet_count}} kali
                    </div>
                  </div>
                  <div class="card-panel">
                    <blockquote><i class="fas fa-quote-left"></i> {{$topTweets[3]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
                    <div class="chip">
                      Diretweet {{$topTweets[3]->retweet_count}} kali
                    </div>
                  </div>
                  <div class="card-panel">
                    <blockquote><i class="fas fa-quote-left"></i> {{$topTweets[4]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
                    <div class="chip">
                      Diretweet {{$topTweets[4]->retweet_count}} kali
                    </div>
                  </div>
              </div>
            </div>
            <div class="col s12 m6">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">5 Tweet mendapatkan likes terbanyak<i class="material-icons right">face</i></h5>
                <hr>
                <div class="card-panel">
                  <blockquote><i class="fas fa-quote-left"></i> {{$topLikes[0]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
                  <div class="chip">
                    Dilike {{$topLikes[0]->favorite_count}} kali
                  </div>
                </div>
                <div class="card-panel">
                  <blockquote><i class="fas fa-quote-left"></i> {{$topLikes[1]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
                  <div class="chip">
                    Dilike {{$topLikes[1]->favorite_count}} kali
                  </div>
                </div>
                <div class="card-panel">
                  <blockquote><i class="fas fa-quote-left"></i> {{$topLikes[2]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
                  <div class="chip">
                    Dilike {{$topLikes[2]->favorite_count}} kali
                  </div>
                </div>
                <div class="card-panel">
                  <blockquote><i class="fas fa-quote-left"></i> {{$topLikes[3]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
                  <div class="chip">
                    Dilike {{$topLikes[3]->favorite_count}} kali
                  </div>
                </div>
                <div class="card-panel">
                  <blockquote><i class="fas fa-quote-left"></i> {{$topLikes[4]->tweet_content}} <i class="fas fa-quote-right"></i></blockquote>
                  <div class="chip">
                    Dilike {{$topLikes[4]->favorite_count}} kali
                  </div>
                </div>
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
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0)), url('{{asset('images/bg10.jpg')}}');
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

  </script>
@endsection
