@extends('layouts.app_test')

@section('content')
    <div class="container-fluid">

        <div id="myModal" class="modal">

            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2 id="additional-owner">Данные</h2>
                </div>
                <div class="modal-body">
                    <table style="border-collapse: separate; width: 100%;border-spacing: 7px 11px;" >
                        <tr>
                            <th>Почта</th>
                            <th>Учитель</th>
                            <th>Телефон</th>
                            <th>Источник</th>
                            <th></th>
                        </tr>
                        <tr id="modal-table-tr">
                            <td><input type="text" data-name="email" class="additional" /></td>
                            <td ><input type="text" data-name="teacher" class="additional" /></td>
                            <td ><input type="text" data-name="phone" class="additional" /></td>
                            <td ><input type="text" data-name="lead_source" class="additional" /></td>
                            <th><th><i class="fa fa-check fa-lg" aria-hidden="true" onclick="sendAdditional()" ></i></th></th>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <h3></h3>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-20 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Панель управления <p><strong>Всего команд: {{$teams->All}} </strong></p>
                        <form method="GET" action="{{route("home_team")}}">

                            <div>
                                <div>
                                    <input type="radio"
                                           onMouseDown="this.isChecked=this.checked;"
                                           onClick="this.checked=!this.isChecked;"
                                           name="type" value="math" {{old("type")=="math"?"checked":""}}/> Математические

                                    <input type="radio"
                                           onMouseDown="this.isChecked=this.checked;"
                                           onClick="this.checked=!this.isChecked;"
                                           name="type" value="puzzle"{{old("type")=="puzzle"?"checked":""}}/> Головоломки

                                </div>
                                <div>
                                    <label for="school"> Школа </label>
                                    <input  type="text" id="school" name="school" value="{{old("school")}}">
                                    <label for="city"> Город </label>
                                    <input  type="text" id="city" name="city" value="{{old("city")}}">
                                    <label for="lastName"> Фамилия </label>
                                    <input  type="text" id="lastName" name="lastName" value="{{old("lastName")}}" >
                                </div>

                            </div>
                            <button type="submit" class="btn btn-success">Выборка</button>
                        </form>
                        <input type="button" class="btn btn-default" onclick="generateExcel('{{route("generate_results_math")}}','{{route("generate_results_puzzle")}}','{{route("generate_results_team")}}')" value="Сгенерировать Excel"/>
                        <label for="olymp-state">Состояние олимпиады</label>
                        <input type="checkbox" class="olymp-state" name="olympState" onchange="setState('{{route('state')}}',this)" {{$state==true?"checked":""}}>
                        <label for="olymp-state">Начались ли головоломки</label>
                        <input type="checkbox" class="olymp-state" name="puzzleState" onchange="setState('{{route('state_puzzle')}}',this)" {{$statePuzzle==true?"checked":""}}>
                    </div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div><input type="text" id="search-field"><i class="fa fa-search fa-lg" id="search-button" aria-hidden="true"></i></div>
                        @if(count($teams)==0)
                            <p>не найдено ни одной команды</p>
                        @else
                            <table style="width:100%" id="url" data-delete="{{route("delete_team",["param"])}}" data-update-marks="{{route("update_marks_team")}}"
                                   data-update="{{route("update_team")}}" data-get-additional="{{route("get_additional_team")}}" data-update-additional="{{route("update_additional_team")}}">
                                <tr>
                                    <th>Номер</th>
                                    <th >Название команды </th>
                                    <th >Имя капитана</th>
                                    <th >Фамилия Капитана</th>
                                    <th>Город</th>
                                    <th>Школа</th>
                                    <th>Участники</th>
                                    @for($i=1;$i<=10;$i++)
                                        <th>Тест {{$i}}</th>
                                    @endfor
                                    <th>Сумма</th>
                                    <th>Место</th>
                                    <th class="controls"></th>
                                    <th class="controls"></th>
                                    @if(Auth::user()->name == "admin")
                                        <th class="controls"></th>
                                    @endif
                                </tr>
                                @for($j=0;$j<$teams->count();$j++)
                                    <tr>
                                        <th data-type="id">{{$j+1}}</th>
                                        <th data-type="text" data-name="teamName">{{$teams[$j]->TeamName}}</th>
                                        <th data-type="text" data-name="leaderFirstName">{{$teams[$j]->LeaderFirstName}}</th>
                                        <th data-type="text" data-name="leaderLastName">{{$teams[$j]->LeaderLastName}}</th>
                                        <th data-type="text" data-name="city">{{$teams[$j]->City}}</th>
                                        <th data-type="text" data-name="school">{{$teams[$j]->School}}</th>
                                        <th data-type="tree" data-name="members">
                                            <span class="tree-button" style="cursor: pointer">Состав</span>
                                            <table style="display: none;border-collapse: separate; border-spacing: 7px 11px;" class="tree">
                                               <tr>
                                                   <th >Имя</th>
                                                   <th >Фамилия</th>
                                                   <th >Класс</th>
                                               </tr>
                                                @foreach($teams[$j]->members as $member)
                                                    <tr data-id ={{$member->id}}>
                                                        <th data-name="firstName">{{$member->FirstName}}</th>
                                                        <th data-name="lastName">{{$member->LastName}}</th>
                                                        <th data-name="class">{{$member->Class}}</th>
                                                    </tr>
                                                    @endforeach
                                            </table>
                                        </th>
                                        @for($i=1;$i<=10;$i++)
                                            <th data-type="integer" data-name="{{"test".$i}}" class="test">{{$teams[$j]["test".$i]}}</th>
                                        @endfor
                                        <th data-type="sum" data-name="sum" class="sum">{{$teams[$j]->Sum}}</th>
                                        <th data-type="enum:1,2,3" data-name="place" >{{$teams[$j]["Place"] != null ? $teams[$j]["Place"]:"Место не определено"}}</th>
                                        <th><i class="fa fa-pencil fa-lg "  data-id="{{$teams[$j]->id}}" aria-hidden="true" onclick="edit(this)" ></i></th>
                                        <th><i class="fa fa-times fa-lg "  data-id="{{$teams[$j]->id}}" aria-hidden="true" onclick="deleting(this)"></i></th>
                                        @if(Auth::user()->name == "admin")
                                            <th><i class="fa fa-gavel fa-lg "  data-id="{{$teams[$j]->id}}" aria-hidden="true" onclick="additional(this)"></i></th>
                                        @endif
                                    </tr>
                                @endfor
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            var tabButton = document.getElementsByClassName("tab-button");
            tabButton[1].style.backgroundColor = "#f5f8fa";
        });
        function showOne()
        {
          location.href= "{{route("home_single")}}";
        }
        function showTeam()
        {
            location.href = "{{route("home_team")}}";
        }
        const tree = document.getElementsByClassName("tree-button");
        for (var i=0;i<tree.length;i++)
        {
            tree[i].addEventListener("click",hideList);
        }
        function hideList(ev) {
            const parent = ev.target.parentNode.childNodes;
            var root = null;
            parent.forEach(function (value) {
                if(value.nodeName==="TABLE"){
                    root = value;
                }
            });
            if(root.style.display === "none") {

                root.style.display = "block";
            }
            else {
                root.style.display = "none";
            }
        }
    </script>
    <script src={{asset("js/menu.js")}}></script>
@endsection