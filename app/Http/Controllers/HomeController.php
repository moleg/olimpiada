<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Models\Student;
use App\Models\TeamMember;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function indexSingle(Request $request)
    {
        $students = Student::whereYear('created_at', '=', date('Y'))->orderBy("created_at","desc");
        if (mb_strtolower($request->get("type")) == "math")
        {
            $students = $students->where("OlympType","Math");//Student::Where("OlympType","Олимпиада")->get();
        }
        elseif (mb_strtolower($request->get("type")) == "puzzle")
        {
            $students = $students->where("OlympType","Puzzle");//Student::Where("OlympType","Головоломки")->get();
        }

      /*  if(null !== $request->get("name"))
        {
            $students = $students->where("LastName","like","%".$request->get("name")."%")
                ->orWhere("FirstName","like","%".$request->get("name")."%");
        }*/
        if(null !== $request->get("class"))
        {
            $students = $students->where("Class",$request->get("class"));
        }
        if(null !== $request->get("school"))
        {
            $students = $students->where("School",$request->get("school"));
        }
        if(null !== $request->get("city"))
        {
            $students = $students->where("City",$request->get("city"));
        }
        if(null !== $request->get("lastName"))
        {
            $students = $students->where("LastName",$request->get("lastName"));
        }
        $students = $students->get();
        $studentCount = new class{};
        $studentCount->All = $students->count();
        $studentCount->FourCount = $students->where('Class',4)->count();
        $studentCount->FiveCount = $students->where('Class',5)->count();
        $studentCount->SixCount = $students->where('Class',6)->count();
        $studentCount->SevenCount = $students->where('Class',7)->count();
        $studentCount->EightCount = $students->where('Class',8)->count();
        $content = Storage::disk('local')->get('settings.json');
        $json = json_decode($content);
        $request->flash();
        return view('single.home')->with(["students" => $students,"studentCount" => $studentCount,'state'=>$json->isGoing,'statePuzzle'=>$json->isPuzzle]);
    }
    public function indexTeam(Request $request)
    {
        $teams = Team::with('members')->whereYear('created_at', '=', date('Y'))->orderBy("created_at","desc");
        if (mb_strtolower($request->get("type")) == "math")
        {
            $teams = $teams->where("OlympType","Math");//Student::Where("OlympType","Олимпиада")->get();
        }
        elseif (mb_strtolower($request->get("type")) == "puzzle")
        {
            $teams = $teams->where("OlympType","Puzzle");//Student::Where("OlympType","Головоломки")->get();
        }


        if(null !== $request->get("school"))
        {
            $teams = $teams->where("School",$request->get("school"));
        }
        if(null !== $request->get("city"))
        {
            $teams = $teams->where("City",$request->get("city"));
        }
        if(null !== $request->get("lastName"))
        {
            $teams = $teams->where("LeaderLastName",$request->get("lastName"));
        }
        $teams = $teams->get();
        $teams->All = $teams->count();
        //$test = Team::with('members')->get();
        //dump($test);
        $content = Storage::disk('local')->get('settings.json');
        $json = json_decode($content);
        $request->flash();
        return view('team.home')->with(["teams"=>$teams,'state'=>$json->isGoing,'statePuzzle'=>$json->isPuzzle]);

    }

    public function name(Request $request,$name)
    {
        $students = Student::where("LastName","like","%".$name."%")
            ->orWhere("FirstName","like","%".$name."%")
            ->get();
        return view('single.home')->with("students",$students);
    }
    public function deleteSingle(Request $request,$id)
    {
        Student::destroy($id);
        return response()->json("OK");
    }
    public function updateSingle(Request $request)
    {

        $student = Student::find($request["id"]);
        $student->FirstName = $request["firstName"];
        $student->LastName = $request["lastName"];
        if ($request["class"] != "null")
        {
            $student->Class = $request["class"];
        }
        $student->City = $request["city"];
        $student->School = $request["school"];
        $student->Place = $request["place"];
        $student->save();
    }
    public function GetMarksSingle(Request $request)
    {
        $studentmarks = Student::where("id",$request["id"])
            ->first(["test1","test2","test3","test4","test5","test6","test7","test8","test9","test10"]);

        return response()->json($studentmarks);
    }
    public function UpdateMarksSingle(Request $request)
    {
        $rules = [
            "test1"=> "integer|min:0|max:20",
            "test2"=> "integer|min:0|max:20",
            "test3"=> "integer|min:0|max:20",
            "test4"=> "integer|min:0|max:20",
            "test5"=> "integer|min:0|max:20",
            "test6"=> "integer|min:0|max:20",
            "test7"=> "integer|min:0|max:20",
            "test8"=> "integer|min:0|max:20",
            "test9"=> "integer|min:0|max:20",
            "test10"=> "integer|min:0|max:20",
            ];
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

            $studentmarks = Student::find($request["id"]);
            $studentmarks->test1 = $request["test1"];
            $studentmarks->test2 = $request["test2"];
            $studentmarks->test3 = $request["test3"];
            $studentmarks->test4 = $request["test4"];
            $studentmarks->test5 = $request["test5"];
            $studentmarks->test6 = $request["test6"];
            $studentmarks->test7 = $request["test7"];
            $studentmarks->test8 = $request["test8"];
            $studentmarks->test9 = $request["test9"];
            $studentmarks->test10 = $request["test10"];
            $studentmarks->Sum = $request["sum"];
            $studentmarks->save();
            return response()->json("OK");

    }
   public function deleteTeam($id)
   {
       $team = Team::find($id);
       $team->members()->delete();
       $team->delete();
   }
    public function UpdateMarksTeam(Request $request)
    {
        $rules = [
            "test1"=> "integer|min:0|max:20",
            "test2"=> "integer|min:0|max:20",
            "test3"=> "integer|min:0|max:20",
            "test4"=> "integer|min:0|max:20",
            "test5"=> "integer|min:0|max:20",
            "test6"=> "integer|min:0|max:20",
            "test7"=> "integer|min:0|max:20",
            "test8"=> "integer|min:0|max:20",
            "test9"=> "integer|min:0|max:20",
            "test10"=> "integer|min:0|max:20",
        ];
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $teammarks = Team::find($request["id"]);
        $teammarks->test1 = $request["test1"];
        $teammarks->test2 = $request["test2"];
        $teammarks->test3 = $request["test3"];
        $teammarks->test4 = $request["test4"];
        $teammarks->test5 = $request["test5"];
        $teammarks->test6 = $request["test6"];
        $teammarks->test7 = $request["test7"];
        $teammarks->test8 = $request["test8"];
        $teammarks->test9 = $request["test9"];
        $teammarks->test10 = $request["test10"];
        $teammarks->Sum = $request["sum"];
        $teammarks->save();
        return response()->json("OK");

    }
    public function updateTeam(Request $request)
    {
        $team = Team::find($request["id"]);
        $team->TeamName = $request["teamName"];
        $team->LeaderFirstName = $request["leaderFirstName"];
        $team->LeaderLastName = $request["leaderLastName"];
        $team->City = $request["city"];
        $team->School = $request["school"];
        $team->Place = $request["place"];
        $membersRequest = json_decode($request["members"]);
        for($i=0;$i<count($membersRequest);$i++)
        {
            $member = TeamMember::find($membersRequest[$i]->id);
            $member->FirstName = $membersRequest[$i]->firstName;
            $member->LastName = $membersRequest[$i]->lastName;
            $member->Class = $membersRequest[$i]->class;
            $member->save();
        }
        $team->save();
        //dd(json_decode($request["members"]));
        return response()->json("OK");
    }

    public function getAdditionalSingle(Request $request)
    {
        $studentAdditional = Student::where("id",$request["id"])
            ->first(["Email","Teacher","PhoneNumber","LeadSource"]);
        return response()->json($studentAdditional);
    }
    public function getAdditionalTeam(Request $request)
    {
        $studentAdditional = Team::where("id",$request["id"])
            ->first(["Email","Teacher","PhoneNumber","LeadSource"]);
        return response()->json($studentAdditional);
    }
    public function updateAdditionalSingle(Request $request)
    {
        $students = Student::find($request["id"]);
        $students->LeadSource = $request["lead_source"];
        $students->Email = $request["email"];
        $students->PhoneNumber = $request["phone"];
        $students->Teacher = $request["teacher"];
        $students->save();
    }
    public function updateAdditionalTeam(Request $request)
    {
        $team = Team::find($request["id"]);
        $team->LeadSource = $request["lead_source"];
        $team->Email = $request["email"];
        $team->PhoneNumber = $request["phone"];
        $team->Teacher = $request["teacher"];
        $team->save();
    }
}
