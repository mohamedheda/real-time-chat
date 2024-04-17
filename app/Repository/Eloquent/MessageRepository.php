<?php

namespace App\Repository\Eloquent;

use App\Models\Message;
use App\Repository\MessageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class MessageRepository extends Repository implements MessageRepositoryInterface
{
    public function __construct(Message $model)
    {
        parent::__construct($model);
    }
    public function loadMoreMessages($chat_room_id, $last_message_id){
        return $this->model::query()
                    ->where('chat_room_id',$chat_room_id)
                    ->where('id','<',$last_message_id)
                    ->limit(20)
                    ->get();
    }
}
