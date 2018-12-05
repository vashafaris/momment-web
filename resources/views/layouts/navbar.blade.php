<?php

// $activeNav = [
//     'dashboard' => '',
//     'compare' => '',
//     'trends' => '',
//     'engage' => ''
// ];
//
// $activeNav[Request::route()->getName()] = 'active';
$display = 'disabled';
$color = 'grey !important';
if (Auth::user()->twitterAccount)
{
  $display = '';
  $color = '';
}
?>

<nav style="background: linear-gradient(to right, #434343, #000000);">
    <div class="nav-wrapper">
      <a href="#" class="brand-logo">Momment</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="engage" style="border-radius:50%;"><i class="fas fa-user-tie"></i></a></li>
        <li><a class="{{$display}}"href="{{ route('dashboard') }}" style="background-color:{{$color}}">Dashboard</a></li>
        <li><a class="{{$display}}"href="{{ route('compare') }}" style="background-color:{{$color}}">Compare</a></li>
        <li><a class="{{$display}}"href="{{ route('trends') }}" style="background-color:{{$color}}">Trends</a></li>
        <li><a href="{{ route('logout') }}">Logout</a></li>
      </ul>
    </div>
  </nav>
