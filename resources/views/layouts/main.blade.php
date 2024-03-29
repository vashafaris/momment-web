<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Momment</title>

  {!! MaterializeCSS::include_full() !!}
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  @yield('custom-style')
  <style>
  .side-nav li.active * {
    color: #871145 !important;
  }

  .side-nav li.active li#good * {
    color: #5cb85c !important;
  }

  .side-nav li.active li#bad * {
    color: #d9534f !important;
  }

  #loading-screen .modal-content {
    background: url('{{ asset('images/loading-screen.gif') }}');
    height: 300px;
    background-size: contain;
    background-repeat: no-repeat;
    background-color: #871145;
    background-position: center;
    display: flex;
  }

  #loading-screen .modal-content span {
    font-size: 12pt;
    font-weight: bold;
    margin: auto auto 0;
  }
  a.disabled{
    pointer-events: none;
    cursor: default;
  }


  .wrapper {
    padding-left: 300px;
  }

  @media only screen and (max-width : 992px) {
    .wrapper{
      padding-left:0;
    }
  }
  </style>
</head>
<body style="background-color: #f0f3f4;{{-- padding-bottom: 125px;--}}">


  @include('layouts.sidenav')
  <div class="wrapper">
    @yield('content')
  </div>
  {{-- @include('layouts.footer') --}}
  @yield('custom-script')
  @yield('custom-subs-script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/highcharts-more.js"></script>
  <script src="https://code.highcharts.com/modules/heatmap.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/wordcloud.js"></script>
  <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
  {{-- <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script> --}}
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
  <script>
  $(document).ready(function(){
    $('.sidenav').sidenav();
  });
  </script>
<script src="{{ asset('js/formatter.js') }}"></script>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
</body>
</html>
