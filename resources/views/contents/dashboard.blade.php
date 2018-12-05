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
              <div class="col s12 m6">
                <div class="card">
                  <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="{{url('/images/bg9.jpg')}}">
                  </div>
                  <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">Rekomendasi</span>
                    <p><a href="#">This is a link</a></p>
                  </div>
                  <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">Card Title<i class="material-icons right">close</i></span>
                    <p>Here is some more information about this product that is only revealed once clicked on.</p>
                  </div>
                </div>
              </div>
              <div class="col s12 m6">
                <div class="card">
                  <div class="card-image waves-effect waves-block waves-light">
                    <img class="activator" src="{{url('/images/bg9.jpg')}}">

                  </div>
                  <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">5 tweet/hari</span>
                  </div>
                  <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">30 tweet/hari<i class="material-icons right">close</i></span>
                    <canvas id="myChart" width="100" height="100"></canvas>
                  </div>
                </div>
              </div>
              <div class="col s12 m6">
                <div class="card-panel">
                  <h5 class="black-text" style="font-size:16px;font-weight:200">Grafik Followers<i class="material-icons right">people</i></h5>
                  <hr>
                  <center style="top:20px"><span style="font-size:70px;color:#5F0F4E;top:20px">0.29
                  </span><span style="font-size:40px;color:#5F0F4E;">%</span></center>
                </div>
              </div>
              <div class="col s12 m6">
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
      var africa = [86,114,106,106,107,111,133,221,783,2478];
      var ctx = document.getElementById("myChart");
      var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
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
