<?php
$display = 'none';
$color = 'grey !important';
if (Auth::user()->twitterAccount)
{
  $display = '';
  $color = '';
}
?>
<nav style="background-color:black" class="right">
  {{-- <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
  <a href="https://twitter.com/intent/tweet" class="twitter-hashtag-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> --}}
  <div class="nav-wrapper">
    <a href="https://twitter.com/intent/tweet" class="twitter-hashtag-button brand-logo right" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
  </div>

</nav>
  <ul id="slide-out" class="sidenav sidenav-fixed">
    {{-- <li><div class="user-view" style="background: linear-gradient(to right, #c94b4b, #4b134f);"> --}}
      <li><div class="user-view" style="background-color: black">
      {{-- <div class="background" style="background-size:cover">
        <img src="images/bg2.jpg">
      </div> --}}
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

{{--
  <div id="container">

  <div id="menu">

    <ul id="slide-out" class="side-nav fixed">
      <li><a href="#!">First Sidebar Link</a></li>
      <li><a href="#!">Second Sidebar Link</a></li>
      <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Dropdown<i class="material-icons">arrow_drop_down</i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="#!">First</a></li>
                <li><a href="#!">Second</a></li>
                <li><a href="#!">Third</a></li>
                <li><a href="#!">Fourth</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>

  <div id="content">
    <a href="#" data-activates="slide-out" class="button-collapse hide-on-large-only"><i class="material-icons">menu</i></a>

    <h3>Simple Materialize Responsive Side Menu</h3>

    <p>Resize browser to see what it looks like in (a) brwoser (b) mobile devices</p>

  </div>

</div>  --}}
