<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Team;



class ResultsController extends Controller
{

    public function index()
    {
        return view('results.result');
    }
    public function GenerateResultsMath()
    {
        $this->GenerateExcel('Math','math');
    }
    public function GenerateResultsPuzzle()
    {
        $this->GenerateExcel('Puzzle','puzzle');
    }
    public function GenerateResultsTeam(){
        $teams = Team::whereYear('created_at', '=', date('Y'))->orderBy("Sum","desc");
        Excel::create("Command_math_".date('Y'), function($excel) use ($teams) {
            $excel->sheet("Командная олимпада(головоломки)", function($sheet) use ($teams) {
                $sheet->appendRow(1,['N','Назва команды','Школа','Завдання 1','Завдання 2','Завдання 3','Завдання 4','Завдання 5','Завдання 6','Завдання 7','Завдання 8','Завдання 9','Завдання 10','Сумма','Место']);
                $data = $teams->where("OlympType","Math")
                    ->select('TeamName','School','test1','test2','test3','test4','test5','test6','test7','test8','test9','test10','Sum','Place')->get();
                for($i=1;$i<=$data->count();$i++)
                {
                    $sheet->row($i+1,[$i]);
                }
                $sheet->fromArray($data, null, 'B2', true,false);
                //unset($data);
            });
        })->store('xls','./excel', true);

        Excel::create("Command_puzzle_".date('Y'), function($excel) use ($teams) {
            $excel->sheet("Командная олимпада(головоломки)", function($sheet) use ($teams) {
                $sheet->appendRow(1,['N','Назва команды','Школа','Завдання 1','Завдання 2','Завдання 3','Завдання 4','Завдання 5','Завдання 6','Завдання 7','Завдання 8','Завдання 9','Завдання 10','Сумма','Место']);
                $data = $teams->where("OlympType","Puzzle")
                    ->select('TeamName','School','test1','test2','test3','test4','test5','test6','test7','test8','test9','test10','Sum','Place')->get();
                for($i=1;$i<=$data->count();$i++)
                {
                    $sheet->row($i+1,[$i]);
                }
                $sheet->fromArray($data, null, 'A1', true,false);
                //unset($data);
            });
        })->store('xls','./excel', true);
    }
    public function ChangeState(Request $request)
    {
        $content = Storage::disk('local')->get('settings.json');
        $json = json_decode($content);
        $json->isGoing = $request["state"]=="true"?true:false;
        Storage::disk('local')->put('settings.json', json_encode($json));
    }
    public function ChangePuzzle(Request $request)
    {
        $content = Storage::disk('local')->get('settings.json');
        $json = json_decode($content);
        $json->isPuzzle = $request["state"]=="true"?true:false;
        Storage::disk('local')->put('settings.json', json_encode($json));
    }


    private function GenerateExcel($type,$name)
    {
        $students = Student::whereYear('created_at', '=', date('Y'))->orderBy("Sum","desc");
        for($i=6;$i<9;$i++)
        {
            Excel::create($i."_form_".$name."_".date('Y'), function($excel) use ($students,$i,$type) {
                $excel->sheet($i." класс", function($sheet) use ($students,$i,$type) {
                    $sheet->appendRow(1,['N','Имя','Фамилия','Школа','Завдання 1','Завдання 2','Завдання 3','Завдання 4','Завдання 5','Завдання 6','Завдання 7','Завдання 8','Завдання 9','Завдання 10','Сумма','Место']);
                    $data = $students->where([
                        "OlympType"=>$type,
                        "Class"=>$i,
                    ])->select('FirstName','LastName','School','test1','test2','test3','test4','test5','test6','test7','test8','test9','test10','Sum','Place')->get();

                    for($j=1;$j<=$data->count();$j++)
                    {
                        $sheet->row($j+1,[$j]);
                    }
                    $sheet->fromArray($data, null, 'B2', true,false);

                });
            })->store('xls','./excel', true);
        }
    }

}

