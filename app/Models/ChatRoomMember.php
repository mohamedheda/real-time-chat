<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoomMember extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function room(){
        return $this->belongsTo(ChatRoom::class , 'chat_room_id');
    }
}
