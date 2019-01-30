@extends('layouts.main')

@section('content')
  <section>
    <div class="row">
      <div class="card-panel background-none z-depth-0">


        @if(count($twitterTrend) > 0)
          <ul class="collapsible">
            @foreach($twitterTrend as $trend)
              @php
                $counterDetail = 0;
              @endphp
              <li><div class="collapsible-header"><i class="fab fa-twitter" style="color:#0084b4"></i>{{$trend->trend}}</div>
                <div class="collapsible-body">
                  @foreach($twitterDetails as $detail)
                    @if($counterDetail < 5)
                      @if($detail->id_trend == $trend->id_trend)
                        @php
                          $counterDetail = $counterDetail + 1;
                        @endphp
                        <div class="row">
                        <div class="col m2">
                          <center><img src="{{$detail->photo_url}}" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>
                        </div>
                        <div class="col m10">
                          <span>{{$detail->name}}</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">{{$detail->screen_name}}</span><span style="color:grey">)</span>
                          <blockquote><i class="fas fa-quote-left"></i> {{$detail->tweet}} <i class="fas fa-quote-right"></i></blockquote>
                          <center><img class="responsive-img materialboxed" src="{{$detail->tweet_pic}}"></center>
                          <br>
                        </div>
                        <div class="chip">
                          Mendapatkan {{$detail->retweet_count}} retweet
                        </div>
                        <div class="chip">
                          Mendapatkan {{$detail->favorite_count}} likes
                        </div>
                        <div class="chip">
                          Mendapatkan {{$detail->replies_count}} replies
                        </div>
                      </div>
                      <hr>
                      @endif

                    @endif


                  @endforeach

                </div>
              </li>
            @endforeach
          </ul>
        @endif
      </div>
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
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.3)), url('{{asset('images/bg1.jpg')}}');
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
    background: linear-gradient(to right, #FFD200, #F7971E); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  }

  .background-none {
    background: none;
  }

  .background-insight2 {
    background: #FF416C;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #FF4B2B, #FF416C);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #FF4B2B, #FF416C); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
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
    $('.carousel').carousel();
    $('.collapsible').collapsible();
    document.getElementById("header").innerHTML = "Trending Twitter";
  });
  </script>
@endsection
