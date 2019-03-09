@extends('layouts.main-auth')

@section('content')
  <div id="register" class="row tab-body">
    <form class="col m12" method="post" action="{{ url('/register') }}" role="form">
      @csrf
      <div class="form-container">
        @if(!Session::has('register-error'))
          <p class="text" style="color: #5F0F4E; font-size: 20px;">Daftar Akun</p>
        @endif
        <div class="row" style="margin-bottom:0">
          <div class="input-field col s12">
            <input id="name" type="text" class="validate" name="name" required oninvalid="this.setCustomValidity('Silahkan isi field ini terlebih dahulu')" oninput="setCustomValidity('')" autofocus>
            <label for="name">Nama Lengkap</label>
          </div>
          <div class="input-field col s12">
            <input id="email" type="email" class="validate" name="email" required oninvalid="this.setCustomValidity('Silahkan isi field ini terlebih dahulu')" oninput="setCustomValidity('')">
            <label for="email">E-mail</label>
          </div>
          <div class="input-field col s12">
            <input id="password" type="password" class="validate" name="password" required oninvalid="this.setCustomValidity('Silahkan isi field ini terlebih dahulu')" oninput="setCustomValidity('')">
            <label for="password">Password</label>
          </div>
          <div class="input-field col s12">
            <input id="confirm-password" type="password" class="validate" name="confirm-password" required oninvalid="this.setCustomValidity('Silahkan isi field ini terlebih dahulu')" oninput="setCustomValidity('')">
            <label for="confirm-password">Konfirmasi Password</label>
          </div>
        </div>
        @if(Session::has('register-error'))
          <div class="card red darken-1">
            <div class="card-content white-text">
              <p><i class="fas fa-book"></i> {{ Session::get('register-error') }}</p>
            </div>
          </div>
        @endif
        <div class="row">
          <div class="col s3">
            <a href="{{url('/login') }}" style="">Login Disini</a>
          </div>
          <div class="col s3 offset-s6">
            <button class="btn waves-effect waves-light" type="submit" name="action"
            style="background-color: #5F0F4E; "> Daftar
          </button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
