<?php

namespace App\Http\Traits;

use App\Repository\ChatRoomRepositoryInterface;
use Illuminate\Support\Facades\DB;

trait UnReadtrait
{
    public function __construct(
        private readonly ChatRoomRepositoryInterface $chatRoomRepository,
    )
    {

    }

    public function updateUnReadCount($chat_room_id, $zero_unread = true)
    {
        try {
            DB::beginTransaction();
            $room = $this->chatRoomRepository->getById($chat_room_id, relations: ['otherMember','authedMember']);
            if ($zero_unread)
                $room->authedMember()?->update(['unread_count' => 0]);
            else
                $room->otherMember()?->increment('unread_count');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            //return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
