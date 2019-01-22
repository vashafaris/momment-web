@extends('layouts.main')

@section('content')
  <section>
    <div class="row">
      <div class="col s12 m12">

        {{-- <div class="card-panel background-none z-depth-0">
        <h5 class="black-text" style="font-weight:200">Profil Akun Twitter</h5>
        <hr>
        <div id="search-result">

      </div>
    </div> --}}

    <div id="competitor-container" style="display:none">


      <div class="card-panel background-none z-depth-0">
        <h5 class="black-text">Daftar Kompetitor</h5>
        <hr>
        <ul class="collection with-header">
          @if(count($competitors) > 0)
            @foreach($competitors as $competitor)
              <li class="collection-item avatar">
                <input type="hidden" value="{{ $competitor->screen_name }}">
                <img src="{{$competitor->photo_url}}" class="center" style="position:absolute;height: 50px;width: 50px;object-fit: cover;border: 2px solid white;border-radius: 50%;top: 15px;left: 15px;">
                <span class="title">{{$competitor->name}}</span>
                <p style="color:grey">@<?php echo $competitor->screen_name?></p>
                <a href="{{url('compare/id/' . $competitor->twitter_id)}}" class="waves-effect waves-light btn secondary-content" style="background-color:#1b95e0"><i class="material-icons left">info_outline</i>Detail</a>
                <a class="waves-effect waves-light btn modal-trigger red secondary-content delete-confirmation" id="{{$competitor->twitter_id}}"  href="#modal1" style="right:150px"><i class="material-icons left">delete</i>Hapus</a>
              </li>
            @endforeach
          @else
            <li class="collection-header center"><h6>Kompetitor Tidak Ditemukan!</h6></li>
          @endif
        </ul>

        {{-- <div id="search-result">

      </div> --}}
      <!-- Modal Trigger -->


        <!-- Modal Structure -->
        <div id="modal1" class="modal">
          <div class="modal-content">
            <p>Apakah anda yakin untuk menghapus kompetitor ?</p>
          </div>
          <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-red btn-flat">Tidak</a>
            <a href="#!" class="modal-close waves-effect waves-green btn-flat delete-competitor">Ya</a>
          </div>
        </div>
    </div>
  </div>

  <div id="competitor-compare">

  </div>

  <div id="add-competitor-container" style="display:none">
    <div class="card-panel background-none z-depth-0">
      <h5 class="black-text">Tambahkan Kompetitor</h5>
      <hr>
      <div class="row z-depth-1" style="background-color:white;margin-left:0px;margin-right:0px">
        <div class="input-field col s10 m10 l11">
          <i class="material-icons prefix ">account_circle</i>
          <input id="username-twitter" type="text" class="validate" >
          <label for="icon_prefix">Username Twitter</label>
        </div>
        <div class="col s2 m2 l1">
          <div class="waves-effect waves-light btn" id="btn-search" onCLick="search()" style="margin-top:20px;"><i class="fas fa-search" style="color:white;"></i></div>
        </div>
      </div>
      <div id="search-result">

      </div>
    </div>

  </div>

</div>
</div>
<div id="btn-to-add" class="fixed-action-btn" style="bottom: 50px; right: 50px;">
  <a onClick="btnAdd()" class="btn-floating btn waves-effect waves-light red modal-trigger" style="font-size:30px"><i class="material-icons">add</i></a>
</div>
<div id="btn-to-compare" class="fixed-action-btn" style="bottom: 50px; right: 50px; display:none">
  <a onClick="btnCompare()" class="btn-floating btn waves-effect waves-light red modal-trigger" style="font-size:30px"><i class="material-icons">list</i></a>
</div>
</section>
@endsection

@section('custom-style')
  <style>
  .vertical-divider {
    border-right: 1px solid #DDDDDD;
  }

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
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 1)), url('{{asset('images/bg4.jpg')}}');
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

  /* label focus color */
  .input-field input[type=text]:focus + label {
    color: black;
  }
  /* label underline focus color */
  .input-field input[type=text]:focus {
    border-bottom: 1px solid black;
    box-shadow: 0 1px 0 0 black;
  }

  </style>
@endsection

@section('custom-script')
  <script>

  $('.delete-confirmation').on('click', function () {
    var selectedObj = $(this), resultContainer;
    // var id = $(selectedObj).parentElement();
    competitor_id = selectedObj[0].id;
    console.log(selectedObj[0].id);
    console.log("testing");
    $('.delete-competitor').on('click', function () {
      console.log(competitor_id);
      $.ajax({
        type: 'GET',
        url: '{{ url('/compare/delete') . '/' }}' + competitor_id,
        data: '_token = {{ csrf_token() }}',
        success: function (data) {
          console.log(data);
          if (data.status === 200) {
            $('.modal1').modal();
            $('#delete-confirmation .modal-content3').html('<center><p>Competitor deleted</p></center>');
            $('#delete-confirmation #delete-confirmation-yes').hide();
            $('#delete-confirmation #delete-confirmation-no').html('OK');
            $('#delete-confirmation').modal('open');
            window.location.reload();
          } else {
            $('.modal1').modal();
            $('#delete-confirmation .modal-content3').html('<p>Im sorry, the wizard might be sick, try again later.</p>');
            $('#delete-confirmation #delete-confirmation-yes').hide();
            $('#delete-confirmation #delete-confirmation-no').html('OK');
            $('#delete-confirmation').modal('open');
            window.location.reload();
          }
        },
        error: function () {
          $('.modal1').modal();
          $('#delete-confirmation .modal-content3').html('<p>Im sorry, the wizard might be sick, try again later.</p>');
          $('#delete-confirmation #delete-confirmation-yes').hide();
          $('#delete-confirmation #delete-confirmation-no').html('OK');
          $('#delete-confirmation').modal('open');
          window.location.reload();
        }
      });
    });
  });

  $(document).ready(function(){
    document.getElementById("header").innerHTML = "Kompetitor";
    $('#competitor-container').fadeIn(500);
    $('#btn-to-compare').hide();
    $('.modal').modal();
    $('.tabs').tabs();

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
  });

  function btnAdd() {
    $("#competitor-container").hide();
    $("#btn-to-add").hide();
    $("#add-competitor-container").fadeIn(500);
    $("#btn-to-compare").fadeIn(500);
  }

  function btnCompare() {
    $("#add-competitor-container").hide();
    $("#btn-to-compare").hide();
    $("#competitor-container").fadeIn(500);
    $("#btn-to-add").fadeIn(500);
  }

  function search() {
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
      url: '{{ url('/compare/search') }}' + '/' + $('#username-twitter').val(),
      data: '_token = {{ csrf_token() }}',
      success: function(data) {
        switch (data.status) {
          case 200:
          if (data.response.profile != null) {
            var banner = (data.response.profile[0].banner_url !== null) ?
            'style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4)), url(\'' + data.response.profile[0].banner_url + '\');height: 200px;width: 100%;background-size: cover;background-position: center;"' :
            'style="background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.4)), url(\'{{ asset('images/default -background.jpg ') }}\');height: 200px;width: 100%;background-size: cover;background-position: center;"';
            var photo = (data.response.profile[0].photo_url !== null) ?
            '<img src="' + data.response.profile[0].photo_url + '" style="height: 64px;width: 64px;object-fit: cover;border: 2px solid white;position: absolute;border-radius: 50%;top: 70px;left: 24px;">' :
            '<img src="{{ asset('images/default -photo.png ') }}" style="height: 64px;width: 64px;object-fit: cover;border: 2px solid white;position: absolute;border-radius: 50%;top: 70px;left: 24px;">';
            var location = (data.response.profile[0].location !== null) ?
            '<div class="divider" style="margin: 10px 0;"></div>' +
            '<span style="font-size: 10pt;margin: 10px 0;"><i class="fas fa-map-marker-alt"></i> &nbsp; ' + data.response.profile[0].location + '</span>' :
            '';
            var since = (data.response.profile[0].created !== null) ?
            '<div class="divider" style="margin: 10px 0;"></div>' +
            '<span style="font-size: 10pt;margin: 10px 0;"><i class="far fa-calendar-alt"></i> &nbsp; Terdaftar Sejak ' + formatDate(new Date(data.response.profile[0].created)) + '</span>' :
            '';
            var engageButton = (!data.response.isEngage) ?
            '<center><a class="waves-effect waves-light btn modal-trigger" href="#engage-modal" style="background-color: #5F0F4E;"><i class="material-icons left">add</i> Tambahkan Kompetitor</a></center>' :
            '<center><a class="waves-effect waves-light btn modal-trigger disabled" href="#engage-modal" style="background-color: #5F0F4E;"><i class="material-icons left">close</i> Kompetitor</a></center>'

            resultContainer.html(
              '<div class="card white card-profile">' +
              '<div class="card-image" ' + banner + '>' +
              photo +
              '<span class="card-title">' + data.response.profile[0].name + '</span>' +
              '<span class="card-title" style="font-size: 9pt;top: 145px;">@' + data.response.profile[0].screen_name + '</span>' +
              '</div>' +
              '<div class="card-content">' +
              '<blockquote style="font-size: 10pt; margin-top: 5px;"><i class="fas fa-quote-right fa-xs"></i> ' + data.response.profile[0].description + ' <i class="fas fa-quote-left fa-xs"></i></blockquote>' +
              '<div class="divider" style="margin: 10px 0;"></div>' +
              '<div class="row" style="margin-bottom: 0px !important;">' +
              '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
              '<span style="font-weight: bold;">Tweet</span><br/>' +
              '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.profile[0].statuses_count) + '</span>' +
              '</div>' +
              '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
              '<span style="font-weight: bold;">Followers</span><br/>' +
              '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.profile[0].followers_count) + '</span>' +
              '</div>' +
              '<div class="col s4" style="text-align: center;font-size: 10pt;">' +
              '<span style="font-weight: bold;">Following</span><br/>' +
              '<span style="color: #F49227;font-size: 12pt;font-weight: bold;">' + formatBigNumber(data.response.profile[0].friends_count) + '</span>' +
              '</div>' +
              '</div>' +
              location +
              since +
              '<div class="divider" style="margin: 10px 0;"></div>' +
              engageButton +
              '<div id="engage-modal" class="modal">' +
              '<div class="modal-content">' +
              '<p>Tambahkan ' + data.response.profile[0].name + ' sebagai kompetitor anda ?</p>' +
              '</div>' +
              '<div class="modal-footer">' +
              '<a href="#!" id="add-confirmation-yes" class="modal-close modal-action waves-effect waves-green btn-flat">Ya</a>' +
              '<a href="#!" id="add-confirmation-no" class="modal-close waves-effect waves-red btn-flat">Tidak</a>' +
              '</div>' +
              '</div>' +
              '</div>' +
              '</div>'
            );

            // Action Button
            if (!data.response.isEngage) {
              $('.modal').modal();
            }
            $('#search-result .btn').on('click', function() {
              var addButton = $(this);
              $('#add-confirmation-yes').on('click', function() {
                $.ajax({
                  type: 'GET',
                  url: '{{ url('/compare/add') }}' + '/' + (data.response.profile[0].screen_name),
                  data: '_token = {{ csrf_token() }}',
                  success: function(data) {
                    if (data.status === 200) {
                      $('.modal').modal();
                      $('#add-confirmation .modal-content').html('<p>Berhasil Menambahkan Kompetitor</p>');
                      $('#add-confirmation #add-confirmation-yes').hide();
                      $('#add-confirmation #add-confirmation-no').html('OK');
                      $('#add-confirmation').modal('open');
                      addButton.html('<i class="material-icons left">close</i> Berhasil Menambahkan Kompetitor');
                      addButton.addClass('disabled');
                      window.location.reload();
                    } else {
                      $('.modal').modal();
                      $('#add-confirmation .modal-content').html('<p>Gagal Menambahkan Kompetitor');
                      $('#add-confirmation #add-confirmation-yes').hide();
                      $('#add-confirmation #add-confirmation-no').html('OK');
                      $('#add-confirmation').modal('open');
                    }
                  },
                  error: function() {
                    $('.modal').modal();
                    $('#add-confirmation .modal-content').html('<p>Gagal Menambahkan Kompetitor</p>');
                    $('#add-confirmation #add-confirmation-yes').hide();
                    $('#add-confirmation #add-confirmation-no').html('OK');
                    $('#add-confirmation').modal('open');
                  }
                });
              });
            });
          } else {
            // Not found
            resultContainer.html(
              '<div class="card red darken-1">' +
              '<div class="card-content white-text">' +
              '<p><i class="fas fa-book"></i> Mohon maaf akun ' + $('#username-twitter').val() + ' tidak ditemukan !</p>' +
              '</div>' +
              '</div>'
            );
          }
          break;
          case 401:
          resultContainer.html(
            '<div class="card red darken-1">' +
            '<div class="card-content white-text">' +
            '<p><i class="fas fa-book"></i> Im sorry, your spell is missing. Please try to re-login..</p>' +
            '</div>' +
            '</div>'
          );
          break;
          case 404 :
          resultContainer.html(
            '<div class="card red darken-1">' +
            '<div class="card-content white-text">' +
            '<p><i class="fas fa-book"></i> Im sorry, Data will available tomorrow</p>' +
            '</div>' +
            '</div>'
          );
          default:
          resultContainer.html(
            '<div class="card red darken-1">' +
            '<div class="card-content white-text">' +
            '<p><i class="fas fa-book"></i> Im sorry, magician might be sick. Trying to recover..</p>' +
            '</div>' +
            '</div>'
          );
          break;
        }
        resultContainer.fadeIn(600);
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
  }
  </script>
@endsection
