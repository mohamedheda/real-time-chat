<?php

namespace App\Repository\Eloquent;

use App\Models\ChatRoomMember;
use App\Repository\ChatRoomMemberRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ChatRoomMemberRepository extends Repository implements ChatRoomMemberRepositoryInterface
{
    public function __construct(ChatRoomMember $model)
    {
        parent::__construct($model);
    }
}
