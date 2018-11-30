<?php

$activeNav = [
    'dashboard' => '',
    'compare' => '',
    'trends' => '',
    'engage' => ''
];

$activeNav[Request::route()->getName()] = 'active';
?>

<nav style="background: linear-gradient(to right, #434343, #000000);">
    <div class="nav-wrapper">
      <a href="#" class="brand-logo">Momment</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="engage" style="border-radius:50%;"><i class="fas fa-user-tie"></i></a></li>
        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('compare') }}">Compare</a></li>
        <li><a href="{{ route('trends') }}">Trends</a></li>
        <li><a href="{{ route('logout') }}">Logout</a></li>
      </ul>
    </div>
  </nav>

  {{-- background: #000000;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #434343, #000000);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #434343, #000000); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */ --}}


{{-- <nav style="background-color: #871145;">
    <div class="nav-wrapper">

        <ul id="nav-mobile" class="left">
            <li><a href="#" id="toggle-sidenav" data-activates="slide-out"><i class="material-icons">menu</i></a></li>
        </ul>
        <ul class="right">
          <li><a class="btn-floating pulse yellow" id="icon-nav" href="{{url('/insight')}}"><i class="material-icons" style="font-size: 28px;border-radius:50%;background-color:white ;color:#871145;">lightbulb_outline</i></a></li>
      </ul>
      <center><a href="#" class="brand-logo"><img src="{{ asset('images/logo-mysights-white.png') }}" style="height: 35px; margin: 10px 0px;"></a></center>
    </div>
</nav> --}}


{{-- <nav style="background-color: #871145;">
    <div class="nav-wrapper">

        <ul id="nav-mobile" class="left">
          <li>
              <a href="{{ route('engage') }}" class="right"><h4><i class="fab fa-twitter fa-s"></i></h4></a>
          </li>
          <li>
              <a href="{{ route('dashboard') }}" class="{{ $activeNav['dashboard'] }}"><h4>Dashboard</h4></a>
          </li>
          <li>
              <a href="{{ route('compare') }}" class="{{ $activeNav['compare'] }}"><h4 class="m-t-0">Compare</h4></a>
          </li>
          <li>
              <a href="{{ route('trends') }}" class="{{ $activeNav['trends'] }}"><h4 class="m-t-0">Trending</h4></a>
          </li>
          <li>
              <a href="{{ route('logout') }}" class="right"><h4 class="m-t-0">Logout</h4></a>
          </li>
        </ul>
    </div>
</nav> --}}


{{-- <nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars" style="display: block;"></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <a href="{{ route('engage') }}" class="right"><h4 class="m-t-0"><i class="fab fa-twitter fa-s"></i></h4></a>
                </li>
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ $activeNav['dashboard'] }}"><h4 class="m-t-0">Dashboard</h4></a>
                </li>
                <li>
                    <a href="{{ route('compare') }}" class="{{ $activeNav['compare'] }}"><h4 class="m-t-0">Compare</h4></a>
                </li>
                <li>
                    <a href="{{ route('trends') }}" class="{{ $activeNav['trends'] }}"><h4 class="m-t-0">Trending</h4></a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" class="right"><h4 class="m-t-0">Logout</h4></a>
                </li>
            </ul>
        </div>
    </div>
</nav> --}}
