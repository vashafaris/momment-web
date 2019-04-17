@extends('layouts.main')

@section('content')
  <section>
    <div class="row">
      <div class="col s12 m12">


    <div id="competitor-container">


      <div class="card-panel background-none z-depth-0">
        <h5 class="black-text">Daftar Tren Topik Indonesia</h5>
        <hr>
        <ul class="collection with-header">
          @if(count($twitterTrend) > 0)
            @foreach($twitterTrend as $tren)
              <li class="collection-item avatar" style="padding-left:20px">
                <input type="hidden" name="id_trend" value="{{ $tren->id_trend }}">
                <i class="fab fa-twitter" style="color:#0084b4"></i>
                <span class="title">{{$tren->trend}}</span>
                <p style="color:grey">Menjadi tren selama {{$tren->count_in_hour}} jam</p>
                <a class="waves-effect waves-light btn modal-trigger blue secondary-content detail-trend" id="{{$tren->id_trend}}"  href="#modal1"><i class="material-icons left">info_outline</i>Detail</a>
              </li>
            @endforeach
          @else
            <li class="collection-header center"><h6>Tren Topik Tidak Ditemukan!</h6></li>
          @endif
        </ul>

        <div id="modal1" class="modal">
          <div class="modal-content">
            <div id="detail-modal">
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
  .modal { width: 75% !important ; height: 75% !important ; }

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

  .overflow-detail {
    height: 80vh;
    overflow: auto;
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
    $('.materialboxed').materialbox();
    $('.modal').modal();
    document.getElementById("header").innerHTML = "Trending Indonesia";

  });

  $('.detail-trend').on('click', function () {
    var selectedObj = $(this), resultContainer;
    var id_trend = selectedObj[0].id;
    // var detail_modal = document.getElementsByClassName("detail-modal");
    var detailModal = $('#detail-modal');
    console.log(selectedObj[0].id);
    console.log(detailModal);
    $.ajax({
      type: 'GET',
      url: '{{ url('/trend/detail') }}' + '/' + id_trend,
      data: '_token = {{ csrf_token() }}',
      success: function(data) {
        console.log(data.response.trend_name[0].trend);
        if(data.status == 200) {
          console.log(data);
          var tweet_pic1 = (data.response.trend_details[0].tweet_pic !== null) ?
          '<center><img class="responsive-img " src="' + data.response.trend_details[0].tweet_pic + '"></center>':
          '';
          var tweet_pic2 = (data.response.trend_details[1].tweet_pic !== null) ?
          '<center><img class="responsive-img " src="' + data.response.trend_details[1].tweet_pic + '"></center>':
          '';
          var tweet_pic3 = (data.response.trend_details[2].tweet_pic !== null) ?
          '<center><img class="responsive-img " src="' + data.response.trend_details[2].tweet_pic + '"></center>':
          '';
          var tweet_pic4 = (data.response.trend_details[3].tweet_pic !== null) ?
          '<center><img class="responsive-img " src="' + data.response.trend_details[3].tweet_pic + '"></center>':
          '';
          var tweet_pic5 = (data.response.trend_details[4].tweet_pic !== null) ?
          '<center><img class="responsive-img " src="' + data.response.trend_details[4].tweet_pic + '"></center>':
          '';
          var tweet_pic6 = (data.response.trend_details[5].tweet_pic !== null) ?
          '<center><img class="responsive-img " src="' + data.response.trend_details[5].tweet_pic + '"></center>':
          '';
          var tweet_pic7 = (data.response.trend_details[6].tweet_pic !== null) ?
          '<center><img class="responsive-img " src="' + data.response.trend_details[6].tweet_pic + '"></center>':
          '';
          var tweet_pic8 = (data.response.trend_details[7].tweet_pic !== null) ?
          '<center><img class="responsive-img " src="' + data.response.trend_details[7].tweet_pic + '"></center>':
          '';
          var tweet_pic9 = (data.response.trend_details[8].tweet_pic !== null) ?
          '<center><img class="responsive-img " src="' + data.response.trend_details[8].tweet_pic + '"></center>':
          '';
          var tweet_pic10 = (data.response.trend_details[9].tweet_pic !== null) ?
          '<center><img class="responsive-img " src="' + data.response.trend_details[9].tweet_pic + '"></center>':
          '';
          detailModal.html(
            '<h5 class="black-text">' + data.response.trend_name[0].trend + '</h5>' +
              '<div class="card-panel" style="margin:30px">' +
            '<div class="row">' +
            '<div class="col m2">' +
              '<center><img src="' + data.response.trend_details[0].photo_url + '" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>' +
            '</div>' +
            '<div class="col m10">' +
              '<span>' + data.response.trend_details[0].name + '</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">' + data.response.trend_details[0].screen_name + '</span><span style="color:grey">)</span>' +
              '<blockquote><i class="fas fa-quote-left"></i> ' + data.response.trend_details[0].tweet + ' <i class="fas fa-quote-right"></i></blockquote>' +
              tweet_pic1 +
              '<br>' +
            '</div>' +
            '<div class="chip">' +
              'Mendapatkan ' + data.response.trend_details[0].retweet_count + ' retweet' +
            '</div>' +
            '<div class="chip">' +
              'Mendapatkan ' + data.response.trend_details[0].favorite_count + ' likes' +
            '</div>' +
            '<div class="chip">' +
              'Mendapatkan ' + data.response.trend_details[0].replies_count + ' replies' +
            '</div>' +
          '</div>' +
          '</div>' +
          '<div class="card-panel" style="margin:30px">' +
          '<div class="row">' +
          '<div class="col m2">' +
            '<center><img src="' + data.response.trend_details[1].photo_url + '" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>' +
          '</div>' +
          '<div class="col m10">' +
            '<span>' + data.response.trend_details[1].name + '</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">' + data.response.trend_details[1].screen_name + '</span><span style="color:grey">)</span>' +
            '<blockquote><i class="fas fa-quote-left"></i> ' + data.response.trend_details[1].tweet + ' <i class="fas fa-quote-right"></i></blockquote>' +
            tweet_pic2 +
            '<br>' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[1].retweet_count + ' retweet' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[1].favorite_count + ' likes' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[1].replies_count + ' replies' +
          '</div>' +
        '</div>' +
          '</div>' +
          '<div class="card-panel" style="margin:30px">' +
          '<div class="row">' +
          '<div class="col m2">' +
            '<center><img src="' + data.response.trend_details[2].photo_url + '" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>' +
          '</div>' +
          '<div class="col m10">' +
            '<span>' + data.response.trend_details[2].name + '</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">' + data.response.trend_details[2].screen_name + '</span><span style="color:grey">)</span>' +
            '<blockquote><i class="fas fa-quote-left"></i> ' + data.response.trend_details[2].tweet + ' <i class="fas fa-quote-right"></i></blockquote>' +
            tweet_pic3 +
            '<br>' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[2].retweet_count + ' retweet' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[2].favorite_count + ' likes' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[2].replies_count + ' replies' +
          '</div>' +
        '</div>' +
          '</div>' +
          '<div class="card-panel" style="margin:30px">' +
          '<div class="row">' +
          '<div class="col m2">' +
            '<center><img src="' + data.response.trend_details[3].photo_url + '" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>' +
          '</div>' +
          '<div class="col m10">' +
            '<span>' + data.response.trend_details[3].name + '</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">' + data.response.trend_details[3].screen_name + '</span><span style="color:grey">)</span>' +
            '<blockquote><i class="fas fa-quote-left"></i> ' + data.response.trend_details[3].tweet + ' <i class="fas fa-quote-right"></i></blockquote>' +
            tweet_pic4 +
            '<br>' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[3].retweet_count + ' retweet' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[3].favorite_count + ' likes' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[3].replies_count + ' replies' +
          '</div>' +
        '</div>' +
          '</div>' +
          '<div class="card-panel" style="margin:30px">' +
          '<div class="row">' +
          '<div class="col m2">' +
            '<center><img src="' + data.response.trend_details[4].photo_url + '" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>' +
          '</div>' +
          '<div class="col m10">' +
            '<span>' + data.response.trend_details[4].name + '</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">' + data.response.trend_details[4].screen_name + '</span><span style="color:grey">)</span>' +
            '<blockquote><i class="fas fa-quote-left"></i> ' + data.response.trend_details[4].tweet + ' <i class="fas fa-quote-right"></i></blockquote>' +
            tweet_pic5 +
            '<br>' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[4].retweet_count + ' retweet' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[4].favorite_count + ' likes' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[4].replies_count + ' replies' +
          '</div>' +
        '</div>' +
          '</div>' +
          '<div class="card-panel" style="margin:30px">' +
          '<div class="row">' +
          '<div class="col m2">' +
            '<center><img src="' + data.response.trend_details[5].photo_url + '" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>' +
          '</div>' +
          '<div class="col m10">' +
            '<span>' + data.response.trend_details[5].name + '</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">' + data.response.trend_details[5].screen_name + '</span><span style="color:grey">)</span>' +
            '<blockquote><i class="fas fa-quote-left"></i> ' + data.response.trend_details[5].tweet + ' <i class="fas fa-quote-right"></i></blockquote>' +
            tweet_pic6 +
            '<br>' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[5].retweet_count + ' retweet' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[5].favorite_count + ' likes' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[5].replies_count + ' replies' +
          '</div>' +
        '</div>' +
          '</div>' +
          '<div class="card-panel" style="margin:30px">' +
          '<div class="row">' +
          '<div class="col m2">' +
            '<center><img src="' + data.response.trend_details[6].photo_url + '" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>' +
          '</div>' +
          '<div class="col m10">' +
            '<span>' + data.response.trend_details[6].name + '</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">' + data.response.trend_details[6].screen_name + '</span><span style="color:grey">)</span>' +
            '<blockquote><i class="fas fa-quote-left"></i> ' + data.response.trend_details[6].tweet + ' <i class="fas fa-quote-right"></i></blockquote>' +
            tweet_pic7 +
            '<br>' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[6].retweet_count + ' retweet' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[6].favorite_count + ' likes' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[6].replies_count + ' replies' +
          '</div>' +
        '</div>' +
          '</div>' +
          '<div class="card-panel" style="margin:30px">' +
          '<div class="row">' +
          '<div class="col m2">' +
            '<center><img src="' + data.response.trend_details[7].photo_url + '" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>' +
          '</div>' +
          '<div class="col m10">' +
            '<span>' + data.response.trend_details[7].name + '</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">' + data.response.trend_details[7].screen_name + '</span><span style="color:grey">)</span>' +
            '<blockquote><i class="fas fa-quote-left"></i> ' + data.response.trend_details[7].tweet + ' <i class="fas fa-quote-right"></i></blockquote>' +
            tweet_pic8 +
            '<br>' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[7].retweet_count + ' retweet' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[7].favorite_count + ' likes' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[7].replies_count + ' replies' +
          '</div>' +
        '</div>' +
          '</div>' +
          '<div class="card-panel" style="margin:30px">' +
          '<div class="row">' +
          '<div class="col m2">' +
            '<center><img src="' + data.response.trend_details[8].photo_url + '" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>' +
          '</div>' +
          '<div class="col m10">' +
            '<span>' + data.response.trend_details[8].name + '</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">' + data.response.trend_details[8].screen_name + '</span><span style="color:grey">)</span>' +
            '<blockquote><i class="fas fa-quote-left"></i> ' + data.response.trend_details[8].tweet + ' <i class="fas fa-quote-right"></i></blockquote>' +
            tweet_pic9 +
            '<br>' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[8].retweet_count + ' retweet' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[8].favorite_count + ' likes' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[8].replies_count + ' replies' +
          '</div>' +
        '</div>' +
          '</div>' +
          '<div class="card-panel" style="margin:30px">' +
          '<div class="row">' +
          '<div class="col m2">' +
            '<center><img src="' + data.response.trend_details[9].photo_url + '" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>' +
          '</div>' +
          '<div class="col m10">' +
            '<span>' + data.response.trend_details[9].name + '</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">' + data.response.trend_details[9].screen_name + '</span><span style="color:grey">)</span>' +
            '<blockquote><i class="fas fa-quote-left"></i> ' + data.response.trend_details[9].tweet + ' <i class="fas fa-quote-right"></i></blockquote>' +
            tweet_pic10 +
            '<br>' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[9].retweet_count + ' retweet' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[9].favorite_count + ' likes' +
          '</div>' +
          '<div class="chip">' +
            'Mendapatkan ' + data.response.trend_details[9].replies_count + ' replies' +
          '</div>' +
        '</div>' +
          '</div>'
          );
        } else {
          console.log(data);
        }
      }
          });
  });
  </script>
@endsection
