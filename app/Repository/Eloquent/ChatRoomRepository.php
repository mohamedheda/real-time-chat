<?php

namespace App\Repository\Eloquent;

use App\Models\ChatRoom;
use App\Repository\ChatRoomRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ChatRoomRepository extends Repository implements ChatRoomRepositoryInterface
{
    public function __construct(ChatRoom $model)
    {
        parent::__construct($model);
    }

    public function checkRoomExist($user_id)
    {
        return $this->model::query()
            ->whereHas('members', function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })
            ->whereHas('members', function ($q) use ($user_id) {
                $q->where('user_id', auth('api')->id());
            })
            ->exists();
    }

    public function getRoom($user_id)
    {

        return $this->model::query()
            ->whereHas('members', function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })
            ->whereHas('members', function ($q) use ($user_id) {
                $q->where('user_id', auth('api')->id());
            })
            ->first();
    }

    public function getRooms()
    {
        return $this->model::query()
            ->whereHas('members', function ($q) {
                $q->where('user_id', auth('api')->id());
            })
            ->whereHas('messages')
            ->with(['otherMember.user', 'authedMember', 'lastMessage'])
            ->orderByDesc('updated_at')
            ->get();
    }

}
