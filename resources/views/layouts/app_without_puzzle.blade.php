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
    <link href="{{ asset('css/easy-autocomplete.min.css') }}" rel="stylesheet">
    <link href="{{asset("css/style0.css")}}" rel="stylesheet">
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
                <center>@lang('fields.Puzzle')</center>
                <center >@lang('fields.Olymp')</center>
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
        <div id = "mode-botton">
            <input class="tab-button" type="button" value=@lang('fields.Single') onclick="showOne()" style="background: {{(count($errors->single)>0) || session("message")? '#f5f8fa' : 'none'}}; ">
            <input class="tab-button" type="button" value=@lang('fields.Team') onclick="showTeam()" style="background: {{(count($errors->team)>0) || session("teamMessage")? '#f5f8fa' : 'none'}};">
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

<div class = "clear"></div>

<div class="art-footer">
    <div class="art-footer-evolution"></div>
    <div class="art-footer-pencil"></div>

    <div class="art-footer-text">


        <div class="art-footer-body">


            <div class="f-d-l">Наш адрес: Киев, бул. И.Шамо, 17а   <a href="mailto:info@rl.kiev.ua">info@rl.kiev.ua</a>&nbsp;&nbsp;&nbsp;тел. 517-38-46
                <div class="f-d-r">© 2005-2017 Русановский лицей</div>
            </div>
            <div class="cleared"></div>
        </div>

    </div>
</div>

</body>