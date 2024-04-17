<?php

namespace App\Http\Services\Api\V1\Message;

use App\Events\ChatroomEvent;
use App\Events\MessageEvent;
use App\Http\Requests\Api\V1\Message\LoadMoreRequest;
use App\Http\Resources\V1\Message\MessageResource;
use App\Http\Services\Mutual\FileManagerService;
use App\Http\Services\Mutual\GetService;
use App\Http\Traits\Responser;
use App\Http\Traits\UnReadtrait;
use App\Repository\ChatRoomRepositoryInterface;
use App\Repository\MessageRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MessageService
{
    use Responser, UnReadtrait;

    public function __construct(
        private readonly MessageRepositoryInterface  $messageRepository,
        private readonly ChatRoomRepositoryInterface $chatRoomRepository,
        private readonly FileManagerService          $fileManagerService,
        private readonly GetService                  $getService,

    )
    {

    }

    public function create($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            if ($request->type != 'TEXT') {
                $data['content'] = $this->uploadNotTextMessage($request->type);
                unset($data['file']);
            }
            $data['user_id'] = auth('api')->id();
            $message = $this->messageRepository->create($data);
            $this->fireEvents($request->chat_room_id, $message);
            $this->updateUnReadCount($request->chat_room_id, false);
            $this->chatRoomRepository->update($request->chat_room_id, ['updated_at' => now()]);
            DB::commit();
            return $this->responseSuccess(data: MessageResource::make($message));
        } catch (\Exception $e) {
            DB::rollBack();
//            return $e;
            return $this->responseFail(message: __('messages.Something went wrong'));
        }
    }

    private function uploadNotTextMessage($type)
    {
        return $this->fileManagerService
            ->handle('file', 'messages/' . strtolower($type));
    }

    private function fireEvents($chat_room_id, $message)
    {
        broadcast(new MessageEvent($chat_room_id, $message))->toOthers();
        $room = $this->chatRoomRepository->getById($chat_room_id);
        broadcast(new ChatroomEvent($room))->toOthers();

    }


    public function loadMore(LoadMoreRequest $request)
    {
        return $this->getService->handle(MessageResource::class, $this->messageRepository,
            'loadMoreMessages', [$request->chat_room_id, $request->last_message_id]);
    }

}
