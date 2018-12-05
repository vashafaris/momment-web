@extends('layouts.main')

@section('content')
    <section>
      <div class="row">
        <div class="col s12 m12">
          <div class="card-panel background1">
            <h5 class="center white-text">Trending Topik Hari Ini</h5>
            <hr>
            <div class="row">
              <div class="col s12 m3">&nbsp;</div>
              <div class="col s12 m6">

                  <div class="card-panel white">
                <div class="carousel carousel-slider center">
                  {{-- <div class="carousel-fixed-item center">
                    {{-- <a class="btn waves-effect white grey-text darken-text-2">button</a> --}}
                  {{-- </div> --}}
                  @if(count($twitterTrend) > 0)
                    @foreach ($twitterTrend as $trend)
                      <div class="carousel-item white black-text">
                        <h2>{{$trend->trend}}</h2>
                        <ul class="collapsible">
                        @foreach ($twitterDetails as $detail)
                          @if($detail->id_to_trending == $trend->id_to_details)
                         <li>
                           <div class="collapsible-header">
                             <img src="{{$detail->photo_url}}" class="center" style="height: 40px;width: 40px;object-fit: cover;border: 2px solid white;border-radius: 50%;top: 70px;left: 24px;">
                             <span>@if($detail->id_to_trending == $trend->id_to_details) {{$detail->name}}@endif</span>&nbsp;<span style="color:grey">@if($detail->id_to_trending == $trend->id_to_details){{$detail->username}}@endif</span>
                           </div>
                           <div class="collapsible-body">
                             <img src="{{$detail->tweet_pic}}" class="center" style="height: 300px;width: 300px;object-fit: cover;"><br>
                             <span>vasha farisi sarwan halim</span>
                           </div>
                         @endif
                         @endforeach
                         </li>
                       </ul>
                      </div>
                    @endforeach
                  @endif
                </div>


              </div>
              </div>


            </div>
          </div>
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
