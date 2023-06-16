<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\Request;

class MudirController extends Controller
{
    public function themes()
    {

        $groups = $this->getGroups();
        $teachers = $this->getTeachers();
        $mudirId = auth()->user()->id;

        $themes = Theme::whereHas('teacher', function ($query) use ($mudirId) {
            $query->where('mudir_id', $mudirId);
        })
            ->with('process')
            ->where('semester','8-semestr')
            ->get();
        $options=(object)[
            'semester'=>'8-semestr'
        ];

        return view('admin.themes.mudir', compact('groups', 'teachers', 'themes','options'));
    }

    public function filteredThemes(Request $request)
    {
        $groups = $this->getGroups();
        $teachers = $this->getTeachers();
        $mudirId = auth()->user()->id;
        $themes = Theme::whereHas('teacher', function ($query) use ($mudirId) {
            $query->where('mudir_id', $mudirId);
        })
            ->with('process')
            ->when($request->group_name != 0, function ($query) use ($request) {
                $query->where('group_name', $request->group_name);
            })
            ->when($request->teacher_id != 0, function ($query) use ($request) {
                $query->where('teacher_id', $request->teacher_id);
            })
            ->when($request->status != 0, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->semester != 0, function ($query) use ($request) {
                $query->where('semester', $request->semester);
            })
            ->paginate(30);
        $options = (object)[
            'group_name' => $request->group_name,
            'teacher_id' => $request->teacher_id,
            'status' => $request->status,
            'semester' => $request->semester,
        ];
        return view('admin.themes.filtered', compact('groups', 'teachers', 'themes', 'options'));
    }

    public static function getGroups()
    {
        return Theme::select('group_name')
            ->distinct()
            ->whereNotNull('group_name')
            ->get()
            ->pluck('group_name')
            ->toArray();
    }

    public static function getTeachers()
    {
        return User::select('id', 'name')
            ->where('mudir_id', auth()->id())
            ->get()
            ->pluck('name', 'id')
            ->toArray();
    }
}
