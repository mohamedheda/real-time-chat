<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChatRoom extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function lastMessageContent(): Attribute
    {
        return Attribute::make(get: function () {
            $type = $this->lastMessage?->type === 'TEXT' ? 'content' : 'type_value';
            $last_message_content = $this->lastMessage?->{$type};
            return Str::limit($last_message_content , 20);
        });
    }


    public function members()
    {
        return $this->hasMany(ChatRoomMember::class, 'chat_room_id');
    }

    public function otherMember()
    {
        return $this->hasOne(ChatRoomMember::class, 'chat_room_id')?->whereNot('user_id', auth('api')->id());
    }

    public function authedMember()
    {
        return $this->hasOne(ChatRoomMember::class, 'chat_room_id')?->where('user_id', auth('api')->id());
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_room_id')
            ->orderBy('created_at')
            ->take(20);
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'chat_room_id')
            ->latest();
    }
}
