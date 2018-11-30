@extends('layouts.main-auth')

@section('content')
    <div id="register" class="row tab-body">
        <form class="col m12" method="post" action="{{ url('/register') }}" role="form">
            @csrf
            <div class="form-container">
                <p class="text" style="color: #5F0F4E; font-size: 20px;">Daftar Akun</p>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="name" type="text" class="validate" name="name" required autofocus>
                        <label for="name">Nama Lengkap</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="email" type="email" class="validate" name="email" required>
                        <label for="email">E-mail</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="password" type="password" class="validate" name="password" required>
                        <label for="password">Password</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="confirm-password" type="password" class="validate" name="confirm-password" required>
                        <label for="confirm-password">Konfirmasi Password</label>
                    </div>
                </div>
                <a href="{{url('/login') }}" style="position:absolute; bottom:30px; left:30px;">Login Disini</a>
                {{-- <button class="btn waves-effect waves-light"
                        style="position:absolute; bottom:30px; left:30px">Register</button> --}}
                <button class="btn waves-effect waves-light" type="submit" name="action"
                        style="background-color: #5F0F4E; position: absolute; bottom: 30px; right: 30px;"> Daftar
                </button>
            </div>
        </form>
    </div>
@endsection
