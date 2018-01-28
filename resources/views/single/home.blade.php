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
                <div class="panel-heading">
                    <div>

                    </div>
                    Панель управления <p><strong> Всего участников: {{$studentCount->All}}, </strong> <strong>4 класс: {{$studentCount->FourCount}}, </strong> <strong>5 класс: {{$studentCount->FiveCount}}, </strong> <strong>6 класс: {{$studentCount->SixCount}}, </strong> <strong>7 класс: {{$studentCount->SevenCount}}, </strong> <strong>8 класс: {{$studentCount->EightCount}}</strong></p>
                    <form method="GET" action="{{route("home_single")}}">

                        <input type="checkbox" class="className"  name="class[]" value="4" {{old("class.1")?"checked":""}}>
                        <label for="className">4 класс</label>
                        <input type="checkbox" class="className"  name="class[]" value="5"{{old("class.2")?"checked":""}}>
                        <label for="className">5 класс</label>
                        <input type="checkbox" class="className"  name="class[]" value="6"{{old("class.3")?"checked":""}}>
                        <label for="className">6 класс</label>
                        <input type="checkbox" class="className" name="class[]" value="7"{{old("class.4")?"checked":""}}>
                        <label for="className">7 класс</label>
                        <input type="checkbox" class="className" name="class[]" value="8"{{old("class.5")?"checked":""}}>
                        <label for="className">8 класс</label>


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
                            <label for="school"> Школа  </label>
                            <input  type="text" id="school" name="school" value="{{old("school")}}">
                            <label for="city"> Город </label>
                            <input  type="text" id="city" name="city" value="{{old("city")}}">
                            <label for="lastName"> Фамилия </label>
                            <input  type="text" id="lastName" name="lastName" value="{{old("lastName")}}" >
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
                        @if(count($students)==0)
                            <p>не найдено ни одного зареестрированого ученика</p>
                        @else
                           <table style="width:100%" id="url" data-update="{{route("update_single")}}" data-delete="{{route("delete_single",["param"])}}"
                                  data-update-additional="{{route("update_additional_single")}}" data-get-additional="{{route("get_additional_single")}}"data-update-marks ="{{route("update_marks_single")}}">
                               <tr>
                                   <th>Номер</th>
                                   <th>Фамилия</th>
                                   <th>Имя</th>
                                   <th>Город</th>
                                   <th>Школа</th>
                                   <th>Класс</th>
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
                               @for($j=0;$j<$students->count();$j++)
                               <tr>
                                   <th data-type="id">{{$j+1}}</th>
                                   <th data-type="text"  data-name="lastName">{{$students[$j]->LastName}}</th>
                                   <th data-type="text"  data-name="firstName">{{$students[$j]->FirstName}}</th>
                                   <th data-type="text" data-name="city">{{$students[$j]->City}}</th>
                                   <th data-type="text" data-name="school">{{$students[$j]->School}}</th>
                                   <th data-type="enum:4,5,6,7,8" data-name="class">{{$students[$j]->Class}}</th>
                                   @for($i=1;$i<=10;$i++)
                                       <th data-type="integer" data-name="{{"test".$i}}" class="test">{{$students[$j]["test".$i]}}</th>
                                   @endfor
                                   <th data-type="sum" data-name="sum" class="sum">{{$students[$j]["Sum"]}}</th>
                                   <th data-type="enum:1,2,3" data-name="place" >{{$students[$j]["Place"] != null ? $students[$j]["Place"]:"Значение не определено"}}</th>
                                   <th><i class="fa fa-pencil fa-lg "  data-id="{{$students[$j]->id}}" aria-hidden="true" onclick="edit(this)" ></i></th>
                                   <th><i class="fa fa-times fa-lg "  data-id="{{$students[$j]->id}}" aria-hidden="true" onclick="deleting(this)"></i></th>
                                   @if(Auth::user()->name == "admin")
                                       <th><i class="fa fa-gavel fa-lg "  data-id="{{$students[$j]->id}}" aria-hidden="true" onclick="additional(this)"></i></th>
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
        tabButton[0].style.backgroundColor = "#f5f8fa";
        if(location.href.includes("type=math"))
        {
            tabButton[2].style.color = "red";
            tabButton[3].style.color = "#3699d1";
        }
        else if (location.href.includes("type=puzzle"))
        {
            tabButton[3].style.color = "red";
            tabButton[2].style.color = "#3699d1";
        }
    });
    function showOne()
    {
        location.href= "{{route("home_single")}}";
    }
    function showTeam()
    {
        location.href = "{{route("home_team")}}";
    }


</script>
<script src={{asset("js/menu.js")}}></script>
@endsection
