<?php

namespace App\Http\Controllers;

use App\Models\Process;
use App\Models\Theme;
use App\Services\ProcessService;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    public function index()
    {
        $processes = Process::all();

        return view('admin.processes.index', compact('processes'));
    }

    public function student_index()
    {

        $theme = Theme::all()
            ->where('student_id', session('hemisaboutme')->student_id_number)
            ->where('semester', session('hemisaboutme')->semester->name)
            ->first();


        if ($theme == null) {
            return redirect()->route('student-themes');
        }

        $process = Process::all()
            ->where('theme_id', $theme->id)
            ->first();

        return view('admin.processes.student_index', compact('process'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {

            ProcessService::update($request->id, $request->file, $request->process, $request->link, $request->status,$request->percentage );

            return redirect()->back()->with('msg', 'Jarayon muvaffaqiyatli yangilandi');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Link xato kiritildi yoki mavjud emas. Quyidagi formatda kiriting: https://github.com/kimdir/nimadir');
//            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function showProcess($id){
        $process = Process::find($id);
        return view('admin.processes.show', compact('process'));
    }



}
