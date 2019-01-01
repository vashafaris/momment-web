<?php
$display = 'none';
$color = 'grey !important';
$account = '';
if (Auth::user()->twitterAccount)
{
  $display = '';
  $color = '';
  $account = 'none';
}
?>
<div class="navbar-fixed">
<nav style="background-color:white">

  <div class="nav-wrapper">
    <a href="#" id="header" class="brand-logo" style="font-weight:200;color:black;position:absolute;left:320px;top:3px"></a>
    <ul id="nav-mobile" class="right">
        <a class="twitter-hashtag-button" href="https://twitter.com/intent/tweet"><i class="fab fa-twitter"></i>Tweet</a>
        <a style="color:black;position:absolute;left:5px;top:3px" href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </ul>
  </div>



</nav>
</div>
  <ul id="slide-out" class="sidenav sidenav-fixed" style="background-color: #3a3f51">
    {{-- <li><div class="user-view" style="background: linear-gradient(to right, #c94b4b, #4b134f);"> --}}
      <li><div class="user-view" >
      {{-- <div class="background" style="background-size:cover">
        <img src="images/bg2.jpg">
      </div> --}}
      <h4 class="white-text">Momment</h4>
      <span class="white-text name">{{Auth::user()->name}}</span>
      <span class="white-text email">{{Auth::user()->email}}</span>
    </div>
  </li>
    <li><div class="divider"></div></li>
    <li><a href="{{ route('engage')}}" style="display:{{$account}}; color:#b4b6bd"><i class="fas fa-user-tie" style="color:white"></i>Akun Twitter</a></li>
    <li><a href="{{ route('dashboard') }}" style="display:{{$display}};color:#b4b6bd" ><i class="fas fa-columns" style="color:white"></i>Dashboard</a></li>
    <li><a href="{{ route('compare') }}" style="display:{{$display}};color:#b4b6bd" ><i class="fas fa-balance-scale" style="color:white"></i>Komparasi</a></li>
    <li><a href="{{ route('trends') }}" style="display:{{$display}};color:#b4b6bd" ><i class="fas fa-chart-line" style="color:white"></i>Tren Topik Twitter</a></li>
    <li><div class="divider"></div></li>
    <li><a href="{{ route('logout') }}" style="color:#b4b6bd"><i class="fas fa-sign-out-alt" style="color:white"></i>Logout</a></li>
  </ul>
