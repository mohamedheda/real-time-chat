<?php

namespace App\Http\Services\Api\V1\ChatRoom;

use App\Http\Resources\V1\ChatRoom\ChatRoomResource;
use App\Http\Traits\Responser;
use App\Repository\ChatRoomMemberRepositoryInterface;
use App\Repository\ChatRoomRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ChatRoomService
{
    use Responser;

    public function __construct(
        private readonly ChatRoomRepositoryInterface       $chatRoomRepository,
        private readonly ChatRoomMemberRepositoryInterface $memberRepository,
    )
    {

    }

    public function create($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            if ($this->chatRoomRepository->checkRoomExist($data['user_id'])) {
                $room = $this->chatRoomRepository->getRoom($data['user_id']);
                $room->load('messages');
                return $this->responseSuccess(data: ChatRoomResource::make($room));
            } else {
                $room = $this->chatRoomRepository->create([]);
                $room->members()?->insert([
                    [
                        'user_id' => auth('api')->id(),
                        'chat_room_id' => $room->id,
                    ],
                    [
                        'user_id' => $data['user_id'],
                        'chat_room_id' => $room->id,
                    ],
                ]);
            }
            DB::commit();
            return $this->responseSuccess(data: ChatRoomResource::make($room));
        } catch (\Exception $e) {
            DB::rollBack();
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }
}
