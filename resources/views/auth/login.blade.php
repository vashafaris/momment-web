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
                        <input id="email" type="text" class="validate" name="email" required autofocus>
                        <label for="email">E-mail</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="password" type="password" class="validate" name="password" required>
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
                <a href="{{url('/register') }}" style="position:absolute; bottom:30px; left:30px;">Daftar Akun Disini</a>
                {{-- <button class="btn waves-effect waves-light"
                        style="position:absolute; bottom:30px; left:30px">Register</button> --}}
                <button class="btn waves-effect waves-light" type="submit" name="action"
                        style="background-color: #5F0F4E; position: absolute; bottom: 30px; right: 30px;"><i
                            class="fas fa-sign-in-alt"></i> Login
                </button>
            </div>
        </form>
    </div>
@endsection
