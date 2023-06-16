<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    public function messages(){
        return $this->hasMany(Message::class);
    }
    public function teacherUnreadMessagesCount(){
        return $this->messages()->where('type','0')->where('is_read',false)->count();
    }

}
