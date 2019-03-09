@extends('layouts.main-auth')

@section('content')
  <div id="login" class="row tab-body">
    <form class="col m12" method="post" action="{{ url('/login') }}" role="form">
      @csrf
      <div class="form-container">
        <p class="text" style="color: #5F0F4E; font-size: 20px;">Login Akun</p>
        <br>
        <div class="row">
          <div class="input-field col s12">
            <input id="email" type="text" class="validate" name="email" required oninvalid="this.setCustomValidity('Silahkan isi field ini terlebih dahulu')" oninput="setCustomValidity('')" autofocus>
            <label for="email">E-mail</label>
          </div>
          <div class="input-field col s12">
            <input id="password" type="password" class="validate" name="password" required oninvalid="this.setCustomValidity('Silahkan isi field ini terlebih dahulu')" oninput="setCustomValidity('')">
            <label for="password">Password</label>
          </div>
        </div>
        @if(Session::has('login-error'))
          <div class="card red darken-1">
            <div class="card-content white-text">
              <p><i class="fas fa-book"></i> {{ Session::get('login-error') }}</p>
            </div>
          </div>
        @endif
        <div class="row bottom">
          <div class="col s6">
            <a href="{{url('/register') }}">Daftar Akun Disini</a>
          </div>
          <div class="col s3 offset-s3">
            <button class="btn waves-effect waves-light" type="submit" name="action"
            style="background-color: #5F0F4E;"><i
            class="fas fa-sign-in-alt"></i> Login
          </button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
