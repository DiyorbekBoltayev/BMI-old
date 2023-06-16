<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Statistic;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SifatController extends Controller
{
    public function statisticsAll(Request $request):View{

        $years=Statistic::getYears();
        $mudirs=User::all()->where('role','mudir');

        $options=(object)[
            'sort'=>$request['sort']??'DESC',
            'semester'=>$request['semester']??'8-semestr',
            'year'=>$request['year']??date('Y')-1 .'-'.date('Y'),
            'mudir_id'=>$request['mudir_id']??0,

        ];

        $teachers = Statistic::teachers($options->mudir_id,$options);

        return view('admin.sifat.index',compact('years','options','mudirs','teachers'));
    }
    public function generateFile(Request $request):Response
    {
        $options=(object)[
            'semester'=>$request['semester']??'8-semestr',
            'year'=>$request['year']??date('Y')-1 .'-'.date('Y'),
            'mudir_id'=>$request['mudir_id']??0,
            'sort'=>$request['sort']??'DESC',
        ];
        $data= Statistic::themesGivenOptionsSelectedByStudents($options);
        $year=$options->year;
        if ($options->semester==0)
            $semester="";
        else
            $semester=$options->semester;
        $filename = 'sifat'.Carbon::now()->format('H:i-d-m-Y').'.pdf';
        $sifat_user_name=auth()->user()->name;
        $pdf = Pdf::loadView('admin.sifat.pdf', compact('data','year','semester','sifat_user_name'));
        return $pdf->download($filename);

    }
}
