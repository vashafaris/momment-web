@extends('layouts.main')

@section('content')
  <section>
    <div class="row">
      <div class="card-panel">


        @if(count($twitterTrend) > 0)
          <ul class="collapsible">
            @foreach($twitterTrend as $trend)
              <li><div class="collapsible-header"><i class="fab fa-twitter" style="color:#0084b4"></i>{{$trend->trend}}</div>
                <div class="collapsible-body">
                  @foreach($twitterDetails as $detail)
                    @if($detail->id_trend== $trend->id_trend)
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
  });

  // $( document ).ready(function() {
  //     var spinner =
  //     '<div class="card white">' +
  //     '<div class="card-content" align="center">' +
  //     '<div class="preloader-wrapper small active">' +
  //     '<div class="spinner-layer spinner-blue-only">' +
  //     '<div class="circle-clipper left">' +
  //     '<div class="circle"></div>' +
  //     '</div><div class="gap-patch">' +
  //     '<div class="circle"></div>' +
  //     '</div><div class="circle-clipper right">' +
  //     '<div class="circle"></div>' +
  //     '</div>' +
  //     '</div>' +
  //     '</div>' +
  //     '</div>' +
  //     '</div>';
  //   var resultContainer = $('#search-result');
  //   resultContainer.hide();
  //   resultContainer.html(spinner);
  //   resultContainer.fadeIn(500);
  //       $.ajax({
  //         type: 'GET',
  //         url: '{{ url('/engage/account') }}',
  //         data: '_token = {{ csrf_token() }}',
  //         success: function(data) {
  //           console.log(data.response.banner_url);
  //
  //           var banner = (data[0].banner_url !== null) ?
  //           'style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4)), url(\'' + data[0].banner_url + '\');height: 200px;width: 100%;background-size: cover;background-position: center;"' :
  //           'style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4)), url(\'{{ asset('images/default -background.jpg ') }}\');height: 200px;width: 100%;background-size: cover;background-position: center;"';
  //           var photo = (data[0].photo_url !== null) ?
  //           '<img src="' + data[0].photo_url + '" style="height: 64px;width: 64px;object-fit: cover;border: 2px solid white;position: absolute;border-radius: 50%;top: 70px;left: 24px;">' :
  //           '<img src="{{ asset('images/default -photo.png ') }}" style="height: 64px;width: 64px;object-fit: cover;border: 2px solid white;position: absolute;border-radius: 50%;top: 70px;left: 24px;">';
  //           var location = (data[0].location !== null) ?
  //           '<div class="divider" style="margin: 10px 0;"></div>' +
  //           '<span style="font-size: 10pt;margin: 10px 0;"><i class="fas fa-map-marker-alt"></i> &nbsp; ' + data[0].location + '</span>' :
  //           '';
  //           var since = (data[0].created !== null) ?
  //           '<div class="divider" style="margin: 10px 0;"></div>' +
  //           '<span style="font-size: 10pt;margin: 10px 0;"><i class="far fa-calendar-alt"></i> &nbsp; Terdaftar Sejak ' + formatDate(new Date(data[0].created)) + '</span>' :
  //           '';
  //
  //           resultContainer.html(
  //             '<div class="card white card-profile">' +
  //             '<div class="card-image" ' + banner + '>' +
  //             photo +
  //             '<span class="card-title">' + data[0].name + '</span>' +
  //             '<span class="card-title" style="font-size: 9pt;top: 145px;">@' + data[0].screen_name + '</span>' +
  //             '</div>' +
  //             '<div class="card-content">' +
  //             '<blockquote style="font-size: 10pt; margin-top: 5px;"><i class="fas fa-quote-right fa-xs"></i> ' + data[0].description + ' <i class="fas fa-quote-left fa-xs"></i></blockquote>' +
  //             '<div class="divider" style="margin: 10px 0;"></div>' +
  //             '<div class="row" style="margin-bottom: 0px !important;">' +
  //             '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
  //             '<span style="font-weight: bold;">Tweet</span><br/>' +
  //             '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data[0].statuses_count) + '</span>' +
  //             '</div>' +
  //             '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
  //             '<span style="font-weight: bold;">Followers</span><br/>' +
  //             '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data[0].followers_count) + '</span>' +
  //             '</div>' +
  //             '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
  //             '<span style="font-weight: bold;">Following</span><br/>' +
  //             '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data[0].friends_count) + '</span>' +
  //             '</div>' +
  //             '</div>' +
  //             location +
  //             since +
  //             '<div class="divider" style="margin: 10px 0;"></div>' +
  //             '</div>' +
  //             '</div>'
  //             );
  //           },
  //             error: function() {
  //               resultContainer.html(
  //                 '<div class="card red darken-1">' +
  //                 '<div class="card-content white-text">' +
  //                 '<p><i class="fas fa-book"></i> Im sorry, magician might be sick. Trying to recover..</p>' +
  //                 '</div>' +
  //                 '</div>'
  //                 );
  //               resultContainer.fadeIn(600);
  //             }
  //         });
  //       });

  </script>
@endsection
