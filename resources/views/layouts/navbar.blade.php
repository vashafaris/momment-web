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
      <a href="#" class="brand-logo right">Momment</a>
      
    </div>
  </nav>
