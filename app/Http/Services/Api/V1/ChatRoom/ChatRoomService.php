<?php

namespace App\Http\Services\Api\V1\ChatRoom;

use App\Http\Resources\V1\ChatRoom\ChatRoomResource;
use App\Http\Traits\Responser;
use App\Http\Traits\UnReadtrait;
use App\Repository\ChatRoomMemberRepositoryInterface;
use App\Repository\ChatRoomRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ChatRoomService
{
    use Responser, UnReadtrait;

    public function __construct(
        private readonly ChatRoomRepositoryInterface       $chatRoomRepository,
        private readonly ChatRoomMemberRepositoryInterface $memberRepository,
        private readonly UserRepositoryInterface           $userRepository,
    )
    {

    }

    public function index()
    {
//        return $this->userRepository->getById(auth('api')->id(),relations: ['chatrooms.room.otherMember']);
        return $this->chatRoomRepository->getRooms();
    }

    public function create($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $other_member = $this->userRepository->getById($data['user_id']);
            if ($this->chatRoomRepository->checkRoomExist($data['user_id'])) {
                $room = $this->chatRoomRepository->getRoom($data['user_id']);
                $room->load('messages');
                $this->updateUnReadCount($room->id);
                $room->other_member = $other_member;
                DB::commit();
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
                $room->other_member = $other_member;
            }
            DB::commit();
            return $this->responseSuccess(data: ChatRoomResource::make($room));
        } catch (\Exception $e) {
            DB::rollBack();
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    public function resetUnread($room_id)
    {
        $this->updateUnReadCount($room_id);
        return $this->responseSuccess();
    }
}
