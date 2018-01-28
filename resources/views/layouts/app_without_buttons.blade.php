<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rl.loc') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/skeleton-alerts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/easy-autocomplete.min.css') }}" rel="stylesheet">
    <link href="{{asset("css/modal.css")}}" rel="stylesheet">
    <link href="{{asset("css/style0.css")}}" rel="stylesheet">
    <script src="https://use.fontawesome.com/0eaf316cf8.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.easy-autocomplete.min.js') }}"></script>
</head>

<body>
<div class = "app">
    <!-- Exchenge -->
    <div id = "art-header">

        <div id ="art-logo">
            <a href="http://www.rl.kiev.ua"><img src="{{asset("img/RL.png")}}" href=""></a>


        </div>

        <div id = "h-c-b">
            <div id = "num_olimp">
                <center id = "number">@lang('fields.Olymp')</center>
                <center>@lang('fields.RL')</center>
                <center id = "reg">@lang('fields.Registration')</center>
            </div>
        </div>

        <div id = "admin">
            <ul>
                @guest
                    <li><a href="{{ route("login") }}">Login</a></li>
                @else
                    <li><a href="{{ route("home_single") }}">Home</a></li>
                @endguest
            </ul>
        </div>
        <div class = "clear"></div>

        <!-- From rl.kiev.ua -->
        <div class="rl-h-i">
            <div>
                <a href="http://www.rl.kiev.ua"><img src="http://www.rl.kiev.ua/wp-content/themes/rl/images/home.gif" width="25px" height="25px" border="0"></a>
            </div>
            <div>
                <a href="mailto:info@rl.kiev.ua"><img src="http://www.rl.kiev.ua/wp-content/themes/rl/images/mailto.gif" width="25px" height="25px" border="0"></a>
            </div>
            <br>


            <div class="site_lng">
                <a onclick="setUA()" style="cursor: pointer">Укр</a>
                |
                <a onclick="setRU()" style="cursor: pointer">Рус</a>
            </div>
        </div>
    </div>
</div>

<div class = "clear"></div>
<div id = "cform">
    <div class = "photo">
        <p><img src="{{asset("img/Olimp201500504.png")}}" alt=""></p>
        <p><img src="{{asset("img/Olimp201500264.png")}}" alt=""></p>
        <p><img src="{{asset("img/Olimp201500335.png")}}" alt=""></p>
        <p><img src="{{asset("img/Olimp201500386.png")}}" alt=""></p>

    </div>
    @yield('content')
</div>
</body>