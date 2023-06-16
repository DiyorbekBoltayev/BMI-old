<?php

namespace App\Http\Controllers;

use App\Services\HemisService;
use App\Services\ProcessService;
use App\Services\Statistic;
use App\Services\ThemeService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticController extends Controller
{

    public function teachers(Request $request){
        $years=Statistic::getYears();

        $options=(object)[
            'sort'=>$request['sort']??'DESC',
            'semester'=>$request['semester']??'8-semestr',
            'year'=>$request['year']??date('Y')-1 .'-'.date('Y'),
        ];
        $teachers = Statistic::teachers(auth()->id(),$options);

        return view('admin.statistic.teachers', compact('teachers','options','years'));

    }
    public function students(Request $request){
        $groups=MudirController::getGroups();
        $options=[
            'sort'=>$request['sort']??'DESC',
            'semester'=>$request['semester']??'8-semestr'
            ];
        if (count($groups)==0){
            $options['group']=$request['group']??0;
        }else{
            $options['group']=$request['group']??$groups[0];
        }
        $options=(object)$options;


        $students = Statistic::students(auth()->id(),$options);

        return view('admin.statistic.students', compact('students','options','groups'));

    }
}
