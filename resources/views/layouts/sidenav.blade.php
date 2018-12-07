<?php
$display = 'none';
$color = 'grey !important';
if (Auth::user()->twitterAccount)
{
  $display = '';
  $color = '';
}
?>

  <ul id="slide-out" class="sidenav">
    <li><div class="user-view">
      <div class="background">
        <img src="images/bg2.jpg">
      </div>
      <h4 class="white-text">Momment</h4>
      <span class="white-text name">Vasha Farisi</span>
      <span class="white-text email">vashafarisi@momment.com</span>
    </div>
  </li>
    <li><a href="engage"><i class="fas fa-user-tie"></i>Akun Twitter</a></li>
    <li><div class="divider"></div></li>
    <li><a href="{{ route('dashboard') }}" style="display:{{$display}}"><i class="fas fa-columns"></i>Dashboard</a></li>
    <li><a href="{{ route('compare') }}" style="display:{{$display}}"><i class="fas fa-balance-scale"></i>Komparasi</a></li>
    <li><a href="{{ route('trends') }}" style="display:{{$display}}"><i class="fas fa-chart-line"></i>Tren Topik Twitter</a></li>
    <li><div class="divider"></div></li>
    <li><a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
  </ul>
  <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>


  {{-- <ul id="nav-mobile" class="right hide-on-med-and-down">
    <li><a href="engage" style="border-radius:50%;"><i class="fas fa-user-tie"></i></a></li>

    <li><a class="{{$display}}"href="{{ route('compare') }}" style="background-color:{{$color}}">Compare</a></li>
    <li><a class="{{$display}}"href="{{ route('trends') }}" style="background-color:{{$color}}">Trends</a></li>
    <li><a href="{{ route('logout') }}">Logout</a></li>
  </ul> --}}
