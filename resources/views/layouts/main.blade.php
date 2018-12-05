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
    </style>
</head>
<body style="background-color: #E0E0E0;{{-- padding-bottom: 125px;--}}">
    @php
    $navigation = isset($navigation) ? $navigation : true;
    @endphp

    @if($navigation)
        @include('layouts.navbar')
    @endif
    @yield('content')
    <div id="loading-screen" class="modal">
        <div class="modal-content">
            <span class="white-text">Please Wait ...</span>
        </div>
    </div>
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


    {{-- <script>
        $(document).ready(function() {
            $("#toggle-sidenav").sideNav();

            @if($navigation && isset($menu))
                $('{{ $menu }}').addClass('active');
                $('{{ $menu }} > a').attr('href', '#');
            @endif

            $('#loading-screen').modal({
                dismissible: false
            });

            $('ul.side-nav li a').not('.subheader').not('[href="#"]').on('click', function () {
                startLoading(function(){
                    $('#loading-screen').modal('open');
                });
            });
        });

        function startLoading(func) {
            setTimeout(func, 0);
        }
    </script> --}}
    <script src="{{ asset('js/formatter.js') }}"></script>
</body>
</html>
