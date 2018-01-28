@extends('layouts.app_without_puzzle')

@section('content')
@if($puzzle ==true)
    <div class="tab" style="display: {{(count($errors->single)>0) || session("message")? 'block' : 'none'}}; ">
        {{ Form::open(array('url' => '/registerstudent')) }}
        <div class="form-group-app {{$errors->single->has("first_name") ? "has-error" : ""}}">

            <label for="first_name">@lang('fields.FirstName')</label>
            <input id="first_name" type="text" class="form-control-app" name="first_name" value="{{old("first_name")}}" required autofocus>
            @if ($errors->single->has('first_name'))
                <span class="help-block">
                    <strong>{{ $errors->single->first('first_name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group-app {{$errors->single->has("last_name") ? "has-error" : ""}} ">
            <label for="last_name">@lang('fields.LastName')</label>
            <input class="form-control-app" type="text" name="last_name" id="last_name" value="{{old("last_name")}}" required="">
            @if ($errors->single->has('last_name'))
                <span class="help-block">
                    <strong>{{ $errors->single->first('last_name') }}</strong>
                </span>
            @endif
        </div>
        <input name="type" type="hidden" value="puzzle">
        <div class="form-group-app {{$errors->single->has("class_num") ? "has-error" : ""}}">
            <label for="class_num">@lang('fields.Class')</label>
            <select id="class_num" name="class_num">
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select>
        </div>
        <div class="form-group-app {{$errors->single->has("city") ? "has-error" : ""}} ">
            <label for="city">@lang('fields.City')</label>
            <input class="form-control-app city" type="text" name="city" id="city"  value="{{old("city")}}" required="">

            @if ($errors->single->has('city'))
                <span class="help-block">
                    <strong>{{ $errors->single->first('city')}}</strong>
                </span>
            @endif
        </div>
        <div class="form-group-app school {{$errors->single->has("school") ? "has-error" : ""}} ">
            <label for="school">@lang('fields.School')</label>
            <input class="form-control-app school" type="text" name="school" id="school" value="{{old("school")}}" required="">

            @if ($errors->single->has('school'))
                <span class="help-block">
                    <strong>{{ $errors->single->first('school') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group-app {{$errors->single->has("teacher") ? "has-error" : ""}}">
            <label for="teacher">@lang('fields.TeacherName')</label>
            <input class="form-control-app" type="text" name="teacher" id="teacher" value="{{old("teacher")}}"  required="">
            @if ($errors->single->has('teacher'))
                <span class="help-block">
                    <strong>{{ $errors->single->first('teacher') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group-app {{$errors->single->has("email") ? "has-error" : ""}} ">
            <label for="email">@lang('fields.Mail')</label>
            <input class="form-control-app" type="email" name="email" id="email" value="{{old("email")}}"  required="">
            @if ($errors->single->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->single->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group-app {{$errors->single->has("phone") ? "has-error" : ""}} ">
            <label for="phone">@lang('fields.Phone')</label>
            <input class="form-control-app" type="text" name="phone" id="phone" value="{{old("phone")}}"  required="">
            @if ($errors->single->has('phone'))
                <span class="help-block">
                    <strong>{{ $errors->single->first('phone')}}</strong>
                </span>
            @endif
        </div>
        <div class="form-group-app">
            <label for="lead_source">@lang('fields.Source')</label>
            <textarea class="form-control-app" name="lead_source"  id="lead_source"></textarea>
        </div>
        <button type="submit" id = "btn1" class="btn">Зарегистрироваться</button>
        {{ Form::close() }}


    </div>
    <div class="tab" style="display: {{(count($errors->team)>0)|| session("teamMessage") ? 'block' : 'none'}}">
        {{ Form::open(array('url' => '/registerTeam')) }}
        <div class = "team-group">

            <input name="type" type="hidden" value="puzzle">
            <div class="form-group-app {{$errors->single->has("teamName") ? "has-error" : ""}} ">
                <label for="first_name">@lang('fields.TeamName')</label>
                <input id="first_name" type="text" class="form-control-app" name="teamName" value="{{old("teamName")}}" required="" autofocus="">
            </div>

            <div class="form-group-app {{$errors->single->has("city") ? "has-error" : ""}}">
                <label for="city">@lang('fields.City')</label>
                <input class="form-control-app" type="text" name="city" id="city" value="{{old("city")}}" required="">
            </div>
            <div class="form-group-app school {{$errors->single->has("school") ? "has-error" : ""}} ">
                <label for="school">@lang('fields.School')</label>
                <input class="form-control-app" type="text" name="school" id="school" value="{{old("school")}}" required="">
            </div>

            <div class="form-group-app {{$errors->single->has("teacher") ? "has-error" : ""}} ">
                <label for="teacher">@lang('fields.TeacherName')</label>
                <input class="form-control-app" type="text" name="teacher" id="teacher" value="{{old("teacher")}}" required="">
            </div>

            <div class="form-group-app {{$errors->single->has("email") ? "has-error" : ""}}">
                <label for="email">@lang('fields.Mail')</label>
                <input class="form-control-app" type="email" name="email" id="email" value="{{old("email")}}" required="">
            </div>
            <div class="form-group-app {{$errors->single->has("phone") ? "has-error" : ""}} ">
                <label for="phone">@lang('fields.Phone')</label>
                <input class="form-control-app" type="text" name="phone" id="phone" value="{{old("phone")}}" required="">
            </div>
            <div class="form-group-app">
                <label for="lead_source">@lang('fields.Source')</label>
                <textarea class="form-control-app" name="lead_source" id="lead_source"></textarea>
            </div>
        </div>

        <div class = "team-group">
            <div id = "team_member">
                <table >
                    <caption>@lang('fields.CaptainName')</caption>
                    <tr border="1">
                        <th>@lang('fields.LastName')</th>
                        <th>@lang('fields.FirstName')</th>
                        <th>@lang('fields.Class')</th>
                    </tr>
                    <tr>
                        <td><input class="form-control-app {{$errors->single->has("leaderFirstName") ? "has-error" : ""}}" type="text" name="leaderFirstName" id="CapFirstName" value="{{old("CapFirstName")}}" required=""></td>
                        <td><input class="form-control-app {{$errors->single->has("leaderLastName") ? "has-error" : ""}}" type="text" name="leaderLastName" id="CapLastName" value="{{old("CapLastName")}}" required=""></td>
                        <td><select id="CapClass" name="CapClass">
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                            </select></td>
                    </tr>
                </table>
                <br>
                <table>
                    <caption>@lang('fields.MemberName')</caption>
                    <tr border="1">
                        <th>@lang('fields.LastName')</th>
                        <th>@lang('fields.FirstName')</th>
                        <th>@lang('fields.Class')</th>
                    </tr>
                    @for($i=0;$i<5;$i++)
                        <tr>
                            <td><input class="form-control-app {{$errors->single->has("FirstName.".$i) ? "has-error" : ""}}" type="text" name="FirstName[{{$i}}]" id="FirstName1" value="{{old("FirstName".$i)}}" required=""></td>
                            <td><input class="form-control-app {{$errors->single->has("LastName.".$i) ? "has-error" : ""}}" type="text" name="LastName[{{$i}}]" id="1LastName1" value="{{old("LastName".$i)}}" required=""></td>
                            <td><select id="class_num1" name="Class[{{$i}}]">
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                </select></td>
                        </tr>
                    @endfor
                </table>
            </div>
        </div>
        <div class = "clear"></div>
        <button type="submit" class="btn btn-default">Зарегистрироваться</button>
        {{ Form::close() }}
    </div>
    @if (session('teamMessage'))
       <script>
           alert('{{session('teamMessage')}}');
       </script>
    @elseif (session('message'))
        <script>
            alert('{{ session('message') }}');
        </script>

    @endif
@else
    <p>Олимпиада пока не открыта <a href="/">назад</a></p>
@endif
    <script src={{asset('js/city.js')}}></script>
@endsection