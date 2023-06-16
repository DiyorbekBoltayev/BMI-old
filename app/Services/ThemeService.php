<?php

namespace App\Services;

use App\Models\Theme;

class ThemeService
{
    public static function create($name, $description, $specialty, $level,$semester, $teacher_id)
    {
        $theme = new Theme();
        $theme->name = $name;
        $theme->description = $description;
        $theme->teacher_id = $teacher_id;
        $theme->specialty = $specialty;
        $theme->level = $level;
        $theme->semester = $semester;
        $theme->save();
        return $theme;
    }

    /**
     * @throws \Exception
     */
    public static function update($id, $name, $description, $specialty, $level,$semester)
    {
        $theme = Theme::find($id);
        if ($theme->student_id != 0) {
            throw new \Exception('Mavzu talaba tomonidan  tanlanganligi uchun o`zgaritirsh mumkin emas');
        }
        $theme->name = $name;
        $theme->description = $description;
        $theme->specialty = $specialty;
        $theme->level = $level;
        $theme->semester = $semester;
        $theme->save();
        return $theme;
    }

    public static function delete($id)
    {
        $theme = Theme::find($id);
        if ($theme->student_id != 0) {
            throw new \Exception('Mavzu talaba tomonidan  tanlanganligi uchun o`chirish mumkin emas');
        }
        $theme->delete();
        return $theme;
    }

    public static function studentChatMessagesCount(){
       $a=Theme::all()->where('student_id',session('hemisaboutme')->student_id_number)
            ->where('semester',session('hemisaboutme')->semester->name)
            ->first();
       if ($a!=null)
           return $a->chat->messages->where('is_read',false)->where('type','1')->count();
       return 0;
    }






}