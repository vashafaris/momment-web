@extends('layouts.main')

@section('content')
  <section>
    <div class="row">
      <div class="col s12 m12">
        <div class="card-panel background-none z-depth-0">
          <div id="update-button" style="visibility:hidden"><a onCLick="updateAccountData()" class="waves-effect waves-light btn right" style="background-color:#3a3f51;margin-top:10px;"><i class="material-icons">update</i> Update Data</a></div>
          <h5 class="black-text">Profil Akun Twitter</h5>

          <hr>
          <div id="profile-result">

          </div>
        </div>
      </div>
      <div class="col s12 m12">
        <div class="card-panel  background-none z-depth-0" style="padding-top:0px!important">
          <h5 class="black-text" >Laporan Aktivitas</h5>
          <hr>
          <div class="row">

            <div id="insight">

            </div>
            <div id="recommendation">

            </div>
          </div>
          <div class="row">
            <div id="followersCard">

            </div>
            <div id="postingCard">

            </div>
            <div id="retweetCard">

            </div>
            <div id="likesCard">

            </div>
            <div id="repliesCard">

            </div>
            <div id="sentimentCard">

            </div>
          </div>
        </div>
      </div>


      <div class="col s12 m12">
        <div class="card-panel background-none z-depth-0" style="padding-top:0px">
          <h5 class="black-text" >5 Tweet Terbaik Anda</h5>
          <hr>
          <div id="topTweets">

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

  .background-insight {
    background: #76b852;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #8DC26F, #76b852);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #8DC26F, #76b852); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

  }

  .background-recommendation {
    background: linear-gradient(to right, #159957, #155799);
  }

  .background-none {
    background: none;
  }

  .responsive-img {
    max-height: 400px;
    border-radius: 5%;
  }

  .vertical-divider {
    border-right: 2px solid #AAAAAA;
  }

  .rcornersPositive {
  border-radius: 25px;
  border: 2px solid #27c24c;
  padding-left: 20px;
  width: 80%;
  height: auto;
  }

  .rcornersNegative {
  border-radius: 25px;
  border: 2px solid #ff6384;
  padding-left: 20px;
  width: 80%;
  height: auto;
  }

  .overflow-text {
    word-wrap: break-word
  }

  #toast-container {
  top: 10% !important;
  right: 30% !important;
  bottom: auto !important;
  left: auto !important;
}

  </style>
@endsection

@section('custom-script')
  <script>

  function test()
  {
    $.ajax({
      type: 'GET',
      url: '{{ url('/dashboard/checkUpdate') }}',
      data: '_token = {{ csrf_token() }}',
      success: function(data) {
      },
      error: function() {
      }
    });
  }
  $(document).ready(function(){
    $('.collapsible').collapsible();
    document.getElementById("header").innerHTML = "Dashboard";

    updateButtonView();
    updateAccountDataView();
    updateInsightView();
    updateRecommendationView();
    updateFollowersView();
    updatePostingView();
    updateRetweetView();
    updateLikesView();
    updateRepliesView();
    updateSentimentDataView();
    updateBestTweetView();
  });

  function updateButtonView()
  {
    $.ajax({
      type: 'GET',
      url: '{{ url('/dashboard/checkUpdate') }}',
      data: '_token = {{ csrf_token() }}',
      success: function(data) {
        if(data.update == 'true') {
          updateAccountData();
          document.getElementById("update-button").style.visibility = "visible";
        } else {
          document.getElementById("update-button").style.visibility = "visible";
        }
      },
      error: function() {
      }
    });
  }

  function updateAccountData()
  {
    document.getElementById("update-button").innerHTML =
    "<a class=' btn right' style='background-color:#3a3f51;margin-top:10px'><i class='material-icons'>update</i> Sedang Proses Update Data Akun Twitter</a>";

    $.ajax({
      type: 'GET',
      url: '{{ url('/dashboard/updateAccountData') }}',
      data: '_token = {{ csrf_token() }}',
      success: function(data) {
        $("#update-button").fadeOut(1);
        $("#update-button").fadeIn(2000);
        M.toast({html: 'Berhasil Update Data Akun Twitter!'});
        document.getElementById("update-button").innerHTML =
        "<a class=' btn right' style='background-color:#3a3f51;margin-top:10px'><i class='material-icons'>update</i> Sedang Update Data Sentimen</a>";
        updateAccountDataView();
        updateFollowersView();
        updatePostingView();
        updateRetweetView();
        updateLikesView();
        updateSentimentData();
      },
      error: function() {
      }
    });
  }

  function updateSentimentData()
  {
    $.ajax({
      type: 'GET',
      url: '{{ url('/dashboard/updateSentimentData') }}',
      data: '_token = {{ csrf_token() }}',
      success: function(data) {
        $("#update-button").fadeOut(1);
        $("#update-button").fadeIn(2000);
        M.toast({html: 'Berhasil Update Data Sentimen!'});
        document.getElementById("update-button").innerHTML =
        "<a class=' btn right' style='background-color:#3a3f51;margin-top:10px'><i class='material-icons'>update</i> Sedang Update Data Tweet Terbaik</a>";
        updateInsightView();
        updateRecommendationView();
        updateRepliesView();
        updateSentimentDataView();
        updateBestTweet();
      },
      error: function() {
      }
    });
  }

  function updateBestTweet()
  {
    $.ajax({
      type: 'GET',
      url: '{{ url('/dashboard/updateBestTweet') }}',
      data: '_token = {{ csrf_token() }}',
      success: function(data) {
        $("#update-button").fadeOut(1);
        $("#update-button").fadeIn(2000);
        M.toast({html: 'Berhasil Update Data Tweet Terbaik'});
        document.getElementById("update-button").innerHTML =
        "<a class=' btn right' style='background-color:#3a3f51;margin-top:10px'><i class='material-icons'>update</i> Sedang Update Data Tren Topik</a>";
        updateBestTweetView();
        updateTrendingTopic();
      },
      error: function() {
      }
    });
  }

  function updateTrendingTopic()
  {
    $.ajax({
      type: 'GET',
      url: '{{ url('/dashboard/updateTrendingTopic') }}',
      data: '_token = {{ csrf_token() }}',
      success: function(data) {
        $("#update-button").fadeOut(1);
        $("#update-button").fadeIn(2000);
        location.reload();
      },
      error: function() {
      }
    });
  }

  function updateAccountDataView() {
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
    var resultContainer = $('#profile-result');
    resultContainer.hide();
    resultContainer.html(spinner);
    resultContainer.fadeIn(500);
    $.ajax({
      type: 'GET',
      url: '{{ url('/dashboard/profile') }}',
      data: '_token = {{ csrf_token() }}',
      success: function(data) {

        var banner = (data.response.banner_url !== null) ?
        'style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4)), url(\'' + data.response.banner_url + '\');height: 200px;width: 100%;background-size: cover;background-position: center;"' :
        'style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4)), url(\'{{ asset('images/default -background.jpg ') }}\');height: 200px;width: 100%;background-size: cover;background-position: center;"';
        var photo = (data.response.photo_url !== null) ?
        '<img src="' + data.response.photo_url + '" style="height: 64px;width: 64px;object-fit: cover;border: 2px solid white;position: absolute;border-radius: 50%;top: 70px;left: 24px;">' :
        '<img src="{{ asset('images/default -photo.png ') }}" style="height: 64px;width: 64px;object-fit: cover;border: 2px solid white;position: absolute;border-radius: 50%;top: 70px;left: 24px;">';
        var location = (data.response.location !== null) ?
        '<div class="divider" style="margin: 10px 0;"></div>' +
        '<span style="font-size: 10pt;margin: 10px 0;"><i class="fas fa-map-marker-alt"></i> &nbsp; ' + data.response.location + '</span>' :
        '';
        var since = (data.response.created !== null) ?
        '<div class="divider" style="margin: 10px 0;"></div>' +
        '<span style="font-size: 10pt;margin: 10px 0;"><i class="far fa-calendar-alt"></i> &nbsp; Terdaftar Sejak ' + formatDate(new Date(data.response.created)) + '</span>' :
        '';

        resultContainer.html(
          '<div class="card white card-profile">' +
          '<div class="card-image" ' + banner + '>' +
          photo +
          '<span class="card-title">' + data.response.name + '</span>' +
          '<span class="card-title" style="font-size: 9pt;top: 145px;">@' + data.response.screen_name + '</span>' +
          '</div>' +
          '<div class="card-content">' +
          '<blockquote style="font-size: 10pt; margin-top: 5px;"><i class="fas fa-quote-right fa-xs"></i> ' + data.response.description + ' <i class="fas fa-quote-left fa-xs"></i></blockquote>' +
          '<div class="divider" style="margin: 10px 0;"></div>' +
          '<div class="row" style="margin-bottom: 0px !important;">' +
          '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
          '<span style="font-weight: bold;">Tweet</span><br/>' +
          '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.statuses_count) + '</span>' +
          '</div>' +
          '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
          '<span style="font-weight: bold;">Followers</span><br/>' +
          '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.followers_count) + '</span>' +
          '</div>' +
          '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
          '<span style="font-weight: bold;">Following</span><br/>' +
          '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.friends_count) + '</span>' +
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
          '<p><i class="fas fa-book"></i> Mohon maaf terjadi kesalahan, silahkan coba lagi!</p>' +
          '</div>' +
          '</div>'
        );
        resultContainer.fadeIn(600);
      }
    });
  }

  function updateSentimentDataView()
  {
    var spinner =
    '<div class="col s12 m12">' +
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
    '</div>' +
    '</div>';
    var resultContainer = $('#sentimentCard');
    resultContainer.hide();
    resultContainer.html(spinner);
    resultContainer.fadeIn(500);
    $.ajax({
      type: 'GET',
      url: '{{ url('/dashboard/showSentiment') }}',
      data: '_token = {{ csrf_token() }}',
      success: function(data) {

        if(data.response.totalSentiment > 0)
        {
          var samplingPositive0 = '';
          var samplingPositive1 = '';
          var samplingPositive2 = '';
          var samplingPositive3 = '';
          var samplingPositive4 = '';
          var samplingNegative0 = '';
          var samplingNegative1 = '';
          var samplingNegative2 = '';
          var samplingNegative3 = '';
          var samplingNegative4 = '';
          if(data.response.samplingPositiveContent[0]){
            samplingPositive0 = '<span>' + data.response.samplingPositiveContent[0] + '</span><br><span class="right">@'+ data.response.samplingPositiveUser[0] +'</span><br>';
          }
          if(data.response.samplingPositiveContent[1]){
            samplingPositive1 = '<span>' + data.response.samplingPositiveContent[1] + '</span><br><span class="right">@'+ data.response.samplingPositiveUser[1] +'</span><br>';
          }
          if(data.response.samplingPositiveContent[2]){
            samplingPositive2 = '<span>' + data.response.samplingPositiveContent[2] + '</span><br><span class="right">@'+ data.response.samplingPositiveUser[2] +'</span><br>';
          }
          if(data.response.samplingPositiveContent[3]){
            samplingPositive3 = '<span>' + data.response.samplingPositiveContent[3] + '</span><br><span class="right">@'+ data.response.samplingPositiveUser[3] +'</span><br>';
          }
          if(data.response.samplingPositiveContent[4]){
            samplingPositive4 = '<span>' + data.response.samplingPositiveContent[4] + '</span><br><span class="right">@'+ data.response.samplingPositiveUser[4] +'</span><br>';
          }
          if(data.response.samplingNegativeContent[0]){
            samplingNegative0 = '<span>' + data.response.samplingNegativeContent[0] + '</span><br><span class="right">@'+ data.response.samplingNegativeUser[0] +'</span><br>';
          }
          if(data.response.samplingNegativeContent[1]){
            samplingNegative1 = '<span>' + data.response.samplingNegativeContent[1] + '</span><br><span class="right">@'+ data.response.samplingNegativeUser[1] +'</span><br>';
          }
          if(data.response.samplingNegativeContent[2]){
            samplingNegative2 = '<span>' + data.response.samplingNegativeContent[2] + '</span><br><span class="right">@'+ data.response.samplingNegativeUser[2] +'</span><br>';
          }
          if(data.response.samplingNegativeContent[3]){
            samplingNegative3 = '<span>' + data.response.samplingNegativeContent[3] + '</span><br><span class="right">@'+ data.response.samplingNegativeUser[3] +'</span><br>';
          }
          if(data.response.samplingNegativeContent[4]){
            samplingNegative4 = '<span>' + data.response.samplingNegativeContent[4] + '</span><br><span class="right">@'+ data.response.samplingNegativeUser[4] +'</span><br>';
          }
        resultContainer.html(
          '<div class="col s12 m12">' +
          '<div class="card-panel">' +
          '<h5 class="black-text" style="font-size:16px;font-weight:200">Analisis Sentimen<i class="fas fa-comments right"></i></h5>' +
          '<hr>' +
          '<center><canvas id="chartSentiment"></canvas></center>' +
          '<span class="right" style="font-weight:200">* angka dalam persen</span>' +
          '<br>' +
          '<br>' +
          '<div class="row">' +
          '<div class="col s12 m6 overflow-text">' +
          '<h5 class="black-text" style="font-size:16px;font-weight:200">Sentimen Positif</h5>' +
            '<hr>' +
            '<div style="padding-left:20px">' +
            samplingPositive0 +
            '</div><br>' +
            '<div style="padding-left:20px">' +
            samplingPositive1 +
            '</div><br>' +
            '<div style="padding-left:20px">' +
            samplingPositive2 +
            '</div><br>' +
            '<div style="padding-left:20px">' +
            samplingPositive3 +
            '</div><br>' +
            '<div style="padding-left:20px">' +
            samplingPositive4 +
            '</div><br>' +
          '</div>' +
          '<div class="col s12 m6 overflow-text">' +
          '<h5 class="black-text" style="font-size:16px;font-weight:200">Sentimen Negatif</h5>' +
            '<hr>' +
            '<div style="padding-left:20px">' +
            samplingNegative0 +
            '</div><br>' +
            '<div style="padding-left:20px">' +
            samplingNegative1 +
            '</div><br>' +
            '<div style="padding-left:20px">' +
            samplingNegative2 +
            '</div><br>' +
            '<div style="padding-left:20px">' +
            samplingNegative3 +
            '</div><br>' +
            '<div style="padding-left:20px">' +
            samplingNegative4 +
            '</div><br>' +
            '</div>' +
            '</div>' +
          '</div>' +
          '</div>'
        );
        var ctx = document.getElementById("chartSentiment");
        var myChart = new Chart(ctx, {
          type: 'pie',
          data: {
            labels: [
              'Positif',
              'Negatif',
              'Netral'
            ],
            datasets: [{
              label: 'Percentage',
              data: [Math.round(data.response.positiveSentiment * 100) / 100, Math.round(data.response.negativeSentiment * 100) / 100, Math.round(data.response.neutralSentiment * 100) / 100],
              backgroundColor: [
                "#27c24c",
                "#ff6384",
                "#9E9E9E",
              ]
            }],
          }
        });
      } else {
        resultContainer.html(
          '<div class="col s12 m12">' +
          '<div class="card red darken-1">' +
          '<div class="card-content white-text">' +
          '<p><i class="fas fa-book"></i> Mohon maaf data sentimen sedang diupdate, silahkan tunggu sesaat lagi!</p>' +
          '</div>' +
          '</div>' +
          '</div>'
        );
      }
      },
      error: function() {
        resultContainer.html(
          '<div class="col s12 m12">' +
          '<div class="card red darken-1">' +
          '<div class="card-content white-text">' +
          '<p><i class="fas fa-book"></i> Mohon maaf terjadi kesalahan, silahkan coba lagi!</p>' +
          '</div>' +
          '</div>' +
          '</div>'
        );
        resultContainer.fadeIn(600);
      }
    });
  }

  function updateBestTweetView()
  {
        var spinner =
        '<div class="col s12 m12">' +
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
        '</div>' +
        '</div>';
        var resultContainer = $('#topTweets');
        resultContainer.hide();
        resultContainer.html(spinner);
        resultContainer.fadeIn(500);
        $.ajax({
          type: 'GET',
          url: '{{ url('/dashboard/showTopTweets') }}',
          data: '_token = {{ csrf_token() }}',
          success: function(data) {

            if (data.response.topTweets[0] !== undefined)
            {
              var tweetMedia0 = (data.response.topTweets[0].tweet_media) ?
              '<center><img class="responsive-img materialboxed" src="'+data.response.topTweets[0].tweet_media+'"></center>' :
              '';
              var tweetMedia1 = (data.response.topTweets[1].tweet_media) ?
              '<center><img class="responsive-img materialboxed" src="'+data.response.topTweets[1].tweet_media+'"></center>' :
              '';
              var tweetMedia2 = (data.response.topTweets[2].tweet_media) ?
              '<center><img class="responsive-img materialboxed" src="'+data.response.topTweets[2].tweet_media+'"></center>' :
              '';
              var tweetMedia3 = (data.response.topTweets[3].tweet_media) ?
              '<center><img class="responsive-img materialboxed" src="'+data.response.topTweets[3].tweet_media+'"></center>' :
              '';
              var tweetMedia4 = (data.response.topTweets[4].tweet_media) ?
              '<center><img class="responsive-img materialboxed" src="'+data.response.topTweets[4].tweet_media+'"></center>' :
              '';
            resultContainer.html(
                  '<div class="card-panel">' +
                    '<div class="row">' +
                      '<div class="col m2">' +
                        '<center><img src="' + data.response.twitterAccountLog.photo_url + '" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>' +
                      '</div>' +
                      '<div class="col m10">' +
                        '<span>'+ data.response.twitterAccountLog.name +'</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">'+data.response.twitterAccountLog.screen_name+'</span><span style="color:grey">)</span>' +
                        '<blockquote><i class="fas fa-quote-left"></i> '+ data.response.topTweets[0].tweet_content+' <i class="fas fa-quote-right"></i></blockquote>' +
                        tweetMedia0 +
                        '<br>' +
                      '</div>' +
                      '<div class="chip">' +
                        'Mendapatkan '+data.response.topTweets[0].retweet_count+' retweet' +
                      '</div>' +
                      '<div class="chip">' +
                        'Mendapatkan '+data.response.topTweets[0].favorite_count+' likes' +
                      '</div>' +
                      '<div class="chip">' +
                        'Mendapatkan '+data.response.topTweets[0].replies_count+' replies' +
                      '</div>' +
                      '<div class="chip">' +
                        ''+data.response.positiveTopTweet[0]+' reply positif' +
                      '</div>' +
                      '<div class="chip">' +
                        ''+data.response.negativeTopTweet[0]+' reply negatif' +
                      '</div>' +
                    '</div>' +
                  '</div>' +

                  '<div class="card-panel">' +
                    '<div class="row">' +
                      '<div class="col m2">' +
                        '<center><img src="' + data.response.twitterAccountLog.photo_url + '" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>' +
                      '</div>' +
                      '<div class="col m10">' +
                        '<span>'+ data.response.twitterAccountLog.name +'</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">'+data.response.twitterAccountLog.screen_name+'</span><span style="color:grey">)</span>' +
                        '<blockquote><i class="fas fa-quote-left"></i> '+ data.response.topTweets[1].tweet_content+' <i class="fas fa-quote-right"></i></blockquote>' +
                        tweetMedia1 +
                        '<br>' +
                      '</div>' +
                      '<div class="chip">' +
                        'Mendapatkan '+data.response.topTweets[1].retweet_count+' retweet' +
                      '</div>' +
                      '<div class="chip">' +
                        'Mendapatkan '+data.response.topTweets[1].favorite_count+' likes' +
                      '</div>' +
                      '<div class="chip">' +
                        'Mendapatkan '+data.response.topTweets[1].replies_count+' replies' +
                      '</div>' +
                      '<div class="chip">' +
                        ''+data.response.positiveTopTweet[1]+' reply positif' +
                      '</div>' +
                      '<div class="chip">' +
                        ''+data.response.negativeTopTweet[1]+' reply negatif' +
                      '</div>' +
                    '</div>' +
                  '</div>' +

                  '<div class="card-panel">' +
                    '<div class="row">' +
                      '<div class="col m2">' +
                        '<center><img src="' + data.response.twitterAccountLog.photo_url + '" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>' +
                      '</div>' +
                      '<div class="col m10">' +
                        '<span>'+ data.response.twitterAccountLog.name +'</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">'+data.response.twitterAccountLog.screen_name+'</span><span style="color:grey">)</span>' +
                        '<blockquote><i class="fas fa-quote-left"></i> '+ data.response.topTweets[2].tweet_content+' <i class="fas fa-quote-right"></i></blockquote>' +
                        tweetMedia2 +
                        '<br>' +
                      '</div>' +
                      '<div class="chip">' +
                        'Mendapatkan '+data.response.topTweets[2].retweet_count+' retweet' +
                      '</div>' +
                      '<div class="chip">' +
                        'Mendapatkan '+data.response.topTweets[2].favorite_count+' likes' +
                      '</div>' +
                      '<div class="chip">' +
                        'Mendapatkan '+data.response.topTweets[2].replies_count+' replies' +
                      '</div>' +
                      '<div class="chip">' +
                        ''+data.response.positiveTopTweet[2]+' reply positif' +
                      '</div>' +
                      '<div class="chip">' +
                        ''+data.response.negativeTopTweet[2]+' reply negatif' +
                      '</div>' +
                    '</div>' +
                  '</div>' +

                  '<div class="card-panel">' +
                    '<div class="row">' +
                      '<div class="col m2">' +
                        '<center><img src="' + data.response.twitterAccountLog.photo_url + '" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>' +
                      '</div>' +
                      '<div class="col m10">' +
                        '<span>'+ data.response.twitterAccountLog.name +'</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">'+data.response.twitterAccountLog.screen_name+'</span><span style="color:grey">)</span>' +
                        '<blockquote><i class="fas fa-quote-left"></i> '+ data.response.topTweets[3].tweet_content+' <i class="fas fa-quote-right"></i></blockquote>' +
                        tweetMedia3 +
                        '<br>' +
                      '</div>' +
                      '<div class="chip">' +
                        'Mendapatkan '+data.response.topTweets[3].retweet_count+' retweet' +
                      '</div>' +
                      '<div class="chip">' +
                        'Mendapatkan '+data.response.topTweets[3].favorite_count+' likes' +
                      '</div>' +
                      '<div class="chip">' +
                        'Mendapatkan '+data.response.topTweets[3].replies_count+' replies' +
                      '</div>' +
                      '<div class="chip">' +
                        ''+data.response.positiveTopTweet[3]+' reply positif' +
                      '</div>' +
                      '<div class="chip">' +
                        ''+data.response.negativeTopTweet[3]+' reply negatif' +
                      '</div>' +
                    '</div>' +
                  '</div>' +

                  '<div class="card-panel">' +
                    '<div class="row">' +
                      '<div class="col m2">' +
                        '<center><img src="' + data.response.twitterAccountLog.photo_url + '" style="height: 75px;width: 75px;object-fit: cover;border: 2px solid white;border-radius: 50%;"></center>' +
                      '</div>' +
                      '<div class="col m10">' +
                        '<span>'+ data.response.twitterAccountLog.name +'</span><span style="color:grey">&nbsp;(@</span><span style="color:grey">'+data.response.twitterAccountLog.screen_name+'</span><span style="color:grey">)</span>' +
                        '<blockquote><i class="fas fa-quote-left"></i> '+ data.response.topTweets[4].tweet_content+' <i class="fas fa-quote-right"></i></blockquote>' +
                        tweetMedia4 +
                        '<br>' +
                      '</div>' +
                      '<div class="chip">' +
                        'Mendapatkan '+data.response.topTweets[4].retweet_count+' retweet' +
                      '</div>' +
                      '<div class="chip">' +
                        'Mendapatkan '+data.response.topTweets[4].favorite_count+' likes' +
                      '</div>' +
                      '<div class="chip">' +
                        'Mendapatkan '+data.response.topTweets[4].replies_count+' replies' +
                      '</div>' +
                      '<div class="chip">' +
                        ''+data.response.positiveTopTweet[4]+' reply positif' +
                      '</div>' +
                      '<div class="chip">' +
                        ''+data.response.negativeTopTweet[4]+' reply negatif' +
                      '</div>' +
                    '</div>' +
                  '</div>'
            );
            $('.materialboxed').materialbox();
            } else {
              resultContainer.html(
                '<div class="col s12 m12">' +
                '<div class="card red darken-1">' +
                '<div class="card-content white-text">' +
                '<p><i class="fas fa-book"></i> Mohon maaf data tweet terbaik sedang diupdate, silahkan tunggu sesaat lagi!</p>' +
                '</div>' +
                '</div>' +
                '</div>'
              );
            }
          },
          error: function() {
            resultContainer.html(
              '<div class="col s12 m12">' +
              '<div class="card red darken-1">' +
              '<div class="card-content white-text">' +
              '<p><i class="fas fa-book"></i> Mohon maaf terjadi kesalahan, silahkan coba lagi!</p>' +
              '</div>' +
              '</div>' +
              '</div>'
            );
            resultContainer.fadeIn(600);
          }
        });
  }

  function updateInsightView()
  {
    var spinner =
    '<div class="col s12 m5">' +
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
    '</div>' +
    '</div>';
    var resultContainer = $('#insight');
    resultContainer.hide();
    resultContainer.html(spinner);
    resultContainer.fadeIn(500);
    $.ajax({
      type: 'GET',
      url: '{{ url('/dashboard/showInsight') }}',
      data: '_token = {{ csrf_token() }}',
      success: function(data) {

        resultContainer.html(

          '<div class="col s12 m5">' +
          '<div class="card-panel background-recommendation white-text">' +
          '<h5 style="font-size:16px;font-weight:200">Penilian Aktivitas<i class="fas fa-lightbulb right"></i></h5>' +
          '<hr>' +
          '<br>' +
          '<center><i class="' + data.response.insightIcon + '" style="color:white;font-size:100px"></i></center>' +
          '<br>' +
          '<center><span>' + data.response.insightText + '</span></center>' +
          '</div>' +
          '</div>'
        );
      },
      error: function() {
        resultContainer.html(
          '<div class="col s12 m5">' +
          '<div class="card red darken-1">' +
          '<div class="card-content white-text">' +
          '<p><i class="fas fa-book"></i> Mohon maaf terjadi kesalahan, silahkan coba lagi!</p>' +
          '</div>' +
          '</div>' +
          '</div>'
        );
        resultContainer.fadeIn(600);
      }
    });
  }

  function updateRecommendationView()
  {
    var spinner =
    '<div class="col s12 m7">' +
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
    '</div>' +
    '</div>';
    var resultContainer = $('#recommendation');
    resultContainer.hide();
    resultContainer.html(spinner);
    resultContainer.fadeIn(500);
    $.ajax({
      type: 'GET',
      url: '{{ url('/dashboard/showRecommendation') }}',
      data: '_token = {{ csrf_token() }}',
      success: function(data) {
        var bestHour = '';
        if (data.response.bestHour[0]) {
          bestHour = '<span><i class="fas fa-lightbulb"></i> Sebaiknya anda posting tweet pada pukul ' + data.response.bestHour[0].hour + '.00 WIB</span><br>';
        }
        resultContainer.html(

          '<div class="col s12 m7">' +
          '<div class="card-panel background-recommendation white-text">' +
          '<h5 style="font-size:16px;font-weight:200">Rekomendasi<i class="fas fa-lightbulb right"></i></h5>' +
          '<hr>' +
          '<br>' +
          data.response.tweetRecommendation +
          data.response.postingRecommendation +
          data.response.mentionRecommendation +
          bestHour +
          '<span><i class="fas fa-lightbulb"></i> Menanggapi tren topik hari ini, <u><a href="{{url('trend')}}" style="color:white">klik disini</a></u></span>' +
          '</div>' +
          '</div>'
        );
      },
      error: function() {
        resultContainer.html(
          '<div class="col s12 m7">' +
          '<div class="card red darken-1">' +
          '<div class="card-content white-text">' +
          '<p><i class="fas fa-book"></i> Mohon maaf terjadi kesalahan, silahkan coba lagi!</p>' +
          '</div>' +
          '</div>' +
          '</div>'
        );
        resultContainer.fadeIn(600);
      }
    });
  }

  function updateFollowersView()
  {
    var spinner =
    '<div class="col s12 m6">' +
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
    '</div>' +
    '</div>';
    var resultContainer = $('#followersCard');
    resultContainer.hide();
    resultContainer.html(spinner);
    resultContainer.fadeIn(500);
    $.ajax({
      type: 'GET',
      url: '{{ url('/dashboard/showFollowers') }}',
      data: '_token = {{ csrf_token() }}',
      success: function(data) {
        var avgFollowersComp = (data.response.avgFollowersComp !== 'null') ?
        '<center class="activator"><span style="font-size:30px;color:#F49227;">' + data.response.avgFollowersComp + '</span><span style="font-size:10px;color:#F49227;"> followers/hari</span></center>' :
        '<center class="activator"><span style="font-size:14px;color:#F49227;">Kompetitor tidak ditemukan</span></center>';

        resultContainer.html(
          '<div class="col s12 m6">' +
          '<div class="card">' +
          '<div class="card-content" style="background-color:#27c24c">' +
          '<h5 class="white-text activator card-title" style="font-size:14px;font-weight:200">Rata-Rata Mendapatkan Followers<i class="fas fa-users right"></i></h5>' +
          '<hr>' +
          '<center class="activator"><span style="font-size:30px;color:white;">' + data.response.avgFollowers + '' +
          '</span><span style="font-size:10px;color:white;"> followers/hari</span></center>' +
          '</div>' +
          '<div class="card-reveal">' +
          '<h5 class="black-text card-title" style="font-size:14px;font-weight:200">Kompetitor<i class="fas fa-users right"></i></h5>' +
          '<hr>' +
          avgFollowersComp +
          '</div>' +
          '</div>' +
          '</div>'
        );
      },
      error: function() {
        resultContainer.html(
          '<div class="col s12 m6">' +
          '<div class="card red darken-1">' +
          '<div class="card-content white-text">' +
          '<p><i class="fas fa-book"></i> Mohon maaf terjadi kesalahan, silahkan coba lagi!</p>' +
          '</div>' +
          '</div>' +
          '</div>'
        );
        resultContainer.fadeIn(600);
      }
    });
}

function updatePostingView()
{
  var spinner =
  '<div class="col s12 m6">' +
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
  '</div>' +
  '</div>';
    var resultContainer = $('#postingCard');
    resultContainer.hide();
    resultContainer.html(spinner);
    resultContainer.fadeIn(500);
    $.ajax({
      type: 'GET',
      url: '{{ url('/dashboard/showPosting') }}',
      data: '_token = {{ csrf_token() }}',
      success: function(data) {
        var avgPostingComp = (data.response.avgPostsComp !== 'null') ?
        '<center class="activator"><span style="font-size:30px;color:#F49227;">' + data.response.avgPostsComp + '</span><span style="font-size:10px;color:#F49227;"> tweet/hari</span></center>' :
        '<center class="activator"><span style="font-size:14px;color:#F49227;">Kompetitor tidak ditemukan</span></center>';

        resultContainer.html(
          '<div class="col s12 m6">' +
          '<div class="card">' +
          '<div class="card-content" style="background-color:#23b7e5">' +
          '<h5 class="white-text activator card-title" style="font-size:14px;font-weight:200">Rata-Rata Posting<i class="fab fa-twitter right"></i></h5>' +
          '<hr>' +
          '<center class="activator"><span style="font-size:30px;color:white;">' + data.response.avgPosts + '' +
          '</span><span style="font-size:10px;color:white;"> tweet/hari</span></center>' +
          '</div>' +
          '<div class="card-reveal">' +
          '<h5 class="black-text card-title" style="font-size:14px;font-weight:200">Kompetitor<i class="fab fa-twitter right"></i></h5>' +
          '<hr>' +
          avgPostingComp +
          '</div>' +
          '</div>' +
          '</div>'
        );
      },
      error: function() {
        resultContainer.html(
          '<div class="col s12 m6">' +
          '<div class="card red darken-1">' +
          '<div class="card-content white-text">' +
          '<p><i class="fas fa-book"></i> Mohon maaf terjadi kesalahan, silahkan coba lagi!</p>' +
          '</div>' +
          '</div>' +
          '</div>'
        );
        resultContainer.fadeIn(600);
      }
    });

}

  function updateRetweetView()
  {
    var spinner =
    '<div class="col s12 m6">' +
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
    '</div>' +
    '</div>';
    var resultContainer = $('#retweetCard');
    resultContainer.hide();
    resultContainer.html(spinner);
    resultContainer.fadeIn(500);
    $.ajax({
      type: 'GET',
      url: '{{ url('/dashboard/showRetweet') }}',
      data: '_token = {{ csrf_token() }}',
      success: function(data) {
        var avgRetweetComp = (data.response.avgRetweetsComp !== 'null') ?
        '<center class="activator"><span style="font-size:30px;color:#F49227;">' + data.response.avgRetweetsComp + '</span><span style="font-size:10px;color:#F49227;"> Retweet/hari</span></center>' :
        '<center class="activator"><span style="font-size:14px;color:#F49227;">Kompetitor tidak ditemukan</span></center>';

        resultContainer.html(
          '<div class="col s12 m4">' +
          '<div class="card">' +
          '<div class="card-content" style="background-color:#6254b2">' +
          '<h5 class="white-text activator card-title" style="font-size:14px;font-weight:200">Rata-Rata Retweet<i class="fas fa-retweet right"></i></h5>' +
          '<hr>' +
          '<center class="activator"><span style="font-size:30px;color:white;">' + data.response.avgRetweets + '' +
          '</span><span style="font-size:10px;color:white;"> Retweet/hari</span></center>' +
          '</div>' +
          '<div class="card-reveal">' +
          '<h5 class="black-text card-title" style="font-size:14px;font-weight:200">Kompetitor<i class="fas fa-retweet right"></i></h5>' +
          '<hr>' +
          avgRetweetComp +
          '</div>' +
          '</div>' +
          '</div>'
        );
      },
      error: function() {
        resultContainer.html(
          '<div class="col s12 m4">' +
          '<div class="card red darken-1">' +
          '<div class="card-content white-text">' +
          '<p><i class="fas fa-book"></i> Mohon maaf terjadi kesalahan, silahkan coba lagi!</p>' +
          '</div>' +
          '</div>' +
          '</div>'
        );
        resultContainer.fadeIn(600);
      }
    });
  }

  function updateLikesView()
  {
    var spinner =
    '<div class="col s12 m6">' +
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
    '</div>' +
    '</div>';
    var resultContainer = $('#likesCard');
    resultContainer.hide();
    resultContainer.html(spinner);
    resultContainer.fadeIn(500);
    $.ajax({
      type: 'GET',
      url: '{{ url('/dashboard/showLikes') }}',
      data: '_token = {{ csrf_token() }}',
      success: function(data) {
        var avgLikesComp = (data.response.avgLikesComp !== 'null') ?
        '<center class="activator"><span style="font-size:30px;color:#F49227;">' + data.response.avgLikesComp + '</span><span style="font-size:10px;color:#F49227;"> Likes/hari</span></center>' :
        '<center class="activator"><span style="font-size:14px;color:#F49227;">Kompetitor tidak ditemukan</span></center>';

        resultContainer.html(
          '<div class="col s12 m4">' +
          '<div class="card">' +
          '<div class="card-content" style="background-color:#fad733">' +
          '<h5 class="white-text activator card-title" style="font-size:14px;font-weight:200">Rata-Rata Likes<i class="fas fa-heart right"></i></h5>' +
          '<hr>' +
          '<center class="activator"><span style="font-size:30px;color:white;">' + data.response.avgLikes + '' +
          '</span><span style="font-size:10px;color:white;"> Likes/hari</span></center>' +
          '</div>' +
          '<div class="card-reveal">' +
          '<h5 class="black-text card-title" style="font-size:14px;font-weight:200">Kompetitor<i class="fas fa-heart right"></i></h5>' +
          '<hr>' +
          avgLikesComp +
          '</div>' +
          '</div>' +
          '</div>'
        );
      },
      error: function() {
        resultContainer.html(
          '<div class="col s12 m4">' +
          '<div class="card red darken-1">' +
          '<div class="card-content white-text">' +
          '<p><i class="fas fa-book"></i> Mohon maaf terjadi kesalahan, silahkan coba lagi!</p>' +
          '</div>' +
          '</div>' +
          '</div>'
        );
        resultContainer.fadeIn(600);
      }
    });
  }

  function updateRepliesView()
  {
    var spinner =
    '<div class="col s12 m6">' +
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
    '</div>' +
    '</div>';
    var resultContainer = $('#repliesCard');
    resultContainer.hide();
    resultContainer.html(spinner);
    resultContainer.fadeIn(500);
    $.ajax({
      type: 'GET',
      url: '{{ url('/dashboard/showReplies') }}',
      data: '_token = {{ csrf_token() }}',
      success: function(data) {
        var avgRepliesComp = (data.response.avgRepliesComp !== 'null') ?
        '<center class="activator"><span style="font-size:30px;color:#F49227;">' + data.response.avgRepliesComp + '</span><span style="font-size:10px;color:#F49227;"> Replies/hari</span></center>' :
        '<center class="activator"><span style="font-size:14px;color:#F49227;">Kompetitor tidak ditemukan</span></center>';

        resultContainer.html(
          '<div class="col s12 m4">' +
          '<div class="card">' +
          '<div class="card-content" style="background-color:#ff6384">' +
          '<h5 class="white-text activator card-title" style="font-size:14px;font-weight:200">Rata-Rata Replies<i class="fas fa-reply right"></i></h5>' +
          '<hr>' +
          '<center class="activator"><span style="font-size:30px;color:white;">' + data.response.avgReplies + '' +
          '</span><span style="font-size:10px;color:white;"> Replies/hari</span></center>' +
          '</div>' +
          '<div class="card-reveal">' +
          '<h5 class="black-text card-title" style="font-size:14px;font-weight:200">Kompetitor<i class="fas fa-reply right"></i></h5>' +
          '<hr>' +
          avgRepliesComp +
          '</div>' +
          '</div>' +
          '</div>'
        );
      },
      error: function() {
        resultContainer.html(
          '<div class="col s12 m4">' +
          '<div class="card red darken-1">' +
          '<div class="card-content white-text">' +
          '<p><i class="fas fa-book"></i> Mohon maaf terjadi kesalahan, silahkan coba lagi!</p>' +
          '</div>' +
          '</div>' +
          '</div>'
        );
        resultContainer.fadeIn(600);
      }
    });
  }
  </script>
@endsection
