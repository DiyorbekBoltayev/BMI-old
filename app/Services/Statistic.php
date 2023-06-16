<?php

namespace App\Services;

use App\Models\Kafedra;
use App\Models\Theme;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Statistic
{


    public static function teachers($mudir_id, $options=[]) {

        if ($options->year!=0){
            $startYear='01.09.'.(explode('-',$options->year)[0]);
            $endYear='01.08.'.(explode('-',$options->year)[1]);
            $startYear = Carbon::createFromFormat('d.m.Y', $startYear)->startOfDay();
            $endYear = Carbon::createFromFormat('d.m.Y', $endYear)->endOfDay();

        }else{
            $startYear=0;
            $endYear=0;
        }



        $teachers = User::with(['themes' => function($query) use ($options, $startYear, $endYear) {
            if ($options->semester != 0) {
                $query->where('semester', $options->semester);
            }
            if ($options->year != 0) {
                $query->whereBetween('created_at', [$startYear, $endYear]);
            }
        }])
            ->where('role', 'teacher')
            ->when($mudir_id != 0, function ($query) use ($mudir_id) {
                return $query->where('mudir_id', $mudir_id);
            })
            ->get();




        $data = $teachers->map(function($teacher) {
            $themes=$teacher->themes;
            $count = $themes->count();
            $percentage = $teacher->themes->sum('percentage');
            $new = $teacher->themes->where('status', 'new')->count();
            $progress = $teacher->themes->where('status', 'process')->count();
            $end = $teacher->themes->where('status', 'end')->count();



            return [
                'teacher' => $teacher,
                'count' => $count,
                'percentage' => $percentage,
                'new' => $new,
                'progress' => $progress,
                'end' => $end,
                'themes' => $themes
            ];

        });

        //sort by count
        if ($options->sort == 'ASC')
            $data = $data->sortBy('count');
        else if ($options->sort == 'DESC')
            $data = $data->sortByDesc('count');

        return (object)$data->toArray();
    }

    public static function students($mudir_id,$options){


        $themes = Theme::whereHas('teacher', function ($query) use ($mudir_id) {
            $query->where('mudir_id', $mudir_id);
        })
            ->where('semester', $options->semester)
            ->when($options->group != 0, function ($query) use ($options) {
                return $query->where('group_name', $options->group);
            })
            ->orderBy('percentage',$options->sort)
            ->get();


        return $themes;

    }

    public static function themesGivenOptionsSelectedByStudents($options):array{
        $startYear=explode('-',$options->year);
        $endYear=strtotime('1.08.'.$startYear[1]);
        $startYear=strtotime('1.09.'.$startYear[0]);

        $themes = DB::table('themes')
            ->join('users', 'themes.teacher_id', '=', 'users.id')
            ->when($options->semester != 0, function ($query) use ($options) {
                return $query->where('themes.semester', $options->semester);
            })
            ->whereDate('themes.created_at','>=',date('Y-m-d',$startYear))
            ->whereDate('themes.created_at','<=',date('Y-m-d',$endYear))
            ->where('themes.student_id','!=',0)
            ->select('themes.student_name','themes.name', 'themes.group_name', 'themes.percentage','users.name as teacher_name','users.mudir_id')
            ->orderBy('themes.group_name',$options->sort)
            ->get()
            ->groupBy('mudir_id')
            ->toArray();
        $keys=array_keys($themes);
        if (!in_array($options->mudir_id,$keys) and $options->mudir_id!=0){
            return [];
        }
        $data=[];
        foreach ($keys as $key){
            $a=[];
            $a['kafedra']=Kafedra::all()->where('user_id',$key)->first()->name;
            $a['themes']=$themes[$key];
            $data[$key]=$a;
        }

        if ($options->mudir_id !=0){
            $b=[];
            $b[]=$data[$options->mudir_id];
            return $b;
        }

        return $data;
    }
    public static function getYears(): array
    {
        return DB::table('themes')
            ->select(DB::raw("DISTINCT CONCAT(
            IF(MONTH(created_at) >= 9, YEAR(created_at), YEAR(created_at) - 1),
            '-',
            IF(MONTH(created_at) >= 9, YEAR(created_at) + 1, YEAR(created_at))
        ) AS year"))
            ->orderBy('year')
            ->get()
            ->pluck('year')
            ->toArray();
    }







}