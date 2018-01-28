@extends('layouts.app_without_buttons')

@section('content')
    <div>
        @for($i=4;$i<9;$i++)
            <p>Результаты математической олимпиады за {{$i}} класс:<a href={{asset("excel/${i}_form_math_".date('Y').".xls")}}>Скачать в фомате excel</a></p>
        @endfor
        @for($i=4;$i<9;$i++)
            <p>Результаты олимпиады по головоломкам за {{$i}} класс:<a href={{asset("excel/${i}_form_puzzle_".date('Y').".xls")}}>Скачать в фомате excel</a></p>
        @endfor
        <p>Результаты командной олимпиады <a href={{asset("excel/Command_math_".date('Y').".xls")}}>Скачать в фомате excel</a></p>
        <p>Результаты командной олимпиады по головоломкам <a href={{asset("excel/Command_puzzle_".date('Y').".xls")}}>Скачать в фомате excel</a></p>
    </div>
@endsection