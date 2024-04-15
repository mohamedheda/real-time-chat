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
    public function checkRoomExist($user_id){
        return $this->model::query()
                    ->whereHas('members',function ($q) use ($user_id) {
                        $q->where('user_id',$user_id);
                    })->exists();
    }
    public function getRoom($user_id){
        return $this->model::query()
            ->whereHas('members',function ($q) use ($user_id) {
                $q->where('user_id',$user_id);
            })->first();
    }

}
