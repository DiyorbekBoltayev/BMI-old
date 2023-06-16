<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\Theme;
use Illuminate\Http\Request;
class ChatController extends Controller
{

    public function create(Request $request){
        $chat=$request->chat_id;
        $message= new Message();
        $message->chat_id=$chat;
        $message->message=$request->message;
        $message->type=$request->type;
        $message->save();
        if ($request->type=='0')
            return redirect()->route('chat-student');
        else
            return redirect()->route('chat',$chat);
    }
    public function show($id){
        $messages= Message::all()->where('chat_id',$id);
        $chat_id=$id;
        $student_name=Theme::all()->where('id',Chat::all()->where('id',$id)->first()->theme_id)->first()->student_name;
        $teacher_name=auth()->user()->name;
        $messages_status=Message::all()->where('chat_id',$chat_id)->where('type','0');
        $messages_status->each(function ($item){
            $item->is_read=true;
            $item->save();
        });
        return view('admin.chats.show',compact('messages','chat_id','student_name','teacher_name'));
    }
    public function showChatForStudent(){
        $student_id=session('hemisaboutme')->student_id_number;
        $theme=Theme::all()->where('student_id',$student_id)
            ->where('semester',session('hemisaboutme')->semester->name)
            ->first();
        if ($theme==null)
            return redirect()->route('student-themes')->withErrors('Sizda hozircha mavjud chat yo`q');

        $chat_id=Chat::all()->where('theme_id',$theme->id)->first()->id;
        $messages= Message::all()->where('chat_id',$chat_id);
        $student_name=$theme->student_name;
        $teacher_name=$theme->teacher->name;
        $messages_status=Message::all()->where('chat_id',$chat_id)->where('type','1');
        $messages_status->each(function ($item){
            $item->is_read=true;
            $item->save();
        });
        return view('admin.chats.show-student',compact('messages','chat_id','student_name','teacher_name'));
    }
}
