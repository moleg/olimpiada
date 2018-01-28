<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Http\Request;
use app\Models;
use Illuminate\Support\Facades\Mail;
use App;
class StudentController extends Controller
{

    public function index(Request $request)
    {
        if (isset($_COOKIE["LANG"]))
        {
            App::setLocale($_COOKIE["LANG"]);
        }
        $request->flash();
        $content = Storage::disk('local')->get('settings.json');
        $json = json_decode($content);
        if ($json->isGoing == true)
        {
            return view('register');
        }
        else
        {
            return response()->redirectToRoute("results");
        }
    }
    public function indexPuzzle(Request $request)
    {
        if (isset($_COOKIE["LANG"]))
        {
            App::setLocale($_COOKIE["LANG"]);
        }
        $request->flash();
        $content = Storage::disk('local')->get('settings.json');
        $json = json_decode($content);
        if ($json->isGoing == true)
        {
            return view('register_puzzle')->with('puzzle',$json->isPuzzle);
        }
        else
        {
            return response()->redirectToRoute("results");
        }
    }
    public function register(Request $request)
    {
        $request->flash();
        $rules = [
            "email" =>"email|required|max:50",
            "first_name"=>"required|max:20|regex:/^[\pL\s\-]+$/u",
            "last_name"=>"required|max:20|regex:/^[\pL\s\-]+$/u",
            "teacher"=>"required|max:50|regex:/^[\pL\s\-]+$/u",
            "city"=>"required|max:30|regex:/^[\pL\s\-]+$/u",
            "school"=>"required|max:30",
            "phone"=>"required|regex:/^[0-9]+$/",

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            //dd($validator->errors());
            //dd(session()->getOldInput());
           // dd($request->all());
            return redirect()->back()->withErrors($validator,"single")->withInput();
        }
        else {
            $student = new Student();
            $student->IpAdress = request()->ip();
            $student->FirstName = mb_strtoupper($request["first_name"], "utf-8");
            $student->LastName = mb_strtoupper($request["last_name"], "utf-8");
            $student->Class = $request["class_num"];
            $student->City = mb_strtoupper($request["city"], "utf-8");
            $student->LeadSource = $request["lead_source"];
            $student->Teacher = $request["teacher"];
            $student->OlympType = $request["type"];
            $student->Email = $request["email"];
            $student->PhoneNumber = $request["phone"];
            $student->School = mb_strtoupper($request["school"], "utf-8");
            $student->LeadSource = $request["lead_source"];
            $student->Registration = isset($request["registration"]) ? true : false;
            $student->save();
            $message = "Поздравляем! Вы успешно зарегистрировались. Полную информацию Вы получите на Ваш e-mail.";
            $username = array("FirstName" => $request["first_name"], "LastName" => $request["last_name"]);

            Mail::send("mail", $username, function ($message) use ($request) {

                $message->to($request["email"])->subject("Test");
            });
            //$request->flash();
            return redirect()->back()->with("message", $message);
        }
    }
    public function registerTeam(Request $request)
    {
        $rules = [
            "teamName" =>"required|max:50",
            "leaderFirstName"=>"required|max:20|/^[\pL\s\-]+$/u",//|regex:/^[A-ZА-Яё]+$/i",
            "leaderLastName"=>"required|max:20|/^[\pL\s\-]+$/u",//|regex:/^[A-ZА-Яё]+$/i",
            "FirstName.*" => "required|max:20|/^[\pL\s\-]+$/u",
            "LastName.*" => "required|max:20|/^[\pL\s\-]+$/u",
            "teacher"=>"required|max:50|/^[\pL\s\-]+$/u",
            "school"=>"required|max:30",
            "phone"=>"required|regex:/^[0-9]+$/",
            "city"=>"required|max:30|alpha",
        ];
        $request->flash();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return redirect('/')->withErrors($validator,"team")->withInput();
        }

        $team = new Team();
        $team->TeamName = $request["teamName"];
        $team->LeaderFirstName = mb_strtoupper($request["leaderFirstName"], "utf-8");
        $team->LeaderLastName = mb_strtoupper($request["leaderLastName"], "utf-8");
        $team->School = mb_strtoupper($request["school"], "utf-8");
        $team->Teacher = $request["teacher"];
        $team->OlympType = $request["type"];
        $team->School = mb_strtoupper($request["school"], "utf-8");
        $team->City = mb_strtoupper($request["city"], "utf-8");
        $team->Email = $request["email"];
        $team->PhoneNumber = $request["phone"];
        $team->LeadSource = $request["lead_source"];
        $first_names = $request["FirstName"];
        $last_names = $request["LastName"];
        $class = $request["Class"];
        for ($i=0;$i<count($first_names);$i++)
        {
            $member = new TeamMember();
            $member->FirstName = $first_names[$i];
            $member->LastName = $last_names[$i];
            $member->Class = $class[$i];
            $team->save();
            $team->members()->save($member);
        }
        $team->save();
        $request->flash();
        return redirect()->back()->with("teamMessage","Успешная регистрация");
    }
    public function getCities()
    {
        $citylist = File::get("city.json");
        return response($citylist);
    }
    public function setLanguage()
    {

    }
}
