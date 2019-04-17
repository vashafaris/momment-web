@extends('layouts.main')

@section('content')
  <section>
    <div class="row">
      <div class="col s12 m12">
        <div class="card-panel background-none z-depth-0">
          <h5>Akun Twitter</h5>
          <hr>
          <div class="row z-depth-1" style="background-color:white;margin-left:0px;margin-right:0px">
            <div class="input-field col s10 m10 l10">
              <i class="material-icons prefix " >account_circle</i>
              <input id="username-twitter" type="text" class="validate">
              <label for="icon_prefix" >Username Twitter</label>
            </div>
            <div class="col s2 m2 l2">
              <div class="waves-effect waves-light btn" id="btn-search" onCLick="search()" style="margin-top:20px;margin-left:20px"><i class="fas fa-search" style="color:white"></i></div>
            </div>
          </div>
          <div id="search-result">

          </div>
          <div id="user-account">

          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('custom-style')
  <style>

  /* label focus color */
  .input-field input[type=text]:focus + label {
    color: #000;
  }
  /* label underline focus color */
  .input-field input[type=text]:focus {
    border-bottom: 1px solid #000;
    box-shadow: 0 1px 0 0 #000;
  }

  #background {
    background-color:white;
  }

  .background-none {
    background: none;
  }

  </style>
@endsection

@section('custom-script')
  <script>

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
      url: '{{ url('/engage/search') }}' + '/' + $('#username-twitter').val(),
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
            '<center><a class="waves-effect waves-light btn modal-trigger" href="#engage-modal" style="background-color: #5F0F4E;"><i class="material-icons left">add</i> Tetapkan Akun</a></center>' :
            '<center><a class="waves-effect waves-light btn modal-trigger disabled" href="#engage-modal" style="background-color: #5F0F4E;"><i class="material-icons left">close</i> Akun Telah Terdaftar</a></center>'

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
              '<p>Tetapkan akun ' + data.response.profile[0].name + ' sebagai media sosial anda ?</p>' +
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
                console.log("masok");
                $.ajax({
                  type: 'GET',
                  url: '{{ url('/engage/account') }}' + '/' + (data.response.profile[0].screen_name),
                  data: '_token = {{ csrf_token() }}',
                  success: function(data) {
                    if (data.status === 200) {
                      $('.modal').modal();
                      $('#add-confirmation .modal-content').html('<p>Berhasil Menetapkan Akun</p>');
                      $('#add-confirmation #add-confirmation-yes').hide();
                      $('#add-confirmation #add-confirmation-no').html('OK');
                      $('#add-confirmation').modal('open');
                      addButton.html('<i class="material-icons left">close</i> Berhasil Menetapkan Akun');
                      addButton.addClass('disabled');
                      window.location.reload();
                    } else {
                      $('.modal').modal();
                      $('#add-confirmation .modal-content').html('<p>Gagal Menetapkan Akun');
                      $('#add-confirmation #add-confirmation-yes').hide();
                      $('#add-confirmation #add-confirmation-no').html('OK');
                      $('#add-confirmation').modal('open');
                    }
                  },
                  error: function() {
                    $('.modal').modal();
                    $('#add-confirmation .modal-content').html('<p>Gagal Menetapkan Akun</p>');
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
          default:
          resultContainer.html(
            '<div class="card red darken-1">' +
            '<div class="card-content white-text">' +
            '<p><i class="fas fa-book"></i> Mohon maaf akun ' + $('#username-twitter').val() + ' tidak ditemukan !</p>' +
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
          '<p><i class="fas fa-book"></i> Mohon maaf akun ' + $('#username-twitter').val() + ' tidak ditemukan !</p>' +
          '</div>' +
          '</div>'
        );
        resultContainer.fadeIn(600);
      }
    });
  }
  // }
  </script>
@endsection
