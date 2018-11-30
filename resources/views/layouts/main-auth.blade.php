<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Momment</title>
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>

        html {
            height: 100%;
        }

        @media (min-width: 400px) {
            .container {
                margin-top: 70px;
                width: 400px;
            }

            .container-logo {
                width: 400px;
                margin-top: 20px;
                margin-left: auto !important;
                margin-right: auto !important;
            }
        }

        @media (max-width: 400px) {
            .container {
                margin-top: 15px;
            }
        }

        .container {
            background-color: rgba(255, 255, 255, 0.4);
        }

        .intro-container, .container {
            margin-top: 30px !important;
        }

        .container-logo {
            margin-bottom: 5px !important;
        }

        .tab-body {
            background-color: white;
            margin: 0 !important;
            min-height: 500px;
        }

        .col {
            padding: 0 !important;
        }

        .tabs .indicator {
            background: color(#5F0F4E alpha(75%) blackness(20%));
            height: 60px;
            opacity: 0.3;
        }

        .tab-body form {
            height: 500px;
        }

        .form-container {
            padding: 40px;
            padding-top: 10px;
            position: relative;
            height: 100%;
        }

        .vertical-divider {
            border-right: 2px solid #AAAAAA;
        }

        /* label color */
        .input-field label {
            color: #5F0F4E !important;
        }

        /* label focus color */
        .input-field input[type=text]:focus + label {
            color: #5F0F4E !important;
        }

        /* label underline focus color */
        .input-field input[type=text]:focus {
            border-bottom: 1px solid #5F0F4E !important;
            box-shadow: 0 1px 0 0 #5F0F4E !important;
        }

        #background {
            position: fixed;
            z-index: -1;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{asset('images/auth-background.jpg')}}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        img.company-logo {
            max-width: 75px;
            display: inline;
            vertical-align: middle;
            margin: 0 5px;
        }

        .white-text {
            font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: white;
        }
    </style>
</head>
<body>
<div id="background"></div>
<div class="row" style="margin-bottom: 0px;">
    <div class="col m12">
        <h3 class="center white-text">Momment</h3>
        <div class="container z-depth-2">
            @yield('content')
        </div>
    </div>
</div>
<!-- Jquery Core Js -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
<script>
    $(document).ready(function () {
        localStorage.removeItem('credential')
        $('.tabs').tabs();
        $('#login button').not('.disabled').on('click', function () {
            if (
                $('#login input[name="email"]').val() != '' &&
                $('#login input[name="password"]').val() != ''
            ) {
                // startLoading(function () {
                //     $('#loading-screen').modal('open');
                // });
            }
        });

        $('#register button').not('.disabled').on('click', function (event) {
            if (
                $('#register input[name="password"]').val() != ''
            ) {
                if ($('#register input[name="password"]').val() == $('#register input[name="confirm-password"]').val()) {
                    // startLoading(function () {
                    //     $('#loading-screen').modal('open');
                    // });
                } else {
                    event.preventDefault();
                    $('#register input[name="confirm-password"]')
                        .siblings('.helper-text')
                        .attr('data-error', 'Password tidak sesuai');
                    $('#register input[name="confirm-password"]').addClass('invalid');
                }
            }
        });
    });
</script>
</body>
</html>
