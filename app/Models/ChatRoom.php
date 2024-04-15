<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function members(){
        return $this->hasMany(ChatRoomMember::class,'chat_room_id');
    }
    public function messages(){
        return $this->hasMany(Message::class,'chat_room_id');
    }
}
