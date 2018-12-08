@extends('layouts.main')

@section('content')
  <section>
    <div class="row">
      <div class="col s12 m12">
        <div class="card-panel background1">
          <h5 class="center white-text">Laporan Aktivitas</h5>
          <hr>
          <div class="row">
            <div class="col s12 m12">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">Rekomendasi<i class="material-icons right">people</i></h5>
                <hr>
                <div class="row">
                  <div class="col m4">
                    {{-- <i style="color:green" class="far fa-check-square right"></i><br>
                    <i style="color:green" class="far fa-check-square right"></i><br>
                    <i style="color:green" class="far fa-check-square right"></i><br>
                    <i style="color:green" class="far fa-check-square right"></i><br> --}}
                  </div>
                  <div class="col m8">
                    <label style="color:black">
                      <input type="checkbox" class="filled-in"  />
                      <span>Posting tweet hari ini</span>
                    </label><br>
                    <label style="color:black">
                      <input type="checkbox" class="filled-in"/>
                      <span>Sebaiknya hari ini anda post 2 tweet lagi</span>
                    </label><br>
                    <label style="color:black">
                      <input type="checkbox" class="filled-in" />
                      <span>Balas mention masuk kepada anda</span>
                    </label><br>
                    <label style="color:black">
                      <input type="checkbox" class="filled-in" />
                      <span>Menanggapi tren topik hari ini</span>
                    </label><br>
                  </div>
                </div>
              </div>
            </div>
            <div class="col s12 m4">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Posting<i class="fab fa-twitter right"></i></h5>
                <hr>
                <canvas id="myChart" width="200" height="200"></canvas>
              </div>
            </div>
            <div class="col s12 m4">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Retweet<i class="fas fa-retweet right"></i></h5>
                <hr>
                <canvas id="myChart2" width="200" height="200"></canvas>
              </div>
            </div>
            <div class="col s12 m4">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Likes<i class="fas fa-heart right"></i></h5>
                <hr>
                <canvas id="myChart3" width="200" height="200"></canvas>
              </div>
            </div>
            <div class="col s12 m6">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">Analisis Sentimen Positif<i class="fas fa-comments right"></i></h5>
                <hr>
                <center style="top:20px"><span style="font-size:70px;color:#F49227;top:20px">+70
                </span><span style="font-size:40px;color:#F49227;">%</span></center>
              </div>
            </div>
            <div class="col s12 m6">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">Analisis Sentimen Negatif<i class="fas fa-comments right"></i></h5>
                <hr>
                <center style="top:20px"><span style="font-size:70px;color:#F49227;top:20px">-30
                </span><span style="font-size:40px;color:#F49227;">%</span></center>
              </div>
            </div>
            <div class="col s12 m6">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">5 Tweet mendapatkan retweet terbanyak<i class="material-icons right">face</i></h5>
                <hr>
                <center style="top:20px">
                  <ul class="collection">
                    <li class="collection-item">LAKSDJFKLAJASKDJFLKAJDLKADJLFKJASDFADSFDFKLJASDKLFJALKDSJFLKAJDKLJALKF</li>
                    <li class="collection-item">Alvin</li>
                    <li class="collection-item">Alvin</li>
                    <li class="collection-item">Alvin</li>
                  </ul>

                </center>
              </div>
            </div>
            <div class="col s12 m6">
              <div class="card-panel">
                <h5 class="black-text" style="font-size:16px;font-weight:200">5 Tweet mendapatkan likes terbanyak<i class="material-icons right">face</i></h5>
                <hr>
                <center style="top:20px">
                  <ul class="collection">
                    <li class="collection-item">Tweet 1</li>
                    <li class="collection-item">Tweet 2</li>
                    <li class="collection-item">Tweet 3</li>
                    <li class="collection-item">Tweet 4</li>
                  </ul>
                </center>
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
    var africa = [86,114,106,106,107,111,133,221,783,2478];
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["H - 6", "H - 5", "H - 4", "H - 3", "H - 2", "H - 1"],
        datasets: [{
          label: '= Tweet Posted',
          data: [8, 0, 3, 5, 2, 3],
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
