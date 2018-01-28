@extends('layouts.app')

@section('content')
        <p>{{$errors->has("single")}}</p>
        <div class="row">

            <div class="col-md-2 col-md-offset-2" id="test">

                <div class="tab" style="display: {{(count($errors->single)>0) || session("message")? 'block' : 'none'}}; " >
                    {{ Form::open(array('url' => '/registerstudent')) }}
                    <div class="form-group {{$errors->single->has("first_name") ? "has-error" : ""}}">
                        <label for="first_name">Имя</label>
                            <input id="first_name" type="text" class="form-control" name="first_name" value="{{ Request::old('first_name') }}" required autofocus>

                            @if ($errors->single->has('first_name'))
                                <span class="help-block">
                                        <strong>{{ $errors->single->first('first_name') }}</strong>
                                    </span>
                            @endif

                    </div>
                    <div class="form-group {{$errors->single->has("last_name") ? "has-error" : ""}}">
                        <label for="last_name">Фамилиия</label>
                        <input class="form-control" type="text" name="last_name" id="last_name" value="{{Request::old("last_name")}}" required/>
                        @if ($errors->single->has('last_name'))
                            <span class="help-block">
                                        <strong>{{ $errors->single->first('last_name') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="type">Тип олимпиады</label>
                        <select id="type" name="type">
                            <option value="Олимпиада">Олимпиада</option>
                            <option value="Головоломки">Головоломки</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="class_num">Класс</label>
                        <select id="class_num" name="class_num">
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                    </div>
                    <div class="form-group {{$errors->single->has("city") ? "has-error" : ""}}">
                        <label for="city">Город</label>
                        <input class="form-control" type="text" name="city" id="city"  required />
                        @if ($errors->single->has('city'))
                            <span class="help-block">
                                        <strong>{{ $errors->single->first('city') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group school {{$errors->single->has("school") ? "has-error" : ""}}"  >
                        <label for="school">Школа</label>
                        <input class="form-control" type="text" name="school"  id="school" required/>
                        @if ($errors->single->has('school'))
                            <span class="help-block">
                                        <strong>{{ $errors->single->first('school') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->single->has("teacher") ? "has-error" : ""}}">
                        <label for="teacher">ФИО учителя</label>
                        <input class="form-control" type="text" name="teacher" id="teacher" value="{{Request::old("teacher")}}" required />
                        @if ($errors->single->has('teacher'))
                            <span class="help-block">
                                        <strong>{{ $errors->single->first('teacher') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->single->has("email") ? "has-error" : ""}}">
                        <label for="email">Почта</label>
                        <input class="form-control" type="email" name="email" id="email" value="{{Request::old("email")}}" required />
                        @if ($errors->single->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->single->has("phone") ? "has-error" : ""}}" >
                        <label for="phone">Телефон</label>
                        <input class="form-control" type="text" name="phone" id="phone" value="{{Request::old("phone")}}"  required/>
                        @if ($errors->single->has('phone'))
                            <span class="help-block">
                                        <strong>{{ $errors->single->first('phone') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="lead_source">Откуда узнал</label>
                        <textarea class="form-control" name="lead_source" id="lead_source">{{Request::old("lead_source")}}</textarea>
                    </div>

                    @guest

                    @else
                        <div class="form-group">
                            <label for="registration">Reg</label>
                            <input  type="checkbox"   name="registration" id="registration" style="width: 20px; height: 20px;"/>
                        </div>
                    @endguest
                        @if (session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                    <button type="submit" class="btn btn-default">Submit</button>
                    {{ Form::close() }}
                </div>
                <div class="tab" style="display: {{(count($errors->team)>0)|| session("teamMessage") ? 'block' : 'none'}}">
                    {{ Form::open(array('url' => '/registerTeam')) }}
                    <div class="form-group {{$errors->team->has("teamName") ? "has-error" : ""}}">
                        <label for="teamName">Название команды</label>
                        <input class="form-control" type="text" name="teamName" id="teamName" required />
                        @if ($errors->team->has('teamName'))
                            <span class="help-block">
                                        <strong>{{ $errors->team->first('teamName') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->team->has("leaderFirstName") ? "has-error" : ""}} ">
                        <label for="teamName">Имя капитана</label>
                        <input class="form-control" type="text" name="leaderFirstName" id="leaderFirstName" required />
                        @if ($errors->team->has('leaderFirstName'))
                            <span class="help-block">
                                        <strong>{{ $errors->team->first('leaderFirstName') }}</strong>
                                    </span>
                        @endif

                    </div>
                    <div class="form-group {{$errors->team->has("leaderLastName") ? "has-error" : ""}}">
                        <label for="teamName">Фамилия капитана</label>
                        <input class="form-control" type="text" name="leaderLastName" id="leaderLastName" required />
                        @if ($errors->team->has('leaderLastName'))
                            <span class="help-block">
                                        <strong>{{ $errors->team->first('leaderLastName') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->team->has("leaderLastName") ? "has-error" : ""}}">
                        <label for="teamName">Школа</label>
                        <input class="form-control" type="text" name="leaderLastName" id="leaderLastName" required />
                        @if ($errors->team->has('leaderLastName'))
                            <span class="help-block">
                                        <strong>{{ $errors->team->first('leaderLastName') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group {{$errors->team->has("leaderLastName") ? "has-error" : ""}} ">
                        <label for="teamName">Члены команды и их классы</label>
                        <div class="panel panel-default ">
                            <div class="panel-body">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Username">
                                    <span class=" input-group-addon">
                                        <select id="class_num" name="class_num">
                                            <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="input-group " style="padding-top: 10px">
                                    <input type="text" class="form-control" placeholder="Username">
                                    <span class=" input-group-addon">
                                        <select id="class_num" name="class_num">
                                            <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="input-group" style="padding-top: 10px" >
                                    <input type="text" class="form-control" placeholder="Username">
                                    <span class=" input-group-addon">
                                        <select id="class_num" name="class_num">
                                            <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="input-group" style="padding-top: 10px">
                                    <input type="text" class="form-control" placeholder="Username">
                                    <span class=" input-group-addon">
                                        <select id="class_num" name="class_num">
                                            <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="input-group" style="padding-top: 10px">
                                    <input type="text" class="form-control" placeholder="Username">
                                    <span class=" input-group-addon">
                                        <select id="class_num" name="class_num">
                                            <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                        </select>
                                    </span>
                                </div>
                            </div>
                    </div>
                    @guest

                    @else
                        <div class="form-group">
                            <label for="registration">Reg</label>
                            <input  type="checkbox"   name="registration" id="registration" style="width: 20px; height: 20px;"/>
                        </div>
                        @endguest
                        @if (session('teamMessage'))
                            <div class="alert alert-success">
                                {{ session('teamMessage') }}
                            </div>
                        @endif
                    <button type="submit" class="btn btn-default">Submit</button>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <script src={{asset('js/city.js')}}></script>
    @endsection
